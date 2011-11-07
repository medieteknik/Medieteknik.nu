<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Main extends CI_Controller {
		
		public function index()
		{
			$data['main_content'] = 'startsida';
			$this->load->view('includes/template.php',$data);
		}
	}
