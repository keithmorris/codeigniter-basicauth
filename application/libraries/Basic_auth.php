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
	const ERROR_USER_NOT_LOGGED_IN = 'errorUserNotLoggedIn';
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
	
	
	public function set_protected_methods($config)
	{
		$this->protected_methods = $config;
	}
	
	
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
	
	
	public function logout()
	{
		return $this->CI->session->unset_userdata($this->session_var_name);
	}
	
	
	public function get_error()
	{
		return $this->_error;
	}


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

	
	protected function configure()
	{
		$this->CI->config->load($this->config_file);
		$this->config = $this->CI->config->item('basic_auth_config');
		$this->users = $this->CI->config->item('basic_auth_users');
		$this->groups = $this->CI->config->item('basic_auth_groups');
		$this->password_type = (!empty($this->config['password_type'])) ? $this->config['password_type'] : $this->password_type ;		
	}
	
	
	protected function method_is_protected()
	{
		if (array_key_exists($this->wildcard_method, $this->protected_methods))
		{
			return TRUE;
		}
		return array_key_exists($this->method, $this->protected_methods);
	}
	

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


	protected function create_authtoken($userid)
	{
		return md5($userid . $this->config['tokensalt'] . $this->users[$userid]);
	}
	
	
	protected function authtoken_is_valid($userid, $authtoken)
	{
		return $authtoken == $this->create_authtoken($userid);
	}	
}