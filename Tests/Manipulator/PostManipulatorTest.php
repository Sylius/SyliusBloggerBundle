<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Tests\Manipulator;

use Sylius\Bundle\BloggerBundle\Manipulator\PostManipulator;

/**
 * Post manipulator test.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PostManipulatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreatePersistsPost()
    {
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('persistPost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer());
        $manipulator->create($post);
    }

    public function testUpdatePersistsPost()
    {
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('persistPost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer());
        $manipulator->update($post);
    }

    public function testDeleteRemovesPost()
    {
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('removePost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer());
        $manipulator->delete($post);
    }

    private function getMockPost()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Model\PostInterface');
    }

    private function getMockPostManager()
    {
        $postManager = $this->getMockBuilder('Sylius\Bundle\BloggerBundle\Model\PostManagerInterface')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $postManager;
    }

    private function getMockBlamer()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Blamer\PostBlamerInterface');
    }

}
