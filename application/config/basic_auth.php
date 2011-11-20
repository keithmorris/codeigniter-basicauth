<?php
/**
 * 
 */
$config['basic_auth_config'] = array(
	'password_type' => 'md5',
	'tokensalt' => 'aLZeKW21ul8Ccjzm75YIFdCq2w50Av6y'
);

/**
 * 
 */
$config['basic_auth_users'] = array(
	
	'adrienne' => '5ed0328b6da6a10f503dd55711bc8d78',
	'ben' => '5ed0328b6da6a10f503dd55711bc8d78',
	'jason' => '5ed0328b6da6a10f503dd55711bc8d78',
	'julie' => '5ed0328b6da6a10f503dd55711bc8d78',
	'justin' => '5ed0328b6da6a10f503dd55711bc8d78',
	'keith' => '5ed0328b6da6a10f503dd55711bc8d78'
);

/**
 * 
 */
$config['basic_auth_groups'] = array(
	'admins' => array(
		'keith',
		'justin'
	),
	'editors' => array(
		'keith',
		'jason'
	),
	'viewers' => array(
		'julie',
		'ben',
		'adrienne'
	)
);