<?php


use Flarum\Extend;
use Sijad\Pages\Api\Controller;
use Sijad\Pages\Listener;
use Illuminate\Contracts\Events\Dispatcher;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less')
        ->route('/pages/home', 'pages.home')
        ->route('/p/{id:\d+(?:-[^/]*)?}', 'pages.page'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),

    (new Extend\Routes('api'))
        ->get('/pages', 'pages.index', Controller\ListPagesController::class)
        ->post('/pages', 'pages.create', Controller\CreatePageController::class)
        ->get('/pages/{id}', 'pages.show', Controller\ShowPageController::class)
        ->patch('/pages/{id}', 'pages.update', Controller\UpdatePageController::class)
        ->delete('/pages/{id}', 'pages.delete', Controller\DeletePageController::class),

    function (Dispatcher $events) {
        app()->instance('path.pages', base_path().DIRECTORY_SEPARATOR.'pages');
        $events->subscribe(Listener\AddHomePageIdAttributes::class);
    }
];
