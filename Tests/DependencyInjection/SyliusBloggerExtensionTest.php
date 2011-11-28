<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sylius\Bundle\BloggerBundle\DependencyInjection\SyliusBloggerExtension;
use Symfony\Component\Yaml\Parser;

class SyliusBloggerExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testUserLoadThrowsExceptionUnlessDriverSet()
    {
        $loader = new SyliusBloggerExtension();
        $config = $this->getEmptyConfig();
        unset($config['driver']);
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \InvalidArgumentException
    */
    public function testUserLoadThrowsExceptionUnlessDriverIsValid()
    {
        $loader = new SyliusBloggerExtension();
        $config = $this->getEmptyConfig();
        $config['driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \InvalidArgumentException
    */
    public function testUserLoadThrowsExceptionUnlessEngineIsValid()
    {
        $loader = new SyliusBloggerExtension();
        $config = $this->getEmptyConfig();
        $config['engine'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }
    
    /**
    * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
    */
    public function testUserLoadThrowsExceptionUnlessProductModelClassSet()
    {
        $loader = new SyliusBloggerExtension();
        $config = $this->getEmptyConfig();
        unset($config['classes']['model']['post']);
        $loader->load(array($config), new ContainerBuilder());
    }

    /**
     * getEmptyConfig
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
driver: ORM
classes:
    model:
        post: Sylius\Bundle\BloggerBundle\Entity\DefaultPost
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }
}