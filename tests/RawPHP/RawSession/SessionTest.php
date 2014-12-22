<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 *
 * Copyright (c) 2014 RawPHP.org
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   RawPHP\RawSession\Tests
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSession;

use PHPUnit_Framework_TestCase;
use RawPHP\RawSession\Exception\InvalidSessionException;

/**
 * This session class tests.
 *
 * @category  PHP
 * @package   RawPHP\RawSession\Tests
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    /**
     * The session instance.
     *
     * @var Session
     */
    public $session;

    /**
     * Cleanup after test suite run.
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        if ( file_exists( TEST_LOCK_FILE ) )
        {
            unlink( TEST_LOCK_FILE );
        }
    }

    /**
     * Setup for each test.
     */
    protected function setUp()
    {
        global $config;

        $this->session = new Session( $config );
    }

    /**
     * Cleanup after each test.
     */
    protected function tearDown()
    {
        try
        {
            $this->session->destroy();
        }
        catch ( InvalidSessionException $e )
        {
            // Do nothing
        }
    }

    /**
     * Test session instantiated correctly.
     */
    public function testSessionInstantiatedCorrectly()
    {
        $this->assertNotNull( $this->session );
    }

    /**
     * Test session throws exception if there is no session to destroy.
     *
     * @expectedException \RawPHP\RawSession\Exception\InvalidSessionException
     */
    public function testDestroyThrowExceptionWhenNoSessionExists()
    {
        $this->session->destroy();
    }
}