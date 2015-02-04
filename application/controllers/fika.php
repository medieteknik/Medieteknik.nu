<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fika extends MY_Controller {

	public function index()
	{
		$string = "fika/";
		$arguments = array();
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for ($i = 0; $i < $numargs; $i++) {
			if($i > 0)
				$arguments[$i] = $arg_list[$i];
			else
				$string .= $arg_list[$i] . "/";
		}
		$string = rtrim($string,"/");
		$string = trim($string,"/");



		$this->load->model('Page_model');
		$main_data['name'] = $string;
		$main_data['lang'] = $this->lang_data;
		$this->load->model('Page_model');
		$this->load->model('Group_model');
		$group_years = $this->Group_model->get_group_years(1);
		$main_data['groups'] = $this->Group_model->get_group(1);
		$main_data['group_years'] = $group_years;

		$group = end($group_years);
		$date = new DateTime();
		$week = $date->format("W");
		$index = (($week+5)/2)%count($group->members);
		$fika_boss = $group->members[$index]; /*<- lol */
		$next_fika_boss = $group->members[$index+1];

		$main_data['fika_boss'] = $fika_boss;
		$main_data['next_fika_boss'] = $next_fika_boss;

		$template_data['main_content'] = $this->load->view('fika',  $main_data, true);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_association().$this->sidebar->get_standard();

		$this->load->view('templates/main_template',$template_data);

	}

}

/* End of file fika.php */
/* Location: ./application/controllers/fika.php */