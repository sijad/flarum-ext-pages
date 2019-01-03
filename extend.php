<?php

namespace Sijad\Pages;

use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Sijad\Pages\Api\Controller;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/less/admin.less')
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/less/forum.less')
        ->js(__DIR__.'/js/dist/forum.js')
        ->route('/pages/home', 'pages.home')
        ->route('/p/{id:\d+(?:-[^/]*)?}', 'pages.page'),

    (new Extend\Routes('api'))
        ->get('/pages', 'pages.index', Controller\ListPagesController::class)
        ->post('/pages', 'pages.create', Controller\CreatePageController::class)
        ->get('/pages/{id}', 'pages.show', Controller\ShowPageController::class)
        ->patch('/pages/{id}', 'pages.update', Controller\UpdatePageController::class)
        ->delete('/pages/{id}', 'pages.delete', Controller\DeletePageController::class),

    function (Dispatcher $events) {
        app()->instance('path.pages', base_path() . DIRECTORY_SEPARATOR . 'pages');

        Page::setFormatter(app()->make('flarum.formatter'));

        $events->subscribe(Listener\AddApiAttributes::class);
    }
];
