<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Manipulator;

use Sylius\Bundle\BloggerBundle\Model\PostInterface;

/**
 * Post manipulator interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PostManipulatorInterface
{
    /**
     * Creates a post.
     *
     * @param PostInterface $post
     */
    function create(PostInterface $post);

    /**
     * Updates a post.
     *
     * @param PostInterface $post
     */
    function update(PostInterface $post);

    /**
     * Deletes a post.
     *
     * @param PostInterface $post
     */
    function delete(PostInterface $post);

    function publish(PostInterface $post);
    function unpublish(PostInterface $post);
}
