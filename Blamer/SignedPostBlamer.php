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

use Symfony\Component\Security\Core\SecurityContextInterface;
use Sylius\Bundle\BloggerBundle\Model\SignedPostInterface;
use Sylius\Bundle\BloggerBundle\Model\PostInterface;

/**
 * Blamer that assigns security user to post.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SignedPostBlamer implements PostBlamerInterface
{
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

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
