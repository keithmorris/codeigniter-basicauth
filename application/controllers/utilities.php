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
class Utilities extends CI_Controller 
{
	protected $pagedata = array();
	
	function __construct() 
	{
		parent::__construct();
		
		$this->load->helper(array('url'));
		$this->load->library('Basic_auth');
	}
	
	public function index()
	{
		$this->hashpassword();
	}


	public function hashpassword()
	{
		$this->pagedata['title'] = "Quick Auth MD5 Hash Utility";
		$this->pagedata['layout'] = "password_hash";
		$this->load->view('wrapper', $this->pagedata);
	}
}

/* End of file utilities.php */
/* Location: ./application/controllers/utilities.php */
