<?php

namespace kudin\SettingsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle for database-centric settings management.
 */
class SettingsBundle extends Bundle
{
    /**
     * This is needed to point @DiagramBundle resource alias to root bundle dir, instead of ./src
     * Because before Symfony 5 by convention for bundle directory structure,
     * resources used to be located in ./src/Resources folder under ./src. But now not
     * @see https://github.com/symfony/symfony/blob/master/UPGRADE-5.0.md#httpkernel
     *
     * @return string
     */
    public function getPath(): string
    {
        return dirname(__DIR__.'\SettingsBundle');
    }
}
