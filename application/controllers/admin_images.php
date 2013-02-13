<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_images extends MY_Controller 
{
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		if(!$this->login->is_admin()) 
		{
			redirect('/admin/access_denied', 'refresh');
		}
		
		$this->load->model('Images_model');
    }

	public function index()
	{
		$this->overview();
	}
	
	function overview() 
	{

		// Data for overview view
		$main_data['image_array'] = $this->Images_model->get_all_images();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/images_overview',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function add_image()
	{
		
	}

	function upload()
	{

	}

	function delete($id)
	{
		$this->Images_model->delete_image($id);
		redirect('admin_images', 'refresh');
	}
}
