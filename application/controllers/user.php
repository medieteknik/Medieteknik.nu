<?php

class User extends MY_Controller
{

	public function index()
	{
		if($this->login->is_logged_in())
		{
			$this->profile($this->login->get_id());
		}else {
			$this->not_logged_in();
		}
	}

	public function profile($id)
	{
		// model for user handeling
		$this->load->model('User_model');

		if(!$this->User_model->id_exists($id))
			show_404();

		// Data for user view
		$main_data['user'] = $this->User_model->get_user_profile($id);
		$main_data['lang'] = $this->lang_data;
		$main_data['is_logged_in'] = $this->login->is_logged_in() && $this->login->get_id() == $id;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('user_profile',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	public function new_user($do = '')
	{
		$user = $this->cas->user();
		$this->load->helper('form');
		$this->load->model('User_model');

		if($do == 'create')
		{
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');

			if($this->User_model->add_user($firstname, $lastname, $user->userlogin, ''))
			{
				$this->login();
			}
			else
				$main_data['error'] = true;




		}

		// Data for user view
		$main_data['user'] = $user->userlogin;
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('user_new',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	public function edit_profile($do = '')
	{
		$id = $this->login->get_id();
		$this->load->helper('form');
		// load user model
		$this->load->model('User_model');

		if(!$this->login->is_logged_in())
			show_404();

		if($do == 'runedit')
		{
			$main_data['run'] = true;

			$web = $this->input->post('web');
			$li = $this->input->post('linkedin');
			$twitter = $this->input->post('twitter');
			$presentation = $this->input->post('presentation');
			$gravatar = $this->input->post('gravatar');

			$main_data['status'] = $this->User_model->edit_user_data($id, $web, $li, $twitter, $presentation, $gravatar);
		}

		// Data for user view
		$main_data['user'] = $this->User_model->get_user_profile($id);
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('user_profile_edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	public function not_logged_in()
	{
		// Data for forum view
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('login_notloggedin',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	public function login($attempt = '', $redir = '')
	{
		// force auth using cas
		$this->cas->force_auth();
		$this->checklogin(base64_decode($redir));

		//old login form, before use of CAS:
		/*
		$this->load->helper('form');

		// Data for login view
		$main_data['lang'] = $this->lang_data;
		$main_data['attempt'] = $attempt;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('login_view',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		*/
	}

	public function logout()
	{
		$this->login->logout();
		redirect('user/login', 'refresh');
	}

	/*
	public function checklogin()
	{
		if($this->input->post('username') != false && $this->input->post('password') != false && $this->login->validate($this->input->post('username'), $this->input->post('password')))
		{
			//success
			redirect('user', 'refresh');
		} else {
			// fail
			//echo $this->input->post('username') ." ". $this->input->post('password');
			redirect('user/login/'.$this->input->post('username'), 'refresh');
		}
	}
	*/

	public function checklogin($redir = '')
	{
		$user = $this->cas->user();

		if($this->login->login($user->userlogin))
		{
			//success
			redirect($redir, 'refresh');
		} else {
			// fail, there is no such user in database
			//echo $this->input->post('username') ." ". $this->input->post('password');
			$this->new_user();
			//$this->login->logout();
			//redirect('user/login/'.$this->input->post('username'), 'refresh');
		}
	}


}

