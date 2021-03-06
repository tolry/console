<?php

/*
 * This file is part of the webmozart/console package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Console\Tests\IO\Input;

use PHPUnit_Framework_TestCase;
use Webmozart\Console\IO\Input\StreamInput;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class StreamInputTest extends PHPUnit_Framework_TestCase
{
    const LOREM_IPSUM = "Lorem ipsum dolor sit amet,\nconsetetur sadipscing elitr,\nsed diam nonumy eirmod tempor invidunt";

    private $handle;

    protected function setUp()
    {
        $this->handle = fopen('php://memory', 'rw');

        fwrite($this->handle, self::LOREM_IPSUM);
        rewind($this->handle);
    }

    protected function tearDown()
    {
        @fclose($this->handle);
    }

    public function testRead()
    {
        $input = new StreamInput($this->handle);

        $this->assertSame('L', $input->read(1));
        $this->assertSame('o', $input->read(1));
        $this->assertSame('rem ipsum dolor sit ', $input->read(20));
        $this->assertSame("amet,\nconsetetur sadipscing elitr,\nsed diam nonumy eirmod tempor invidunt", $input->read(100));
        $this->assertNull($input->read(1));
    }

    /**
     * @expectedException \Webmozart\Console\Api\IO\IOException
     */
    public function testReadFailsAfterClose()
    {
        $input = new StreamInput($this->handle);
        $input->close();

        $input->read(1);
    }

    public function testReadLine()
    {
        $input = new StreamInput($this->handle);

        $this->assertSame("Lorem ipsum dolor sit amet,\n", $input->readLine());
        $this->assertSame('consetetu', $input->readLine(10));
        $this->assertSame("r sadipscing elitr,\n", $input->readLine(100));
        $this->assertSame('sed diam nonumy eirmod tempor invidunt', $input->readLine());
        $this->assertNull($input->readLine());
    }

    /**
     * @expectedException \Webmozart\Console\Api\IO\IOException
     */
    public function testReadLineFailsAfterClose()
    {
        $input = new StreamInput($this->handle);
        $input->close();

        $input->readLine();
    }

    public function testIgnoreDuplicateClose()
    {
        $input = new StreamInput($this->handle);
        $input->close();
        $input->close();
    }
}
