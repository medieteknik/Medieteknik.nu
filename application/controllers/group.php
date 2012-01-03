<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Group extends CI_Controller {
	
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
		$this->display();
	}
	
	function display() {
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->language, 'swedish');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->language, 'swedish');

		// Data for Startsida view
		$this->load->model('Group_model');
		$groups_data['groups_array'] = $this->Group_model->get_all_groups();
		$groups_data['common_lang'] = $this->lang->load_with_fallback('common', $this->language, 'swedish');
		
		// tweets
		$this->load->model('Tweet_model');
		$groups_data['tweet_array'] = $this->Tweet_model->get_latest_tweets();
		
		// image
		$this->load->library('imagemanip');
		$mhm = new imagemanip();$mhm->create("example");
		$mhm2 = new imagemanip();$mhm2->create("example_large");
		$groups_data['images_array'] = array($mhm,$mhm2);
		//echo $mhm->get_img_tag();
		//$mhm = $this->imagemanip->create("jonas");
		//echo $mhm->filename_thumb;

		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->parser->parse('includes/menu',$menu_data);
		$this->load->view('groups_display', $groups_data);
		$this->load->view('includes/footer',$header_data);
	}
	
	function info($name) {
		// Header data
		$header_data = $this->lang->load_with_fallback('header', $this->language, 'swedish');
		$header_data['container'] = true;
		
		// Menu data, combining if key is missing from selected language
		$menu_data = $this->lang->load_with_fallback('menu', $this->language, 'swedish');

		// Data for Startsida view
		$this->load->model('Group_model');
		$groups_data['group_info'] = $this->Group_model->get_group_name($name,$this->language_abbr);
		$groups_data['common_lang'] = $this->lang->load_with_fallback('common', $this->language, 'swedish');

		$this->load->view('includes/head',$header_data);
		$this->load->view('includes/header');
		$this->parser->parse('includes/menu',$menu_data);
		if(sizeof($groups_data['group_info']) > 0) {
			$this->load->view('groups_info', $groups_data);
		} else {
			$this->load->view('groups_nomatch', $groups_data);
		}
		$this->load->view('includes/footer',$header_data);
	}
}
