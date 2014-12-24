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
 * @package   RawPHP\RawSession
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
namespace RawPHP\RawSession;

use RawPHP\RawSession\Contract\IHandler;
use RawPHP\RawSession\Contract\ISession;
use RawPHP\RawSession\Exception\InvalidSessionException;
use RawPHP\RawSession\Handler\FileHandler;
use RawPHP\RawSession\Handler\Handler;
use RawPHP\RawSession\Handler\PHPHandler;

/**
 * This class can be used to manage sessions in the application.
 *
 * @category  PHP
 * @package   RawPHP\RawSession
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Session implements ISession
{
    /** @var  Handler */
    protected $handler;

    /**
     * Create new session.
     *
     * @param array    $config
     * @param IHandler $handler
     */
    public function __construct( array $config = [ ], IHandler $handler = NULL )
    {
        $this->handler = $handler;

        if ( !empty( $config ) )
        {
            $this->init( $config );
        }
    }

    /**
     * Initialises the session.
     *
     * If config array is specified this function
     * will update the session and calls session_start();
     *
     * @param array $config configuration array
     */
    public function init( $config = NULL )
    {
        $path = '';

        if ( is_array( $config ) )
        {
            foreach ( $config as $key => $value )
            {
                switch ( $key )
                {
                    case 'handler':
                        if ( 'file' === $value )
                        {
                            $this->handler = new FileHandler();
                        }
                        elseif ( 'php' === $value )
                        {
                            $this->handler = new PHPHandler();
                        }
                        break;

                    case 'strict':
                        $this->handler->setStrict( $value );
                        break;

                    case 'session_path':
                        $path = $value;
                        break;

                    case 'session_id':
                        $this->handler->setSessionID( $value );
                        break;

                    default:
                        // Do nothing
                        break;
                }
            }
        }

        if ( NULL !== $this->handler )
        {
            $this->handler->create( $path );
        }
        else
        {
            throw new InvalidSessionException( 'Session has no valid handler.' );
        }
    }

    /**
     * Starts a new Session.
     */
    public function create()
    {
        $this->handler->create();
    }

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
    public function destroy()
    {
        if ( NULL == $this->handler )
        {
            throw new InvalidSessionException( 'Unable to destroy session. Handler is NULL.' );
        }

        $this->handler->destroy();
    }

    /**
     * Destroys and starts a new session.
     */
    public function recreate()
    {
        $this->destroy();
        $this->create();
    }

    /**
     * Returns the session ID.
     *
     * @return string session ID
     */
    public function getID()
    {
        return $this->handler->getSessionID();
    }

    /**
     * Returns the session status.
     *
     * If PHP version < 5.4 returns 'Unknown'.
     *
     * @return string session status
     */
    public function getStatus()
    {
        $retval = NULL;

//        if ( version_compare( '5.4.0', phpversion(), '>' ) )
//        {
//            return self::STATUS_UNKNOWN;
//        }
//
//        switch ( session_status() )
//        {
//            case 0:
//                $retval = self::STATUS_DISABLED;
//                break;
//
//            case 1:
//                $retval = self::STATUS_NONE;
//                break;
//
//            case 2:
//                $retval = self::STATUS_ACTIVE;
//                break;
//
//            default:
//                $retval = self::STATUS_UNKNOWN;
//                break;
//        }

        return $retval;
    }

    /**
     * Retrieves a value from the session.
     *
     * @param string $key the key
     *
     * @return mixed the value for the key or NULL
     */
    public function get( $key )
    {
        return $this->handler->get( $key );
    }

    /**
     * Adds a key->value pair to the current session.
     *
     * @param string $key   the key
     * @param mixed  $value the value
     */
    public function add( $key, $value )
    {
        $this->handler->add( $key, $value );
    }

    /**
     * Removes a value from the session.
     *
     * @param string $key key for the value
     */
    public function remove( $key )
    {
        $this->handler->remove( $key );
    }

    /**
     * Get the session handler.
     *
     * @return IHandler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Set the session handler.
     *
     * @param IHandler $handler
     */
    public function setHandler( IHandler $handler )
    {
        $this->handler = $handler;
    }

    const STATUS_UNKNOWN = 'Unknown';
    const STATUS_DISABLED = 'Disabled';
    const STATUS_NONE = 'None';
    const STATUS_ACTIVE = 'Active';

    /**
     * Remove a handler from the session.
     *
     * @param IHandler $handler
     */
    public function removeHandler( IHandler $handler = NULL )
    {
        if ( NULL !== $handler && $this->handler == $handler )
        {
            $this->handler = NULL;
        }
        else
        {
            $this->handler = NULL;
        }
    }
}