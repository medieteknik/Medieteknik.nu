<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class About extends MY_Controller {
	
	public function index()
	{
		$this->education();
	}
	
	public function assosciation() {
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('about_assosciation',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_about().$this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}
	
	public function education() {
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('about_education',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_about().$this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

}
