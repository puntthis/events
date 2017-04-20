<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_user_m');
		$this->_verify_user();
	}
		
	/**
	* Check Username and Password for User
	* 
	* @return void
	*/
	private function _verify_user()
	{
		list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
		
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
		{
			$user_verified = $this->Api_user_m->user_verified($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
			
			//Invalid Username and/or Password
			if (!$user_verified)
			{
				echo json_encode(array('errors' => array('Invalid Username and/or Password')));
				exit;
			}
		}
		else //Missing Username and/or Password
		{
			echo json_encode(array('errors' => array('Missing Username and/or Password')));
			exit;
		}
	}
	
}