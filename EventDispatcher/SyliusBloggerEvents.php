<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\EventDispatcher;

/** 
 * Sylius blogger events.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
final class SyliusBloggerEvents
{
    const POST_CREATE     = 'sylius_blogger.event.post.create';
    const POST_UPDATE     = 'sylius_blogger.event.post.update';
    const POST_DELETE     = 'sylius_blogger.event.post.delete';
}
