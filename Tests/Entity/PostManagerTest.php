<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Tests\Entity;

use Sylius\Bundle\BloggerBundle\Entity\PostManager;

class PostManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testPersistPost()
    {
        $post = $this->getMockPost();

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($post))
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $postManager = new PostManager($entityManager, 'Foo\Bar');
        $postManager->persistPost($post);
    }

    public function testRemovePost()
    {
        $post = $this->getMockPost();

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($post))
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $postManager = new PostManager($entityManager, 'Foo\Bar');
        $postManager->removePost($post);
    }

    private function getMockPost()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Model\PostInterface');
    }

    private function getMockEntityManager()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->setMethods(array('persist', 'remove', 'flush', 'getRepository'))
            ->getMock()
        ;
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue(null))
        ;

        return $entityManager;
    }
}
