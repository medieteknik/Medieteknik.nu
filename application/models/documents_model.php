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

	function get_document_years($year_from = 2005)
	{
		$years_array = array();
		$year_to = date("Y",time()); 

		$month = date("m", time());
		if($month < 6)
			$year_to--;	// Example: $year_to is 2013 if current board is 2013/2014

		array_push($years_array, $year_from); // first entry
        while ($year_from<$year_to)
        {
            $year_from+=1; // add 1 year
            array_push($years_array,$year_from);
        }

        return array_reverse($years_array);
	}

	function add_uploaded_document($orig_filename, $document_type, $userid, $title = '', $description = '', $group_id, $is_public = true, $upload_date) 
	{

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

	}

	function get_all_documents_for_group($group_id, $type=0){

		$this->db->select('*');
		$this->db->from('documents');
		$this->db->order_by('upload_date', 'desc');
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