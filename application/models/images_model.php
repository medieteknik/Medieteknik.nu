<?php
class Images_model extends CI_Model 
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function news_get_config() 
	{
		
		$config['upload_path'] ='./user_content/images/original';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '1920';
		$config['max_height']  = '1200';
		$config['overwrite']  = FALSE;
		$config['file_name']  = uniqid('news_');
		return $config;
	}

	function add_image(&$upload_data, $userid, $title = '', $description = '') 
	{
		
	}
	
	function add_news_image(&$upload_data) 
	{
		
	}

	function get_images($limit = 0){
		$this->db->select('image_original_filename');
		$this->db->from('images');
		if($limit){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
		$result = $query->result();
		foreach($result as &$res){
			$image = new imagemanip();
			$image->create($res->image_original_filename, 'zoom', 100, 100);
			$res = $image->get_img_tag();
		}
		return $result;
	}
}
