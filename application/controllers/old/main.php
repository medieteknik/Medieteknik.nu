<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Main extends CI_Controller {
		
		public function index()
		{
			// Header data
			$header_data = $this->lang->load_with_fallback('header', $this->config->item('language'), 'swedish');
			$header_data['container'] = true;
			
			// Menu data, combining if key is missing from selected language
			$menu_data = $this->lang->load_with_fallback('menu', $this->config->item('language'), 'swedish');

			// Data for Startsida view
			$startsida_data['data'] = "data";

			$this->load->view('includes/head',$header_data);
			$this->load->view('includes/header');
			$this->parser->parse('includes/menu',$menu_data);
			$this->load->view('startsida', $startsida_data);
			$this->load->view('includes/footer',$header_data);
		}
	}
