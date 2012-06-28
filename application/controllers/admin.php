<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	public $lang_data = '';
	public $adminmenu = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
		$this->language = $this->config->item('language');
		$this->language_abbr = $this->config->item('language_abbr');
		
		// language data
		$this->lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		if(!$this->login->is_admin() && $this->uri->segment(2) != "access_denied") {
			redirect('/admin/access_denied', 'refresh');
		}
		
		$this->adminmenu['title'] = "Admin";
		$this->adminmenu['items'] = array(	array('title' => $this->lang_data['admin_addnews'], 'href' => "admin/news"),
										array('title' => $this->lang_data['admin_editusers'], 'href' => "admin/edit_users"),
										array('title' => $this->lang_data['admin_editimages'], 'href' => "admin/edit_images"),
										array('title' => $this->lang_data['admin_addusers'], 'href' => "admin/add_users"),
										array('title' => $this->lang_data['admin_addusers'], 'href' => "admin/add_users"));
		
    }

	public function index()
	{
		$this->overview();
	}
	
	public function access_denied() {
		// Data for denied view
		$denied_data['lang'] = $this->lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$denied_data, true);
		$template_data['left_content'] = $this->load->view('admin/denied',  $profile_data, true);					
		$template_data['right_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	/*
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
	*/
	function overview() {

		// Data for overview view
		$this->load->model('User_model');
		$overview_data['privileges'] = $this->User_model->get_user_privileges($this->login->get_id());
		$overview_data['lang'] = $this->lang_data;
		//$profile_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['left_content'] = $this->load->view('admin/overview',  $overview_data, true);					
		$template_data['right_content'] = $this->load->view('includes/link', $this->adminmenu, true);			
		$template_data['right_content'] .= $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	function news() {
		$this->load->helper('form');
		// Data for forum view
		//$this->load->model('User_model');
		$news_data['lang'] = $this->lang_data;
		//$profile_data['lang'] = $lang_data;
		
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['left_content'] = $this->load->view('admin/news',  $news_data, true);					
		$template_data['right_content'] = $this->load->view('includes/link', $this->adminmenu, true);			
		$template_data['right_content'] .= $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	

	
	
}
