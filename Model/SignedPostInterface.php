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

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface for posts that are signed by security user.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SignedPostInterface extends PostInterface
{
    /**
     * Get user.
     *
     * @return UserInterface
     */
    function getUser();

    /**
     * Set user.
     *
     * @param UserInterface $user
     */
    function setUser(UserInterface $user);
}
