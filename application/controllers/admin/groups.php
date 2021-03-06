<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends MY_Controller
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		if(!$this->login->is_admin())
		{
			redirect('/admin/admin/access_denied', 'refresh');
		}
		// access granted, loading modules and helpers
		$this->load->model('Group_model');
		$this->load->model('User_model');
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
		// Data for overview page
		$main_data['groups_array'] = $this->Group_model->get_all_groups();
		$main_data['lang'] = $this->lang_data;
		$main_data['message'] = $message;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/overview',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function list_members($groups_year_id, $group_id, $message = '')
	{
		// Data for member list view
		$main_data['group_year'] = $this->Group_model->get_group_year($groups_year_id);
		$main_data['member_list'] = $this->Group_model->get_group_members_year($groups_year_id);
		$main_data['group_id'] = $group_id;
		$main_data['message'] = $message;
		$main_data['groups_year_id'] = $groups_year_id;
		$main_data['lang'] = $this->lang_data;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/list_members',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function remove_year($groups_year_id = 0)
	{
		if($groups_year_id == 0)
			show_404();

		$this->Group_model->remove_groups_year($groups_year_id);

		redirect('admin/groups/edit/'.$groups_year_id.'/success', 'refresh');
	}

	function edit_member($groups_year_id, $group_id, $user_id = 0, $do = '')
	{
		if($do == 'edit')
		{
			$position = $this->input->post('position');
			$email = $this->input->post('email');

			$main_data['edit_member'] = $this->Group_model->update_member_info($groups_year_id, $user_id, $position, $email);
		}
		elseif($do == 'delete')
		{
			$this->Group_model->remove_member($groups_year_id, $user_id);
			redirect('admin/groups/list_members/'.$groups_year_id.'/'.$group_id, 'refresh');
		}

		// Data for overview view
		$main_data['members'] = $this->Group_model->get_group_year_member($groups_year_id, $user_id);
		$main_data['groups_year_id'] = $groups_year_id;
		$main_data['group_id'] = $group_id;
		$main_data['lang'] = $this->lang_data;
		$main_data['whattodo'] = $do;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/edit_member',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function add_member($groups_year_id = 0, $group_id = 0, $do = '', $user_id = 0)
	{
		if($groups_year_id == 0)
			show_404();

		$main_data['lang'] = $this->lang_data;
		$this->load->library('table');

		$main_data['groups_year_id'] = $groups_year_id;
		$main_data['group_id'] = $group_id;

		if($do == 'search' && $this->input->get('search')) // if form is sent
		{
			$main_data['result'] = $this->User_model->search_user($this->input->get('search'));
			$main_data['query'] = $this->input->get('search');
		}
		else if($do == 'add')
		{
			if($user_id != 0)
			{
				$user = array(
					array("user_id" => $user_id),
				);

				$createuser = $this->Group_model->add_users_to_group_year($groups_year_id, $user);

				$main_data['user_added'] = $user_id;
				$main_data['status'] = $createuser;
			}
		}

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/add_member', $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function create()
	{
		// Data for edit view
		$main_data['lang'] = $this->lang_data;
		$main_data['languages'] = $this->languages;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit($id = 0)
	{
		if(!$this->Group_model->group_exists($id))
			show_404();

		// Data for edit view
		$main_data['group'] = $this->Group_model->admin_get_group($id);
		$main_data['group_years'] = $this->Group_model->get_group_years($id);
		$main_data['lang'] = $this->lang_data;
		$main_data['id'] = $id;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/edit',  $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function edit_group($id)
	{
		if($this->input->post('save'))
		{
			$this->db->trans_start();

			$translations = array();
			// check if translations is added
			foreach($this->languages as $lang)
			{
				$theName = addslashes($this->input->post('name_'.$lang['language_abbr']));
				$theDescription = addslashes($this->input->post('description_'.$lang['language_abbr']));

				// new
				if($id == 0){
					array_push($translations, array("lang" => $lang['language_abbr'], "name" => $theName, "description" => $theDescription));
				}
				else
				{
					// update existing
					$this->Group_model->update_group_translation($id, $lang['language_abbr'], $theName, $theDescription);
				}
			}

			//Check if group is official
			$official = $this->input->post('official');

			// new
			if($id == 0) {
				$id = $this->Group_model->add_group($translations, $official);
			}
			else
			{ // update existing
				$data = array(
		               'official' => $official
		        );
				$this->db->where("id", $id);
				$this->db->update("groups", $data);
			}

			$this->db->trans_complete();

			redirect('admin/groups/edit/'.$id , 'refresh');
		}
		if($this->input->post('delete'))
		{
			if(!$this->Group_model->group_exists($id))
				show_404();

			if($this->Group_model->delete_group($id))
				redirect('admin/groups/overview/success', 'location');
			else
				redirect('admin/groups/edit/'.$id, 'location');
		}
	}

	function add_year($group_id = 0, $do = '')
	{
		$main_data['lang'] = $this->lang_data;

		if($this->input->post('save')) // if form is sent
		{
			$startyear = $this->input->post('startyear');
			$stopyear = $this->input->post('stopyear');

			$main_data['entered'] = array(
										'start' => $startyear,
										'stop' => $stopyear,
									);

			if($stopyear >= $startyear)
			{
				$createyear = $this->Group_model->add_group_year($group_id, $startyear, $stopyear);
				if($createyear)
					redirect('admin/groups/list_members/'.$createyear.'/'.$group_id, 'location');
				else
					$main_data['status'] = false;
			}
			else {
				$main_data['status'] = false;
			}

		}

		$main_data['group_id'] = $group_id;

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('admin/groups/add',  $main_data, true);
		$template_data['sidebar_content'] =  $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function delete($id = 0)
	{
		if($id == 0)
		{
			show_404();
		}

		$this->Group_model->delete_group($id);

		redirect('admin_groups', 'refresh');
	}
}
