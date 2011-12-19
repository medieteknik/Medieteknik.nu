<?php
class Install_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		// check all tables one by one and fill them with content if necessary
		$this->create_users_table();
		$this->create_language_table();
		$this->create_news_table();
		$this->create_news_translation_table();
		$this->create_news_sticky_table();
		$this->create_groups_table();
		$this->create_users_groups_table();
		$this->create_groups_descriptions_table();

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
	
	function create_language_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('language'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_language_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('language');
			
			log_message('info', "Created table: language");
			
			// inserting data
			$data = array(
			   'language_abbr' => 'se' ,
			   'language_name' => 'Svenska' ,
			   'language_order' => 1
			);
			$this->db->insert('language', $data);
			
			$data = array(
			   'language_abbr' => 'en' ,
			   'language_name' => 'English' ,
			   'language_order' => 2
			);
			$this->db->insert('language', $data);
		}
	}
	
	function create_news_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('news'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_news_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('news');
			
			log_message('info', "Created table: news");
			
			$data = array(
			   'user_id' => 1,
			   'group_id' => 1 ,
			   'date' => "2011-11-11 11:11:00",
			   'draft' => 0,
			   'approved' => 1,
			);
			$this->db->insert('news', $data);
			$data = array(
			   'user_id' => 2,
			   'group_id' => 1 ,
			   'date' => "2011-12-11 11:11:00",
			   'draft' => 0,
			   'approved' => 1,
			);
			$this->db->insert('news', $data);
		}
	}
	
	function create_news_translation_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('news_translation'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_news_translation_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('news_id',true);						// set the primary keys
			$this->dbforge->add_key('lang_id',true);						// set the primary keys
			$this->dbforge->create_table('news_translation');
			
			log_message('info', "Created table: news_translation");
			
			$data = array(
			   'news_id' => 1,
			   'lang_id' => 1,
			   'title' => "Klistrad nyhet!",
			   'text' => "Den här nyheten är verkligen klistrad",
			   'last_edit' => "0000-00-00 00:00:00"
			);
			$this->db->insert('news_translation', $data);
			
			$data = array(
			   'news_id' => 1,
			   'lang_id' => 2,
			   'title' => "Sticky News!",
			   'text' => "This is some sticky news!",
			   'last_edit' => "0000-00-00 00:00:00"
			);
			$this->db->insert('news_translation', $data);
			
			$data = array(
			   'news_id' => 2,
			   'lang_id' => 1,
			   'title' => "Inte klistrad!",
			   'text' => "Den här nyheten är inte klistrad!",
			   'last_edit' => "0000-00-00 00:00:00"
			);
			$this->db->insert('news_translation', $data);
			
			$data = array(
			   'news_id' => 2,
			   'lang_id' => 2,
			   'title' => "Not sticky!",
			   'text' => "TThis news is not sticky!",
			   'last_edit' => "0000-00-00 00:00:00"
			);
			$this->db->insert('news_translation', $data);
		}
	}
	
	function create_news_sticky_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('news_sticky'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_news_sticky_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('news_id',true);						// set the primary keys
			$this->dbforge->add_key('sticky_order');
			$this->dbforge->create_table('news_sticky');
			
			log_message('info', "Created table: news_sticky");
			
			$data = array(
			   'news_id' => 1,
			   'sticky_order' => 1 ,
			);
			$this->db->insert('news_sticky', $data);
		}
	}
	
	function create_groups_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('groups'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_groups_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('groups');
			
			log_message('info', "Created table: groups");
			
			$data = array(
			   'group_name' => "Styrelsen",
			);
			$this->db->insert('groups', $data);
			
			$data = array(
			   'sub_to_id' => 1,
			   'group_name' => "Styrelsen 2011/2012",
			);
			$this->db->insert('groups', $data);
			
			$data = array(
			   'sub_to_id' => 0,
			   'group_name' => "gamla styrelsen såatteh",
			);
			$this->db->insert('groups', $data);
		}
	}
	
	function create_groups_descriptions_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('groups_descriptions'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_groups_descriptions_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('lang_id',true);						// set the primary keys
			$this->dbforge->add_key('group_id',true);	
			$this->dbforge->create_table('groups_descriptions');
			
			log_message('info', "Created table: groups_descriptions");
			
			$data = array(
			   'group_id' => 1,
			   'lang_id' => 1,
			   'description' => "Medietekniksektionens styrelse är studenter invalda för att sköta sektionen under ett år."
			);
			$this->db->insert('groups_descriptions', $data);
			
			$data = array(
			   'group_id' => 1,
			   'lang_id' => 2,
			   'description' => "The Media Technology association board is elected students bla bla bla."
			);
			$this->db->insert('groups_descriptions', $data);
		}
	}
	
	function create_users_groups_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('users_groups'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_users_groups_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('user_id',true);						// set the primary keys
			$this->dbforge->add_key('group_id',true);
			$this->dbforge->create_table('users_groups');
			
			log_message('info', "Created table: users_groups");
			
			$data = array(
			   'user_id' => 1,
			   'group_id' => 1,
			   'position' => "Studienämndsordförande",
			   'email' => "snordf@medieteknik.nu",
			);
			$this->db->insert('users_groups', $data);
		}
	}
	
}

