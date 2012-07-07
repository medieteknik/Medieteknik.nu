<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Sidebar
{
	protected $CI;
	
	public $language = '';
	public $language_abbr = '';
	public $lang_data = '';
	public $adminmenu = '';
	
	public function __construct() {
		$this->CI = & get_instance();
		
		$this->language = $this->CI->config->item('language');
		$this->language_abbr = $this->CI->config->item('language_abbr');
		
		// language data
		$this->lang_data = $this->CI->lang->load_with_fallback('common', $this->language, 'swedish');
	}
	
	public function get_latest_events() {
		$upcomingevents['title'] = $this->lang_data['misc_upcomingevents'] ;
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan", 'href' => 'linj'));
		
		return $this->CI->load->view('includes/list', $upcomingevents, true);	
	}
	
	public function get_latest_forum() {
		
		$latestforum['title'] = $this->lang_data['misc_latestforum'];
		$latestforum['items'] = array(array('title' => "Första", 'data' => "Såatteeeh"));
		
		return $this->CI->load->view('includes/list', $latestforum, true);	
	}
	
	public function get_admin_menu() {
		
		$this->adminmenu['title'] = "Admin";
		$this->adminmenu['items'] = array(array('title' => $this->lang_data['menu_admin'], 'href' => "admin"));
		
		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminnews'], 'href' => "admin_news"));
		
		/*	
		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editusers'], 'href' => "admin/edit_users"));
		
		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editimages'], 'href' => "admin/edit_images"));
			
		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_addusers'], 'href' => "admin/add_users"));
		*/
		return $this->CI->load->view('includes/list', $this->adminmenu, true);
	}
	
	public function get_standard() {
		$menus = '';
		if($this->CI->login->has_privilege('admin')) {
			$menus .= $this->get_admin_menu();
		}
		
		$menus .= $this->get_latest_events();
		$menus .= $this->get_latest_forum();
		return $menus;
	}
	
}
