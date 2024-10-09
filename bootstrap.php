<?php

use App\Services;

/** @var $container \Illuminate\Container\Container */
/** @var $events \TightenCo\Jigsaw\Events\EventBus */

/**
 * You can run custom code at different stages of the build process by
 * listening to the 'beforeBuild', 'afterCollections', and 'afterBuild' events.
 */
$events->beforeBuild([
    Services\RemoteData::class,
]);

$events->afterCollections([
    //
]);

$events->afterBuild([
    Services\SitemapGenerator::class,
]);
