<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MY_Controller
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		if(!$this->login->is_admin())
		{
			redirect('/admin/admin/access_denied', 'refresh');
		}

		$this->load->model('Images_model');
		$this->load->helper('form');
    }

	public function index()
	{
		$this->overview();
	}

	function overview()
	{
		// Data for overview view
		$main_data['image_array'] = $this->Images_model->get_all_images();
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/images_overview',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function add_image()
	{
		// Data for overview view
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/images_edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function upload()
	{
		$this->load->model("Images_model");
		$config = $this->Images_model->get_config();
		$this->load->library('upload', $config);

		$title = '';
		$description = '';

		if ($this->input->post('title'))
		{
			$title = $this->input->post('title');
		}
		if ($this->input->post('description'))
		{
			$description = $this->input->post('description');
		}

		if ($this->upload->do_upload('img_file'))
		{
			$this->Images_model->add_uploaded_image(
														$this->upload->data(),
														$this->login->get_id(),
														$title,
														$description
													);
		}
		redirect('admin_images', 'refresh');
	}

	function delete($id)
	{
		$this->Images_model->delete_image($id);
		redirect('admin/images/overview/success', 'refresh');
	}
}
