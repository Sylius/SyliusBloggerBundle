<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Blamer;

use Sylius\Bundle\BloggerBundle\Model\PostInterface;

/**
 * Interface for post blamer.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PostBlamerInterface
{
    /**
     * Sets user or username as post author.
     *
     * @param PostInterface $post
     */
    function blame(PostInterface $post);
}
