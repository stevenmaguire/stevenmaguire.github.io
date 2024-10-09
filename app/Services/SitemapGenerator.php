<?php

namespace App\Services;

use Illuminate\Support\Str;
use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class SitemapGenerator
{
    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');
        $sitemap = new Sitemap($jigsaw->getDestinationPath().'/sitemap.xml');

        $basePaths = collect($jigsaw->getOutputPaths())
            ->sortBy(fn ($p) => Str::lower($p))
            ->reject(fn ($p) => $this->shouldSkip($p));

        $basePaths->each(function ($path) use ($sitemap, $baseUrl) {
            [$timestamp, $frequency, $priority] = $this->getTimestampAndFrequencyByPath($path);
            $sitemap->addItem(sprintf('%s%s', $baseUrl, $path), $timestamp, $frequency, $priority);
        });

        $sitemap->write();
    }

    public function getTimestampAndFrequencyByPath($path)
    {
        return [time(), Sitemap::WEEKLY, 0.8];
    }

    public function shouldSkip($path)
    {
        $pathsToSkip = [

        ];

        return in_array($path, $pathsToSkip) || Str::startsWith($path, '/assets');
    }
}
