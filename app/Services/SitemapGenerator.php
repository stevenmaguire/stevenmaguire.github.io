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
        $robotRules = $this->parseRobotsTxt(file_get_contents($jigsaw->getDestinationPath().'/robots.txt'));

        $isDisallowed = function ($url) use ($robotRules) {
            return $this->isUrlDisallowed($url, $robotRules);
        };

        $basePaths = collect($jigsaw->getOutputPaths())
            ->sortBy(fn ($p) => Str::lower($p))
            ->reject(fn ($p) => $this->shouldSkip($p));

        $basePaths->each(function ($path) use ($sitemap, $baseUrl, $isDisallowed) {
            if (! $isDisallowed($path)) {
                [$timestamp, $frequency, $priority] = $this->getTimestampAndFrequencyByPath($path);
                $sitemap->addItem(sprintf('%s%s', $baseUrl, $path), $timestamp, $frequency, $priority);
            }
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

    protected function parseRobotsTxt($robotsTxt)
    {
        $rules = [];
        $currentUserAgent = null;

        // Split the file into lines
        $lines = explode("\n", $robotsTxt);

        foreach ($lines as $line) {
            // Clean up the line by removing comments and whitespace
            $line = trim($line);
            if (empty($line) || $line[0] === '#') {
                continue; // Skip empty lines and comments
            }

            // Handle User-agent section
            if (stripos($line, 'User-agent:') === 0) {
                $currentUserAgent = trim(substr($line, 11)); // Get the user-agent name
                $rules[$currentUserAgent] = ['disallow' => [], 'allow' => []];
            } elseif (stripos($line, 'Disallow:') === 0) {
                $path = trim(substr($line, 9));
                if ($currentUserAgent !== null) {
                    $rules[$currentUserAgent]['disallow'][] = $path;
                }
            } elseif (stripos($line, 'Allow:') === 0) {
                $path = trim(substr($line, 6));
                if ($currentUserAgent !== null) {
                    $rules[$currentUserAgent]['allow'][] = $path;
                }
            }
        }

        return $rules;
    }

    protected function isUrlDisallowed($url, $rules, $userAgent = '*')
    {
        // Normalize the URL to match paths (you might want to use parse_url() to handle this properly)
        $path = parse_url($url, PHP_URL_PATH);
        $path = rtrim($path, '/'); // Remove trailing slashes for consistency

        // Check for the specific user-agent or default to '*' (which matches all user agents)
        if (! isset($rules[$userAgent])) {
            // If no specific rules for the given user-agent, check the default (wildcard) rules
            $userAgent = '*';
        }

        // Check Disallow rules
        foreach ($rules[$userAgent]['disallow'] as $disallowedPath) {
            $disallowedPath = rtrim($disallowedPath, '/');
            // If the disallowed path matches the URL path
            if (strpos($path, $disallowedPath) === 0) {
                return true; // URL is disallowed
            }
        }

        // Check Allow rules (this is optional depending on how you want to handle it)
        foreach ($rules[$userAgent]['allow'] as $allowedPath) {
            $allowedPath = rtrim($allowedPath, '/');
            // If there's an Allow rule that matches, it might override Disallow
            if (strpos($path, $allowedPath) === 0) {
                return false; // URL is allowed
            }
        }

        // Default to false if no disallow matches
        return false;
    }
}
