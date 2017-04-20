<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_user_m extends MY_Model {

	public function __construct()
	{
        parent::__construct();
    }
	
	/**
	* Verify the Username and Password for the user
	* 
	* @param string $username
	* @param string $password
	* 
	* @return bool
	*/
    public function user_verified($username, $password)
    {
    	$result = FALSE;
    	$query = $this->db->query("
    	SELECT userp
    	FROM api_user
    	WHERE username = ?
    	", array($username));
    	if ($query->num_rows())
    	{
			if (password_verify($password, $query->row()->userp))
			{
				$result = TRUE;
			}
		}
		return $result;
    }

}