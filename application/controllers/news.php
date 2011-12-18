<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class News extends CI_Controller {
	
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
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->language, 'swedish');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->language, 'swedish');

		// Data for Startsida view
		$news_data = $this->lang->load_with_fallback('news', $this->language, 'swedish');
		$this->load->model('News_model');
		$news_data['news_array'] = $this->News_model->get_latest_news($this->language_abbr);
		$news_data['common_lang'] = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->parser->parse('includes/menu',$menu_data);
		$this->load->view('news', $news_data);
		$this->load->view('includes/footer',$header_data);
	}
}
