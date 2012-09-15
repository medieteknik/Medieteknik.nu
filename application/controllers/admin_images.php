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
		
    }

	public function index()
	{
		$this->overview();
	}
	
	function overview() 
	{

		// Data for overview view
		$this->load->model('News_model');
		$main_data['news_array'] = $this->News_model->admin_get_all_news_overview();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_overview',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}
}
