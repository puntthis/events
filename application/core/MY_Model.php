<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $arr_bindings = array();
	protected $arr_where = array();
	
	public function __construct()
	{
		parent::__construct();
	}
	
}