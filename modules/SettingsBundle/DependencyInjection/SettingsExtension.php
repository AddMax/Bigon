<?php

namespace kudin\SettingsBundle\DependencyInjection;

use kudin\SettingsBundle\Controller\SettingsController;
use kudin\SettingsBundle\Form\Type\SettingsType;
use kudin\SettingsBundle\Manager\CachedSettingsManager;
use kudin\SettingsBundle\Manager\SettingsManager;
use kudin\SettingsBundle\Manager\SettingsManagerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SettingsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // dd($configs);
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $container->setParameter('settings_manager.serialization', $config['serialization']);

        // Configure the correct storage
        if (null === $config['cache_service']) {
            $container->removeDefinition(CachedSettingsManager::class);
        } else {
            $container->getDefinition(CachedSettingsManager::class)
                ->replaceArgument(1, new Reference($config['cache_service']))
                ->replaceArgument(2, $config['cache_lifetime']);

            // set an alias to make sure the cached settings manager is the default
            $container->setAlias(SettingsManagerInterface::class, CachedSettingsManager::class);
        }

        $container->getDefinition(SettingsManager::class)
            ->replaceArgument(2, $config['settings']);

        $container->getDefinition(SettingsType::class)
            ->replaceArgument(0, $config['settings']);

        $container->getDefinition(SettingsController::class)
            ->replaceArgument(2, $config['template'])
            ->replaceArgument(3, $config['security']['users_can_manage_own_settings'])
            ->replaceArgument(4, $config['security']['manage_global_settings_role']);
    }
}
