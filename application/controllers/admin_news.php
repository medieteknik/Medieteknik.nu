<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_news extends CI_Controller {
	
	public $language = '';
	public $language_abbr = '';
	public $lang_data = '';
	public $adminmenu = '';
	public $languages = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
		$this->language = $this->config->item('language');
		$this->language_abbr = $this->config->item('language_abbr');
		
		// language data
		$this->lang_data = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		if(!$this->login->is_admin()) {
			redirect('/admin/access_denied', 'refresh');
		}
		
		$this->languages = array	(
													array(	'language_abbr' => 'se',
															'language_name' => 'Svenska',
															'id' => 1),
													array(	'language_abbr' => 'en',
															'language_name' => 'English',
															'id' => 2)
												);
		
		$this->adminmenu['title'] = "Admin";
		$this->adminmenu['items'] = array(array('title' => $this->lang_data['menu_admin'], 'href' => "admin"));
		
		if($this->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminnews'], 'href' => "admin_news"));
			
		if($this->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editusers'], 'href' => "admin/edit_users"));
			
		if($this->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editimages'], 'href' => "admin/edit_images"));
			
		if($this->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_addusers'], 'href' => "admin/add_users"));
		
    }

	public function index()
	{
		$this->overview();
	}
	
	function overview() {

		// Data for overview view
		$this->load->model('News_model');
		$overview_data['news_array'] = $this->News_model->admin_get_all_news_overview();
		$overview_data['lang'] = $this->lang_data;
		//$profile_data['lang'] = $lang_data;
		
		// data for the right column
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_overview',  $overview_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/link', $this->adminmenu, true);			
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	function create() {
		$this->load->helper('form');
		// Data for forum view
		//$this->load->model('User_model');
		$news_data['lang'] = $this->lang_data;
		//$profile_data['lang'] = $lang_data;
		
		$news_data['is_editor'] = true;
		
		$news_data['languages'] = $this->languages;
		
		$upcomingevents['title'] = "Kommande Event";
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan"));
		$latestforum['title'] = "Nytt i Forumet";
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_create',  $news_data, true);					
		$template_data['sidebar_content'] = $this->load->view('includes/link', $this->adminmenu, true);			
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $upcomingevents, true);
		$template_data['sidebar_content'] .= $this->load->view('includes/list', $latestforum, true);
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	function add_news() {
		$translations = array();
		
		$success = false;
		
		foreach($this->languages as $lang) {
			if($this->input->post('title_'.$lang['language_abbr']) != '' && $this->input->post('text_'.$lang['language_abbr']) != '') {
				echo 'yes för ' . $lang['language_abbr'] . '<br>';
				array_push($translations, array("lang" => $lang['language_abbr'], "title" => $this->input->post('title_'.$lang['language_abbr']), "text" => $this->input->post('text_'.$lang['language_abbr'])));
				$success = true;
			}
		}
		
		if($success) {
			$this->load->model("News_model");
			
			// get the time
			$theTime = time();
			if(strtotime($this->input->post('post_date')) !== false) {
				$theTime = $this->input->post('post_date');
			}
			
			// get draft and approved setting
			$draft = 0; $approved = 0;
			if($this->input->post('draft') == 1) $draft = 1;
			if($this->input->post('approved') == 1) $approved = 1;
			echo 'draft ' . $draft . '<br>';
			echo 'approved ' . $approved . '<br>';
			
			// do the actual update
			//$this->News_model->add_news(1, $translations, $theTime);
			echo "did it";
		}
		
		// var_dump($translations);
	}
	
	function edit_translation($id, $lang_abbr) {
		
	}
	

	
	
}
