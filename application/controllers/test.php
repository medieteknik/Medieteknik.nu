<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Test extends MY_Controller {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function index()
	{
		$this->overview();
	}

	function overview() {

		// Data for overview view
		$this->load->model('User_model');
		$main_data['privileges'] = $this->User_model->get_user_privileges($this->login->get_id());
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('test_vars',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

}
