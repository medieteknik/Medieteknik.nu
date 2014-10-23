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

		$main_data['name'] = $string;
		$main_data['lang'] = $this->lang_data;

		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		switch($string)
		{
			case "about/mtd":
				$this->load->model('Group_model');
				$main_data['groups'] = $this->Group_model->get_group(4);
				$main_data['group_years'] = $this->Group_model->get_group_years(4);
				$template_data['main_content'] = $this->load->view('group_overview', $main_data, true);
				break;
			default:
				$main_data['content'] = $this->Page_model->get_page_by_name($string);
				$template_data['main_content'] = $this->load->view('about_page',  $main_data, true);

				break;
		}

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
