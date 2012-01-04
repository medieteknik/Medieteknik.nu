<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Forum extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->language = $this->config->item('language');
		$this->language_abbr = $this->config->item('language_abbr');
    }

	public function index()
	{
		$this->overview();
	}
	
	function overview() {
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->language, 'swedish');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->language, 'swedish');

		// Data for Startsida view
		$this->load->model('Forum_model');
		$forum_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to(0,$this->language_abbr);
		$forum_data['common_lang'] = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->parser->parse('includes/menu',$menu_data);
		$this->load->view('forum_overview', $forum_data);
		$this->load->view('includes/footer',$header_data);
	}
	
	
}
