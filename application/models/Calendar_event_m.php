<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_event_m extends MY_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
    
	/**
	* Get Records based on filters
	* 
	* Available Filters:
	* id (int) 
	* impact (mixed, int or string), (>,<,>=,<=)(int) or (int) ex. 1, >=1, >= 1
	* from_date (date)
	* to_date (date)
	* instrument (string) 
	* 
	* @param array $arr_filters
	* 
	* @return object
	*/
    public function read($arr_filters = array())
    {
    	$sql = "
    	SELECT id, title, event_date AS date, impact, instrument, actual, forecast
    	FROM calendar_event
    	";
    	$arr_valid_filters = array('id','impact','from_date','to_date','instrument');
    	foreach($arr_filters as $key => $value)
    	{
			if (in_array($key,$arr_valid_filters))
			{
				if ($key != 'impact')
				{
					$this->arr_bindings[] = $value;
				}
				switch($key)
				{
					case 'impact':
					if (filter_var($value, FILTER_VALIDATE_INT) || preg_match("/(>|<)(=)?(\s)?([0-9]+)/",$value))
					{
						$this->arr_where[] = 'impact '.(filter_var($value, FILTER_VALIDATE_INT) ? '= '.$value : $value);	
					}
					break;
					
					case 'from_date':
					$this->arr_where[] = 'event_date >= ?';
					break;
					
					case 'to_date':
					$this->arr_where[] = 'event_date <= ?';	
					break;
					
					default:
					$this->arr_where[] = $key.' = ?';
				}
			}
		}
    	if (!empty($this->arr_where))
    	{
			$sql .= ' WHERE '.implode(' AND ',$this->arr_where);
		}
    	$sql .= ' ORDER BY event_date';
    	$query = $this->db->query($sql,$this->arr_bindings);
    	return $query;
    }
    
    /**
	* Get Record By id
	* 
	* @param int $id
	* 
	* @return object
	*/
    public function read_by_id($id)
    {
		return $this->read(array('id' => $id));
	}
    
    /**
	* Update Record
	* 
	* @param int $id
	* @param array $data
	* 
	* @return bool
	*/
    public function update($id, $data)
	{
		//Replace date with event_date since that's the way it's being stored in the DB, date is a reserved word in MySQL
		if (isset($data['date']))
		{
			$data['event_date'] = $data['date'];
			unset($data['date']);
		}
		
		//Check to make sure data fields are DB table fields
		if (!empty(array_diff(array_keys($data), $this->db->list_fields('calendar_event'))))
		{
			return FALSE;
		}
		
		return $this->db->update('calendar_event', $data, array('id' => $id));
	}

}