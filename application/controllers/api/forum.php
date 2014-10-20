<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('Forum_model');
	}

	function markdown_preview()
	{
		$text = $this->input->post('text');
		$view_data = array();

		if($text)
		{
			$view_data['result'] = text_format($text);
			$view_data['message'] = 'Preview of text';
		}
		else
		{
			$view_data['result'] = false;
			$view_data['message'] = 'No post data sent';
		}

		$this->load->view('templates/json', $view_data);
	}
}

?>
