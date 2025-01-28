<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

        if ($packagistStatsUrl = $jigsaw->getConfig('packagist_stats_url')) {
            $packagistStatsResponse = $this->api->get($packagistStatsUrl, ['query' => ['per_page' => 100]]);
            $packagistStats = json_decode((string) $packagistStatsResponse->getBody(), true);
            $projects = collect(data_get($packagistStats, 'data', []));
            $currentCollections->set('opensource.items', $projects->all());
            if ($totalDownloads = $projects->sum('downloads')) {
                $jigsaw->setConfig('opensource_total_downloads', $totalDownloads);
            }
        }

        if ($missionStatsUrl = $jigsaw->getConfig('mission_stats_url')) {
            $missionStatsResponse = $this->api->get($missionStatsUrl);
            $missionStats = json_decode((string) $missionStatsResponse->getBody(), true);
            $currentCollections->set('missions.items', data_get($missionStats, 'data', []));
        }

        if ($travelLogUrl = $jigsaw->getConfig('travel_log_url')) {
            $travelLogItems = collect();
            $continue = true;
            $page = 1;
            while ($continue) {
                $travelLogResponse = $this->api->get($travelLogUrl, ['query' => ['page' => $page]]);
                $travelLogPage = json_decode((string) $travelLogResponse->getBody(), true);
                $travelLogs = collect(data_get($travelLogPage, 'data', []));
                $travelLogItems = $travelLogItems->merge($travelLogs);
                if (data_get($travelLogPage, 'next_page_url')) {
                    $page++;
                } else {
                    $continue = false;
                }
            }
            $travelLogItems = $travelLogItems->map(function ($t) {
                $t['body'] = Arr::pull($t, 'content');

                return $t;
            });
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
}
