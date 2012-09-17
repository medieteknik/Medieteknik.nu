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
		$config['allowed_types'] = 'jpg';
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
}
