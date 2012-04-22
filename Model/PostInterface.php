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

/**
 * Post model interface.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface PostInterface
{
    /**
     * Returns post id.
     *
     * @return mixed
     */
    function getId();

    /**
     * Set post id.
     *
     * @param mixed $id
     */
    function setId($id);

    /**
     * Returns post title.
     *
     * @return string
     */
    function getTitle();

    /**
     * Sets post title.
     *
     * @param string
     */
    function setTitle($title);

    /**
     * Returns slug.
     *
     * @return string
     */
    function getSlug();

    /**
     * Sets slug.
     *
     * @param string
     *
     * @return null
     */
    function setSlug($slug);

    /**
     * Returns post content.
     *
     * @return string
     */
    function getContent();

    /**
     * Sets post content.
     *
     * @param string
     * @return null
     */
    function setContent($content);

    /**
     * Returns author.
     *
     * @return string
     */
    function getAuthor();

    /**
     * Sets post author.
     *
     * @param string $author
     */
    function setAuthor($author);

    /**
     * Is published?
     *
     * @return Boolean
     */
    function isPublished();

    /**
     * Set published.
     *
     * @param Boolean $published
     */
    function setPublished($published);

    /**
     * Get creation time.
     *
     * @return \DateTime
     */
    function getCreatedAt();

    /**
     * Set creation time.
     *
     * @param DateTime $createdAt
     */
    function setCreatedAt(\DateTime $createdAt);

    /**
     * Increments creation time.
     */
    function incrementCreatedAt();

    /**
     * Get modification time.
     *
     * @return \DateTime
     */
    function getUpdatedAt();

    /**
     * Set update time.
     *
     * @param \DateTime $updatedAt
     */
    function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Set update time to now.
     */
    function incrementUpdatedAt();
}
