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
		$sidebar_about['title'] = $this->lang_data['menu_about'] ;
		$sidebar_about['items'] = array(	array('title' => $this->lang_data['menu_education'], 'href' => 'about/education'),
											array('title' => $this->lang_data['menu_applicants'], 'href' => 'about/applicant'),
											array('title' => $this->lang_data['menu_businesses'], 'href' => 'about/business '),
											);

		return $this->CI->load->view('includes/list', $sidebar_about, true);
	}

	public function get_association() {
		$sidebar_association['title'] = $this->lang_data['menu_association'] ;
		$sidebar_association['items'] = array(
			array('title' => $this->lang_data['menu_board'], 'href' => 'association/board'),
			array('title' => $this->lang_data['menu_committees'], 'href' => 'association/committee'),
			array('title' => $this->lang_data['menu_webgroup'], 'href' => 'association/web'),
			array('title' => "Mette", 'href' => 'association/mette'),
			array('title' => $this->lang_data['menu_alumnus'], 'href' => 'https://alumni.liu.se/Portal/Public/Default.aspx'),
			array('title' => $this->lang_data['menu_documents'], 'href' => 'association/documents')
		);

		return $this->CI->load->view('includes/list', $sidebar_association, true);
	}


	public function get_latest_forum() {

		$this->CI->load->model('Forum_model');

		$data = $this->CI->Forum_model->get_all_latest_threads(7);

		//do_dump($data);
		$latestforum['items'] = array();

		foreach($data as $item) {
			$topic = $item->topic;

			if(strlen($topic) > 25)
				$topic = substr($topic, 0, 25).'...';

			array_push($latestforum['items'], array('title' => $topic, 'data' => readable_date($item->date,$this->lang_data, TRUE), 'href' => 'forum/thread/'.$item->id));
		}

		$latestforum['title'] = $this->lang_data['misc_latestforum'];

		return $this->CI->load->view('includes/list', $latestforum, true);
	}

	public function get_admin_menu() {
		$this->CI->load->model('Notification_model');

		$notif = $this->CI->Notification_model->get_admin_notifications();
		// do_dump($notif);

		$this->adminmenu['title'] = "Admin";
		$this->adminmenu['items'] = array(array('title' => $this->lang_data['menu_admin'], 'href' => "admin"));

		if($this->CI->login->has_privilege('news_editor'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminnews'], 'href' => "admin/news"));

		if($this->CI->login->has_privilege('forum_moderator'))
		{
			// this /10 fix is the ugliest thing ever. I'm so sorry for it, I just dont want to spend
			// another hour searching for the cause of this wierd issue.
			$forum_count = $notif->forum_reports + $notif->forum_pending;
			$forum_reports = $forum_count > 0 ? ' <span class="badge">'.(($forum_count)/10).'</span>' : '';
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_forum'].$forum_reports, 'href' => "admin/forum"));
		}

		if($this->CI->login->has_privilege('admin'))
		{
			$notif_users = $notif->new_users > 0 ? ' <span class="badge">'.$notif->new_users.'</span>' : '';
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_editusers'].$notif_users, 'href' => "admin/user"));
		}

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_admincarousel'], 'href' => "admin/carousel"));

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminpage'], 'href' => "admin/page"));

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_adminimages'], 'href' => "admin/images"));

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_admingroups'], 'href' => "admin/groups"));

		if($this->CI->login->has_privilege('admin'))
			array_push($this->adminmenu['items'], array('title' => $this->lang_data['admin_admindocuments'], 'href' => "admin/documents"));

		return $this->CI->load->view('includes/list', $this->adminmenu, true);
	}

	public function get_standard($showadmin = true) {
		$menus = '';

		if($showadmin && $this->CI->login->has_privilege('admin')) {
			$menus .= $this->get_admin_menu();
		}

		$menus .= $this->get_latest_forum();
		$menus .= $this->get_xamera_rss();
		return $menus;
	}

	public function get_xamera_rss()
	{
		$this->CI->load->library('rssparser');
		$this->CI->rssparser->set_feed_url('http://cv.xjobba.nu/cv/rss.jsp?key=Mt');
		$this->CI->rssparser->set_cache_life(0);
		$rss = $this->CI->rssparser->getFeed(3);

		$rssfeed['feed'] = $rss;
		$rssfeed['title'] = "Exjobbsflöde";

		return $this->CI->load->view('includes/rss', $rssfeed, true);
	}
}
