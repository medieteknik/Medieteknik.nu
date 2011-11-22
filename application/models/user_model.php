<?php
class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }
}

