<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class News extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->language = $this->config->item('language');
		//$this->language_abbr = $this->config->item('language_abbr');
    }

	public function index()
	{
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for news view
		$this->load->model('News_model');
		$news_data['news_array'] = $this->News_model->get_latest_news();
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['left_content'] = $this->load->view('carouselle','', true);
		$template_data['left_content'] .= $this->load->view('news', $news_data, true);						
		$template_data['right_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
}
