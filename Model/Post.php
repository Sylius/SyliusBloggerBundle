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
 * Post model.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class Post implements PostInterface
{
    /**
     * Id.
     */
    protected $id;

    /**
     * Post title.
     */
    protected $title;
    
    /**
     * Slug.
     */
    protected $slug;

    /**
     * Author.
     * 
     * @var string
     */
    protected $author;
    
    /**
     * Content.
     */
    protected $content;
    
    /**
     * Creation time.
     */
    protected $createdAt;
    
    /**
     * Modification time.
     */
    protected $updatedAt;
    
    /**
     * Constructor.
     * Defines default entity values.
     */
    public function __construct()
    {
        $this->incrementCreatedAt();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
    	return $this->title;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
    	$this->title = $title;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
    	return $this->slug;
    }
    
	/**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function incrementCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

	/**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * {@inheritdoc}
     */
    public function incrementUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
}
