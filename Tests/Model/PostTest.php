<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Tests\Model;

class PostTest extends \PHPUnit_Framework_TestCase
{
    public function testTitle()
    {
        $post = $this->getPost();
        $this->assertNull($post->getTitle());

        $post->setTitle('testing post');
        $this->assertEquals('testing post', $post->getTitle());
    }

    public function testSlug()
    {
        $post = $this->getPost();
        $this->assertNull($post->getSlug());

        $post->setSlug('testing-post');
        $this->assertEquals('testing-post', $post->getSlug());
    }

    public function testContent()
    {
        $post = $this->getPost();
        $this->assertNull($post->getContent());

        $post->setContent('testing post...');
        $this->assertEquals('testing post...', $post->getContent());
    }

    protected function getPost()
    {
        return $this->getMockForAbstractClass('Sylius\Bundle\BloggerBundle\Model\Post');
    }
}
