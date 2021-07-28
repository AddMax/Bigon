<?php

namespace Evercode\DependentSelectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dependent_select');

        $rootNode
                ->useAttributeAsKey('id')
                ->prototype('array')
                    ->children()
                        ->scalarNode('class')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('parent_property')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('role')
                            ->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('no_result_msg')
                            ->defaultValue('No results were found')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('order_property')
                            ->defaultValue('id')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('order_direction')
                            ->defaultValue('ASC')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('property')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->booleanNode('property_complicated')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('case_insensitive')
                            ->defaultTrue()
                        ->end()
                        ->scalarNode('search')
                            ->defaultValue('begins_with')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('callback')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('selected_result_service')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('fallback_alias')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('grandparent_property')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('auto_select_first_result')
                            ->defaultValue(null)
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('child_entity_filters')
                            ->useAttributeAsKey('id')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('property')
                                        ->defaultValue(null)
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('sign')
                                        ->defaultValue('=')
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->scalarNode('value')
                                        ->defaultValue(null)
                                        ->cannotBeEmpty()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('many_to_many')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('active')
                                    ->defaultFalse()
                                ->end()
                                ->scalarNode('entity')
                                    ->defaultValue(null)
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('property')
                                    ->defaultValue(null)
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('callback_if_empty_parent')
                                    ->defaultValue(null)
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
