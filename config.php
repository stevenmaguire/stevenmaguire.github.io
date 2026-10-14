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
    'volunteering_url' => env('VOLUNTEERING_URL'),
    'theatre_url' => env('THEATRE_URL'),
    'channel_url' => env('CHANNEL_URL'),

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
        // About, Colophon, Privacy and Terms, from Alfred: each at its own path.
        'pages' => [
            'extends' => '_layouts.markdown',
            'section' => 'content',
            'path' => '{filename}',
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
        'publications' => [
            'publishedAt' => fn ($p) => Carbon::parse($p->date),
            'sort' => '-date',
        ],
        'theatre' => [
            'sort' => '-open_date',
            // The venue comes with each production from Alfred (its place).
            'locationMeta' => fn ($c) => $c->place
                ? collect($c->place)
                    ->only(['name', 'street_address', 'locality', 'postal_code', 'region', 'country'])
                    ->all()
                : null,
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
