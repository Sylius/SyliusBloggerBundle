<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\BloggerBundle\Inflector;

/**
 * An object that creates a slug of given string.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
interface SlugizerInterface
{
    /**
     * Slugizes a string.
     *
     * @param string $string
     */
    function slugize($string);
}
