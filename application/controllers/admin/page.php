<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller
{

	public $languages = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		if(!$this->login->is_admin())
		{
			redirect('/admin/admin/access_denied', 'refresh');
		}

		// access granted, loading modules
		$this->load->model('Page_model');
		$this->load->helper('form');

		$this->languages = array(
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

	function overview($message = '')
	{
		// Data for overview view
		$main_data['page_array'] = $this->Page_model->admin_get_all_pages_overview();
		$main_data['lang'] = $this->lang_data;
		$main_data['message'] = $message;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/page_overview',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function create()
	{
		// Data for forum view
		$main_data['lang'] = $this->lang_data;
		$main_data['is_editor'] = true;
		$main_data['languages'] = $this->languages;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/page_edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit($id, $message = '')
	{
		// Data for overview view
		$main_data['page'] = $this->Page_model->admin_get_page($id);
		$main_data['lang'] = $this->lang_data;
		$main_data['id'] = $id;
		$main_data['message'] = $message;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/page_edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit_page($id)
	{
		if($this->input->post('delete'))
		{
			if($this->Page_model->is_draft($id) && $this->Page_model->admin_remove_page($id))
				redirect('admin/page/overview/success', 'location');
			else
				redirect('admin/page/edit/'.$id.'/error', 'location');
		}
		elseif($this->input->post('save'))
		{
			$this->db->trans_start();

			$translations = array();
			// check if translations is added
			foreach($this->languages as $lang)
			{
				$theTitle = addslashes($this->input->post('title_'.$lang['language_abbr']));
				$theText = addslashes($this->input->post('text_'.$lang['language_abbr']));

				// new
				if($id == 0)
				{
					array_push($translations, array("lang" => $lang['language_abbr'], "header" => $theTitle, "content" => $theText));
				}
				else
				{
					// update existing
					$this->Page_model->update_page_translation($id, $lang['language_abbr'], $theTitle, $theText);
				}
			}

			// get draft and approved setting
			$draft = !$this->input->post('draft');

			// new
			if($id == 0) {
				if($this->input->post('pagename'))
				{
					$id = $this->Page_model->add_page(addslashes($this->input->post('pagename')), $translations, $draft);
				}
			} else { // update existing
				$data = array(
		               'published' => $draft
		        );
				if($this->input->post('pagename')) {
					$data['name'] = addslashes($this->input->post('pagename'));
				}
				$this->db->where("id", $id);
				$this->db->update("page", $data);
			}

			$this->db->trans_complete();

			redirect('admin/page/edit/'.$id.'/success', 'location');
		}

		show_404();
	}

}
