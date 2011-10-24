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
class Slugizer implements SlugizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function slugize($string)
    {
        return preg_replace('/[^a-z0-9_\s-]/', '', preg_replace("/[\s_]/", "-", strtolower(trim($string))));
    }
}
