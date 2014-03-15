<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Login
{
	protected $CI;

	public function __construct() {
		$this->CI = & get_instance();
	}

	function is_logged_in() {
		$is_logged_in = $this->CI->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in !== true)
		{
			return false;
		}
		elseif($this->is_disabled() && $this->CI->uri->segment(3) !== 'suspended')
		{
			redirect('/user/not_logged_in/suspended', 'location');
		}
		return true;
	}

	function is_admin() {
		if($this->is_logged_in()) {
			$is_admin = $this->CI->session->userdata('is_admin');
			if(!isset($is_admin) || $is_admin != true)
			{
				return false;
			}
			return true;
		}
		return false;
	}

	public function has_privilege($privileges) {
		if(!isset($privileges)) {
			return false;
		}

		if($this->is_logged_in()) {
			$id = $this->CI->session->userdata('id');
			$this->CI->load->model('User_model');
			return $this->CI->User_model->has_privilege($id, $privileges);
		}
		return false;
	}

	public function validate($name = '', $pwd = '') {
		$this->CI->load->model('User_model');
		$query = $this->CI->User_model->validate($name, $pwd);

		if($query) // if the user's credentials validated...
		{
			$result = $query->result();
			$result = $result[0];

			if($this->CI->User_model->has_privilege($result->id, "admin")) {
				$admin = true;
			} else {
				$admin = false;
			}

			$data = array(
				'id' => $result->id,
				'lukasid' => $result->lukasid,
				'is_logged_in' => true,
				'is_admin' => ($admin === true) ? true : false,
			);
			$this->CI->session->set_userdata($data);
			return true;
		}
		else // incorrect username or password
		{
			return false;
		}
	}

	public function get_id() {
		return $this->CI->session->userdata('id');
	}

	public function get_lukasid() {
		return $this->CI->session->userdata('lukasid');
	}

	public function is_disabled()
	{
		$id = $this->get_id();
		$this->CI->load->model("User_model");
		return $this->CI->User_model->is_disabled($id);
	}

	public function get_name()
	{
		// load model and collect uid
		$this->CI->load->model('User_model');
		$id = $this->CI->session->userdata('id');
		// get user
		$user = $this->CI->User_model->get_user_name($id);

		return $user[0]['first_name'].' '.$user[0]['last_name'];
	}

	public function get_gravatar()
	{
		// load model and collect uid
		$this->CI->load->model('User_model');
		$id = $this->get_id();
		return $this->CI->User_model->get_user_gravatar($id);
	}

	public function login($lid) {
		$this->CI->load->model('User_model');
		$query = $this->CI->User_model->get_user($lid);

		if($query) // if the user's credentials validated...
		{
			$result = $query->result();
			$result = $result[0];

			if($this->CI->User_model->has_privilege($result->id, "admin")) {
				$admin = true;
			} else {
				$admin = false;
			}

			$data = array(
				'id' => $result->id,
				'lukasid' => $result->lukasid,
				'is_logged_in' => true,
				'is_admin' => ($admin === true) ? true : false,
			);
			$this->CI->session->set_userdata($data);
			return true;
		}
		else // incorrect username or password
		{
			return false;
		}
	}

	public function logout($cas_logout = true) {
		$data = array(
			'id' => 0,
			'lukasid' => "",
			'is_logged_in' => false,
			'is_admin' => false,
		);
		$this->CI->session->set_userdata($data);
		$this->CI->session->sess_destroy();
		if($cas_logout)
			$this->CI->cas->logout();
	}

}
