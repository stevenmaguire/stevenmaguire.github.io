<?php

namespace App\Services;

use RuntimeException;
use TightenCo\Jigsaw\Jigsaw;

/**
 * Writes Alfred's plain-text pages (a path ending in .txt, like llms.txt) to
 * the build exactly as written: no layout, no Markdown rendering, and not in
 * the sitemap. RemoteData collects them.
 */
class PlainTextPages
{
    public function handle(Jigsaw $jigsaw): void
    {
        foreach ($jigsaw->getConfig('plainTextPages') ?? [] as $path => $body) {
            if (! preg_match('#^[a-z0-9-]+(/[a-z0-9-]+)*\.txt$#', $path)) {
                throw new RuntimeException("Not a plain-text page path: {$path}");
            }

            $file = $jigsaw->getDestinationPath().'/'.$path;

            if (! is_dir(dirname($file))) {
                mkdir(dirname($file), 0755, true);
            }

            file_put_contents($file, rtrim($body)."\n");
        }
    }
}
