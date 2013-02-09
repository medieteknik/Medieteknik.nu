<?php
/**
* The following functions are defining the tables
*
* @uses the install model class is using these functions when creating the tables
*/

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
		'password_hash' => array(
			'type' => 'VARCHAR',
			'constraint' => '130',
			),
		'disabled' => array(
			'type' => 'BOOL',
			'default' => '0',
			),
		);
	return $fields;
}

function get_users_data_table_fields()
{
	$fields = array(
		'users_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE
			),
		'gravatar' => array(
			'type' => 'VARCHAR',
			'constraint' => 255,
			),
		'web' => array(
			'type' => 'VARCHAR',
			'constraint' => '300',
			),
		'linkedin' => array(
			'type' => 'VARCHAR',
			'constraint' => '300',
			),
		'presentation' => array(
			'type' => 'VARCHAR',
			'constraint' => '1000',
			),
		'twitter' => array(
			'type' => 'VARCHAR',
			'constraint' => '300',
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
		'group_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'default' => 0,
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
			'auto_increment' => TRUE
		),
		'sub_to_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'default' => 0,
		),
		'group_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
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

function get_users_groups_fields()
{
	$fields = array(
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

function get_forum_categories_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'sub_to_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'default' => 0
		),
		'guest_allowed' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
			'default' => 0
		),
		'posting_allowed' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
			'default' => 1
		),
		'group_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'default' => 0
		),
		'order' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'default' => 0
		),
		);
	return $fields;
}

function get_forum_categories_descriptions_fields()
{
	$fields = array(
		'cat_id' => array(
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
			'constraint' => "50",
		),
		'description' => array(
			'type' => 'VARCHAR',
			'constraint' => "300",
		),
		);
	return $fields;
}

function get_forum_topic_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'cat_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'topic' => array(
			'type' => 'VARCHAR',
			'constraint' => "100",
		),
		'last_reply_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		);
	return $fields;
}

function get_forum_reply_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'topic_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'reply' => array(
			'type' => 'TEXT',
		),
		'reply_date' => array(
			'type' => 'DATETIME',
		),
		);
	return $fields;
}

function get_forum_reply_guest_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'topic_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'post' => array(
			'type' => 'TEXT',
		),
		'reply_date' => array(
			'type' => 'DATETIME',
		),
		'first_name' => array(
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

function get_privileges_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'privilege_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '20',
		),
		'privilege_description' => array(
			'type' => 'VARCHAR',
			'constraint' => '320',
		),
		);
	return $fields;
}

function get_users_privileges_fields()
{
	$fields = array(
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE
		),
		'privilege_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE
		)
		);
	return $fields;
}

function get_images_fields()
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
		'image_original_filename' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'width' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'height' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'image_title' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'image_description' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		);
	return $fields;
}

function get_news_images_fields()
{
	$fields = array(
		'news_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'images_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'size' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'position' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'height' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),

		);
	return $fields;
}
