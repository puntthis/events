<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		//Whether to add onto URL
		$url_add_on = '';
		if ($this->uri->segment(2))
		{
			$url_add_on = '/'.$this->uri->segment(2);
		}
		else
		{
			if (!empty($_SERVER['QUERY_STRING']))
			{
				$url_add_on = '?'.$_SERVER['QUERY_STRING'];
			}
		}
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://localhost/events'.$url_add_on);
		curl_setopt($curl, CURLOPT_USERPWD, 'demo:demo');
		if ($this->uri->segment(3) == 'post')
		{
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $_SERVER['QUERY_STRING']);	
		}
		curl_exec($curl);
	}
	
}