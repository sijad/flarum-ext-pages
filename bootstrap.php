<?php

use Illuminate\Contracts\Events\Dispatcher;
use Sijad\Pages\Listener;

return function (Dispatcher $events) {
    app()->register('Sijad\Pages\Formatter\FormatterServiceProvider');

    $events->subscribe(Listener\AddClientAssets::class);
    $events->subscribe(Listener\AddPagesRoute::class);
    $events->subscribe(Listener\AddPagesApi::class);
};
