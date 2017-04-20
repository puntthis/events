<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends Api {
	
	private $_arr_errors = array();
	private $_result;
	
	public function __construct()
	{
    	parent::__construct();
    	$this->load->model('Calendar_event_m');
    }
	
	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//No id
			if ($this->uri->segment(2) === NULL)
			{
				$this->_arr_errors[] = 'Missing id';	
			}
			
			//No data
			if (empty($this->input->post()))
			{
				$this->_arr_errors[] = 'Missing data';
			}
			
			//Check if id and data provided
			if (!empty($this->_arr_errors))
			{
				$this->_result = array('errors' => $this->_arr_errors);
			}
			else //id and data provided
			{
				if ($this->Calendar_event_m->update($this->uri->segment(2),$this->input->post()))
				{
					$this->_result = ($read = $this->Calendar_event_m->read_by_id($this->uri->segment(2))) ? $read->row_array() : array('errors' => array('Database Read Error'));
				}
				else
				{
					$this->_result = array('errors' => array('Database Update Error'));
				}
			}
		}
		else //GET
		{
			$read = $this->uri->segment(2) !== NULL ? $this->Calendar_event_m->read_by_id($this->uri->segment(2)) : $this->Calendar_event_m->read($this->input->get());
			
			if ($read)
			{
				if ($read->num_rows())
				{
					$this->_result = $this->uri->segment(2) !== NULL ? $read->row_array() : $read->result_array();
				}
				else
				{
					$this->_result = array('response_message' => 'No Results');
				}
			}
			else
			{
				$this->_result = array('errors' => array('Database Read Error'));
			}
		}
		
		//Display JSON response
		echo json_encode($this->_result, JSON_NUMERIC_CHECK);
	}
	
}