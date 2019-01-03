<?php

namespace Sijad\Pages\Listener;

use Flarum\Api\Event\Serializing;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;

class AddApiAttributes {
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'serializing']);
    }

    public function serializing(Serializing $event) {
        if ($id && $event->isSerializer(ForumSerializer::class)) {
            if ($id = $this->settings->get('pages_home')) {
                $event->attributes['pagesHome'] = $id;
            }
        }
    }
}

