<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\ReCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phpmob_recaptcha');

        $rootNode
            ->children()
                ->scalarNode("site_key")->isRequired()->end()
                ->scalarNode("secret_key")->isRequired()->end()
                ->scalarNode("theme")->defaultValue('light')->end()
                ->booleanNode("enabled")->defaultTrue()->end()
                ->booleanNode("verify_host")->defaultTrue()->end()
                ->scalarNode("requested_key")->defaultValue('g-recaptcha-response')->cannotBeEmpty()->end()
                ->arrayNode("login")
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode("enabled")->defaultFalse()->end()
                        ->scalarNode("firewall")->defaultNull()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;

        $this->addHttpClientConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addHttpClientConfiguration(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode("http_proxy")
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode("host")->defaultValue(null)->end()
                        ->scalarNode("port")->defaultValue(null)->end()
                        ->scalarNode("auth")->defaultValue(null)->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
