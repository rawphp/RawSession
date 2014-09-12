
# RawSession - A Simple Session Wrapper Class for PHP Applications

## Class Features

- Easily manage sessions with `start()`, `close()`, `destroy()` and `recreate()`
- Manage data persistence across requests with `add()`, `get()`, `remove()`

## Installation

### Composer
RawSession is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-session).

Add `""rawphp/raw-session": "dev-master"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-session": "dev-master"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-session "dev-master"
```

### Tarball
Alternatively, just copy the contents of the RawSession folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Basic Usage

```php
<?php

use RawPHP\RawSession\Session;

// optional configuration
$config = array(
    'auto_start' => FALSE,  // should the session be started automatically
    'strict'     => TRUE,   // throw exceptions if there are problems with the session
);

// create a new session instance
$session = new Session( $config );

// start session
$session->start( );

// get session ID
$id     = $session->getID( );

// get session status
$status = $session->getStatus( );

// add a value to the session
$session->add( 'user_id', 1 );

// get a value from the session
$userID = $session->get( 'user_id' );

// remove value from the session
$session->remove( 'user_id' );

// destroy the session
$session->destroy( );

// destroy and start a new session
$session->recreate( );
```

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawSession/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawSession/issues).

## Changelog

- Initial Code Commit
