<?php


use Flarum\Extend;
use Sijad\Pages\Listener;
use Illuminate\Contracts\Events\Dispatcher;

return [
    /* (new Extend\Frontend('forum')) */
    /*     ->js(__DIR__.'/js/dist/forum.js') */
    /*     ->css(__DIR__.'/less/forum.less'), */

    /* (new Extend\Frontend('admin')) */
    /*     ->js(__DIR__.'/js/dist/admin.js') */
    /*     ->css(__DIR__.'/less/admin.less'), */

    function (Dispatcher $events) {
        app()->instance('path.pages', base_path().DIRECTORY_SEPARATOR.'pages');

        $events->subscribe(Listener\AddClientAssets::class);
        $events->subscribe(Listener\AddPagesRoute::class);
        $events->subscribe(Listener\AddPagesApi::class);
        $events->subscribe(Listener\AddApiAttributes::class);
    }
];
