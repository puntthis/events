<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();
    	$this->load->model('Api_user_m');
    	$this->_authenticate();
    }
	
	private function _encrypted_password($password)
	{
		$this->encryption->initialize(array('cipher' => 'aes-256', 'mode' => 'ctr'));
		return $this->encryption->encrypt($password);
	}
	
	private function _authenticate()
	{
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
		{
			$read = $this->Api_user_m->read($_SERVER['PHP_AUTH_USER'],$this->_encrypted_password($_SERVER['PHP_AUTH_PW']));
			//Invalid Username and/or Password
			if (!$read->num_rows())
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