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
 * Signed post model.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SignedPost extends Post implements SignedPostInterface
{
    protected $user;
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
    
    public function getAuthor()
    {
        return $this->user->getUsername();
    }
    
    public function setAuthor($author)
    {
    }
}
