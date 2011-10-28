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

use Sylius\Bundle\BloggerBundle\Blamer\PostBlamerInterface;

use Sylius\Bundle\BloggerBundle\Model\PostManagerInterface;

use Sylius\Bundle\BloggerBundle\Inflector\SlugizerInterface;
use Sylius\Bundle\BloggerBundle\Model\PostInterface;

/**
 * Post manipulator.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PostManipulator implements PostManipulatorInterface
{
    /**
     * Post manager.
     * 
     * @var PostManagerInterface
     */
    protected $postManager;
    
    /**
     * Blamer.
     * 
     * @var PostBlamerInterface
     */
    protected $postBlamer;
    
    /**
     * Slugizer inflector.
     * 
     * @var SlugizerInterface
     */
    protected $slugizer;
    
    /**
     * Constructor.
     * 
     * @param SlugizerInterface $slugizer
     */
    public function __construct(PostManagerInterface $postManager, PostBlamerInterface $postBlamer, SlugizerInterface $slugizer)
    {
        $this->postManager = $postManager;
        $this->postBlamer = $postBlamer;
        $this->slugizer = $slugizer;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create(PostInterface $post)
    {
        $post->setSlug($this->slugizer->slugize($post->getTitle()));
        
        $this->postBlamer->blame($post);
        $this->postManager->persistPost($post);
    }
    
	/**
     * {@inheritdoc}
     */
    public function update(PostInterface $post)
    {        
        $post->setSlug($this->slugizer->slugize($post->getTitle()));
        
        $this->postBlamer->blame($post);
        $this->postManager->persistPost($post);
    }
    
	/**
     * {@inheritdoc}
     */
    public function delete(PostInterface $post)
    {         
        $this->postManager->removePost($post);
    }
}
