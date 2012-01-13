<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\EventDispatcher\Event;

use Sylius\Bundle\BloggerBundle\Model\PostInterface;
use Symfony\Component\EventDispatcher\Event;

final class FilterPostEvent extends Event
{
    private $post;

    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}
