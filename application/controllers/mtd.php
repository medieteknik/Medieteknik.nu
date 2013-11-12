<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtd extends MY_Controller
{

	public function index()
	{
		$this->load->model('Page_model');
		//$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$string = "mtd";

		$main_data['content'] = $this->Page_model->get_page_by_name($string);
		$main_data['name'] = $string;
		$main_data['lang'] = $this->lang_data;

		$template_data['main_content'] = $this->load->view('about_page',  $main_data, true);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_association().$this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}
}
