<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Admin_documents extends MY_Controller 
{
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		if(!$this->login->is_admin()) 
		{
			redirect('/admin/access_denied', 'refresh');
		}
		
		$this->load->model('Documents_model');
		$this->load->helper('form');
    }

	public function index()
	{
			// $protocol_year = date("Y",time());
			// $month = date("m", time());

			// if($month < 6)
			// 	$protocol_year--;

			// redirect("admin_documents/overview/$protocol_year", 'refresh');
		$this->overview();
	}
	
	function overview($protocol_year = 0) 
	{
		if($protocol_year == 0)
		{
			$protocol_year = date("Y",time());
			$month = date("m", time());

			if($month < 6)
				$protocol_year--;

			// redirect("admin_documents/overview/$protocol_year", 'refresh');
		}

		$main_data['config'] = $this->Documents_model->get_config();
		$main_data['document_years_array'] = $this->Documents_model->get_document_years(2005);

		// Data for overview view
		// currently only medietekniksektionen
		$main_data['protocol_year'] = $protocol_year;
		$main_data['document_types'] = $this->Documents_model->get_all_documents_for_group(1);
		$main_data['group'] = "medietekniksektionen";
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/documents',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	//Called from the dropzone class
	function upload()
	{
		$config = $this->Documents_model->get_config();

		if (!empty($_FILES))
	    {
	        $tempFile = $_FILES['file']['tmp_name'];
	        $targetPath = $config['uploadPath'];
	        $targetFile = $targetPath . $_FILES['file']['name'];

	        if(!file_exists($targetFile))
	        {
		        if(move_uploaded_file($tempFile, $targetFile))
		        {
		          	$temp_type = $_POST['document_type'];
		          	$temp_title = $_POST['title'];
		          	$temp_date = $_POST['upload_date'];

		          	if($temp_type == "1_autumn")
		          		$temp_type = 1;
		          	elseif($temp_type == "1_spring")
		          		$temp_type = 1;

		          	//upload successful
		          	$this->Documents_model->add_uploaded_document($_FILES['file']['name'], $temp_type, 1, $temp_title, $_POST['description'], 1, true, $temp_date);
		        }
		    }
	    }
	}

	function delete($id)
	{
		$this->Documents_model->delete_document($id);
		redirect('admin_documents', 'refresh');
	}
}
