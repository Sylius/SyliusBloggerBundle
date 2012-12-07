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

use Sylius\Bundle\BloggerBundle\SyliusBloggerBundle;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Blogger extension.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusBloggerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $driver = $config['driver'];
        $engine = $config['engine'];

        if (!in_array($driver, SyliusBloggerBundle::getSupportedDrivers())) {
            throw new \InvalidArgumentException(sprintf('Driver "%s" is unsupported by SyliusBloggerBundle', $config['driver']));
        }

        $loader->load(sprintf('driver/%s.xml', $driver));

        $container->setParameter('sylius_blogger.driver', $driver);
        $container->setParameter('sylius_blogger.engine', $engine);

        $loader->load('services.xml');

        $container->setAlias('sylius_blogger.blamer.post', $config['services']['blamer']['post']);

        $classes = $config['classes']['post'];

        $container->setParameter('sylius_blogger.model.post.class', $classes['model']);
        $container->setParameter('sylius_blogger.controller.post.class', $classes['controller']);
        $container->setParameter('sylius_blogger.form.type.post.class', $classes['form']);

        if (isset($classes['repository'])) {
            $container->setParameter('sylius_blogger.repository.post.class', $classes['repository']);
        }
    }

}
