# CodeIgniter BasicAuth Library

This is a simple authorization and permissions Library that works simply off of a config file. The library is distributed with a simple example application that demonstrates protected method and a sample authentication controller for handling the UI for logging in, not-authorized messages, etc.

I built this library because all of the other Auth libraries I found required a database. I was building an application that didn't require a database so I didn't want to create a database simply for authentication. The main purpose of the authentication was to allow some teams to review progress on the application while restricting access to other teams until the sections were ready for review.

Please note that this is a fairly insecure method of authentication and authorization and should not be used for production applications that require any degree of strong security.

Hopefully you will find it helpful for those projects that need a quick lockdown mechanism.

## Requirements

1. PHP 5.2+
2. CodeIgniter 2.0.3+ (may work on 1.7.x+ but have not tested)

## Usage

This Basic Authentication library is, at its core, simply a library to handle authentication and authorization without the need for a database. The library is simply a set of methods to authenticate a user and to determine if the current user is allowed to access the requested method of the controller.

The library is distributed with an example application to show how to configure authorization levels via groups as well as a demonstration of a working authentication UI that can be used as a starting point to build your own.

There are only two files in the distribution that you really need in order to use the BasicAuth library:
```shell	
	/application/libraries/Basic_auth.php
	/application/config/basic_auth.php
```

Within the config file, you define the list of users with their passwords as an associative array with the key being the username and the value being the password. By default, the library expects the password to be stored as an md5 has of the actual password. You then define groups that the users belong to. The per-method authorization is done at the group level; not the user level.

To configure the protection on each of the methods, in the constructor of the controller, you load the Basic Auth library then set the methods that are to be protected via the set_protected_methods() method of the Basic Auth library. The configuration is an associative array where the key is the name of the method to be protected and the value is a comma-delimited list of groups that are allowed to access the method. By default, there is a wildcard '*' key that can be used that overrides all other keys. This wildcard sets all methods of the controller to be protected and accessible only to the groups specified for the wildcard method. Please note that setting the wildcard will protect ALL methods so any authentication and/or "Not Authorized" pages you want to create will have to be created in a different controller and not the one being protected. The example app demonstrates this.
```php
	$this->load->library('Basic_auth');
	$this->basic_auth->set_protected_methods(array(
		// Uncomment the '*' line below to protect all methods
		//'*' => 'user,admins',
		'restricted' => 'viewers,editors,admins',
		'adminsonly' => 'admins'
	));
```
After this, you call the check() method of the Basic Auth library which determines if the current method should be protected and if so, if the current user is logged in and has access. This method returns one of three scenarios:

* If user is logged in and has permission to access the method, check() returns TRUE.
* If the user is not logged in, the method returns false and sets the error property of the library to indicate that the user is not logged in. 
* If the user is logged in but does not have permission to access the method, it returns false but sets the error property to indicate that the user is not authorized. 

If the check() method returns TRUE, you should pass the user through to the requested method.

In the event of one of the errors above, the error message can be retrieved via the $this->basic_auth->get_error() method and will hold the value of one of the following two constants:
```shell
	Basic_auth::ERROR_USER_NOT_LOGGED_IN
	Basic_auth::ERROR_USER_NOT_AUTHORIZED
```

See the distributed sample application for an example of how to handle these errors and login the user or present them with a "Not Authorized" page.

### A Note about Passwords

The library defaults to expecting the passwords stored in the config to be md5 hashes of the actual password. You can use the included /utilities/hashpassword utility to create the hashes for your passwords.

By using the 'md5' value in the 'password\_type' in the config, you are simply instructing the $this->basic\_auth->login($user,$pass) method to md5 hash the password before checking it against the value in the config. i.e. login expects a plaintext password to be passed to it and it will hash it. If you have a different encryption method or plan on doing the hashing before passing it to the login() method, change the password_type property in the config file to 'plain' and it will compare whatever you pass into the login method directly with the password value in the config file.

## Change Log

### 0.2
* Updated Codeigniter core to 2.1.0
* Cleaned up the example application
* added a simple utility method (hashpassword) to MD5 hash a string for use in generating the hashes for the md5 hashed user passwords (http://example.com/utlilities/hashpassword



## Contact Me

If you have found BasicAuth useful, please drop me a line and let me know at standupbass [at] gmail dot com. Better yet, fork the code and contribute some enhancements.
