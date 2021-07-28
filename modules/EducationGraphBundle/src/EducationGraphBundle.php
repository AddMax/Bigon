<?php

namespace kudin\EducationGraphBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EducationGraphBundle extends Bundle
{
    /**
     * Add custom compiler pass to DI compilation process
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
