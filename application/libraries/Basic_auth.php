<?php
/*
	Copyright 2011 Keith Morris <standupbass@gmail.com>

	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.
*/

/**
 * basic_auth class
 * 
 * QuickAuth CodeIgniter library for doing simple config-based authentication 
 * without the need for a database.
 *
 * @author		Keith Morris <standupbass@gmail.com>
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @license		http://www.apache.org/licenses/LICENSE-2.0
 */
class Basic_auth
{
	/**
	 * Constant that is used to identify the error when a user tries to access a 
	 * protected method and is not logged in.
	 */
	const ERROR_USER_NOT_LOGGED_IN = 'errorUserNotLoggedIn';
	
	/**
	 * Constant that is used to identify the error when a logged-in user tries 
	 * to access a protected method to which they are not authorized.
	 */
	const ERROR_USER_NOT_AUTHORIZED = 'errorUserNotAuthorized';
	
	
	protected $CI;
	protected $config_file = 'basic_auth';
	protected $password_type = 'md5';
	protected $session_var_name = 'basic_auth';
	protected $wildcard_method = '*';
	
	protected $config;
	protected $users = array();
	protected $groups = array();
	protected $method;
	protected $logged_in_user = FALSE;


	protected $_error;
	protected $protected_methods = array();
	

	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->configure();
		$this->method = $this->CI->router->method;
	}
	
	/**
	 * Based on the configuration information about the protected methods that 
	 * is set with the 'set_protected_methods()' method, this method determines 
	 * if the current requested method is protected and, if so, checks if the 
	 * logged in user has permissions to access it. This returns TRUE if the 
	 * user is logged in and authorized. Otherwise it stores either the 
	 * ERROR_USER_NOT_LOGGED_IN or ERROR_USER_NOT_AUTHORIZED and returns FALSE. 
	 * The error can be retreived using get_error()
	 * 
	 * @return boolean
	 */
	public function check()
	{	
		if ($this->method_is_protected())
		{
			if ($this->user_is_logged_in())
			{
				if ($this->user_is_authorized())
				{
					return TRUE;
				}
				else
				{
					$this->_error = self::ERROR_USER_NOT_AUTHORIZED;
					return FALSE;
				}
			}
			else
			{
				$this->_error = self::ERROR_USER_NOT_LOGGED_IN;
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * Configures which methods are protected and which user groups can access 
	 * each method. The config parameter is an associative array where the key 
	 * is the name of the method and the value is a comma-delimited list of 
	 * group names that are allowed to access the method.
	 * 
	 * Should the key be the the wildcard method (default '*') this will 
	 * supercede all other method configurations and will apply to all methods.
	 * 
	 * The example below could be setup within your controller constructor (or a 
	 * method called in the constructor) to configure the protected methods.
	 * 
	 * <code>
	 *		$this->basic_auth->set_protected_methods(array(
	 *			'method_one' => 'viewers,editors,admins',
	 *			'method_two' => 'admins'
	 *		));
	 * </code>
	 * 
	 * @param array $config 
	 */
	public function set_protected_methods($config)
	{
		$this->protected_methods = $config;
	}
	
	
	/**
	 * The login method takes a username and password and checks it agains the 
	 * users setup in the config. If it matches, it creates an authtoken and 
	 * stores it as a session variable to indicate the user is logged in.
	 * 
	 * By default, the login method expectes that the password is stored in the 
	 * config as an md5 hash. If the config is set to md5, the login method 
	 * expects a plaintext $password which it will md5 then compare to the value 
	 * stored for that user in the config.
	 * 
	 * If you are using your own encryption method in your applicaiton, you will 
	 * want to set the password_type in the config to 'plain' then set the 
	 * password in the config to be an encoded version of the password using 
	 * your encryption method.
	 * 
	 * @param string $username
	 * @param string $password
	 * @return boolean 
	 */
	public function login($username, $password)
	{
		$this->logout();
		
		if($this->password_type == 'md5')
		{
			$password = md5($password);
		}
		
		if(isset($this->users[$username]) AND $this->users[$username] == $password)
		{
			$this->CI->session->set_userdata($this->session_var_name, array('user' => $username, 'authtoken' => $this->create_authtoken($username)));
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Logs the current user out of the system
	 * 
	 * @return boolean
	 */
	public function logout()
	{
		return $this->CI->session->unset_userdata($this->session_var_name);
	}
	
	/**
	 * Returns the error that was stored by the check() method.
	 * 
	 * @return string
	 */
	public function get_error()
	{
		return $this->_error;
	}

	/**
	 * Returns a boolean indicating if the current user is logged in. If they 
	 * are not, it attemts to auto log them in based on the session cookie 
	 * information.
	 * 
	 * @return boolean
	 */
	public function user_is_logged_in()
	{
		if($this->logged_in_user)
		{
			return true;
		}
		
		$session_auth_data = $this->CI->session->userdata($this->session_var_name);
		if ( !empty($session_auth_data) && !empty ($session_auth_data['user']) && !empty ($session_auth_data['authtoken']) )
		{
			if( $this->authtoken_is_valid($session_auth_data['user'], $session_auth_data['authtoken']))
			{
				$this->logged_in_user = $session_auth_data['user'];
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Gets the currently logged in user or FALSE if the user is not logged in.
	 * 
	 * @return string
	 */
	public function get_logged_in_user()
	{
		if($this->user_is_logged_in())
		{
			return $this->logged_in_user;
		}
		else
		{
			return FALSE;
		}
	}

	/*************************************************************
	*
	*       PRIVATE AND PROTECTED METHODS
	*
	*************************************************************/

	/**
	 * Reads the basic_auth.php config file and sets the class properties.
	 */
	protected function configure()
	{
		$this->CI->config->load($this->config_file);
		$this->config = $this->CI->config->item('basic_auth_config');
		$this->users = $this->CI->config->item('basic_auth_users');
		$this->groups = $this->CI->config->item('basic_auth_groups');
		$this->password_type = (!empty($this->config['password_type'])) ? $this->config['password_type'] : $this->password_type ;		
	}
	
	/**
	 * Determines if the current method is protected.
	 * 
	 * @return boolean
	 */
	protected function method_is_protected()
	{
		if (array_key_exists($this->wildcard_method, $this->protected_methods))
		{
			return TRUE;
		}
		return array_key_exists($this->method, $this->protected_methods);
	}
	
	/**
	 * Determines if the current user is authorized to access the current method.
	 * 
	 * @return true
	 */
	protected function user_is_authorized()
	{
		if($this->logged_in_user)
		{
			$auth_users = $this->get_authorized_method_users();
			return in_array($this->logged_in_user, $auth_users);
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Gets a list of unique authorized users for the current method from the 
	 * user groups.
	 * 
	 * @return array
	 */
	protected function get_authorized_method_users()
	{
		if (array_key_exists($this->wildcard_method, $this->protected_methods))
		{
			$auth_groups = explode(',', $this->protected_methods[$this->wildcard_method]);;
		}
		else
		{
			$auth_groups = explode(',', $this->protected_methods[$this->method]);
		}
		
		$auth_groups = array_values(array_intersect($auth_groups, array_keys($this->groups)));

		$auth_users = array();

		foreach ($auth_groups as $group)
		{
			$auth_users = array_merge($auth_users, $this->groups[$group]);
		}

		return array_unique($auth_users);
	}

	/**
	 * Creates authtoken for the current user. Also used to validate user auth cookie.
	 * 
	 * @param string $userid
	 * @return string
	 */
	protected function create_authtoken($userid)
	{
		if (!empty($this->users[$userid]))
		{
			return md5($userid . $this->config['tokensalt'] . $this->users[$userid]);
		}
		else
		{
			return FALSE;
		}
		
	}
	
	/**
	 * Used to validate if the authtoken stored in the users session data is valid.
	 * 
	 * @param string $userid
	 * @param string $authtoken
	 * @return boolean  
	 */
	protected function authtoken_is_valid($userid, $authtoken)
	{
		return $authtoken == $this->create_authtoken($userid);
	}	
}

/* End of file Basic_auth.php */
/* Location: ./application/libraries/Basic_auth.php */