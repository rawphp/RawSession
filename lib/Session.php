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
 * @package   RawPHP/RawSession
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawSession;

use RawPHP\RawBase\Component;
use RawPHP\RawSession\ISession;
use RawPHP\RawSession\InvalidSessionException;

/**
 * This class can be used to manage sessions in the application.
 * 
 * @category  PHP
 * @package   RawPHP/RawSession
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Session extends Component implements ISession
{
    private $_sessionPath;
    private $_sessionID;
    private $_strict        = FALSE;
    
    /**
     * Initialises the session.
     * 
     * If config array is specified this function
     * will update the session and calls session_start();
     * 
     * @param array $config configuration array
     * 
     * @action ON_SESSION_INIT_ACTION
     */
    public function init( $config )
    {
        if ( is_array( $config ) )
        {
            foreach ( $config as $key => $value )
            {
                switch ( $key )
                {
                    case 'strict':
                        $this->_strict = $value;
                        break;
                    
                    case 'session_path':
                        $this->_sessionPath = $value;
                        session_save_path( $this->_sessionPath );
                        break;
                    
                    case 'session_id':
                        $this->_sessionID = $value;
                        session_id( $this->_sessionID );
                        break;
                    
                    default:
                        // Do nothing
                        break;
                }
            }
        }
        
        if ( !file_exists( TEST_LOCK_FILE ) )
        {
            $this->start();
            
            $this->_sessionID = session_id();
        }
        
        if ( isset( $config[ 'auto_start' ] ) && $config[ 'auto_start' ] )
        {
            $this->start( );
        }
        
        $this->doAction( self::ON_SESSION_INIT_ACTION );
    }
    
    /**
     * Starts a new Session.
     * 
     * @action ON_SESSION_START_ACTION
     */
    public function start( )
    {
        session_start( );
        
        $this->_sessionID = session_id( );
        
        $this->doAction( self::ON_SESSION_START_ACTION );
    }
    
    /**
     * Closes the session.
     * 
     * Nothing happens if there is no session.
     * 
     * If strict is used, then an exception will be thrown
     * if there is no session to close.
     * 
     * @action ON_BEFORE_SESSION_CLOSE_ACTION
     * @action ON_AFTER_SESSION_CLOSE_ACTION
     * 
     * @throws InvalidSessionException if there is no session to close
     */
    public function close( )
    {
        $this->doAction( self::ON_BEFORE_SESSION_CLOSE_ACTION );
        
        if ( NULL !== $this->_sessionID )
        {
            session_write_close( );
        }
        elseif ( $this->_strict )
        {
            throw new InvalidSessionException( 'There is no session to close' );
        }
        
        $this->doAction( self::ON_AFTER_SESSION_CLOSE_ACTION );
    }
    
    /**
     * Destroys the active session.
     * 
     * Nothing happens if there is no session.
     * 
     * If strict is used, then an exception will be thrown
     * if there is no session to close.
     * 
     * @action ON_BEFORE_SESSION_DESTROY_ACTION
     * @action ON_AFTER_SESSION_DESTROY_ACTION
     * 
     * @throws InvalidSessionException if there is no session to close
     */
    public function destroy( )
    {
        $this->doAction( self::ON_BEFORE_SESSION_DESTROY_ACTION );
        
        if ( NULL !== $this->_sessionID )
        {
            session_destroy();
        }
        elseif ( $this->_strict )
        {
            throw new InvalidSessionException( 'There is no session to destroy' );
        }
        
        $this->doAction( self::ON_AFTER_SESSION_DESTROY_ACTION );
    }
    
    /**
     * Destroys and starts a new session.
     * 
     * @action ON_SESSION_RECREATE_ACTION
     */
    public function recreate( )
    {
        $this->destroy();
        $this->start();
        
        $this->doAction( self::ON_SESSION_RECREATE_ACTION );
    }
    
    /**
     * Returns the session ID.
     * 
     * @filter ON_GET_SESSION_ID_FILTER
     * 
     * @return string session ID
     */
    public function getID( )
    {
        return $this->filter( self::ON_GET_SESSION_ID_FILTER, $this->_sessionID );
    }
    
    /**
     * Returns the session status.
     * 
     * @fitler ON_GET_SESSION_STATUS_FILTER
     * 
     * @return string session status
     */
    public function getStatus( )
    {
        $retval = NULL;
        
        switch ( session_status( ) )
        {
            case 0:
                $retval = self::STATUS_DISABLED;
                break;
            
            case 1:
                $retval = self::STATUS_NONE;
                break;
            
            case 2:
                $retval = self::STATUS_ACTIVE;
                break;
            
            default:
                $retval = self::STATUS_UNKNOWN;
                break;
        }
        
        return $this->filter( self::ON_GET_SESSION_STATUS_FILTER, $retval );
    }
    
    /**
     * Retrieves a value from the session.
     * 
     * @param string $key the key
     * 
     * @filter ON_GET_SESSION_VALUE_FILTER
     * 
     * @return mixed the value for the key or NULL
     */
    public function get( $key )
    {
        $retval = NULL;
        
        if ( isset( $_SESSION[ $key ] ) )
        {
            $retval = $_SESSION[ $key ];
        }
        
        return $this->filters( self::ON_GET_SESSION_VALUE_FILTER, $retval, $key );
    }
    
    /**
     * Adds a key->value pair to the currernt session.
     * 
     * @param string $key   the key
     * @param mixed  $value the value
     * 
     * @filter ON_ADD_SESSION_VALUE_FILTER
     * @action ON_AFTER_ADD_SESSION_VALUE_ACTION
     */
    public function add( $key, $value )
    {
        $_SESSION[ $key ] = $this->filter( self::ON_ADD_SESSION_VALUE_FILTER, $value, $key );
        
        $this->doAction( self::ON_AFTER_ADD_SESSION_VALUE_ACTION );
    }
    
    /**
     * Removes a value from the session.
     * 
     * @param string $key key for the value
     * 
     * @filter ON_REMOVE_SESSION_VALUE_FILTER
     */
    public function remove( $key )
    {
        $key = $this->filter( self::ON_REMOVE_SESSION_VALUE_FILTER, $key );
        
        unset( $_SESSION[ $key ] );
    }
    
    const STATUS_UNKNOWN  = 'Unknown';
    const STATUS_DISABLED = 'Distabled';
    const STATUS_NONE     = 'None';
    const STATUS_ACTIVE   = 'Active';
    
    // hooks
    const ON_SESSION_INIT_ACTION            = 'on_session_init_action';
    const ON_SESSION_START_ACTION           = 'on_session_start_action';
    const ON_BEFORE_SESSION_CLOSE_ACTION    = 'on_before_session_close_action';
    const ON_AFTER_SESSION_CLOSE_ACTION     = 'on_session_close_action';
    const ON_BEFORE_SESSION_DESTROY_ACTION  = 'on_before_session_destroy_action';
    const ON_AFTER_SESSION_DESTROY_ACTION   = 'on_after_session_destroy_action';
    const ON_SESSION_RECREATE_ACTION        = 'on_session_recreate_action';
    const ON_AFTER_ADD_SESSION_VALUE_ACTION = 'on_after_add_session_value_action';
    
    const ON_GET_SESSION_ID_FILTER          = 'on_get_session_id_filter';
    const ON_GET_SESSION_STATUS_FILTER      = 'on_get_session_status_filter';
    const ON_GET_SESSION_VALUE_FILTER       = 'on_get_session_value_filter';
    const ON_ADD_SESSION_VALUE_FILTER       = 'on_add_session_value_filter';
    const ON_REMOVE_SESSION_VALUE_FILTER    = 'on_remove_session_value_filter';
}
