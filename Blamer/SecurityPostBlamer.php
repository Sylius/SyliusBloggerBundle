<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Blamer;

use Sylius\Bundle\BloggerBundle\Model\PostInterface;
use Sylius\Bundle\BloggerBundle\Model\SignedPostInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Blamer that assigns security user to post.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SecurityPostBlamer implements PostBlamerInterface
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function blame(PostInterface $post)
    {
        if (!$post instanceof SignedPostInterface) {
            throw new InvalidArgumentException('The post must implement Sylius\Bundle\BloggerBundle\Model\SignedPostInterface');
        }

        if (null === $this->securityContext->getToken()) {
            throw new RuntimeException('You must configure a firewall for this route');
        }

        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $post->setUser($this->securityContext->getToken()->getUser());
        }
    }
}
