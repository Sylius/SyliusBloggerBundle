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
use Sylius\Bundle\BloggerBundle\Model\PostInterface;
use Sylius\Bundle\BloggerBundle\Model\PostManagerInterface;

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
     * Constructor.
     *
     * @param PostManagerInterface $postManager
     * @param PostBlamerInterface  $postBlamer
     */
    public function __construct(PostManagerInterface $postManager, PostBlamerInterface $postBlamer)
    {
        $this->postManager = $postManager;
        $this->postBlamer = $postBlamer;
    }

    /**
     * {@inheritdoc}
     */
    public function create(PostInterface $post)
    {
        $this->postBlamer->blame($post);
        $this->postManager->persistPost($post);
    }

    /**
     * {@inheritdoc}
     */
    public function update(PostInterface $post)
    {
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

    /**
     * {@inheritdoc}
     */
    public function publish(PostInterface $post)
    {
        $post->setPublished(true);
        $this->update($post);
    }

    /**
     * {@inheritdoc}
     */
    public function unpublish(PostInterface $post)
    {
        $post->setPublished(false);
        $this->update($post);
    }
}
