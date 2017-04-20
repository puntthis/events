<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_event_m extends CI_Model {

	public function __construct()
	{
        parent::__construct();
    }
	
    public function read($id = NULL, $impact = NULL, $from_date = NULL, $to_date = NULL, $instructment = NULL)
    {
    	$arr_args = get_defined_vars();
    	$sql = "
    	SELECT id, title, event_date, impact, instructment, actual, forecast
    	FROM calendar_event
    	";
    	$arr_filters = array();	
    	$arr_bindings = array();
    	foreach($arr_args as $key => $value)
    	{
			$arr_bindings[] = $value;
			switch($key)
			{
				case 'impact':
				$arr_filters[] = 'impact ?';
				break;
				
				case 'from_date':
				$arr_filters[] = 'from_date >= ?';
				break;
				
				case 'to_date':
				$arr_filters[] = 'to_date <= ?';	
				break;
				
				default:
				$arr_filters[] = $key.' = ?';
			}
		}
    	if (!empty($arr_filters))
    	{
			$sql .= ' WHERE '.implode(' AND ',$arr_filters);
		}
    	$sql .= ' ORDER BY event_date';
    	$query = $this->db->query($sql,$arr_bindings);
    	return $query;
    }
    
    public function update($id, $data)
	{
		$this->db->update('calendar_event', $data, array('id' => $id));
	}

}