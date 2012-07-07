<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
		
	public function index()
	{
			
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->config->item('language'), 'swedish');
		//$header_data['css_screen'] = array('reset', 'basic', 'base');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->config->item('language'), 'swedish');

		// user view data
		$this->load->model('User_model');
		$user_data['users'] = $this->User_model->get_all_users();

		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->load->view('includes/menu',$menu_data);
		$this->load->view('users_view',$user_data);
		$this->load->view('includes/footer',$header_data);
	}
}
