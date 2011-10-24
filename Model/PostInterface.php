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
     * @return integer
     */
    function getId();
    
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
     * Get creation time.
     * 
     * @return \DateTime
     */
    function getCreatedAt();
    
    /**
     * Increments creation time.
     * 
     * @return null
     */
    function incrementCreatedAt();

	/**
     * Get modification time.
     * 
     * @return \DateTime
     */
    function getUpdatedAt();
}
