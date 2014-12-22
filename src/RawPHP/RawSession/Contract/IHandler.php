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
 * @package   RawPHP\RawSession\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSession\Contract;

/**
 * Interface IHandler
 *
 * @package RawPHP\RawSession\Contract
 */
interface IHandler
{
    /**
     * Create new session.
     *
     * @param string $path
     */
    public function create( $path = '' );

    /**
     * Destroy session.
     */
    public function destroy();

    /**
     * Add a session item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function add( $key, $value );

    /**
     * Get a session item.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get( $key, $default = NULL );

    /**
     * Determine if the item exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has( $key );

    /**
     * Remove an item from the session.
     *
     * @param string $key
     */
    public function remove( $key );
}