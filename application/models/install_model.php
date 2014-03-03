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
		$this->create_groups_descriptions_table();
		$this->create_groups_year_table();
		$this->create_users_groups_year_table();
		$this->create_groups_year_images_table();
		$this->create_forum_categories_table();
		$this->create_forum_categories_descriptions_table();
		$this->create_forum_topic_table();
		$this->create_forum_reply_table();
		$this->create_forum_reply_guest_table();
		$this->create_privileges_table();
		$this->create_users_privileges_table();
		$this->create_images_table();
		$this->create_documents_table();
		$this->create_document_types_table();
		$this->create_news_images_table();
		$this->create_page_table();
		$this->create_page_content_table();

		// check all views exist
		$this->create_forum_categories_descriptions_language_view();
		$this->create_news_translation_language_view();
		$this->create_groups_descriptions_language_view();
		$this->create_page_content_language_view();

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
		$this->dbforge->drop_table('groups_year');
		$this->dbforge->drop_table('groups_year_images');
		$this->dbforge->drop_table('users_groups_year');
		$this->dbforge->drop_table('forum_categories');
		$this->dbforge->drop_table('forum_categories_descriptions');
		$this->dbforge->drop_table('forum_topic');
		$this->dbforge->drop_table('forum_reply');
		$this->dbforge->drop_table('forum_reply_guest');
		$this->dbforge->drop_table('privileges');
		$this->dbforge->drop_table('users_privileges');
		$this->dbforge->drop_table('images');
		$this->dbforge->drop_table('documents');
		$this->dbforge->drop_table('document_types');
		$this->dbforge->drop_table('news_images');
		$this->dbforge->drop_table('page');
		$this->dbforge->drop_table('page_content');
	}

	function create_sql_functions()
	{
		$arr = array();
		$query = $this->db->query("SHOW FUNCTION STATUS");
		foreach($query->result() as $r)
		{
			if($r->Db == $this->db->database)
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
			$this->User_model->add_user("Klas", "Eskilson", "klaes950", "password");
			$this->User_model->add_user("Simon", "Joelsson", "simjo407", "password");
			$this->User_model->add_user("Martin", "Kierkegaard", "marki423", "password");
			$this->User_model->add_user("Mikael", "Zackrisson", "mikza835", "password");
			$this->User_model->add_user("Arg", "Mtare", "argmt123", "password");
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
			$data = array('users_id' => 5, 'gravatar' => 'jonasemanuelzeitler@gmail.com');
			$this->db->insert('users_data', $data);
			$data = array('users_id' => 6, 'web' => "http://www.klaseskilson.se", 'presentation' => "Jag heter Klas och pillar med den här sidan lite.", 'twitter' => 'Eskilicious', 'gravatar' => 'klas.eskilson@gmail.com');
			$this->db->insert('users_data', $data);
			$data = array('users_id' => 9, 'gravatar' => 'micke.zackrisson@gmail.com');
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
									array("lang" => "se", "title" => "Klistrad nyhet!", "introduction" =>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit.", 
									 "text" => "Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."),
									array("lang" => "en", "title" => "Sticky News!", "introduction" =>"Lorizzle bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz.",
									 "text" => "Lorizzle bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz."),
								);
			$this->News_model->add_news(1, $translations, "2012-01-06");
			$this->News_model->add_news(1, array("lang_abbr" => "se", "title" => "Bilder", "introduction" =>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit.",
				"text" => "[img align=left id=5124141247590 w=150 h=100]Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit.

[img align=right id=5124141247590 w=250 h=200]Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo http://www.google.se/ . Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."), "2012-01-06");
			$this->News_model->add_news(1, array("lang_abbr" => "se", "title" => "Utkast!", "introduction" =>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit.",
				"text" => "Ett utkast mtf!"), "2012-10-06", 1);


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
			$this->dbforge->add_key('groups_id',true);
			$this->dbforge->create_table('groups_descriptions');

			log_message('info', "Created table: groups_descriptions");
		}
	}

	function create_groups_year_table()
	{
		// if the users table does not exist, create it
		if(!$this->db->table_exists('groups_year') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_groups_year_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);						// set the primary keys
			$this->dbforge->create_table('groups_year');

			log_message('info', "Created table: groups_year");

		}
	}

	function create_users_groups_year_table()
	{
		// if the users table does not exist, create it
		if(!$this->db->table_exists('users_groups_year') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_users_groups_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('user_id',true);						// set the primary keys
			$this->dbforge->add_key('groups_year_id',true);						// set the primary keys
			$this->dbforge->create_table('users_groups_year');

			log_message('info', "Created table: users_groups_year");


			$this->load->model("Group_model");
			$translations = array(
									array("lang" => "se", "name" => "Styrelsen", "description" => "Medietekniksektionen skall bevaka MT-studentens intressen när det gäller såväl studierna som profilering mot näringslivet. Här kommer sektionsstyrelsen in i bilden som sektionens verkställande organ. Kontakta oss på info@medieteknik.nu. Läs mer om våra (association/committee|utskott)"),
									array("lang" => "en", "name" => "The Board", "description" => "The Board is hard."),
								);
			$id = $this->Group_model->add_group($translations);
			$user_list = array(
								array("user_id" => 9, "position" => "Webbchef"),
			);
			$this->Group_model->add_group_year($id, 2011, 2012, $user_list);

			$translations = array(
									array("lang" => "se", "name" => "Webbgruppen", "description" => "Om några är grymma så är det webbgruppen"),
									array("lang" => "en", "name" => "Web development group", "description" => "If someone os cruel, then its the spider-web group."),
								);
			$id =$this->Group_model->add_group($translations);

			$user_list = array(
								array("user_id" => 1, "position" => "Coder", "email" => "jonst184@student.liu.se"),
								array("user_id" => 5, "position" => "Ajax master"),
								array("user_id" => 6, "position" => "HTML/CSS Guru"),
			);
			$this->Group_model->add_group_year($id, 2012, 2013, $user_list);
			$user_list = array(
								array("user_id" => 1, "position" => "Coder", "email" => "jonst184@student.liu.se"),
			);
			$this->Group_model->add_group_year($id, 2011, 2012, $user_list);

			$translations = array(
									array("lang" => "se", "name" => "Mette", "description" => "Mette är en förening för alla tjejer som studerar Medieteknik på Campus Norrköping. Vårt mål är att främja gemenskapen mellan alla tjejer på MT-programmet. Under skolåret anordnar vi olika roliga aktiviteter, vissa är enbart för MT-tjejer medan andra aktiviteter är till för alla som pluggar MT, kille som tjej. Mette är även med och anordnar sittningen Ladies Night i mars där alla flickor som vill kan träffas och äta god mat och kolla på gycklande pojkar."),
								);
			$id = $this->Group_model->add_group($translations);
			$user_list = array(
								array("user_id" => 1, "position" => "Tjej? Nope."),
			);
			$this->Group_model->add_group_year($id, 2012, 2013, $user_list);

			$translations = array(
									array("lang" => "se", "name" => "Medieteknikdagarna", "description" => "Arbetsmarknadsdagar, se http://www.medieteknikdagarna.se/"),
								);
			$id = $this->Group_model->add_group($translations);
			$user_list = array(
								array("user_id" => 1, "position" => "Projektassistent"),
			);
			$this->Group_model->add_group_year($id, 2010, 2011, $user_list);
		}
	}

	function create_groups_year_images_table()
	{
		// if the users table does not exist, create it
		if(!$this->db->table_exists('groups_year_images') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_groups_year_images_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('groups_year_id',true);						// set the primary keys
			$this->dbforge->add_key('images_id',true);						// set the primary keys
			$this->dbforge->create_table('groups_year_images');

			log_message('info', "Created table: groups_year_images");
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
			$this->Forum_model->create_topic(4, 10, 'Vart fan är nya hemsidan?', 'Vad håller webbchefen på med egentligen?', '2013-11-12 19:00:00');

			$this->Forum_model->create_topic(4, 1, 'När börjar det?', 'Hej, jag undrar när Medieteknikdagarna 2012 går av stapeln?
			Det viktiga är inte exakt dag utan på ett ungefär?

			puss', '2011-12-12 11:00:00');
			$this->Forum_model->create_topic(4, 2, 'LiU is the best.', 'its only a game.', '2011-12-12 12:00:00');
			$this->Forum_model->add_reply(2, 2, 'Det har redan varit.', '2011-12-12 13:00:00');
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
			$data = array('user_id' => 9,'privilege_id' => 1);
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

			//get and insert sample images in db
			$dir = 'user_content/images/original/';
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if(preg_match('/(.jpg|.png)$/i', $file)){
						$img_size = getimagesize($dir.$file);
						$data = array(	'user_id' => 1,
										'image_original_filename' => $file,
										'width' => $img_size[0],
										'height' => $img_size[1],
										'image_title' => 'news_image',
										'image_description' => 'news_image');
						$this->db->insert('images', $data);
					}
				}
				closedir($handle);
			}

		}
	}

	function create_documents_table() {
		// if the documents table does not exist, create it
		if(!$this->db->table_exists('documents') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_documents_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);					// set the primary key
			$this->dbforge->create_table('documents');

			log_message('info', "Created table: documents");

			//get and insert sample pdfs in db
			$dir = 'user_content/documents';
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if(preg_match('/(.pdf)$/i', $file)){
						$data = array(
							'user_id' => 1,
							'type' => 2,
							'document_original_filename' => $file,
							'document_title' => str_replace('.pdf', "", $file),
							'document_description' => 'Document description',
							'group_id' => 1,
							'is_public' => true
						);
						$this->db->insert('documents', $data);
					}
				}
				closedir($handle);
			}
		}
	}

	function create_document_types_table()
	{
		if(!$this->db->table_exists('document_types') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_document_types_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('document_types');

			log_message('info', "Created table: document_types");

			$data = array(
			   	'document_type' => 'protocol',
			);
			$this->db->insert('document_types', $data);

			// $data = array(
			//    	'document_type' => 'protocol_autumn',
			// );
			// $this->db->insert('document_types', $data);

			// $data = array(
			//    	'document_type' => 'protocol_spring',
			// );
			// $this->db->insert('document_types', $data);

			$data = array(
			   	'document_type' => 'directional_document',
			);
			$this->db->insert('document_types', $data);
			
			$data = array(
			   	'document_type' => 'documents_meeting_autumn',
			);
			$this->db->insert('document_types', $data);

			$data = array(
			   	'document_type' => 'documents_meeting_spring',
			);
			$this->db->insert('document_types', $data);			
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

	function create_page_table()
	{
		if(!$this->db->table_exists('page') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_page_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('id',true);
			$this->dbforge->create_table('page');

			log_message('info', "Created table: page");

		}
	}
	function create_page_content_table()
	{
		if(!$this->db->table_exists('page_content') || isset($_GET['drop']))
		{
			$this->load->dbforge();
			// the table configurations from /application/helpers/create_tables_helper.php
			$this->dbforge->add_field(get_page_content_fields()); 	// get_user_table_fields() returns an array with the fields
			$this->dbforge->add_key('page_id',true);
			$this->dbforge->add_key('lang_id',true);
			$this->dbforge->create_table('page_content');

			log_message('info', "Created table: page_content");

			$this->load->model("Page_model");

			$translations = array(
									array("lang" => "se", "header" => "Sidan finns inte", "content" => "Sidan du försökte nå finns inte. Var god rapportera till webbansvarige."),
									array("lang" => "en", "header" => "The page does not exist", "content" => "The page you tried to reach does not exist. Please report to the webmaster."),
								);
			$this->Page_model->add_page("404", $translations, 1);


			$translations = array(
									array("lang" => "se", "header" => "Utbildningen", "content" => "Civilingenjör i medieteknik är en mångsidig utbildning med tyngdpunkten på teknik för en bransch i ständig förändring. Liksom alla traditionella civilingenjörsutbildningar, består medieteknik av en gedigen grund i matematik och teknik. Styrkan ligger i vår unika förmåga att vara allsidiga, samtidigt som vi själva har möjligheten att välja vår egen profil och utveckla spetskompetens inom visualisering, grafisk teknik, ljud och video.

###Hård och mjuk
									Om ni tittar närmare på vår logotyp, ser ni att den är indelad i en mörkare grå kub, som står för de tunga tekniska ämnena samt en mjukare orange, som präglas av de mer humanistiskt lagda bitarna av utbildningen, såsom design, projektledning, interaktion mellan människa och teknik, osv. Denna kombination av teknik och humaniora är en av grundstenarna till Medieteknikutbildningen, såväl som orsak till dess popularitet hos såväl företag som gymnasiestudenter.

###Efter plugget
									En utexaminerad medietekniker har en bred och varierad arbetsmarknad och har visat sig vara oumbärlig både innanför rikets gränser och utanför. Allt ifrån filmeffekter i Hollywood, 3D-visualiseringar av röntgenbilder och galaxer, fysiksimuleringar inom spelbranschen, virtuella möbler i Ikea-katalogen, IT-konsult och garanterad färgkvalitet i trycksaker. Listan kan göras lång och blir bara längre och längre. Allsidighet är ett nyckelord som ständigt kommer tillbaka.
									"),
									array("lang" => "en", "header" => "Education", "content" => "Lorizzle bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz."),
								);
			$this->Page_model->add_page("about/education", $translations, 1);

			$translations = array(
									array("lang" => "se", "header" => "Medieteknikdagarna", "content" => "Det borde man gå på. Läs mer på http://medieteknikdagarna.se/"),
									array("lang" => "en", "header" => "Media Technology Days", "content" => "You should go to it. Read more http://medieteknikdagarna.se/"),
								);
			$this->Page_model->add_page("mtd", $translations, 1);

			/*
			$translations = array(
									array("lang" => "se", "header" => "Utbildningen", "content" => "Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."),
									array("lang" => "en", "header" => "Education", "content" => "Lorizzle bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz."),
								);
			$this->Page_model->add_page("about/education", $translations, 1);
			*/

			$translations = array(
									array("lang" => "se", "header" => "Kurser", "content" => "Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."),
								);
			$this->Page_model->add_page("about/courses", $translations, 1);

			$translations = array(
									array("lang" => "se", "header" => "Sökande", "content" => "Lorem [b]ipsum[/b] [i]dolor[/i] sit amet, consectetur adipiscing elit. Curabitur eget eros eu nulla porta fringilla. Morbi facilisis quam at mi dictum vel vestibulum tellus ultrices. Duis et orci neque, sit amet commodo libero. Pellentesque accumsan pharetra justo. Proin eu metus eget leo dapibus volutpat et in dui. Ut risus sapien, commodo id tempor vitae, dignissim at eros. Mauris sit amet sem non justo rutrum feugiat. Mauris semper tincidunt hendrerit."),
								);
			$this->Page_model->add_page("about/applicant", $translations, 1);

			$translations = array(
									array("lang" => "en", "header" => "Association", "content" => "Lorizzle (association/board|Styret) bizzle dolor bow wow wow amizzle, consectetuer adipiscing boom shackalack. Nullizzle sapien velizzle, shiz volutpizzle, pizzle quizzle, gravida vizzle, arcu. Pellentesque eget tortor. Sed eros. Fusce sizzle dolor dapibizzle shiz tempus sheezy. Maurizzle pellentesque funky fresh izzle turpizzle. You son of a bizzle shut the shizzle up doggy. Bow wow wow my shizz rhoncizzle crazy. In you son of a bizzle ma nizzle platea dictumst. Shut the shizzle up tellivizzle. Curabitur tellizzle tellivizzle, dawg pimpin', mattizzle ac, eleifend bizzle, nunc. Break it down suscipit. Integizzle sempizzle away sizzle my shizz."),
								);
			$this->Page_model->add_page("association/overview", $translations, 1);

			$translations = array(
									array("lang" => "se", "header" => "Utskott", "content" => "Mycket av den verksamhet som sker inom sektionen sker inom de olika utskott eller grupper som finns i anslutning till sektionen. Dessa grupper leds av respektive styrelsemedlem för just det området. Men det finns även några andra som inte är direkt kopplade till styrelsen utan snarare till sektionen.

##Styrelseutskott
###Event-utskottet
Event-utskottet har hand om försäljningen i MT-shopen, samt designar och ser till att det finns nya, tuffa produkter. Utskottet har tidigare bl.a.tagit fram en mössa med MT-kuberna på samt ett fint joggingset, hoodie och byxa, med ett otroligt tjusigt MT-märke på.

Det är även vi som anordnar förSAFT och SAFT (SektionsAktivas FesT) på hösten resp. vårkanten. Detta är mycket trevliga tillställningar där alla sektionsaktiva innom MT får chansen att lära känna varandra.

Utskottet är även med och planerar och anordnar sektionspubar på Trappan. Vi försöker även vara på hugget när det gäller saker som kan gynna rekryteringen.

###Midsommarphestutskottet
Vi som är med i Midsommarphestutskottet ansvarar för att fixa en så bra sittning som möjligt för studenterna på Medieteknik. Midsommarphesten är en relativt stor sittning med runt 120 sittande och för att den ska bli så bra som möjligt krävs en hel del jobb, något som oftast också är väldigt roligt! Bland annat fixar vi ett fint märke, gör en affisch, målar ett lakan, kollar priser, bokar lokal, köper in allt och organiserar samtidigt som vi i gruppen har trevligt tillsammans.

###Näringslivsutskottet
Näringslivsutskottet (NLU) skapar nya och tar tillvara på redan tagna kontakter med näringslivet. Det är vi som ser till att företaget vet vilka vi är och hur bra vi är på det vi kan! I år har utskottet tagit fram en ny företagsfolder som är tänkt att fungera som ett informerande komplement till traditionella ansökningshandlingar, t ex när man söker examensarbete och jobb. Företagsfoldern finns med start i april till försäljning i MT-shoppen. Utskottet har också anordnat företagskvällar och studiebesök hos företag i området.

###PR- & Medieutskottet
Utskottet jobbar främst med det interna och externa informationsflödet inom medietekniksektionen. Bland annat genom att se till att medietekniks Lithaniansida fylls med reportage och information samt skapar intressanta MT-relevanta reportage till hemsidan.

###Rekryteringsutskottet
Utskottet jobbar främst med nya och gamla idéer för att öka söktrycket till medietekniksprogrammet i Norrköping. Utskottet har bra kontakt med kommunikatörerna på skolan och ser till att ha den mest uppdaterade informationen om hemmissioneringen.

Under verksamhetsåret 12/13 så jobbar utskottet med tre större uppgifter:

Medieteknikbroschyren – En broschyr som representanter från utbildningen ska ha möjlighet att dela ut vid olika event eller hemmissioneringar. Broschyren ska ha relevant information om just medietekniska programmet i Norrköping.

”Det här är MT” – Ett nyskapat projekt där rekryteringsutskottet har möjlighet att skapa ett rekryteringsevent för att synas på gymnasieskolor och basår. Eventets syfte är att öka söktrycket för just medietekniksutbildningen samt se till rätt bild av medieteknik syns utåt.

Medietekniks rekryteringsfilm – Ett nyskapat projekt där filmintresserade studenter på medieteknik skapar en film avsedd för rekrytering inom medietekniksektionen. Filmen ska också kunna användas på mässor och event för att göra reklam för just medieteknik i Norrköping.


###Webbutskottet
Utskottet ansvarar för utvecklingen av medieteknik.nu sidan, i form av funktionalitet och grafisk utformning. Samt underhåll under verksamhetsåret och dess innehåll.

##Övriga grupper
###Arbetsmiljöombudet
Arbetsmiljöombudets uppgift består av två delar; den fysiska och den psykiska arbetsmiljön. För den fysiska delen möts alla arbetsmiljöombud från sektionerna i Norrköping en gång i månaden och uppdateras om vad som händer på fronten. Här tas även nya förslag upp som sedan skickas vidare till beslutsorganen. Så om du har ett förslag är det bara att kontakta mig så för jag vidare det, eller tar kontakt med de parter den gäller. Exempel på fysisk arbetsmiljö är problem med lokaler, framkomlighet m.m. Min roll i den psykiska arbetsmiljön är att ge råd på hur du ska gå tillväga med ditt problem rent byråkratiskt samt ge direktiv om vem du skall kontakta om du vill prata med någon. Detta gäller då trakasserier, mobbing m.m. Mer information om arbetsmiljö och arbetsmiljöombud hittas på denna sida: https://www.student.liu.se/arbetsmiljo?l=sv

###Jämställdhetsansvarig
Jämställdhetsansvarig inom Medietekniksektionen är Jenny Yu

###Resultat av jämställdhetsformuläret
Lärarformuläret[br]
Jämställdhetsplan 2006

###MTD-gruppen
Är gruppen av hårt arbetande studenter som ser till att MTs årliga branschdag 'Medieteknikdagarna' blir den bästa någonsin, år efter år!

Se mer på http://www.medieteknikdagarna.se/


###Valberedningen
Väljs under höstmötet och har som uppdrag att till vårmötet lägga fram förslag på nästa års styrelse."),
								);
			$this->Page_model->add_page("association/committee", $translations, 1);

		}
	}



	function create_forum_categories_descriptions_language_view()
	{
		if(!$this->db->table_exists('forum_categories_descriptions_language') || isset($_GET['drop']))
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
		if(!$this->db->table_exists('news_translation_language') || isset($_GET['drop']))
		{
			$q = "CREATE OR REPLACE VIEW news_translation_language AS (SELECT e.news_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.introduction,e.introduction) as introduction, COALESCE(o.text,e.text) as text, e.last_edit ";
			$q .= " FROM news_translation               e";
			$q .= " LEFT OUTER JOIN news_translation o ON e.news_id=o.news_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}

	function create_groups_descriptions_language_view()
	{
		if(!$this->db->table_exists('groups_descriptions_language') || isset($_GET['drop']))
		{
			$q = "CREATE OR REPLACE VIEW groups_descriptions_language AS (SELECT e.groups_id,e.lang_id,COALESCE(o.description,e.description) as description,COALESCE(o.name,e.name) as name ";
			$q .= " FROM groups_descriptions               e";
			$q .= " LEFT OUTER JOIN groups_descriptions o ON e.groups_id=o.groups_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}

	function create_page_content_language_view()
	{
		if(!$this->db->table_exists('page_content_language'))
		{
			$q = "CREATE OR REPLACE VIEW page_content_language AS (SELECT e.page_id,e.lang_id,COALESCE(o.header,e.header) as header, COALESCE(o.content,e.content) as content, COALESCE(o.last_edit,e.last_edit) as last_edit  ";
			$q .= " FROM page_content               e";
			$q .= " LEFT OUTER JOIN page_content o ON e.page_id=o.page_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()";
			$q .= " WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))";
			$this->db->query($q);
		}
	}

}

