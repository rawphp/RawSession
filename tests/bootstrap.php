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
 * @category  PHP
 * @package   RawPHP/RawSession
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

defined( 'DS' )                 || define( 'DS', DIRECTORY_SEPARATOR );
defined( 'SUPPORT_DIR' )        || define( 'SUPPORT_DIR', dirname( __FILE__ ) . DS . '_support' . DS );
defined( 'OUTPUT_DIR' )         || define( 'OUTPUT_DIR', dirname( __FILE__ ) . DS . '_output' . DS );

defined( 'TEST_LOCK_FILE' )     || define( 'TEST_LOCK_FILE', OUTPUT_DIR . 'test.lock' );
defined( 'SESSION_NAMESPACE' )  || define( 'SESSION_NAMESPACE', 'RawPHP\\RawSession\\' );

require_once dirname( dirname( __FILE__ ) ) . DS . 'vendor' . DS . 'autoload.php';

touch( TEST_LOCK_FILE );
