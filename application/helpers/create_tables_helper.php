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
		'disabled' => array(
			'type' => 'BOOL',
			'default' => '0',
			),
		'new' => array(
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
		'github' => array(
			'type' => 'VARCHAR',
			'constraint' => '300',
			)
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

function get_carousel_table_fields()
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
		'carousel_type' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'carousel_order' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
			),
		'disabled' => array(
			'type' => 'BOOL',
			'default' => '0',
			),
		'draft' => array(
			'type' => 'BOOL',
			'default' => '1',
			),
		'date' => array(
			'type' => 'DATETIME',
			),
		);
	return $fields;
}

function get_carousel_translation_table_fields()
{
	$fields = array(
		'carousel_id' => array(
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
		'content' => array(
			'type' => 'VARCHAR',
			'constraint' => '200',
		)
	);
	return $fields;
}

function get_carousel_images_fields()
{
	$fields = array(
		'carousel_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'images_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'photo' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'link' => array(
			'type' => 'VARCHAR',
			'constraint' => '100',
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
		'official' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
		),
		);
	return $fields;
}

function get_groups_descriptions_fields()
{
	$fields = array(
		'groups_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			),
		'lang_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'description' => array(
			'type' => 'VARCHAR',
			'constraint' => '600',
		),
		);
	return $fields;
}

function get_groups_year_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'groups_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'start_year' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'stop_year' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		);
	return $fields;
}

function get_groups_year_images_fields()
{
	$fields = array(
		'groups_year_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'images_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		);
	return $fields;
}

function get_groups_year_members_fields()
{
	$fields = array(
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'groups_year_id' => array(
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
			'constraint' => '320'
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
		'slug' => array(
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
		'reply' => array(
			'type' => 'TEXT',
		),
		'reply_date' => array(
			'type' => 'DATETIME',
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '100',
		),
		'email' => array(
			'type' => 'VARCHAR',
			'constraint' => '320',
		),
		);
	return $fields;
}

function get_forum_report_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'reply_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'handled' => array(
			'type' => 'bool',
			'default' => 0
		)
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

function get_documents_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
			'type' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
			'user_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'document_original_filename' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'document_title' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'document_description' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'group_id' => array(
			'type' => 'INT',
			'constraint' => 5,
		),
		'is_public' => array(
			'type' => 'TINYINT',
			'unsigned' => TRUE,
		),
		'upload_date' => array(
			'type' => 'TIMESTAMP'
		),
		);
	return $fields;
}

function get_document_types_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'document_type' => array(
			'type' => 'VARCHAR',
			'constraint' => '30',
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
		);
	return $fields;
}

function get_page_fields()
{
	$fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
		),
		'link_sort' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'published' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
	);
	return $fields;
}

function get_page_content_fields()
{
	$fields = array(
		'page_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'lang_id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'unsigned' => TRUE,
		),
		'last_edit' => array(
			'type' => 'DATETIME',
		),
		'link_name' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'header' => array(
			'type' => 'VARCHAR',
			'constraint' => '50',
		),
		'content' => array(
			'type' => 'TEXT',
		),
	);
	return $fields;
}
