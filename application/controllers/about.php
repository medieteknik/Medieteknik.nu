<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends MY_Controller
{

	public function index()
	{
		$this->page("education");
	}

	public function page()
	{
		$string = "about/";
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for ($i = 0; $i < $numargs; $i++) {
			$string .= $arg_list[$i] . "/";
		}
		$string = rtrim($string,"/");
		$string = trim($string,"/");
		$this->load->model('Page_model');

		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$main_data['content'] = $this->Page_model->get_page_by_name($string);
		$main_data['name'] = $string;
		$main_data['lang'] = $this->lang_data;

		$template_data['main_content'] = $this->load->view('about_page',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_about().$this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	public function format()
	{
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('about_format',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_about().$this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

}
