<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_blogger');
        
        $rootNode
            ->children()
                ->scalarNode('driver')->isRequired()->end()
                ->scalarNode('engine')->defaultValue('twig')->end()
            ->end();
        
        $this->addClassesSection($rootNode);
        $this->addServicesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `classes` section.
     * 
     * @param ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('model')
                            ->isRequired()
                            ->children()
                                ->scalarNode('post')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('controller')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('backend')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('post')->defaultValue('Sylius\\Bundle\\BloggerBundle\\Controller\Backend\\PostController')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('frontend')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('post')->defaultValue('Sylius\\Bundle\\BloggerBundle\\Controller\\Frontend\\PostController')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('type')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('post')->defaultValue('Sylius\\Bundle\\BloggerBundle\\Form\\Type\\PostFormType')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('manipulator')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('post')->defaultValue('Sylius\\Bundle\\BloggerBundle\\Manipulator\\PostManipulator')->end()
                            ->end()
                        ->end()
                        ->arrayNode('inflector')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('slugizer')->defaultValue('Sylius\\Bundle\\BloggerBundle\\Inflector\\Slugizer')->end()
                            ->end()
                        ->end()
                    ->end();
    }
    
	/**
     * Adds `services` section.
     * 
     * @param ArrayNodeDefinition $node
     */
    private function addServicesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('services')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('blamer')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('post')->defaultValue('sylius_blogger.blamer.post.nooop')->end()
                            ->end()
                        ->end()
                    ->end();
    }
}
