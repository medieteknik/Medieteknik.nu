<?php

function get_user_table_fields()
{	
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			'auto_increment' => TRUE
			),
		'first_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '20',
			),
		'last_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
			),
		'lukasid' => array(
			'type' => 'VARCHAR',
			'constraint' => '10',
			),
		);
	return $fields;
}

function get_language_table_fields()
{	
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			'auto_increment' => TRUE
			),
		'language_abbr' => array(
			'type' => 'CHAR',
			'constraint' => '2',
			),
		'language_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
			),
		'language_order' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE
			),
		);
	return $fields;
}

function get_news_table_fields()
{	
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			'auto_increment' => TRUE
			),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
		),
		'user_group_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
		),
		'date' => array(
			'type' => 'DATETIME',
			),
		'draft' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
			),
		'approved' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
			),
		);
	return $fields;
}

function get_news_translation_table_fields()
{	
	$fields = array(
		'news_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			),
		'lang_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
		),
		'title' => array(
			'type' => 'VARCHAR',
			'constraint' => '100', 
		),
		'text' => array(
			'type' => 'TEXT',
			),
		'last_edit' => array(
			'type' => 'DATETIME',
			),
		);
	return $fields;
}

function get_news_sticky_table_fields()
{	
	$fields = array(
		'news_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			),
		'sticky_order' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE
			),
		);
	return $fields;
}

function get_groups_fields()
{	
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			),
		'group_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
			),
		);
	return $fields;
}

function get_users_groups_fields()
{	
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
		),
		'group_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
		),
		'start' => array(
			'type' => 'DATETIME',
		),
		'stop' => array(
			'type' => 'DATETIME',
		),
		'position' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'email' => array(
			'type' => 'VARCHAR',
			'constraint' => '320',
		),
		);
	return $fields;
}

function get_groups_descriptions_fields()
{	
	$fields = array(
		'group_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			),
		'lang_id' => array(
			'type' => 'INT',
			'constraint' => 5, 
			'unsigned' => TRUE,
			),
		'description' => array(
			'type' => 'VARCHAR',
			'constraint' => '300', 
			),
		);
	return $fields;
}
