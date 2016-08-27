<?php

namespace Sijad\Pages\Formatter;

use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

class FormatterServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton('sijad.pages.formatter', function (Container $container) {
            return new Formatter(
                $container->make('cache.store'),
                $container->make('events'),
                $this->app->storagePath().'/formatter'
            );
        });

        $this->app->alias('sijad.pages.formatter', 'Sijad\Formatter\Formatter');
    }
}
