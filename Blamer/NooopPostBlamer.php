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

use Sylius\Bundle\BloggerBundle\Model\PostInterface;

/**
 * Post blamer that does nothing...
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class NooopPostBlamer implements PostBlamerInterface
{
    /**
     * Pufff.
     *
     * @param PostInterface $post
     */
    public function blame(PostInterface $post)
    {
        // do nothing.
    }
}
