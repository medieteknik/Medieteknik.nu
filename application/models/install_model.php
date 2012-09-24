<?php
class Install_model extends CI_Model 
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		// check all required sql functions exist
		$this->create_sql_functions();
		
		// drop all tables if ?drop is set in the address bar
		if(isset($_GET['drop'])) {
			$this->drop_tables();
		}
		
		// check all tables one by one and fill them with content if necessary
		$this->create_users_table();
		$this->create_users_data_table();
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
		$this->create_privileges_table();
		$this->create_users_privileges_table();
		$this->create_images_table();
		$this->create_news_images_table();
		
		// check all views exist
		$this->create_forum_categories_descriptions_language_view();
		$this->create_news_translation_language_view();
		$this->create_groups_descriptions_language_view();
		
		// Log a debug message
		log_message('debug', "Install_model Class Initialized");
    }
	
	function drop_tables() {
		$this->load->dbforge();
		$this->dbforge->drop_table('users');
		$this->dbforge->drop_table('users_data');
		$this->dbforge->drop_table('language');
		$this->dbforge->drop_table('news');
		$this->dbforge->drop_table('news_translation');
		$this->dbforge->drop_table('news_sticky');
		$this->dbforge->drop_table('groups');
		$this->dbforge->drop_table('groups_descriptions');
		$this->dbforge->drop_table('users_groups');
		$this->dbforge->drop_table('forum_categories');
		$this->dbforge->drop_table('forum_categories_descriptions');
		$this->dbforge->drop_table('forum_topic');
		$this->dbforge->drop_table('forum_reply');
		$this->dbforge->drop_table('forum_reply_guest');
		$this->dbforge->drop_table('privileges');
		$this->dbforge->drop_table('users_privileges');
		$this->dbforge->drop_table('images');
		$this->dbforge->drop_table('news_images');
	}
 	
	function create_sql_functions() 
	{
		$arr = array();
		$query = $this->db->query("SHOW FUNCTION STATUS");
		foreach($query->result() as $r) 
		{
			if($r->Db == "medieteknik") 
			{
				$arr[] = $r->Name;
			}
		}
		if(!in_array("get_primary_language_id", $arr)) 
		{
			$query = $this->db->query("CREATE FUNCTION get_primary_language_id() RETURNS INT(5) RETURN @primary_language_id;");
		}
		if(!in_array("get_secondary_language_id", $arr)) 
		{
			$query = $this->db->query("CREATE FUNCTION get_secondary_language_id() RETURNS INT(5) RETURN @secondary_language_id;");
		}
	}

	function create_users_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('users') || isset($_GET['drop']))
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
			$this->User_model->add_user("Anders", "Nord", "andno992", "password");
			$this->User_model->add_user("Jonas", "Zeitler", "jonze168", "password");
			$this->User_model->add_user("Klas", "Eskison", "klaes950", "password");
			$this->User_model->add_user("Simon", "Joelsson", "simjo407", "password");
			$this->User_model->add_user("Martin", "Kierkegaard", "marki423", "password");
		}
	}
	
	function create_users_data_table()
	{
		// if the users_data table does not exist, create it
		if(!$this->db->table_exists('users_data') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_users_data_table_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('users_id',true);						// set the primary keys
			$this->dbforge->create_table('users_data');
			log_message('info', "Created table: users");
			
			// inserting data
			$data = array('users_id' => 1, 'web' => "http://www.jonasstrandstedt.se", 'presentation' => "Jag heter jonas");
			$this->db->insert('users_data', $data);
			$data = array('users_id' => 6, 'web' => "http://www.esklsn.net", 'presentation' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", 'twitter' => 'eskilicious');
			$this->db->insert('users_data', $data);
		}
	}
	
	function create_language_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('language') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('news') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('news_translation') || isset($_GET['drop']))
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
									array("lang" => "se", "title" => "Klistrad nyhet!", "text" => "Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."),
									array("lang" => "en", "title" => "Sticky News!", "text" => "Lorizzle bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz."),
								);
			$this->News_model->add_news(1, $translations, "2012-01-06");
			$this->News_model->add_news(1, array("lang_abbr" => "se", "title" => "Bilder", "text" => "Bild1 = [img id=news_4ff898bae87bb]
			Bild2 = [img id=news_4ff898bae87bb w=200] 
			Bild3 = [img id=news_4ff898bae87bb w=150 h=100]"), "2012-01-06");
			$this->News_model->add_news(1, array("lang_abbr" => "se", "title" => "Utkast!", "text" => "Ett utkast mtf!"), "2012-10-06", 1);
			

		}
	}
	
	function create_news_sticky_table()
	{	
		// if the users table does not exist, create it
		if(!$this->db->table_exists('news_sticky') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('groups') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('groups_descriptions') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('users_groups') || isset($_GET['drop']))
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
	
	function create_forum_categories_table() 
	{
		if(!$this->db->table_exists('forum_categories') || isset($_GET['drop']))
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
	
	function create_forum_categories_descriptions_table() 
	{
		if(!$this->db->table_exists('forum_categories_descriptions') || isset($_GET['drop']))
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
	
	function create_forum_topic_table() 
	{
		if(!$this->db->table_exists('forum_topic') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_topic_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_topic');
			
			log_message('info', "Created table: forum_topic");

		}
	}
	
	function create_forum_reply_table() 
	{
		if(!$this->db->table_exists('forum_reply') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_reply_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_reply');
			
			log_message('info', "Created table: forum_reply");

			// inserting users
			$this->load->model("Forum_model");
			$this->Forum_model->create_topic(4, 1, 'När börjar det?', 'Hej, jag undrar när Medieteknikdagarna 2012 går av stapeln?
			Det viktiga är inte exakt dag utan på ett ungefär?
			
			puss', '2011-12-12 11:00:00');
			$this->Forum_model->create_topic(4, 2, 'LiU is the best.', 'its only a game.', '2011-12-12 12:00:00');
			$this->Forum_model->add_reply(1, 2, 'Det har redan varit.', '2011-12-12 13:00:00');
		}
	}
	
	function create_forum_reply_guest_table() 
	{
		if(!$this->db->table_exists('forum_reply_guest') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_forum_reply_guest_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('forum_reply_guest');
			
			log_message('info', "Created table: forum_reply_guest");
		}
	}
	
	function create_privileges_table() 
	{
		if(!$this->db->table_exists('privileges') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_privileges_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('privileges');
			
			log_message('info', "Created table: privileges");
			
			$data = array(
			   	'privilege_name' => 'superadmin',
				'privilege_description' => 'Full access to everything'
			);
			$this->db->insert('privileges', $data);
			
			$data = array(
			   	'privilege_name' => 'admin',
				'privilege_description' => 'Allows the user to access the admin menu'
			);
			$this->db->insert('privileges', $data);
			
			$data = array(
			   	'privilege_name' => 'forum_moderator',
				'privilege_description' => 'Allows user to moderate forum'
			);
			$this->db->insert('privileges', $data);
			
			$data = array(
			   	'privilege_name' => 'news_post',
				'privilege_description' => 'Allows user to post news, but not approve them'
			);
			$this->db->insert('privileges', $data);
			
			$data = array(
			   	'privilege_name' => 'news_editor',
				'privilege_description' => 'Allows user to post news, and approve them'
			);
			$this->db->insert('privileges', $data);
		}
	}
	
	function create_users_privileges_table() 
	{
		if(!$this->db->table_exists('users_privileges') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_users_privileges_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('user_id',true);
			$this->dbforge->add_key('privilege_id',true);
			$this->dbforge->create_table('users_privileges');
			
			log_message('info', "Created table: users_privileges");
			
			// superadmin
			$data = array('user_id' => 1,'privilege_id' => 1);
			$this->db->insert('users_privileges', $data);
			$data = array('user_id' => 2,'privilege_id' => 1);
			$this->db->insert('users_privileges', $data);
			$data = array('user_id' => 4,'privilege_id' => 1);
			$this->db->insert('users_privileges', $data);
			$data = array('user_id' => 5,'privilege_id' => 1);
			$this->db->insert('users_privileges', $data);
			$data = array('user_id' => 6,'privilege_id' => 1);
			$this->db->insert('users_privileges', $data);
			
			// news_post
			$data = array('user_id' => 3,'privilege_id' => 4);
			$this->db->insert('users_privileges', $data);
		}
	}
	
	function create_images_table() 
	{
		if(!$this->db->table_exists('images') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_images_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('images');
			
			log_message('info', "Created table: images");
			
		}
	}
	
	function create_news_images_table() 
	{
		if(!$this->db->table_exists('news_images') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_news_images_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('news_id',true);
			$this->dbforge->add_key('images_id',true);
			$this->dbforge->create_table('news_images');
			
			log_message('info', "Created table: news_images");
			
		}
	}
	
	
	
	function create_forum_categories_descriptions_language_view() 
	{
		if(!$this->db->table_exists('forum_categories_descriptions_language')) 
		{
			$q = "CREATE OR REPLACE VIEW forum_categories_descriptions_language AS (SELECT e.cat_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.description,e.description) as description "; 
			$q .= " FROM forum_categories_descriptions               e";
			$q .= " LEFT OUTER JOIN forum_categories_descriptions o ON e.cat_id=o.cat_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
	function create_news_translation_language_view() 
	{
		if(!$this->db->table_exists('news_translation_language')) 
		{
			$q = "CREATE OR REPLACE VIEW news_translation_language AS (SELECT e.news_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.text,e.text) as text, e.last_edit "; 
			$q .= " FROM news_translation               e";
			$q .= " LEFT OUTER JOIN news_translation o ON e.news_id=o.news_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
	function create_groups_descriptions_language_view() 
	{
		if(!$this->db->table_exists('groups_descriptions_language')) 
		{
			$q = "CREATE OR REPLACE VIEW groups_descriptions_language AS (SELECT e.group_id,e.lang_id,COALESCE(o.description,e.description) as description "; 
			$q .= " FROM groups_descriptions               e";
			$q .= " LEFT OUTER JOIN groups_descriptions o ON e.group_id=o.group_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}
	
}

