<?php 
	
class User extends CI_Controller {

	public $language = '';
	public $language_abbr = '';
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->language = $this->config->item('language');
		$this->language_abbr = $this->config->item('language_abbr');
    }

	public function index()
	{
		if($this->login->is_logged_in()) {
			$this->profile(1);
		}else {
			$this->not_logged_in();
		}
	}
	
	public function profile($id) {
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for forum view
		$this->load->model('User_model');
		$profile_data['user'] = $this->User_model->get_user_profile($id);
		$profile_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['main_content'] = $this->load->view('user_profile',  $profile_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function not_logged_in() {
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for forum view
		$login_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['main_content'] = $this->load->view('login_notloggedin',  $login_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function login() {
		$this->load->helper('form');
		
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for forum view
		$login_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['main_content'] = $this->load->view('login_view',  $login_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function logout() {
		$this->login->logout();
		redirect('user/login', 'refresh');
	}
	
	public function checklogin() {
		if($this->input->post('username') != false && $this->input->post('password') != false && $this->login->validate($this->input->post('username'), $this->input->post('password'))){
			//success
			redirect('user', 'refresh');
		} else {
			// fail
			
			echo $this->input->post('username') ." ". $this->input->post('password');
			redirect('user/login', 'refresh');
		}
	}
	

	
}


/*
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Login extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->language = $this->config->item('language');
		//$this->language_abbr = $this->config->item('language_abbr');
    }

	public function index()
	{
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for forum view
		$login_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['main_content'] = $this->load->view('login_view',  $login_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
}


*/
