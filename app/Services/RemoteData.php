<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;
use TightenCo\Jigsaw\Jigsaw;

class RemoteData
{
    /**
     * Http Client
     *
     * @var GuzzleHttp\Client|null
     */
    protected ?Client $api;

    /**
     * Creates new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api = new Client;
    }

    /**
     * Jigsaw requires either a callable or the name of
     * a class which implements a method called "handle"
     */
    public function handle(Jigsaw $jigsaw): void
    {
        $currentCollections = $jigsaw->getConfig('collections');

        if ($githubRepo = $jigsaw->getConfig('github_repo')) {
            $changelog = collect();
            $githubRepoUrl = sprintf('https://api.github.com/repos/%s/commits?per_page=100&page=1', $githubRepo);
            while ($githubRepoUrl) {
                $githubRepoResponse = $this->api->get($githubRepoUrl);
                $githubRepoCommits = json_decode((string) $githubRepoResponse->getBody(), true);
                $changelog = $changelog->merge(collect($githubRepoCommits));
                $githubRepoUrl = Str::of($githubRepoResponse->getHeader('Link')[0] ?? null)->split('/,/')
                    ->filter(fn ($link) => Str::contains($link, 'rel="next"'))
                    ->map(fn ($link) => (string) Str::of($link)->match('/<(.*?)>/m'))
                    ->first();
            }
            $changelog = $changelog->map(function ($c) {
                return [
                    'id' => data_get($c, 'sha'),
                    'date' => data_get($c, 'commit.author.date'),
                    'message' => data_get($c, 'commit.message'),
                ];
            })->reject(fn ($c) => Str::contains(strtolower($c['message']), ['dependabot', 'bump', 'merge branch']));
            $currentCollections->set('changelog.items', $changelog->values()->all());
        }

        /*
         * The feeds below are read from Alfred's v1 APIs (missions, projects
         * and the travel log also from collector's older endpoints): each
         * item is mapped into the fields the views use.
         *
         * Every feed is required. A missing URL, an error, something other
         * than JSON, or no items fails the build, so a broken or forgotten
         * feed never deploys empty pages (the deploy replaces the whole bucket).
         */

        $packagistStatsUrl = $this->required($jigsaw, 'packagist_stats_url', 'PACKAGIST_STATS_URL');
        $projects = collect($this->items($packagistStatsUrl, ['per_page' => 100], 'open source projects'))
            ->map(fn ($p) => $this->openSourceProject($p));
        $currentCollections->set('opensource.items', $projects->all());
        if ($totalDownloads = $projects->sum('downloads')) {
            $jigsaw->setConfig('opensource_total_downloads', $totalDownloads);
        }

        $missionStatsUrl = $this->required($jigsaw, 'mission_stats_url', 'MISSION_STATS_URL');
        $missions = collect($this->items($missionStatsUrl, [], 'missions'))
            ->map(fn ($m) => $this->mission($m));
        $currentCollections->set('missions.items', $missions->all());

        $volunteeringUrl = $this->required($jigsaw, 'volunteering_url', 'VOLUNTEERING_URL');
        $roles = collect($this->items($volunteeringUrl, [], 'volunteering'))
            ->map(fn ($v) => $this->volunteerRole($v));
        $currentCollections->set('volunteering.items', $roles->all());

        $theatreUrl = $this->required($jigsaw, 'theatre_url', 'THEATRE_URL');
        $productions = collect($this->items($theatreUrl, [], 'theatre'))
            ->map(fn ($p) => $this->theatreProduction($p));
        $currentCollections->set('theatre.items', $productions->all());

        $travelLogUrl = $this->required($jigsaw, 'travel_log_url', 'TRAVEL_LOG_URL');
        $travelLogItems = collect();
        $pageUrl = $travelLogUrl;
        $query = ['per_page' => 100];
        while ($pageUrl) {
            $travelLogPage = $this->json($pageUrl, $query, 'travel log');
            $travelLogItems = $travelLogItems->merge(data_get($travelLogPage, 'data', []));
            // Alfred gives links.next, collector next_page_url: both full URLs, query included.
            $pageUrl = data_get($travelLogPage, 'links.next') ?? data_get($travelLogPage, 'next_page_url');
            $query = [];
        }
        if ($travelLogItems->isEmpty()) {
            throw new RuntimeException(
                "The travel log feed ({$travelLogUrl}) returned no entries: not building a site without them."
            );
        }
        $travelLogItems = $travelLogItems->map(fn ($t) => $this->travelLog($t));
        $currentCollections->set('travel.items', $travelLogItems->values()->all());

        // The site's own channel: posts and publications, its pages, and the artwork.
        $channelUrl = rtrim($this->required($jigsaw, 'channel_url', 'CHANNEL_URL'), '/');
        $entries = collect();
        $pageUrl = $channelUrl.'/entries';
        $query = ['per_page' => 100];
        while ($pageUrl) {
            $entriesPage = $this->json($pageUrl, $query, 'posts and publications');
            $entries = $entries->merge(data_get($entriesPage, 'data', []));
            $pageUrl = data_get($entriesPage, 'links.next');
            $query = [];
        }
        $posts = $entries->filter(fn ($e) => data_get($e, 'category.slug') === 'post');
        $publications = $entries->reject(fn ($e) => data_get($e, 'category.slug') === 'post');
        if ($posts->isEmpty() || $publications->isEmpty()) {
            throw new RuntimeException(
                "The channel feed ({$channelUrl}) returned no posts or no publications: "
                .'not building a site without them.'
            );
        }
        $currentCollections->set('posts.items', $posts->map(fn ($e) => $this->post($e))->values()->all());
        $currentCollections->set(
            'publications.items',
            $publications->map(fn ($e) => $this->publication($e))->values()->all()
        );
        $currentCollections->set('pages.items', collect($this->items($channelUrl.'/pages', [], 'pages'))
            ->map(fn ($p) => $this->page($p))->values()->all());
        $artwork = data_get($this->json($channelUrl.'/galleries/artwork', [], 'artwork'), 'data.items');
        if (! is_array($artwork) || $artwork === []) {
            throw new RuntimeException(
                "The artwork feed ({$channelUrl}/galleries/artwork) returned no images: "
                .'not building a site without them.'
            );
        }
        // Named in the gallery's order: Jigsaw lists items by file name ("logos-10" before "logos-2").
        $currentCollections->set('logos.items', array_map(
            fn ($i, $n) => [
                'filename' => sprintf('logo-%03d', $n + 1),
                'image' => $i['image'] ?? null,
                'client' => $i['caption'] ?? null,
            ],
            $artwork,
            array_keys($artwork)
        ));

        /**
         * Set build time config.
         */
        $jigsaw->setConfig('build_time', Carbon::now());

        /**
         * Set updated collections.
         */
        $jigsaw->setConfig('collections', $currentCollections);
    }

    /**
     * A feed's URL, which must be set (see .env.example).
     *
     * @throws RuntimeException
     */
    protected function required(Jigsaw $jigsaw, string $key, string $variable): string
    {
        $url = $jigsaw->getConfig($key);

        if (! is_string($url) || trim($url) === '') {
            throw new RuntimeException("{$variable} is not set: not building a site without that feed.");
        }

        return $url;
    }

    /**
     * A feed's items (its "data"), which must not be empty.
     *
     * @throws RuntimeException
     */
    protected function items(string $url, array $query, string $feed): array
    {
        $items = data_get($this->json($url, $query, $feed), 'data');

        if (! is_array($items) || $items === []) {
            throw new RuntimeException(
                "The {$feed} feed ({$url}) returned no items: not building a site without them."
            );
        }

        return $items;
    }

    /**
     * A feed's response as JSON. Guzzle already throws on an error status.
     * Guzzle's "query" option replaces a URL's own query string (a next-page
     * URL's ?page=2) even when empty, so it is set only when there is one,
     * merged with the URL's own.
     *
     * @throws RuntimeException
     */
    protected function json(string $url, array $query, string $feed): array
    {
        $options = ['headers' => ['Accept' => 'application/json']];

        if ($query !== []) {
            parse_str((string) parse_url($url, PHP_URL_QUERY), $own);
            $options['query'] = array_merge($own, $query);
        }

        $response = $this->api->get($url, $options);
        $body = json_decode((string) $response->getBody(), true);

        if (! is_array($body)) {
            throw new RuntimeException("The {$feed} feed ({$url}) did not return JSON.");
        }

        return $body;
    }

    /**
     * A project as the views use it (collector's fields). Alfred's v1 nests
     * downloads and refs, and calls primary_url "url".
     */
    protected function openSourceProject(array $p): array
    {
        if (! is_array($p['downloads'] ?? null)) {
            return $p;
        }

        return array_merge($p, [
            'downloads' => (int) data_get($p, 'downloads.total', 0),
            'downloads_last_refreshed_at' => data_get($p, 'downloads.refreshed_at'),
            'primary_url' => $p['url'] ?? null,
            'github_ref' => data_get($p, 'refs.github'),
            'packagist_ref' => data_get($p, 'refs.packagist'),
            'npm_ref' => data_get($p, 'refs.npm'),
        ]);
    }

    /**
     * A mission as the views use it (collector's fields). Alfred's v1 nests
     * the period, story and valuation, and calls the model "business_model".
     */
    protected function mission(array $m): array
    {
        if (! isset($m['period'])) {
            return $m;
        }

        return array_merge(Arr::except($m, ['period', 'story', 'valuation']), [
            'model' => $m['business_model'] ?? null,
            'start_date' => data_get($m, 'period.start'),
            'end_date' => data_get($m, 'period.end'),
            'summary' => data_get($m, 'story.summary'),
            'challenge' => data_get($m, 'story.challenge'),
            'approach' => data_get($m, 'story.approach'),
            'solution' => data_get($m, 'story.solution'),
            'results' => data_get($m, 'story.results'),
            'valuation_change_percent' => data_get($m, 'valuation.change_percent'),
            'valuation_downstream_change_percent' => data_get($m, 'valuation.downstream_change_percent'),
            'downstream_event' => data_get($m, 'valuation.downstream_event'),
            'links' => $m['links'] ?? [],
        ]);
    }

    /**
     * A volunteer role from Alfred, as the views use the site's own files.
     */
    protected function volunteerRole(array $v): array
    {
        return [
            'role' => $v['role'] ?? null,
            'organization' => $v['organization'] ?? null,
            'dates' => $v['period'] ?? null,
            'description' => $v['description'] ?? null,
            'date' => $v['dated_on'] ?? null,
        ];
    }

    /**
     * A theatre production from Alfred, as the views use the site's own files;
     * its venue comes with it (the place), not from config.php.
     */
    protected function theatreProduction(array $p): array
    {
        $place = $p['place'] ?? null;

        return [
            'name' => $p['name'] ?? null,
            'season' => $p['season'] ?? null,
            'dates' => $p['period'] ?? null,
            'open_date' => $p['opens_on'] ?? null,
            'close_date' => $p['closes_on'] ?? null,
            'location' => $place['slug'] ?? null,
            'place' => $place === null
                ? null
                : Arr::only($place, ['name', 'street_address', 'locality', 'postal_code', 'region', 'country']),
            'roles' => array_map(
                fn ($r) => ['name' => $r['role'] ?? null, 'department' => $r['department'] ?? null],
                $p['roles'] ?? []
            ),
            'footnotes' => ($p['common_credit'] ?? false) ? ['ecu-common-credit'] : [],
            // The page's structured data reads a production-level department (only one file had it).
            'department' => $p['roles'][0]['department'] ?? null,
        ];
    }

    /**
     * A post from Alfred, as the views use the site's own files: the file
     * name (its date and slug, from which the page's path is made) and the
     * date in Chicago time, so a post keeps the date it was written on.
     */
    protected function post(array $e): array
    {
        $date = Carbon::parse($e['published_at'])->setTimezone('America/Chicago');

        return [
            'filename' => $date->format('Y-m-d').'-'.$e['slug'],
            'title' => $e['title'] ?? null,
            'date' => $date->format('Y-m-d H:i:s O'),
            'image' => $e['image'] ?? null,
            'description' => $e['summary'] ?? null,
            'elsewhere' => $e['elsewhere'] ?? [],
            'content' => $e['body'] ?? '',
        ];
    }

    /**
     * A publication (presentation, training or interview) from Alfred, as the
     * views use the site's own files: its category, link and audiences, with
     * times in Chicago time, as the files wrote them.
     */
    protected function publication(array $e): array
    {
        return [
            'filename' => $e['slug'],
            'title' => $e['title'] ?? null,
            'date' => Carbon::parse($e['published_at'])->setTimezone('America/Chicago')->format('Y-m-d H:i:s'),
            'category' => data_get($e, 'category.slug'),
            'link' => $e['link'] ?? null,
            'image' => $e['image'] ?? null,
            'description' => $e['summary'] ?? null,
            'audiences' => array_map(fn ($a) => [
                'name' => $a['name'] ?? null,
                'date' => isset($a['date'])
                    ? Carbon::parse($a['date'])->setTimezone('America/Chicago')->format('Y-m-d H:i:s')
                    : null,
            ], $e['appearances'] ?? []),
            'content' => $e['body'] ?? '',
        ];
    }

    /**
     * A page from Alfred (About, Colophon, Privacy, Terms), served at its
     * path. The colophon shows the changelog under its text.
     */
    protected function page(array $p): array
    {
        return [
            'filename' => $p['path'],
            'title' => $p['title'] ?? null,
            'image' => $p['image'] ?? null,
            'description' => $p['summary'] ?? null,
            'changelog' => $p['path'] === 'colophon',
            'content' => $p['body'] ?? '',
        ];
    }

    /**
     * A travel log entry as the views use it: body, created_at, media (URLs)
     * and tags with "#". Alfred's v1 has published_at, images and tag objects,
     * and an entry without a caption has a null body.
     */
    protected function travelLog(array $t): array
    {
        if (array_key_exists('content', $t)) {
            $t['body'] = Arr::pull($t, 'content');

            return $t;
        }

        return array_merge($t, [
            'location' => data_get($t, 'place.name') ?? $t['location'] ?? null,
            'body' => $t['body'] ?? '',
            'created_at' => $t['published_at'] ?? null,
            'media' => collect($t['images'] ?? [])->pluck('url')->filter()->values()->all(),
            'tags' => collect($t['tags'] ?? [])
                ->map(fn ($tag) => is_array($tag) ? ($tag['name'] ?? $tag['slug'] ?? '') : ltrim((string) $tag, '#'))
                ->map(fn ($name) => '#'.$name)
                ->reject(fn ($tag) => $tag === '#')
                ->values()
                ->all(),
        ]);
    }
}
