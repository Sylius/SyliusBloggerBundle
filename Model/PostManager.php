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
 * Post manager base class.
 * 
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class PostManager implements PostManagerInterface
{
    /**
     * Post class.
     * 
     * @var string
     */
    protected $class;
    
    /**
     * Constructor.
     * 
     * @var string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }
    
    /**
     * Returns FQCN of post.
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * Sets FQCN of post.
     * 
     * @param string
     * @return null
     */
    public function setClass($class)
    {
        $this->class = $class;
    }
}
