<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_news extends MY_Controller {

	public $languages = '';
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		if(!$this->login->is_admin()) {
			redirect('/admin/access_denied', 'refresh');
		}
		
		// access granted, loading modules
		$this->load->model('News_model');
		$this->load->helper('form');
		
		$this->languages = array	(
													array(	'language_abbr' => 'se',
															'language_name' => 'Svenska',
															'id' => 1),
													array(	'language_abbr' => 'en',
															'language_name' => 'English',
															'id' => 2)
												);
		
    }

	public function index()
	{
		$this->overview();
	}
	
	function overview() {

		// Data for overview view
		$this->load->model('News_model');
		$main_data['news_array'] = $this->News_model->admin_get_all_news_overview();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_overview',  $main_data, true);					
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	function create() {
		// Data for forum view
		$main_data['lang'] = $this->lang_data;
		$main_data['is_editor'] = true;
		$main_data['languages'] = $this->languages;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_create',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
	}
	
	function add_news() {
		$translations = array();
		$success = false;
		
		// check if translations is added
		foreach($this->languages as $lang) {
			if($this->input->post('title_'.$lang['language_abbr']) != '' && $this->input->post('text_'.$lang['language_abbr']) != '') {
				echo 'yes för ' . $lang['language_abbr'] . '<br>';
				array_push($translations, array("lang" => $lang['language_abbr'], "title" => $this->input->post('title_'.$lang['language_abbr']), "text" => $this->input->post('text_'.$lang['language_abbr'])));
				$success = true;
			}
		}
		
		if($success) {
			$this->load->model("Images_model");
	
			$config = $this->Images_model->news_get_config();
			$this->load->library('upload', $config);
			
			
			// get the time
			$theTime = date("Y-m-d H:i",time());
			if(strtotime($this->input->post('post_date')) !== false) {
				$theTime = $this->input->post('post_date');
			}
			
			// get draft and approved setting
			$draft = 0; $approved = 0; $imgheight = 150; $size = 1; $position = 1;
			if($this->input->post('draft') == 1) $draft = 1;
			if($this->input->post('approved') == 1) $approved = 1;
			if(is_numeric($this->input->post('img_height')) && $this->input->post('img_height') >= 75 && $this->input->post('img_height') <= 400) $imgheight = $this->input->post('img_height'); 
			if(is_numeric($this->input->post('img_size')) && $this->input->post('img_size') >= 1 && $this->input->post('img_size') <= 4) $size = $this->input->post('img_size'); 
			if(is_numeric($this->input->post('img_position')) && $this->input->post('img_position') >= 1 && $this->input->post('img_position') <= 2) $position = $this->input->post('img_position'); 
			
			/*
			echo 'date ' . $theTime . '<br>';
			echo 'draft ' . $draft . '<br>';
			echo 'approved ' . $approved . '<br>';
			echo 'imgheight ' . $imgheight . '<br>';
			*/
			
			$this->db->trans_start();
			$news_id = $this->News_model->add_news(1, $translations, $theTime, $draft, $approved);
			
			if ( ! $this->upload->do_upload('img_file'))
			{
				/*
				 * // probably no file set
				$error = array('error' => $this->upload->display_errors());
				echo '<pre>';
				var_dump($error);
				echo '</pre>';
				*/
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
				$data = array(
					'user_id' => 1,
					'image_original_filename' => $data['upload_data']['file_name'],
					'image_title' => 'news_image',
					'image_description' => 'news_image',
					);
				$this->db->insert('images', $data);
				$images_id = $this->db->insert_id();
				
				$data = array(
					'news_id' => $news_id,
					'images_id' => $images_id,
					'size' => $size,
					'position' => $position,
					'height' => $imgheight,
					);
				$this->db->insert('news_images', $data);
				
				/*
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					return false;
				} else {
					$this->db->trans_commit();
					echo "FUCK YEAH<br>";
				}
				*/
				/*
				if ($this->db->trans_status() === FALSE)
				{
					// generate an error... or use the log_message() function to log your error
					echo "not OK<br>";
				} else {
					echo "It is okay <br>";
				}
				*/
				
				
				/*
				// it is working, handle the upload
				echo '<pre>';
				var_dump($data);
				echo '</pre>';
				echo $data['upload_data']['file_name'];
				*/
				
			}
			
			$this->db->trans_complete();
			
			
			redirect('admin_news', 'refresh');
		}
	}
	
	function edit($id) {
		// Data for overview view
		$main_data['news'] = $this->News_model->admin_get_news($id);
		$main_data['lang'] = $this->lang_data;
		$main_data['is_editor'] = true;
		$main_data['id'] = $id;

		// composing the views
		$this->load->view('includes/head', $this->lang_data);
		$this->load->view('includes/header', $this->lang_data);
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/news_edit',  $main_data, true);					
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
		$this->load->view('includes/footer');
		
	}
	
	function edit_news($id) {
		// check if translations is added
		foreach($this->languages as $lang) {
			$this->News_model->update_translation($id, $lang['language_abbr'], $this->input->post('title_'.$lang['language_abbr']), $this->input->post('text_'.$lang['language_abbr']));
		}
		
		// get the time
		$theTime = date("Y-m-d H:i",time());
		if(strtotime($this->input->post('post_date')) !== false) {
			$theTime = $this->input->post('post_date');
		}
			
		// get draft and approved setting
		$draft = 0; $approved = 0; $imgheight = 150; $size = 1; $position = 1;
		if($this->input->post('draft') == 1) $draft = 1;
		if($this->input->post('approved') == 1) $approved = 1;
		if(is_numeric($this->input->post('img_height')) && $this->input->post('img_height') >= 75 && $this->input->post('img_height') <= 400) $imgheight = $this->input->post('img_height'); 
		if(is_numeric($this->input->post('img_size')) && $this->input->post('img_size') >= 1 && $this->input->post('img_size') <= 4) $size = $this->input->post('img_size'); 
		if(is_numeric($this->input->post('img_position')) && $this->input->post('img_position') >= 1 && $this->input->post('img_position') <= 2) $position = $this->input->post('img_position'); 
			
		$data = array(
               'draft' => $title,
               'approved' => $name,
               'date' => $theTime,
            );

		$this->db->where('id', $id);
		$this->db->update('news', $data); 
		
		$data = array(
               'size' => $size,
               'position' => $position,
               'height' => $imgheight,
            );

		$this->db->where('news_id', $id);
		$this->db->update('news_images', $data);
		
		redirect('admin_news', 'refresh');
	}
	

	
	
}
