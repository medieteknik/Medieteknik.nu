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
		$config['uploadPath'] = './user_content/documents/';
		$config['acceptedFiles'] = "application/pdf,.doc,.rtf";
		$config['maxSize'] = '20'; //MB
		return $config;
	}

	function add_uploaded_document($orig_filename, $document_type, $userid, $title = '', $description = '', $group_id, $is_public = true, $upload_date) 
	{
		//do_dump($upload_data);
		//$temp_path = 'user_content/documents';
		//$new_path = 'user_content/documents';

		//$orig_filepath = $temp_path . $upload_data['file_name'];
		//$ext = $upload_data['file_ext'];

		$data = array(
			'user_id' => $userid,
			'type' => $document_type,
			'document_original_filename' => $orig_filename,
			'document_title' => $title,
			'document_description' => $description,
			'group_id' => $group_id,
			'is_public' => $is_public,
			'upload_date' => $upload_date
			);
		$this->db->insert('documents', $data);
		$document_id = $this->db->insert_id();
		
		return $document_id;

		// $data = array(
		// 	'user_id' => 1,
		// 	'type' => 2,
		// 	'document_original_filename' => $file,
		// 	'document_title' => str_replace('.pdf', "", $file),
		// 	'document_description' => 'Document description',
		// 	'group_id' => 1,
		// 	'is_public' => true
		// );
		// $this->db->insert('documents', $data);
	}

	function get_all_documents_for_group($group_id, $type=0){

		$this->db->select('*');
		$this->db->from('documents');
		if($type != 0)
			$this->db->where('type', $type);
		$query = $this->db->get();
		$documents = $query->result();

		$this->db->select('*');
		$this->db->from('document_types');
		$query = $this->db->get();
		$result = $query->result();

		foreach($result as $result_type)
			$result_type->documents = array();
		
		foreach($documents as $document)
			array_push($result[$document->type-1]->documents, $document);	

		return $result;
	}

	function delete_document($id)
	{
		$query = $this->db->get_where('documents', array('id' => $id), 1, 0);
		if ($query->num_rows() == 1) 
		{
			$res = $query->result();
			$res = $res[0];
			unlink('user_content/documents/'.$res->document_original_filename);
		}
		$this->db->delete('documents', array('id' => $id)); 
	}
}