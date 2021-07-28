<?php

namespace Dmishh\SettingsBundle\Tests;

use Dmishh\SettingsBundle\DependencyInjection\DmishhSettingsExtension;
use Dmishh\SettingsBundle\Manager\CachedSettingsManager;
use Dmishh\SettingsBundle\Manager\SettingsManager;
use Dmishh\SettingsBundle\Manager\SettingsManagerInterface;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Tests
 */
class ServiceTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new DmishhSettingsExtension(),
        ];
    }

    public function testAlias()
    {
        $this->load();
        $this->assertContainerBuilderHasAlias(SettingsManagerInterface::class, SettingsManager::class);
    }

    /**
     * If we provide a cache_service we should use the CachedSettingsManager as default.
     */
    public function testCacheServiceAlias()
    {
        $this->load(['cache_service' => 'cache']);
        $this->assertContainerBuilderHasAlias(SettingsManagerInterface::class, CachedSettingsManager::class);
    }
}
