<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Tests\EventDispatcher\Event;

use Sylius\Bundle\BloggerBundle\EventDispatcher\Event\FilterPostEvent;

class FilterPostEventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $post = $this->getMockPost();
        $event = new FilterPostEvent($post);
        $this->assertEquals($post, $event->getPost());
    }

    private function getMockPost()
    {
        return $this->getMock('Sylius\Bundle\BloggerBundle\Model\PostInterface');
    }
}