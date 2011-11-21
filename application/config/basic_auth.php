<?php
/*
 *--------------------------------------------------------------------------
 * BasicAuth config
 *--------------------------------------------------------------------------
 *
 * This config parameter is an associative array of two values: password_type 
 * and tokensalt.
 * 
 * Currently the only tso supported types of password type are 'md5' and plain. 
 * If this is set to md5, the password in the basic_auth_users array below needs 
 * to be md5 hashed.
 * 
 * tokensalt is a random string of letters and numbers that are used to salt the 
 * session data of an authenticated user to make it a little more secure. Please 
 * set this to a randome string of characters (upper and lower) and numbers.
 *
 */
$config['basic_auth_config'] = array(
	'password_type' => 'md5',
	'tokensalt' => 'aLZeKW21ul8Ccjzm75YIFdCq2w50Av6y'
);

/*
 *--------------------------------------------------------------------------
 * BasicAuth Users
 *--------------------------------------------------------------------------
 *
 * This config parameter is an associative array of users. The key to the array 
 * is the username while the value is the password of that user. If 'md5' is 
 * selected in the 'password_type' key of the basic_auth_config array above 
 * (recommended and default), then the value here should be an md5 hash of the 
 * actual password. If you are not going to use md5, then this should be plain 
 * text.
 * 
 * In the sample data here, '5ed0328b6da6a10f503dd55711bc8d78' is the md5 hash 
 * for the password 'cornbread'
 *
 */
$config['basic_auth_users'] = array(
	
	'dave' => '5ed0328b6da6a10f503dd55711bc8d78',
	'jessica' => '5ed0328b6da6a10f503dd55711bc8d78',
	'jason' => '5ed0328b6da6a10f503dd55711bc8d78',
	'julie' => '5ed0328b6da6a10f503dd55711bc8d78',
	'justin' => '5ed0328b6da6a10f503dd55711bc8d78',
	'steve' => '5ed0328b6da6a10f503dd55711bc8d78'
);

/*
 *--------------------------------------------------------------------------
 * BasicAuth Groups
 *--------------------------------------------------------------------------
 *
 * This config parameter is an associative array of user groups. The name of the 
 * group is the value that is used when locking down the different methods of 
 * your controller. The key is the name of the authentication group while the 
 * value is an array of the basic_auth_users from above that are in the group.
 *
 */
$config['basic_auth_groups'] = array(
	'admins' => array(
		'steve',
		'justin'
	),
	'editors' => array(
		'steve',
		'jason'
	),
	'viewers' => array(
		'dave',
		'jessica',
		'jason',
		'julie'
	)
);

/* End of file basic_auth.php */
/* Location: ./application/config/basic_auth.php */