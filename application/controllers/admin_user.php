<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_user extends MY_Controller 
{

	public $languages = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		if(!$this->login->is_admin()) 
		{
			redirect('/admin/access_denied', 'refresh');
		}
		
		// access granted, loading modules
		$this->load->model('user_model');
		$this->load->helper('form');
		
		$this->languages = array	(
										array(	'language_abbr' => 'se',
												'language_name' => 'Svenska',
												'id' => 1),
										array(	'language_abbr' => 'en',
												'language_name' => 'English',
												'id' => 2)
									);
    }

	public function index()
	{
		$this->user_overview();
	}
	
	function user_overview() 
	{

		// Data for overview view
		$this->load->model('User_model');
		$main_data['user_list'] = $this->User_model->get_all_users();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/user_overview',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}
	
	function edit_user($id) 
	{

		// Data for overview view
		$this->load->model('User_model');
		$main_data['user'] = $this->User_model->get_user_profile($id);
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/user_edit',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}
	
}
?>