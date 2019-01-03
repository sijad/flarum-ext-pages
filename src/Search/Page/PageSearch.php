<?php

namespace Sijad\Pages\Search\Page;

use Flarum\Search\AbstractSearch;

class PageSearch extends AbstractSearch
{
    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['editTime' => 'desc'];
}
