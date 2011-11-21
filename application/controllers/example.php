<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
class Example extends CI_Controller 
{
	protected $pagedata = array();

	function __construct() 
	{
		parent::__construct();
		$this->load->helper(array('url'));
		
		//comment out this line to remove all authorization requirements
		$this->_authorize();
	}
	
	protected function _authorize()
	{
		$this->load->library('Basic_auth');
		
		/*
		 * The set_protected_methods takes an associative array of all of the 
		 * method names that will be protected. The key is the method name while
		 * the value is a comma-delimited list of groups allowed to access the
		 * method.
		 * 
		 * Using '*' as the key will protect all methods in the controller. Be 
		 * aware that using '*' will require that any authorization (login, 
		 * logout, etc.) be done in a different controller because those methods
		 * would be protected as well.
		 */
		$this->basic_auth->set_protected_methods(array(
			// Uncomment the '*' line below to protect all methods
			//'*' => 'user,admins',
			'restricted' => 'viewers,editors,admins',
			'adminsonly' => 'admins'
		));
		
		if (!$this->basic_auth->check())
		{
			switch ($this->basic_auth->get_error())
			{
				case basic_auth::ERROR_USER_NOT_AUTHORIZED:
					$redirect = 'authenticate/not_authorized';
					break;
				
				case basic_auth::ERROR_USER_NOT_LOGGED_IN:
					$redirect = 'authenticate/login';
					$this->session->set_userdata('returnurl', uri_string());
					break;
				default:
					break;
			} 
			
			redirect($redirect);
		}
	}


	public function index()
	{
		$this->pagedata['title'] = "No Restriction";
		$this->pagedata['layout'] = "norestrictions";
		$this->load->view('wrapper', $this->pagedata);
	}
	
	public function restricted()
	{
		$this->pagedata['title'] = "Restricted";
		$this->pagedata['layout'] = "authorized";
		$this->load->view('wrapper', $this->pagedata);
	}
	
	public function adminsonly()
	{
		$this->pagedata['title'] = "Restricted";
		$this->pagedata['layout'] = "authorized";
		$this->pagedata['success'][] = "AUTHORIZED! You are a member of the admins group.";
		$this->load->view('wrapper', $this->pagedata);		
	}
	
	public function unrestricted()
	{
		$this->pagedata['title'] = "No Restriction";
		$this->pagedata['layout'] = "norestrictions";
		$this->load->view('wrapper', $this->pagedata);		
	}
}

/* End of file AuthTest */
/* Location: ./application/controllers/AuthTest */
