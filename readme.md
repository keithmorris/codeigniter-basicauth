# CodeIgniter BasicAuth Library

This is a simple authorization and permissions Library that works simply off of a config file. The library is distributed with a simple example application that demonstrates protected method and a sample authentication controller for handling the UI for logging in, not-authorized messages, etc.

## Requirements

1. PHP 5.2+
2. CodeIgniter 2.0.3+ (may work on 1.7.x+ but have not tested)

## Usage

This Basic Authentication library is, at its core, simply a library to handle authentication and authorization without the need for a database. The library is simply a set of methods to authenticate a user and to determine if the current user is allowed to access the requested method of the controller.

The library is distributed with an example application as well as a demonstration of a working authentication UI that can be used as a starting point to build your own.

[Example Text](http://www.google.com)

## Change Log

### 0.2
* Updated Codeigniter core to 2.1.0
* Cleaned up the example application
* added a simple utility method (hashpassword) to MD5 hash a string for use in generating the hashes for the md5 hashed user passwords (http://example.com/authenticate/hashpassword



## Contact Me

If you have found BasicAuth useful, please drop me a line and let me know at standupbass [at] gmail dot com. Better yet, fork the code and contribute some enhancements