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
         * The three feeds below are read from Alfred's v1 APIs, or from
         * collector's older endpoints: each item is mapped into the fields
         * the views use, whichever shape it arrives in, so each URL can be
         * switched (and switched back) on its own.
         *
         * A feed that answers with an error, something other than JSON, or no
         * items fails the build, so a broken API never deploys empty pages
         * (the deploy replaces the whole bucket).
         */

        if ($packagistStatsUrl = $jigsaw->getConfig('packagist_stats_url')) {
            $projects = collect($this->items($packagistStatsUrl, ['per_page' => 100], 'open source projects'))
                ->map(fn ($p) => $this->openSourceProject($p));
            $currentCollections->set('opensource.items', $projects->all());
            if ($totalDownloads = $projects->sum('downloads')) {
                $jigsaw->setConfig('opensource_total_downloads', $totalDownloads);
            }
        }

        if ($missionStatsUrl = $jigsaw->getConfig('mission_stats_url')) {
            $missions = collect($this->items($missionStatsUrl, [], 'missions'))
                ->map(fn ($m) => $this->mission($m));
            $currentCollections->set('missions.items', $missions->all());
        }

        if ($travelLogUrl = $jigsaw->getConfig('travel_log_url')) {
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
        }

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
