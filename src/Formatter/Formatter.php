<?php

namespace Sijad\Pages\Formatter;

use Flarum\Formatter\Formatter as FlarumFormatter;

class Formatter extends FlarumFormatter
{
    /**
     * @return Configurator
     */
    protected function getConfigurator()
    {
        $configurator = parent::getConfigurator();

        // TODO: allow html tags here somehow

        return $configurator;
    }
}
