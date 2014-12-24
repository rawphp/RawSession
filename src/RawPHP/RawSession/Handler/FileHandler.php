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
 * @package   RawPHP\RawSession\Handler
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSession\Handler;

/**
 * Class FileHandler
 *
 * @package RawPHP\RawSession\Handler
 */
class FileHandler extends Handler
{
    /** @var  array */
    protected $items;

    /**
     * Create new session.
     *
     * @param string $path
     */
    public function create( $path = '' )
    {
        $this->sessionPath = $path;

        if ( file_exists( $path ) )
        {
            $this->getFileContents();
        }
        else
        {
            $this->items = [ ];
        }
    }

    /**
     * Destroy session.
     */
    public function destroy()
    {
        unlink( $this->sessionPath );

        $this->items = [ ];
    }

    /**
     * Add a session item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function add( $key, $value )
    {
        $this->items[ $key ] = $value;

        $this->updateSessionFile();
    }

    /**
     * Get a session item.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get( $key, $default = NULL )
    {
        if ( $this->has( $key ) )
        {
            return $this->items[ $key ];
        }

        return $default;
    }

    /**
     * Determine if the item exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has( $key )
    {
        return isset( $this->items[ $key ] );
    }

    /**
     * Remove an item from the session.
     *
     * @param string $key
     */
    public function remove( $key )
    {
        if ( $this->has( $key ) )
        {
            unset( $this->items[ $key ] );
        }

        $this->updateSessionFile();
    }

    /**
     * Write items to file.
     */
    protected function updateSessionFile()
    {
        $json = json_encode( $this->items );

        file_put_contents( $this->path, $json );
    }

    /**
     * Get file contents from file.
     */
    protected function getFileContents()
    {
        $json = file_get_contents( $this->sessionPath );

        $this->items = json_decode( $json );
    }
}