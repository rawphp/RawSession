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
 * PHP version 5.3
 * 
 * @category  PHP
 * @package   RawPHP/RawSession
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSession;

/**
 * This session interface.
 * 
 * @category  PHP
 * @package   RawPHP/Core
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
interface ISession
{
    /**
     * Starts a new Session.
     */
    public function start();
    
    /**
     * Closes the session.
     * 
     * Nothing happens if there is no session.
     * 
     * If strict is used, then an exception will be thrown
     * if there is no session to close.
     * 
     * @throws InvalidSessionException if there is no session to close
     */
    public function close();
    
    /**
     * Destroys the active session.
     * 
     * Nothing happens if there is no session.
     * 
     * If strict is used, then an exception will be thrown
     * if there is no session to close.
     * 
     * @throws InvalidSessionException if there is no session to close
     */
    public function destroy();
    
    /**
     * Destroys and starts a new session.
     */
    public function recreate();
    
    /**
     * Returns the session ID.
     * 
     * @return string session ID
     */
    public function getID();
    
    /**
     * Returns the session status.
     * 
     * @return string session status
     */
    public function getStatus();
    
    /**
     * Retrieves a value from the session.
     * 
     * @param string $key the key
     * 
     * @return mixed the value for the key or NULL
     */
    public function get( $key );
    
    /**
     * Adds a key->value pair to the currernt session.
     * 
     * @param string $key   the key
     * @param mixed  $value the value
     */
    public function add( $key, $value );
    
    /**
     * Removes a value from the session.
     * 
     * @param string $key key for the value
     */
    public function remove( $key );
}