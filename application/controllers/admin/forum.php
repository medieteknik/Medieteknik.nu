<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

		if(!$this->login->has_privilege('forum_moderator'))
		{
			redirect('/admin/admin/access_denied', 'refresh');
		}
		// access granted, loading modules and helpers
		$this->load->model('Forum_model');
		$this->load->helper('form');

		$this->languages = array(
								array(	'language_abbr' => 'se',
										'language_name' => 'Svenska',
										'id' => 1),
								array(	'language_abbr' => 'en',
										'language_name' => 'English',
										'id' => 2)
							);
	}

	function index()
	{
		$this->overview();
	}

	function overview($message = '')
	{
		// Data for overview page
		$main_data['reports'] = $this->Forum_model->get_all_active_reports();
		$main_data['pending'] = $this->Forum_model->get_all_pending_posts();
		$main_data['lang'] = $this->lang_data;
		$main_data['message'] = $message;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/forum_overview',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function remove_report($report_id)
	{
		if(!is_numeric($report_id))
			show_404();

		if($this->Forum_model->handle_report($report_id))
			redirect('admin/forum/overview/success', 'location');
		else
			redirect('admin/forum/overview/fail', 'location');
	}

	function verify($reply_id)
	{
		if(!is_numeric($reply_id))
			show_404();

		if($this->Forum_model->verify_id($reply_id))
			redirect('admin/forum/overview/success', 'location');
		else
			redirect('admin/forum/overview/fail', 'location');
	}
}
