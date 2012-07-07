<?php 
	
class User extends MY_Controller {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function index()
	{
		if($this->login->is_logged_in()) {
			$this->profile($this->login->get_id());
		}else {
			$this->not_logged_in();
		}
	}
	
	public function profile($id) {

		// Data for forum view
		$this->load->model('User_model');
		$main_data['user'] = $this->User_model->get_user_profile($id);
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('user_profile',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function not_logged_in() {
		// Data for forum view
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('login_notloggedin',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function login() {
		$this->load->helper('form');

		// Data for forum view
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('login_view',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
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

