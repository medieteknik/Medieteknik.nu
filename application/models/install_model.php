<?php
class Install_model extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		// check all required sql functions exist
		$this->create_sql_functions();
		
		// check all tables one by one and fill them with content if necessary
		$this->create_users_table();
		$this->create_language_table();
		$this->create_news_table();
		$this->create_news_translation_table();
		$this->create_news_sticky_table();
		$this->create_groups_table();
		$this->create_users_groups_table();
		$this->create_groups_descriptions_table();
		$this->create_forum_categories_table();
		$this->create_forum_categories_descriptions_table();
		$this->create_forum_topic_table();
		$this->create_forum_reply_table();
		$this->create_forum_reply_guest_table();
		
		// check all views exist
		$this->create_forum_categories_descriptions_language_view();
		$this->create_news_translation_language_view();
		$this->create_groups_descriptions_language_view();

		// Log a debug message
		log_message('debug', "Install_model Class Initialized");
    }
 	
	function create_sql_functions() {
		$arr = array();
		$query = $this->db->query("SHOW FUNCTION STATUS");
		foreach($query->result() as $r) {
			if($r->Db == "medieteknik") {
				$arr[] = $r->Name;
			}
		}
		if(!in_array("get_primary_language_id", $arr)) {
			$query = $this->db->query("CREATE FUNCTION get_primary_language_id() RETURNS INT(5) RETURN @primary_language_id;");
		}
		if(!in_array("get_secondary_language_id", $arr)) {
			$query = $this->db->query("CREATE FUNCTION get_secondary_language_id() RETURNS INT(5) RETURN @secondary_language_id;");
		}
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
			$q = $this->db->query("ALTER TABLE  `users` ADD UNIQUE (`lukasid`)");
			log_message('info', "Created table: users");
			
			// inserting users
			$this->load->model("User_model");
			$this->User_model->add_user("Jonas", "Strandstedt", "jonst184", "password");
			$this->User_model->add_user("Emil", "Axelsson", "emiax775", "password");
			$this->User_model->add_user("Kristofer", "Janukiewicz", "krija286", "password");
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
			
			// Adding language
			$data = array('language_abbr' => 'se' , 'language_name' => 'Svenska' , 'language_order' => 1);
			$this->db->insert('language', $data);
			$data = array('language_abbr' => 'en' ,'language_name' => 'English' ,'language_order' => 2);
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
			
			$this->load->model("News_model");
			$translations = array(
									array("lang" => "se", "title" => "Klistrad nyhet!", "text" => "Den här nyheten är verkligen klistrad"),
									array("lang" => "en", "title" => "Sticky News!", "text" => "This is some sticky news!"),
								);
			$this->News_model->add_news(1,0, $translations, "2012-01-06");
			$this->News_model->add_news(1,0, array("lang_abbr" => "se", "title" => "Inte klistrad!", "text" => "Den här nyheten är inte klistrad eller översatt!"), "2012-01-06");
			

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
	
	function create_forum_categories_table() {
		if(!$this->db->table_exists('forum_categories'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_categories_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_categories');
			
			log_message('info', "Created table: forum_categories");
			
			//applicant
			$data = array(
			   'sub_to_id' => 0,
				'guest_allowed' => 1,
				'posting_allowed' => 0,
				'order' => 2,
			);
			$this->db->insert('forum_categories', $data);
			
			// student
			$data = array(
			   'sub_to_id' => 0,
				'guest_allowed' => 0,
				'posting_allowed' => 0,
				'order' => 1,
			);
			$this->db->insert('forum_categories', $data);
			
			// ADVERTISEMENT
			$data = array(
			   'sub_to_id' => 0,
				'guest_allowed' => 0,
				'posting_allowed' => 0,
				'order' => 3,
			);
			$this->db->insert('forum_categories', $data);
			
			// school
			$data = array(
			   'sub_to_id' => 2,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 1,
			);
			$this->db->insert('forum_categories', $data);
			
			// work and LEISURE
			$data = array(
			   'sub_to_id' => 2,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 2,
			);
			$this->db->insert('forum_categories', $data);
			
			// buy and sell
			$data = array(
			   'sub_to_id' => 2,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 3,
			);
			$this->db->insert('forum_categories', $data);
			
			// ACG
			$data = array(
			   'sub_to_id' => 2,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 4,
			);
			$this->db->insert('forum_categories', $data);
			
			// thesis
			$data = array(
			   'sub_to_id' => 3,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 1,
			);
			$this->db->insert('forum_categories', $data);
			
			// other services
			$data = array(
			   'sub_to_id' => 3,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 2,
			);
			$this->db->insert('forum_categories', $data);
			
			// advertisement
			$data = array(
			   'sub_to_id' => 3,
				'guest_allowed' => 0,
				'posting_allowed' => 1,
				'order' => 3,
			);
			$this->db->insert('forum_categories', $data);
			
			// q&a
			$data = array(
			   'sub_to_id' => 1,
				'guest_allowed' => 1,
				'posting_allowed' => 1,
				'order' => 1,
			);
			$this->db->insert('forum_categories', $data);
		}
	}
	
	function create_forum_categories_descriptions_table() {
		if(!$this->db->table_exists('forum_categories_descriptions'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_categories_descriptions_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('cat_id',true);
			$this->dbforge->add_key('lang_id',true);
			$this->dbforge->create_table('forum_categories_descriptions');
			
			log_message('info', "Created table: forum_categories_descriptions");
			
			$data = array(
			   	'cat_id' => 1,
				'lang_id' => 1,
				'title' => 'Sökande',
				'description' => 'I den här forumdelen kan gäster skriva och fråga om medieteknikprogrammet.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 1,
				'lang_id' => 2,
				'title' => 'Applicant',
				'description' => 'In this forum guests can post and ask questions about Media Technology',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 2,
				'lang_id' => 1,
				'title' => 'Student',
				'description' => 'Detta forum är avsett för studenter att prata om allt och inget',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 2,
				'lang_id' => 2,
				'title' => 'Student',
				'description' => 'This forum is for students',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 3,
				'lang_id' => 1,
				'title' => 'Annonser och jobb',
				'description' => 'Här finns alla annonser och jobb samlade',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 3,
				'lang_id' => 2,
				'title' => 'Ads and jobs',
				'description' => 'Here is all the ads and jobs',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 4,
				'lang_id' => 1,
				'title' => 'Skolan',
				'description' => 'Allt som rör kurser, plugg och annat skolreleterat.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 4,
				'lang_id' => 2,
				'title' => 'School',
				'description' => 'All about courses, studying and other school related topics.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 5,
				'lang_id' => 1,
				'title' => 'Köp & sälj',
				'description' => 'Känner du att du har för många prylar? Sälj överflödet här.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 5,
				'lang_id' => 2,
				'title' => 'Buy & sell',
				'description' => 'Too much stuff? Sell it here',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 6,
				'lang_id' => 1,
				'title' => 'Arbete & fritid',
				'description' => 'Om det gäller fest, sportande, jobb eller bara allmän fritid, skriv här.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 6,
				'lang_id' => 2,
				'title' => 'Work & leisure',
				'description' => 'Partying, partying yeah! Fun fun fun fun!',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			// english only for ACG
			$data = array(
			   	'cat_id' => 7,
				'lang_id' => 2,
				'title' => 'Advanced Computer Graphics',
				'description' => 'This forum is for ACG students and topics about the Master program ACG.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 8,
				'lang_id' => 1,
				'title' => 'Exjobb',
				'description' => 'Annonser om exjobb här',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 8,
				'lang_id' => 2,
				'title' => 'Thesis',
				'description' => 'Ads about thesis here',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 9,
				'lang_id' => 1,
				'title' => 'Övriga tjänster',
				'description' => 'Andra jobberbjudanden.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 9,
				'lang_id' => 2,
				'title' => 'Other Services',
				'description' => 'Jobs',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 10,
				'lang_id' => 1,
				'title' => 'Övriga annonser',
				'description' => 'Annonser',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 10,
				'lang_id' => 2,
				'title' => 'Other advertisements',
				'description' => 'Ads',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
			$data = array(
			   	'cat_id' => 11,
				'lang_id' => 1,
				'title' => 'Frågor & svar',
				'description' => 'Undrar du något om hur det är att plugga medieteknik? Fråga här.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			$data = array(
			   	'cat_id' => 11,
				'lang_id' => 2,
				'title' => 'Questions & Answers',
				'description' => 'Have a question about Medie Technology? Ask it here.',
			);
			$this->db->insert('forum_categories_descriptions', $data);
			
		}
	}
	
	function create_forum_topic_table() {
		if(!$this->db->table_exists('forum_topic'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_topic_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_topic');
			
			log_message('info', "Created table: forum_topic");
			
			$data = array(
			   	'cat_id' => 2,
				'user_id' => 1,
				'topic' => 'När börjar det?',
				'post_date' => '2011-12-12 11:00:00',
			);
			$this->db->insert('forum_topic', $data);
		}
	}
	
	function create_forum_reply_table() {
		if(!$this->db->table_exists('forum_reply'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_reply_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_reply');
			
			log_message('info', "Created table: forum_reply");
			
			$data = array(
			   	'topic_id' => 1,
				'user_id' => 1,
				'reply' => 'Hej, jag undrar när Medieteknikdagarna 2012 går av stapeln?\nDet viktiga är inte exakt dag utan på ett ungefär?\n\npuss',
				'reply_date' => '2011-12-12 11:00:00',
			);
			$this->db->insert('forum_reply', $data);
		}
	}
	
	function create_forum_reply_guest_table() {
		if(!$this->db->table_exists('forum_reply_guest'))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_reply_guest_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_reply_guest');
			
			log_message('info', "Created table: forum_reply_guest");
		}
	}
	
	
	
	function create_forum_categories_descriptions_language_view() {
		if(!$this->db->table_exists('forum_categories_descriptions_language')) {
			$q = "CREATE OR REPLACE VIEW forum_categories_descriptions_language AS (SELECT e.cat_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.description,e.description) as description "; 
			$q .= " FROM forum_categories_descriptions               e";
			$q .= " LEFT OUTER JOIN forum_categories_descriptions o ON e.cat_id=o.cat_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
	function create_news_translation_language_view() {
		if(!$this->db->table_exists('news_translation_language')) {
			$q = "CREATE OR REPLACE VIEW news_translation_language AS (SELECT e.news_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.text,e.text) as text, e.last_edit "; 
			$q .= " FROM news_translation               e";
			$q .= " LEFT OUTER JOIN news_translation o ON e.news_id=o.news_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
	function create_groups_descriptions_language_view() {
		if(!$this->db->table_exists('groups_descriptions_language')) {
			$q = "CREATE OR REPLACE VIEW groups_descriptions_language AS (SELECT e.group_id,e.lang_id,COALESCE(o.description,e.description) as description "; 
			$q .= " FROM groups_descriptions               e";
			$q .= " LEFT OUTER JOIN groups_descriptions o ON e.group_id=o.group_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
}

