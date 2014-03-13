<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('Forum_model');
		$this->load->helper(array('form', 'forum'));
    }

	public function index()
	{
		$this->overview();
	}

	function overview()
	{

		$this->category(0);

	}

	function category($theid = 0)
	{
		if(is_numeric($theid))
			$id = $theid;
		else
			$id = $this->Forum_model->get_id_from_slug($theid);

		if($theid !== 0 && !$this->Forum_model->category_exists($id))
			show_404();

		$main_data['ancestors_array']=$this->Forum_model->get_all_categories_ancestors_to($id);
		// Data for forum view
		$main_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to($id, 2);
		$main_data['lang'] = $this->lang_data;

		$main_data['topics_array'] = $this->Forum_model->get_topics($id);

		if(count($main_data['categories_array']) == 1)
		{
			$c = $main_data['categories_array'][0];
			$main_data['posting_allowed'] = $c->posting_allowed == 1;
			$main_data['is_logged_in'] = $this->login->is_logged_in();
			$main_data['guest_allowed'] = $c->guest_allowed == 1;
		}
		else
		{
			$main_data['posting_allowed'] = false;
			$main_data['is_logged_in'] = $this->login->is_logged_in();
			$main_data['guest_allowed'] =false;
		}

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('forum_overview', $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}

	function post_topic()
	{

		$c = $this->Forum_model->get_all_categories_sub_to($this->input->post('cat_id'), 1);
		$c = $c[0];

		$tid = 0;
		if($c->posting_allowed == 1)
		{
			if($this->input->post('topic') != '' && $this->input->post('reply') != '')
			{

				// $cat_id, $user_id, $topic, $post, $date = ''
				$tid = $this->Forum_model->create_topic($this->input->post('cat_id'), $this->login->get_id(),$this->input->post('topic'), $this->input->post('reply'));
			}
		}

		redirect('forum/thread/'.$tid, 'refresh');
	}

	function post_reply()
	{
		$c = $this->Forum_model->get_all_categories_sub_to($this->input->post('cat_id'), 1);
		$c = $c[0];

		$tid = 0;
		if($c->posting_allowed == 1)
		{
			if($this->input->post('reply') != '')
			{
				// $cat_id, $user_id, $topic, $post, $date = ''
				$this->Forum_model->add_reply($this->input->post('topic_id'), $this->login->get_id(),$this->input->post('reply'));
			}
		}

		redirect('forum/thread/'.$this->input->post('topic_id'), 'refresh');
	}

	function thread($id = 0)
	{
		// check topic existance
		if(!$this->Forum_model->topic_exists($id))
			show_404();

		$main_data['replies'] = $this->Forum_model->get_replies($id);
		$main_data['topic'] = $this->Forum_model->get_topic($id);
		$main_data['lang'] = $this->lang_data;

		$main_data['ancestors_array']=$this->Forum_model->get_all_categories_ancestors_to($main_data['topic']->cat_id);
		$main_data['categories_array'] = $this->Forum_model->get_all_categories_sub_to($main_data['topic']->cat_id, 1);

		if(count($main_data['categories_array']) == 1)
		{
			$c = $main_data['categories_array'][0];

			if($c->posting_allowed == 1)
			{

				if($this->login->is_logged_in())
				{
					$main_data['postform'] = TRUE;
				}
				else if(!$this->login->is_logged_in() && $c->guest_allowed == 1)
				{
					$main_data['postform'] = TRUE;
					$main_data['guest'] = TRUE;
				}
			}
		}

		// composing the views
		$template_data['menu'] = $this->load->view('includes/menu',$this->lang_data, true);
		$template_data['main_content'] = $this->load->view('forum_thread', $main_data, true);
		$template_data['sidebar_content'] = $this->sidebar->get_standard();
		$this->load->view('templates/main_template',$template_data);
	}


}
