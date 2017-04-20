<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

	public function __construct()
	{
    	parent::__construct();
    	$this->load->model('Calendar_event_m');
    }
	
	public function index()
	{
		$this->encryption->initialize(array('cipher' => 'aes-256', 'mode' => 'ctr'));
		echo $this->encryption->encrypt('demo');
		exit;
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$arr_errors = array();
			
			//No id
			if (!isset($this->uri->segment(2)))
			{
				$arr_errors[] = 'Missing id';	
			}
			
			//No data
			if (empty($this->input->post()))
			{
				$arr_errors[] = 'Missing data';
			}
			
			
			if (!empty($arr_errors))
			{
				$result = array('errors' => $arr_errors);
			}
			else
			{
				$this->Calendar_event_m->update($this->uri->segment(2),$this->input->post());
				$result = array('Record Updated');	
			}
			
		}
		else //GET
		{
			$read = isset($this->uri->segment(2)) ? $this->Calendar_event_m->read($this->uri->segment(2)) : $this->Calendar_event_m->read();
			
			
			if (isset($this->uri->segment(2)))
			{
				$read = $this->Calendar_event_m->read($this->uri->segment(2));
			}
			else
			{
				$read = 
			}
		}
		
		json_encode($result);
	}
	
}