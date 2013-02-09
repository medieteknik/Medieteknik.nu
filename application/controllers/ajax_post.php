<?php
/**
* Controller for ajax post requests
*/
class Ajax_post extends MY_Controller
{
	
	function __construct()
	{
		// Call the Model constructor
        parent::__construct();

        //no access if not admin (could be changed later)
		if(!$this->login->is_admin()) 
		{
			redirect('/admin/access_denied', 'refresh');
		}
	}

	function get_images($limit = 0){
		$this->load->model("Images_model");
		echo json_encode($this->Images_model->get_images($limit));
	}
}