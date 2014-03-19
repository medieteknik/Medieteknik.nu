<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carousel extends MY_Controller
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
		$this->load->model('Carousel_model');
		$this->load->model("Images_model");
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

	function overview()
	{
		// Data for overview view
		$this->load->model('Carousel_model');
		$main_data['carousel_array'] = $this->Carousel_model->admin_get_all_carousel_items();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/carousel_overview',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function create($type = 0)
	{
		if($type === 0)
		{
			show_404();
		}

		$main_data['lang'] = $this->lang_data;
		$main_data['languages'] = $this->languages;
		$edit_view = '';

		if($type === 'images')
		{
			$edit_view = 'carousel_edit_images';
		}
		else if($type === 'embedded')
		{
			$edit_view = 'carousel_edit_embedded';
		}
		else
		{
			show_404();
		}

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/'.$edit_view,  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit($id)
	{
		// Data for overview view
		$main_data['carousel'] = $this->Carousel_model->admin_get_carousel_item($id);
		$main_data['images_array'] = $this->Carousel_model->get_carousel_item_images($id);
		$main_data['lang'] = $this->lang_data;
		$main_data['languages'] = $this->languages;
		$main_data['id'] = $id;

		// composing the views
		$edit_view = '';
		if($main_data['carousel']->carousel_type == 1)
		{
			$edit_view = 'carousel_edit_embedded';
		}
		else if($main_data['carousel']->carousel_type == 2)
		{
			$edit_view = 'carousel_edit_images';
		}

		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/'.$edit_view,  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit_carousel($id)
	{
		if($this->input->post('disabled') == 1)
		{
			$disabled = 1;
		}
		else
		{
			$disabled = 0;
		}

		if($this->input->post('draft') == 1)
		{
			$draft = 1;
		}
		else
		{
			$draft = 0;
		}

		$item_type = $this->input->post('item_type');

		$this->db->trans_start();
		if ($id == 0)
		{
			$translations = array();
			$success = false;

			// check if translations is added
			foreach($this->languages as $lang)
			{
				// Item_type 1 is embedded content. Content is the same for all languages
				if($item_type == 1)
				{
					array_push($translations, array("lang" => $lang['language_abbr'], "title" => $this->input->post('title_'.$lang['language_abbr']), "content" => $this->input->post('content_')));
				}
				else
				{
					array_push($translations, array("lang" => $lang['language_abbr'], "title" => $this->input->post('title_'.$lang['language_abbr']), "content" => $this->input->post('content_'.$lang['language_abbr'])));
				}
				$success = true;
			}

			if($success)
			{
				$item_order = $this->Carousel_model->get_number_of_carousel_items() + 1;
				$carousel_id = $this->Carousel_model->add_carousel_item($this->login->get_id(), $translations, $item_type, $item_order, $disabled, $draft);
			}
		}
		else
		{
			// check if translations is added
			foreach($this->languages as $lang)
			{
				$theTitle = addslashes($this->input->post('title_'.$lang['language_abbr']));
				$theContent = addslashes($this->input->post('content_'));
				$this->Carousel_model->update_carousel_translation($id, $lang['language_abbr'], $theTitle, $theContent);
			}

			$data = array('disabled' => $disabled, 'draft' => $draft);

			$this->db->where('id', $id);
			$this->db->update('carousel', $data);
		}

		$this->db->trans_complete();

		redirect('admin/carousel', 'refresh');
	}

	function add_image($id)
	{
		$config = $this->Images_model->get_config();
		$this->load->library('upload', $config);

		$images_id = 0;
		if ($this->upload->do_upload('img_file'))
		{
			$images_id = $this->Images_model->add_uploaded_image($this->upload->data(), $this->login->get_id(), 'Carousel', 'Carousel');
		}

		$photo = $this->input->post('photo');
		$link = $this->input->post('link');

		$this->Carousel_model->add_carousel_image($id,$images_id,$photo,$link);

		redirect('admin/carousel/edit/'.$id, 'refresh');
	}

	function remove_image($id, $image_id)
	{
		$this->Carousel_model->remove_carousel_image($id, $image_id);
		redirect('admin/carousel/edit/'.$id, 'refresh');
	}

	function moveup($id)
	{
		$this->Carousel_model->move_carousel_item_order($id, 'up');

		redirect('admin/carousel', 'refresh');
	}

	function movedown($id)
	{
		$this->Carousel_model->move_carousel_item_order($id, 'down');

		redirect('admin/carousel', 'refresh');
	}

	function delete($id)
	{
		$this->Carousel_model->delete_carousel_item($id);
		redirect('admin/carousel', 'refresh');
	}
}
