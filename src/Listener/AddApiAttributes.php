<?php

namespace Sijad\Pages\Listener;

use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\PrepareApiAttributes;
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
        $events->listen(PrepareApiAttributes::class, [$this, 'prepareApiAttributes']);
    }

    public function prepareApiAttributes(PrepareApiAttributes $event) {
        $id = intval($this->settings->get('pages_home'));
        if ($id && $event->isSerializer(ForumSerializer::class)) {
            $event->attributes['pagesHome'] = $id;
        }
    }
}

