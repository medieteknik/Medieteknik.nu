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
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for forum view
		$this->load->model('Forum_model');
		$forum_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to(0,$this->language_abbr);
		$forum_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['left_content'] = $this->load->view('forum_overview', $forum_data, true);				
		$template_data['right_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');

	}
	
	function thread($id) {
		// language data
		$lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		// Data for news view
		$this->load->model('Forum_model');
		$thread_data['replies'] = $this->Forum_model->get_replies($id);
		$thread_data['topic'] = $this->Forum_model->get_topic($id);
		$thread_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $lang_data);
		$this->load->view('includes/header', $lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$lang_data, true);
		$template_data['left_content'] = $this->load->view('forum_thread', $thread_data, true);					
		$template_data['right_content'] = $this->load->view('includes/list', $upcomingevents, true);
		$template_data['right_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	
}
