<?php
/**
* Model to fetch uploaded documents
*/
class Documents_model extends CI_Model
{
	
	function __construct()
	{
		// Call the Model constructor
        parent::__construct();
	}

	function get_config() 
	{
		
		$config['upload_path'] ='./user_content/documents';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '8000';
		$config['overwrite']  = FALSE;
		$config['file_name']  = uniqid('temp_');
		return $config;
	}

	// function add_uploaded_document(&$upload_data, $userid, $title = '', $description = '') 
	// {
	// 	//do_dump($upload_data);
	// 	$temp_path = 'user_content/documents';
	// 	$new_path = 'user_content/documents';

	// 	$orig_filepath = $temp_path . $upload_data['file_name'];
	// 	$ext = $upload_data['file_ext'];

	// 	$new_filename = uniqid() . ".pdf";

	// 	unlink($orig_filepath);

	// 	$data = array(
	// 		'user_id' => $userid,
	// 		'document_original_filename' => $new_filename,
	// 		'document_title' => $title,
	// 		'document_description' => $description,
	// 		);
	// 	$this->db->insert('documents', $data);
	// 	$document_id = $this->db->insert_id();
		
	// 	return $document_id;
	// }

	function get_all_documents_for_group($group_id){
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('group_id', $group_id);
		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}
}