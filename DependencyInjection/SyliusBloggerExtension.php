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

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

/**
 * Blogger extension.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusBloggerExtension extends Extension
{
    /**
     * @see Extension/Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/container'));

        if (!in_array($config['driver'], array('ORM'))) {
            throw new \InvalidArgumentException(sprintf('Driver "%s" is unsupported for this extension.', $config['driver']));
        }
        
        if (!in_array($config['engine'], array('php', 'twig'))) {
            throw new \InvalidArgumentException(sprintf('Engine "%s" is unsupported for this extension.', $config['engine']));
        }
        
        $loader->load(sprintf('driver/%s.xml', $config['driver']));
        $loader->load(sprintf('engine/%s.xml', $config['engine']));
        
        $container->setParameter('sylius_blogger.driver', $config['driver']);
        $container->setParameter('sylius_blogger.engine', $config['engine']);
        
        $configurations = array(
            'controllers',
            'forms',
            'inflectors',
            'manipulators',
            'blamers'
        );
        
        foreach ($configurations as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $container->setAlias('sylius_blogger.blamer.post', $config['services']['blamer']['post']);
        
        $this->remapParametersNamespaces($config['classes'], $container, array(
            'model'          => 'sylius_blogger.model.%s.class',
            'manipulator'    => 'sylius_blogger.manipulator.%s.class',
            'inflector'      => 'sylius_blogger.inflector.%s.class'
        ));
        
        $this->remapParametersNamespaces($config['classes']['controller'], $container, array(
            'frontend'	   => 'sylius_blogger.controller.frontend.%s.class',
            'backend'      => 'sylius_blogger.controller.backend.%s.class',
        ));
        
        $this->remapParametersNamespaces($config['classes']['form'], $container, array(
            'type'              => 'sylius_blogger.form.type.%s.class',
        ));
    }
    
	/**
     * Remap parameters.
     * 
     * @param $config
     * @param ContainerBuilder $container
     * @param $map
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (isset($config[$name])) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    /**
     * Remap parameter namespaces.
     * 
     * @param $config
     * @param ContainerBuilder $container
     * @param $map
     */
    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!isset($config[$ns])) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    if (null !== $value) {
                        $container->setParameter(sprintf($map, $name), $value);
                    }
                }
            }
        }
    }
}
