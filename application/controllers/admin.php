<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin extends CI_Controller {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		if(!$this->login->is_admin() && $this->uri->segment(2) != "login") {
			redirect('/admin/login/', 'refresh');
		}
    }

	public function index()
	{
		$this->overview();
	}
	
	function login() {
		
		$this->login->logout();
		$this->login->validate("emiax775", "password");
		
		if($this->login->is_logged_in()) {
			echo "logged in";
		}
		if($this->login->is_admin()) {
			echo " and admin";
		}
		
		if($this->login->has_privilege("admin")) {
			echo "<br> true";
		}
	}
	
	function overview() {
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->language, 'swedish');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->language, 'swedish');

		// Data for Startsida view
		$this->load->model('Forum_model');
		$forum_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to(0,$this->language_abbr);
		$forum_data['common_lang'] = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->parser->parse('includes/menu',$menu_data);
		$this->parser->parse('admin/menu',$menu_data);
		$this->load->view('forum_overview', $forum_data);
		$this->load->view('includes/footer',$header_data);
	}
	
	private function checkLogin() {
		if($this->uri->segment(2) == "login") {
			return true;
		}
		return false;
	}
	
	
}
