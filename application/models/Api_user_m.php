<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api_user_m extends CI_Model {

	public function __construct()
	{
        parent::__construct();
    }
	
    public function read($username, $userp)
    {
    	$query = $this->db->query("
    	SELECT id
    	FROM api_user
    	WHERE username = ? AND userp = ?
    	");
    	return $query;
    }

}