<?php

/*
 * This file is part of the webmozart/console package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Console\Tests\Api\Config\Fixtures;

use Webmozart\Console\Api\Config\Config;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class ConcreteConfig extends Config
{
    public $configureCalled = false;

    protected function configure()
    {
        $this->configureCalled = true;
    }
}
