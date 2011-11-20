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

