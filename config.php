<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

return [
    'production' => false,
    'baseUrl' => 'http://localhost:8080',
    'build_time' => null,
    'title' => 'Steven Maguire',
    'email' => 'maguire@hey.com',
    'description' => 'Hands-on CTO, Team Builder, Software Architect, and '.
        'Product Designer specializing in Digital Transformations & '.
        'Profitable Turnarounds living in Chicago, IL.',

    'isPath' => function ($page, $path) {
        $path = trim($path, '/');
        switch ($path) {
            case 'publications':
                return Str::startsWith($page->getPath(), ['/publications', '/posts']);
            case 'about':
            case 'open-source':
            case 'missions':
                return Str::startsWith($page->getPath(), sprintf('/%s', $path));
        }

        return false;
    },

    'getSiblingPages' => function ($page, $allPages) {
        $siblings = collect();
        $pageKeys = $allPages->keys()->all();
        if ($currentPageKey = $allPages->filter(fn ($p) => $page->getPath() == $p->getPath())->keys()->first()) {
            $index = array_search($currentPageKey, $pageKeys);
            if ($previousIndex = $pageKeys[$index - 1] ?? null) {
                $siblings->put('previous', $allPages->get($previousIndex));
            }
            if ($nextIndex = $pageKeys[$index + 1] ?? null) {
                $siblings->put('next', $allPages->get($nextIndex));
            }
        }

        return $siblings;
    },

    'github_repo' => env('GH_REPO'),
    'mission_stats_url' => env('MISSION_STATS_URL'),
    'packagist_stats_url' => env('PACKAGIST_STATS_URL'),
    'travel_log_url' => env('TRAVEL_LOG_URL'),

    'opensource_total_downloads' => 12286558,
    'opensource_last_refreshed' => null,

    'collections' => [
        'posts' => [
            'path' => function ($p) {
                $date = $p->publishedAt();

                return sprintf(
                    'posts/%s/%s/%s/%s',
                    $date->format('Y'),
                    $date->format('m'),
                    $date->format('d'),
                    trim(Str::replace($date->toDateString(), '', $p->getFilename()), '-')
                );
            },
            'excerpt' => fn ($p) => preg_split('#\r?\n#', $p->getContent(), 2)[0],
            'publishedAt' => fn ($p) => Carbon::parse($p->date),
            'author' => 'Steven Maguire',
            'extends' => '_layouts.post',
            'section' => 'content',
            'sort' => '-date',
        ],
        'changelog' => [
            'sort' => '-date',
        ],
        'logos',
        'missions' => [
            'extends' => '_layouts.mission',
            'path' => 'missions/{slug}',
            'isCurrent' => function ($m) {
                $endDate = $m->end_date ? Carbon::parse($m->end_date) : null;

                return is_null($endDate) || $endDate > Carbon::now();
            },
            'tenure' => function ($m) {
                $startDate = Carbon::parse($m->start_date);
                $endDate = $m->end_date ? Carbon::parse($m->end_date) : null;

                $tenure = sprintf('Q%d %d to ', $startDate->quarter, $startDate->year);
                if ($endDate) {
                    $tenure .= sprintf('Q%d %d', $endDate->quarter, $endDate->year);
                } else {
                    $tenure .= 'Current';
                }

                return $tenure;
            },
            'change' => function ($m, bool $downstream = false) {
                // if ($m->isCurrent()) {
                //     return null;
                // }

                if ($downstream) {
                    return $m->valuation_downstream_change_percent;
                }

                return $m->valuation_change_percent;
            },
        ],
        'opensource' => [
            'sort' => '-downloads',
        ],
        'projects',
        'publications' => [
            'publishedAt' => fn ($p) => Carbon::parse($p->date),
            'sort' => '-date',
        ],
        'theatre' => [
            'sort' => '-open_date',
            'locationMeta' => function ($c) {
                switch ($c->location) {
                    case 'ecu-loessin':
                        return [
                            'name' => 'McGinnis Theater',
                            'street_address' => 'East 5th Street',
                            'locality' => 'Greenville',
                            'postal_code' => '27858',
                            'region' => 'NC',
                            'country' => 'US',
                        ];
                    case 'ecu-mendenhall':
                        return [
                            'name' => 'Mendenhall Student Center at ECU',
                            'street_address' => 'East 5th Street',
                            'locality' => 'Greenville',
                            'postal_code' => '27858',
                            'region' => 'NC',
                            'country' => 'US',
                        ];
                    case 'turnage-little-washington':
                        return [
                            'name' => 'Turnage Theater',
                            'street_address' => '150 W Main St',
                            'locality' => 'Washington',
                            'postal_code' => '27889',
                            'region' => 'NC',
                            'country' => 'US',
                        ];
                }

                return null;
            },
        ],
        'travel' => [
            'extends' => '_layouts.travel',
            'path' => 'travel/{slug}',
            'sort' => '-created_at',
            'createdAt' => fn ($p) => Carbon::parse($p->created_at),
            'splitTitleForFormat' => function ($t) {
                $title = $t['title'];
                preg_match("/(\p{P})$/", $title, $matches);
                if ($punctuation = $matches[1] ?? null) {
                    return [rtrim($title, $punctuation), $punctuation];
                }
            },
        ],
        'volunteering' => [
            'sort' => '-date',
        ],
    ],
];
