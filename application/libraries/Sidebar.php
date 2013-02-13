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
	
	public function get_about() {
		$upcomingevents['title'] = $this->lang_data['menu_about'] ;
		$upcomingevents['items'] = array(	array('title' => "Om utbildningen", 'href' => 'about/education'),
											array('title' => "Kurser", 'href' => 'about/courses'),
											array('title' => "Sökande", 'href' => 'about/applicant'),
											);
		
		return $this->CI->load->view('includes/list', $upcomingevents, true);	
	}
	
	public function get_association() {
		$upcomingevents['title'] = $this->lang_data['menu_association'] ;
		$upcomingevents['items'] = array(	array('title' => "Om sektionen", 'href' => 'association'),
											array('title' => "Webbgruppen", 'href' => 'association/web'),
											array('title' => "Wiki", 'href' => 'http://wiki.medieteknik.nu/'),
											array('title' => "LiU Alumn-inloggning", 'href' => 'https://alumni.liu.se/public/start/start.asp'),
											);
		
		return $this->CI->load->view('includes/list', $upcomingevents, true);	
	}
	
	public function get_latest_events() {
		$upcomingevents['title'] = $this->lang_data['misc_upcomingevents'] ;
		$upcomingevents['items'] = array(array('title' => "Första", 'data' => "datan", 'href' => 'linj'));
		
		return $this->CI->load->view('includes/list', $upcomingevents, true);	
	}
	
	public function get_latest_forum() {
		
		$this->CI->load->model('Forum_model');
		
		$data = $this->CI->Forum_model->get_all_latest_threads(7);
		
		//do_dump($data);
		$latestforum['items'] = array();
		
		foreach($data as $item) {
			array_push($latestforum['items'], array('title' => $item->topic, 'data' => readable_date($item->date,$this->lang_data, TRUE), 'href' => 'forum/thread/'.$item->id));
		}
		
		$latestforum['title'] = $this->lang_data['misc_latestforum'];
		
		return $this->CI->load->view('includes/list', $latestforum, true);	
	}
	
	public function get_admin_menu() {
		
		$this->adminmenu['title'] = "Admin";
		$this->adminmenu['items'] = array(array('title' => $this->lang_data['menu_admin'], 'href' => "admin"));
		
		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminnews'], 'href' => "admin_news"));

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editusers'], 'href' => "admin_user"));
		
		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminpage'], 'href' => "admin_page"));
		
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
	
	public function get_standard($showadmin = true) {
		$menus = '';
		
		if($showadmin && $this->CI->login->has_privilege('admin')) {
			$menus .= $this->get_admin_menu();
		}
		
		$menus .= $this->get_latest_events();
		$menus .= $this->get_latest_forum();
		return $menus;
	}
	
}
