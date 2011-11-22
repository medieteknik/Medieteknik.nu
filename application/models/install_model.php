<?php
class Install_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		// check all tables one by one and fill them with content if necessary
		if(!$this->db->table_exists('users'))
		{
			$this->create_users_table();
		}

		// Log a debug message
		log_message('debug', "Install_model Class Initialized");
    }
 

	function create_users_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('users'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_user_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('users');
			
			log_message('info', "Created table: users");
			
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

