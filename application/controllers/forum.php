<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Forum extends MY_Controller {
	
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

		// Data for forum view
		$this->load->model('Forum_model');
		$main_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to(0,$this->language_abbr);
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('forum_overview', $main_data, true);				
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');

	}
	
	function thread($id) {

		// Data for news view
		$this->load->model('Forum_model');
		$main_data['replies'] = $this->Forum_model->get_replies($id);
		$main_data['topic'] = $this->Forum_model->get_topic($id);
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('forum_thread', $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	
}
