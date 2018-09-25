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
        $id = intval($this->settings->get('pages_home'));
        if ($id && $event->isSerializer(ForumSerializer::class)) {
            $event->attributes['pagesHome'] = $id;
        }
    }
}

