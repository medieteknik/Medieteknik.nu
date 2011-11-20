<?php
class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->checkTables();
    }
    
    function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

	function checkTables()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('users'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_user_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('users');
			
			// inserting data
			$data = array(
			   'first_name' => 'Jonas' ,
			   'last_name' => 'Strandstedt' ,
			   'lukasid' => 'jonst123'
			);
			$this->db->insert('users', $data);
			
			$data = array(
			   'first_name' => 'John' ,
			   'last_name' => 'Doe' ,
			   'lukasid' => 'johdo987'
			);
			$this->db->insert('users', $data);
			
			$data = array(
			   'first_name' => 'Joe' ,
			   'last_name' => 'Schmoe' ,
			   'lukasid' => 'joesc567'
			);
			$this->db->insert('users', $data);
		}
	}
}

