<?php
class User_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	/**
	 * Validates if the user credentials is correct
	 *
	 * @param  string	$lukasid	The lukas-id of the user, for example abcde123
	 * @param  string	$password	The password in clear text
	 * @param  bool 	$login		Wether or not we require user to be active
	 * @return bool
	 */
	function validate($lukasid = '', $password = '', $login = TRUE)
	{
		$lid = preg_replace("/(@.*)/", "", $lukasid);

		$this->db->where('lukasid', $lid);
		$this->db->where('password_hash', encrypt_password($password));
		if($login)
			$this->db->where('disabled', 0);
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return $query;
		}
		return false;

	}

	/**
	 * Return query if there is a user with that lukasid
	 *
	 * @param  string	$lukasid	The lukas-id of the user, for example abcde123
	 * @param  bool 	$login		Wether or not we require user to be active
	 * @return bool
	 */
	function get_user($lukasid = '', $login = FALSE)
	{
		$lid = preg_replace("/(@.*)/", "", $lukasid);

		$this->db->where('lukasid', $lid);
		if($login)
			$this->db->where('disabled', 0);
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return $query;
		}
		return false;
	}

	/**
	 * Fetches the name of specified user
	 *
	 * @param  integer	$id	The id of the user
	 * @return array 	if no user is found, user_id returns 0
	 */
    function get_user_name($id)
    {
    	$this->db->select('first_name, last_name');
    	$this->db->where('id', $id);
    	$query = $this->db->get('users');

    	if($query && $query->num_rows() > 0)
    		return $query->result_array();

    	return false;
	}

	/**
	 * Fetches the gravatar hash of specified user
	 *
	 * @param  integer	$id	The id of the user
	 * @return array 	if no user is found, user_id returns 0
	 */
    function get_user_gravatar($id)
    {
    	$this->db->select('gravatar');
    	$this->db->where('users_id', $id);
    	$query = $this->db->get('users_data');

    	if($query && $query->num_rows() > 0)
    	{
    		$result = $query->result_array();
    		return strtolower($result[0]['gravatar']);
    	}

    	return false;
	}

	/**
	 * Checks if the user has any of the specified privileges
	 *
	 * @param  integer	$user_id	The user id
	 * @param  string	$privilege	The privilege name, ex forum_moderator or array('forum_moderator', 'admin')
	 * @return bool
	 */
	function has_privilege($user_id, $privilege)
	{
		if(!is_array($privilege))
		{
			$thePrivileges = array($privilege);
		} else {
			$thePrivileges = $privilege;
		}
		$first = true;
		array_push($thePrivileges, 'superadmin');

		$this->db->select("*");
		$this->db->from("privileges");
		$this->db->join("users_privileges", "users_privileges.privilege_id = privileges.id", "");
		$this->db->where("users_privileges.user_id", $user_id);
		$this->db->where_in("privileges.privilege_name ", $thePrivileges);

		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			return true;
		}
		return false;
	}

	/**
	 * Fetches all the users
	 *
	 * @param  integer	$pagination	Pagination or not. If so, how many results per page?
	 * @param  integer	$page	The current page.
	 * @param  string	$option	What to get. All users, disabled user, enabled users?
	 * @return array
	 */
    function get_all_users($pagination = 0, $page = 1, $option = 'all')
    {
    	if($pagination)
    		$this->db->limit($pagination, ($page-1) * $pagination);

    	// are only disabled users asked for?
    	if ($option == 'disabled')
    		$this->db->where('disabled !=', '0');
    	elseif ($option == 'active')
    		$this->db->where('disabled', '0');

        $query = $this->db->get('users');
        return $query->result();
    }

	/**
	 * Counts all the users
	 *
	 * @return integer
	 */
    function count_all_users($option = '')
    {
    	if ($option == 'disabled')
    		$this->db->where('disabled !=', '0');
    	elseif ($option == 'active')
    		$this->db->where('disabled', '0');

        $query = $this->db->get('users');
        return $query->num_rows();
    }

	/**
	 * Fetches the user profile of specified user
	 *
	 * @param  integer	$id	The id or the lukasid of the user
	 * @return array 	if no user is found, user_id returns 0
	 */
    function get_user_profile($id)
    {
    	// check if the id is numeric, ie if it is a user id or lukasid
		if(is_numeric($id))
			$where = 'id';
		else
			$where = 'lukasid';

		$this->db->select("*");
		$this->db->from("users");
		$this->db->join("users_data", "users.id = users_data.users_id", "left");
		$this->db->where("users.".$where, $id);
		$this->db->limit(1);
		$query = $this->db->get();
		$res = $query->result();
		if(!$res)
			$res['user_id'] = 0;
		else
			$res = $res[0];

		$res->groups = $this->get_user_groups($id);
		$res->news = $this->get_user_news($id);
		$res->forum_posts = $this->get_user_forum_posts($id);

		return $res;
	}

	/**
	 * Fetches the privileges of specied user
	 *
	 * @param  integer	$id		The id of the user
	 * @return array
	 */
	function get_user_privileges($id)
	{
		$this->db->select("*");
		$this->db->from("users_privileges");
		$this->db->join("privileges", "privileges.id = users_privileges.privilege_id", "");
		$this->db->where("users_privileges.user_id", $id);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Checks if specified lukasid exists
	 *
	 * @param  string	$lukasid	The lukasid to check
	 * @return bool
	 */
	function lukasid_exists($lid = '')
	{
		$this->db->where('lukasid', $lid);
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return true;
		}
		return false;
	}

	/**
	 * Checks if specified userid exists
	 *
	 * @param  int	$uid	The user id to check
	 * @return bool
	 */
	function userid_exists($uid = '')
	{
		if(!is_numeric($uid))
			return false;
		$this->db->where('id', $uid);
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return true;
		}
		return false;
	}

	/**
	 * Adds a user to the database
	 *
	 * @param  string	$fname		The first name of the user
	 * @param  string	$lname		The last name of the user
	 * @param  string	$lukasid	The lukasid of the user, ex abcde123
	 * @param  string	$new		Wether or not the flag 'new' should be true
	 * @return bool
	 */
	function add_user($fname = '', $lname = '', $lukasid = '', $new = 0)
	{
		// fixing and trimming
		$fn = trim(preg_replace("/[^A-Za-zåäöÅÄÖ]/", "", $fname ));
		$ln = trim(preg_replace("/[^A-Za-zåäöÅÄÖ]/", "", $lname ));
		$lid = trim(preg_replace("/[^A-Za-z0-9]/", "", $lukasid ));

		// check lengths
		if(strlen($fn) > 0 && strlen($ln) > 0 && strlen($lid) == 8)
		{
			// if lukas_id not exists insert user
			if(!$this->lukasid_exists($lid))
			{
				$data = array(
				   'first_name' => $fn ,
				   'last_name' => $ln,
				   'lukasid' => $lid,
				   'new' => ($new ? true : false)
				);
				$q = $this->db->insert('users', $data);
				return $q;
			}
			else
				return false;
		} else {
			// something was not correct
			return false;
		}
	}

	/**
	 * Edit user data
	 *
	 * @param  integer	$id			The user id
	 * @param  integer	$gravatar	The chosen gravatar email for the user.
	 * @param  string	$web		The user web adress
	 * @param  string	$linkedin	The user LinkedIn-profile
	 * @param  string	$twitter	The users Twitter-id
	 * @param  string	$presentation 	The user presentation text
	 * @return boole
	 */
	function edit_user_data($id, $web = '', $linkedin = '', $twitter = '', $presentation = '', $gravatar = '', $github = '')
	{
		$this->load->helper('string');

		// fixing and trimming
		$twitter = preg_replace("/[^0-9A-Za-z_]/", "", $twitter );
		$web = trim_slashes(prep_url($web));
		$linkedin = trim_slashes(prep_url($linkedin));
		$presentation = trim($presentation);
		$gravatar = strtolower(trim($gravatar));
		$github = trim_slashes(prep_url($github));

		// validate
		if(strlen($web) <= 300 && strlen($twitter) <= 300 && strlen($gravatar) <= 255 &&
			strlen($linkedin) <= 300 && strlen($presentation) <= 1000 && strlen($github) <= 300)
		{
			//set data to be updated/inserted
			$data = array(
						'gravatar' => $gravatar,
						'web' => $web,
						'linkedin' => $linkedin,
						'presentation' => $presentation,
						'twitter' => $twitter,
						'github' => $github
					);

			// search for user data
			$this->db->where('users_id', $id);
			$find = $this->db->get('users_data');

			// update or insert?
			if($find->num_rows == 1) // update
			{
				$this->db->where('users_id', $id);
				$q = $this->db->update('users_data', $data);
			}
			else // insert
			{
				$data['users_id'] = $id;
				$q = $this->db->insert('users_data', $data);
			}

			// return result from query
			return $q;
		}
		else
			return false;
	}

	/**
	 * Edit user
	 *
	 * @param  integer	$id			The user id
	 * @param  string	$fname		First name
	 * @param  string	$lname 		Last name
	 * @param  string	$liuid 		LiU-id of user
	 * @return bool
	 */
	function edit_user($id, $fname = '', $lname = '', $liuid = '')
	{
		// fixing and trimming
		$fn = trim(preg_replace("/[^[:alpha:]\s-]/u", "", $fname ));
		$ln = trim(preg_replace("/[^[:alpha:]\s-]/u", "", $lname ));
		$lid = trim(preg_replace("/[^A-Za-z0-9]/", "", $liuid ));

		// check lengths
		if((strlen($lid) == 8 || strlen($lid) == 0))
		{
			// if userid exists, edit user
			if($this->userid_exists($id))
			{
				// set data
				$data = array();
				if(!empty($fn))
					$data['first_name'] = $fn;
				if(!empty($ln))
					$data['last_name'] = $ln;
				if(!empty($lid))
					$data['lukasid'] = $lid;

				// update user
				$this->db->where('id', $id);
				return $this->db->update('users', $data);
			}
			else
				return false;
		}
		else
			return false;
	}

	/**
	 * Changes a users status to deactivated, if activated and the other way around
	 *
	 * @param  integer	$id			The user id
	 * @return bool
	 */
	function disableswitch($id)
	{
		$this->db->select("disabled");
		$this->db->from("users");
		$this->db->where('id', $id);
		$get = $this->db->get();
		$result = $get->result();

		if($result[0]->disabled == 0)
			$data['disabled'] = 1;
		else
			$data['disabled'] = 0;

		$q = $this->db->update('users', $data, 'id ='.$id);

		return $q;
	}

	/**
	 * Confirms a new user
	 *
	 * @param  integer	$id			The user id
	 * @return bool
	 */
	function enable($id)
	{
		return $this->db->update('users', array('new' => 0), 'id ='.$id);
	}

	/**
	 * change user pricil
	 * @param  int $id
	 * @param  int $privil
	 * @return bool
	 */
	function edit_user_privil($id, $privil)
	{
		$search = $this->db->get_where('users_privileges', array('user_id' => $id));

		if($search->num_rows() > 0)
			return $this->db->update('users_privileges', array('privilege_id' => $privil), array('user_id' => $id));
		else
			return $this->db->insert('users_privileges', array('privilege_id' => $privil, 'user_id' => $id));
	}

	/**
	 * remove user pricil
	 * @param  int $id
	 * @return bool
	 */
	function remove_user_privil($id)
	{
		return $this->db->delete('users_privileges', array('user_id' => $id));
	}

	/**
	 * Search through users
	 *
	 * @param  string	$search			The search string. Searches first name, last name, lukasid.
	 * @return array
	 */
	function search_user($search)
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->like('lukasid', $search);
		$this->db->or_like('first_name', $search);
		$this->db->or_like('last_name', $search);
		$get = $this->db->get();

		return $get->result();
	}

	/**
	 * Remove a user from the database
	 *
	 * @param 	int 	$id 		The user to be removed
	 * @param 	string 	$liuid 		LiU-id must match user id
	 * @return 	bool
	 */
	function remove_user($id, $liuid)
	{
		$this->db->where('id', $id);
		$this->db->where('lukasid', $liuid);

		$this->db->from("users");
		// count user results
		if($this->db->count_all_results() == 1)
		{
			// delete user
			$del1 = $this->db->delete('users', array('id' => $id, 'lukasid' => $liuid));
			// delete user data
			$del2 = $this->db->delete('users_data', array('users_id' => $id));

			return ($del1 && $del2);
		}
		return false;
	}

	/**
	 * Check if a specific user_id exists
	 *
	 * @param 	int 	$id 		The id to be searched for
	 * @return 	bool
	 */
	function id_exists($id)
	{
		$this->db->where('id', $id);
		$this->db->from("users");
		return $this->db->count_all_results();
	}

	/**
	 * get various admin notif
	 * @return obj 	the notifications
	 */
	function admin_get_notifications()
	{
		$this->db->select("SUM(users.disabled=1) as disabled, COUNT(*) as total, SUM(users.new=1) as unapproved");
		$query = $this->db->get("users");
		$res = $query->result();

		return $res[0];
	}

	/**
	 * get group memberships for user
	 * @param  int $id
	 * @return array
	 */
	function get_user_groups($id)
	{
		$this->db->select("groups.id, groups_descriptions_language.name, groups_year.start_year, groups_year.stop_year, groups_year_members.*");
		$this->db->from("groups_year_members");
		$this->db->join("groups_year", "groups_year_members.groups_year_id = groups_year.id", "");
		$this->db->join("groups_descriptions_language", "groups_year.groups_id = groups_descriptions_language.groups_id", "");
		$this->db->join("groups", "groups_year.groups_id = groups.id", "");
		$this->db->where("groups_year_members.user_id", $id);
		$this->db->order_by("groups_year.stop_year", "asc");

		$query = $this->db->get();
		$result = $query->result();

		return $result;
	}

	/**
	 * get news posted by yser
	 * @param  int $id
	 * @return array
	 */
	function get_user_news($id, $limit = 10)
	{
		$this->db->select("news.*, news_translation_language.*");
		$this->db->from("news");
		$this->db->join("news_translation_language", "news.id = news_translation_language.news_id", "");
		$this->db->where("user_id", $id);
		$this->db->where("draft", 0);
		$this->db->where("approved", 1);
		$this->db->where("news.date <= NOW()");
		$this->db->order_by("date", "desc");
		$this->db->limit($limit);
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * get forum posts by user
	 * @param  int $id
	 * @return array
	 */
	function get_user_forum_posts($id, $limit = 5)
	{
		$this->db->select("forum_reply.id as reply_id, forum_reply.reply_date, forum_reply.topic_id, forum_topic.topic, forum_categories_descriptions_language.title");
		$this->db->from("forum_reply");
		$this->db->join("forum_topic", "forum_reply.topic_id = forum_topic.id", "");
		$this->db->join("forum_categories_descriptions_language", "forum_topic.cat_id = forum_categories_descriptions_language.cat_id", "");
		$this->db->where("forum_reply.user_id", $id);
		$this->db->order_by("reply_date", "desc");
		$this->db->limit($limit);

		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * check if user with id is disabled
	 * @param  in  $id
	 * @return boolean
	 */
	function is_disabled($id)
	{
		$this->db->where("id", $id);
		$this->db->where("disabled", 1);
		$this->db->from("users");

		return $this->db->count_all_results();
	}

	function get_all_privileges()
	{
		$query = $this->db->get('privileges');
		return $query->result();
	}

}

