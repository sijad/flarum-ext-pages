<?php

namespace Sijad\Pages\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;

class PageSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'pages';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($page)
    {
        $attributes = [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'time' => $page->time,
            'editTime' => $page->edit_time,
            'contentHtml' => $page->is_html ? nl2br($page->content) : $page->content_html
        ];

        if ($this->actor->isAdmin()) {
            $attributes['content'] = $page->content;
            $attributes['isHidden'] = $page->is_hidden;
        }

        $attributes['contentHtml'] = $this->loadViews($attributes['contentHtml'], $page);

        return $attributes;
    }

    private function loadViews($html, $page) {
        if (strpos($html, '@include(') !== false) {
            $html = preg_replace_callback(
                '/\@include\([\"\']([\.\/\w\s]+)[\"\']\)/mi',
                function ($matches) use ($page) {
                    $base = app('path.pages');
                    $path = trim($matches[1], " \r\n\t\f/.");
                    $path = $base.DIRECTORY_SEPARATOR.$path;
                    if (substr($path, -10) != ($bladeExt = '.blade.php')) {
                        $path .= $bladeExt;
                    }
                    $path = realpath($path);
                    if (!empty($path) && strpos($path, $base) === 0 && is_readable($path)) {
                        $view = app('view')->file($path);
                        $view->page = $page;
                        return $view->render();
                    }
                    return $matches[0];
                },
                $html
            );
        }
        return $html;
    }
}
