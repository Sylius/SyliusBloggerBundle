<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Model;

use Sylius\Bundle\BloggerBundle\Sorting\SorterInterface;

/**
 * Post manager interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PostManagerInterface
{
    /**
     * Creates new post object.
     *
     * @return PostInterface
     */
    function createPost();

    /**
     * Creates a paginator instance.
     *
     * @param SorterInterface $sorter
     * @param Boolean         $filterNotPublished
     */
    function createPaginator(SorterInterface $sorter = null, $filterNotPublished = true);

    /**
     * Persist post.
     *
     * @param PostInterface
     */
    function persistPost(PostInterface $category);

    /**
     * Removes post.
     *
     * @param PostInterface $category
     */
    function removePost(PostInterface $category);

    /**
     * Finds post by id.
     *
     * @param integer $id
     * @return PostInterface
     */
    function findPost($id);

    /**
     * Finds post by criteria.
     *
     * @param array $criteria
     * @return PostInterface
     */
    function findPostBy(array $criteria);

    /**
     * Finds all posts.
     *
     * @return array
     */
    function findPosts();

    /**
     * Finds posts by criteria.
     *
     * @param array $criteria
     * @return array
     */
    function findPostsBy(array $criteria);

    /**
     * Returns FQCN of post.
     *
     * @return string
     */
    function getClass();
}
