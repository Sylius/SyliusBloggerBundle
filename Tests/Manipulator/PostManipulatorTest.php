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

class PostManipulatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateSetsPostSlug()
    {
        $slugizer = $this->getMockSlugizer();
        $slugizer->expects($this->once())
            ->method('slugize')
            ->with($this->equalTo('foo bar'))
            ->will($this->returnValue('foo-bar'))
        ;

        $post = $this->getMockPost();
        $post->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('foo bar'))
        ;
        $post->expects($this->once())
            ->method('setSlug')
            ->with($this->equalTo('foo-bar'))
        ;

        $manipulator = new PostManipulator($this->getMockPostManager(), $this->getMockBlamer(), $slugizer);
        $manipulator->create($post);
    }

    public function testCreateIncrementsPostCreatedAt()
    {
        $slugizer = $this->getMockSlugizer();

        $post = $this->getMockPost();
        $post->expects($this->once())
            ->method('incrementCreatedAt')
        ;

        $manipulator = new PostManipulator($this->getMockPostManager(), $this->getMockBlamer(), $slugizer);
        $manipulator->create($post);
    }

    public function testCreatePersistsPost()
    {
        $slugizer = $this->getMockSlugizer();
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('persistPost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer(), $slugizer);
        $manipulator->create($post);
    }

    public function testUpdateSetsPostSlug()
    {
        $slugizer = $this->getMockSlugizer();
        $slugizer->expects($this->once())
            ->method('slugize')
            ->with($this->equalTo('foo bar'))
            ->will($this->returnValue('foo-bar'))
        ;

        $post = $this->getMockPost();
        $post->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('foo bar'))
        ;
        $post->expects($this->once())
            ->method('setSlug')
            ->with($this->equalTo('foo-bar'))
        ;

        $manipulator = new PostManipulator($this->getMockPostManager(), $this->getMockBlamer(), $slugizer);
        $manipulator->update($post);
    }

    public function testUpdateIncrementsPostUpdatedAt()
    {
        $slugizer = $this->getMockSlugizer();

        $post = $this->getMockPost();
        $post->expects($this->once())
            ->method('incrementUpdatedAt')
        ;

        $manipulator = new PostManipulator($this->getMockPostManager(), $this->getMockBlamer(), $slugizer);
        $manipulator->update($post);
    }

    public function testUpdatePersistsPost()
    {
        $slugizer = $this->getMockSlugizer();
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('persistPost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer(), $slugizer);
        $manipulator->update($post);
    }

    public function testDeleteRemovesPost()
    {
        $slugizer = $this->getMockSlugizer();
        $post = $this->getMockPost();

        $postManager = $this->getMockPostManager();
        $postManager->expects($this->once())
            ->method('removePost')
            ->with($this->equalTo($post))
        ;

        $manipulator = new PostManipulator($postManager, $this->getMockBlamer(), $slugizer);
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
        $postManager->expects($this->any())
            ->method('persistPost')
            ->will($this->returnValue(null))
        ;

        return $postManager;
    }

    private function getMockBlamer()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Blamer\PostBlamerInterface');
    }

    private function getMockSlugizer()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Inflector\SlugizerInterface');
    }
}