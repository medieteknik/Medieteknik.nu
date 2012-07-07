<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class News extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	public $lang_data = '';
	public $upcomingevents = '';
	public $latestforum = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->language = $this->config->item('language');
		//$this->language_abbr = $this->config->item('language_abbr');
		
		// language data
		$this->lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		// data for the right column
		$this->upcomingevents['title'] = "Kommande Event";
		$this->upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$this->latestforum['title'] = "Nytt i Forumet";
		$this->latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));
    }

	public function index()
	{
		// load image model
		$this->load->library('Imagemanip');
		
		// Data for news view
		$this->load->model('News_model');
		$news_data['news_array'] = $this->News_model->get_latest_news();
		
		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('carouselle','', true);
		$template_data['main_content'] .= $this->load->view('news', $news_data, true);						
		$template_data['sidebar_content'] = $this->load->view('includes/list', $this->upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $this->latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	public function view($id) {
		// Data for news view
		$this->load->model('News_model');
		$news_data['news'] = $this->News_model->get_news($id);
		$news_data['language'] = $this->lang_data;
		
		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('news_full', $news_data, true);						
		$template_data['sidebar_content'] = $this->load->view('includes/list', $this->upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $this->latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
}
