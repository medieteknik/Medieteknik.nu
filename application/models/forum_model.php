<?php
class Forum_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * check existance of category id
     *
     * @param 	int $id the cat id
     * @return 	bool
     */
    function category_exists($id)
    {
    	$this->db->where('id', $id);
    	$query = $this->db->get('forum_categories');
    	return $query->num_rows();
    }

	/**
	 * Fetches all subcategories to a certain category
	 *
	 * @param  integer	$id		The ID of the category from which to fetch the sub categories from
	 * @param  integer  $levels	Hos many levels of sub categories to fetch
	 * @param  bool 	$recursive	Check if it is a recursive call
	 * @return array
	 */
    function get_all_categories_sub_to($id = 0, $levels = 1, $recursive = FALSE)
    {
		//$this->db->distinct();
		$this->db->select("forum_categories.*, forum_categories_descriptions_language.title");
		$this->db->select("forum_categories_descriptions_language.slug, forum_categories_descriptions_language.description");
		$this->db->from("forum_categories");
		$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
		$this->db->join("forum_topic", "forum_topic.cat_id = forum_categories.id", "left");
		$this->db->join("forum_reply", "forum_reply.topic_id = forum_topic.id", "left");
		$this->db->group_by("forum_categories.id");
		$this->db->where("forum_categories.sub_to_id", $id);
		$this->db->order_by("order ASC");
		$query = $this->db->get();
		$result = $query->result();
		if($levels > 1)
		{
			foreach($result as $res)
			{
				$res->sub_categories = $this->get_all_categories_sub_to($res->id, $levels - 1, TRUE);
				/*
				foreach($res->sub_categories as $cat) {
					$cat->threads = $this->get_latest_threads($cat->id,5);
				}
				*/
			}
		}

		// if not a recursive call and not the root node, fetch also the title of the current category
		if(!$recursive && $id != 0)
		{
			$this->db->select("forum_categories.*, forum_categories_descriptions_language.title");
			$this->db->select("forum_categories_descriptions_language.description, forum_categories_descriptions_language.slug");
			$this->db->from("forum_categories");
			$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
			$this->db->where("forum_categories.id", $id);
			$this->db->limit(1);

			$query = $this->db->get();
			$result2 = $query->result();
			foreach($result2 as $res)
			{
				$res->sub_categories = $result;
			}
			$result = $result2;

		}

        return $result;
    }

    /**
     * Fetches all ancestors to category with $id
     *
     * @param  integer 	$id sub-category id
     * @return array 	$categoryAncestors
     */
    function get_all_categories_ancestors_to($id = 0)
    {
    	if($id)
    	{
	    	$this->db->select("id, title, sub_to_id, slug");
	    	$this->db->from("forum_categories");
	    	$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
	    	$this->db->where("forum_categories.id", $id);

			$query = $this->db->get();
			$categoryAncestors = $query->result();

			if($categoryAncestors[0]->sub_to_id != 0)
			{
				$categoryAncestors=array_merge($categoryAncestors,
					$this->get_all_categories_ancestors_to($categoryAncestors[0]->sub_to_id));
			}

			return $categoryAncestors;
	 	}
    }

	/**
	 * Fetches all latest threads in a specific category
	 *
	 * @param  integer	$id		The ID of the category from which to fetch threads
	 * @param  integer  $max_threads	How many threads to fetch
	 * @return array
	 */
    function get_latest_threads($id, $max_threads = 5)
    {
		$this->db->select("*");
		$this->db->from("forum_reply");
		$this->db->join("forum_topic", "forum_reply.topic_id = forum_topic.id", "");
		$this->db->where("forum_topic.cat_id", $id);
		$this->db->order_by("forum_reply.reply_date ASC");
		$this->db->group_by("forum_topic.id");
		$this->db->limit($max_threads);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Check topic existance
	 *
	 * @param  integer	$id		The ID of the topic
	 * @return bool
	 */
	function topic_exists($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('forum_topic');
		return $query->num_rows();
	}

	/**
	 * Fetches all topics in a category
	 *
	 * @param  integer	$id		The ID of the category from which to fetch topics
	 * @return array
	 */
	function get_topics($id)
	{
		$this->db->select("forum_topic.*, forum_reply.*, users.first_name, users.last_name, first_reply.*");
		$this->db->select("forum_reply_guest.name, forum_reply_guest.email, verify.verified");
		$this->db->from("forum_topic");
		$this->db->join("forum_reply", "forum_reply.id = forum_topic.last_reply_id", "");
		$this->db->join("forum_reply as first_reply", "first_reply.id = forum_topic.last_reply_id", "");
		$this->db->join("users", "first_reply.user_id = users.id", "left");
		// only verified threads!
		$this->db->join("forum_reply_guest AS verify", "verify.reply_id = forum_topic.first_reply_id", "left");
		$this->db->join("forum_reply_guest", "forum_reply_guest.reply_id = forum_topic.last_reply_id", "left");
		$this->db->where("forum_topic.cat_id", $id);
		// only verified threads!
		$this->db->where("(forum_reply_guest.email IS NULL OR verify.verified = 1)");
		$this->db->order_by("forum_reply.reply_date DESC");
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Fetches cat_id from slug
	 * @param  string $slug the slug
	 * @return int          the cat id
	 */
	function get_id_from_slug($slug)
	{
		$this->db->select('cat_id');
		$this->db->where('slug', $slug);
		$this->db->limit(1);
		$query = $this->db->get('forum_categories_descriptions');
		$result = $query->result_array();

		if($query->num_rows() > 0)
			return $result[0]['cat_id'];

		return false;
	}

	/**
	 * Fetches the latest threads in all categories
	 *
	 * @param  integer	$max_threads	Maximum number of threads to fetch
	 * @return array
	 */
	function get_all_latest_threads($max_threads = 5)
	{
		$this->db->select("forum_topic.id, forum_topic.topic, MAX(forum_reply.reply_date) as date");
		// $this->db->select("forum_reply_guest.email");
		$this->db->from("forum_reply");
		$this->db->join("forum_topic", "forum_reply.topic_id = forum_topic.id", "");
		$this->db->join("forum_reply_guest", "forum_reply_guest.reply_id = forum_reply.id", "left");
		$this->db->order_by("date DESC");
		$this->db->group_by("forum_topic.id");
		$this->db->where("(forum_reply_guest.email IS NULL OR forum_reply_guest.verified = 1)");
		$this->db->limit($max_threads);
		$query = $this->db->get();
		return $query->result();
	}

	/**
	 * Fetches a topic
	 *
	 * @param  integer	$id		The ID of the topic to fetch
	 * @return array
	 */
	function get_topic($id)
	{
		$this->db->select("forum_topic.*");
		$this->db->from("forum_topic");
		$this->db->where("forum_topic.id", $id);
		$this->db->limit(1);
		$query = $this->db->get();
		$theone = $query->result();
		return $theone[0];
	}

	/**
	 * Fetches all replies to a specific topic
	 *
	 * @param  integer	$id		The ID of topic to fetch replies from
	 * @return array
	 */
	function get_replies($topic_id)
	{
		$this->db->select("forum_reply.*, forum_reply_guest.*, users.first_name, users.last_name, users_data.gravatar");
		$this->db->from("forum_reply");
		$this->db->join("users", "forum_reply.user_id = users.id", "left");
		$this->db->join("users_data", "users.id = users_data.users_id", "left");
		$this->db->join("forum_reply_guest", "forum_reply_guest.reply_id = forum_reply.id", "left");
		$this->db->where("forum_reply.topic_id", $topic_id);
		// only verified/approved replies!
		$this->db->where("(forum_reply_guest.email IS NULL OR forum_reply_guest.verified = 1)");
		$this->db->order_by("forum_reply.reply_date ASC");
		$query = $this->db->get();
		$result = $query->result();

		// This is inefficient, should be included in the first mysql query, but
		// i could not get it working properly. Should be looked on some day, but it works
		// for now! /klaes950
		if($this->login->is_logged_in())
		{
			$user_id = $this->login->get_id();
			foreach ($result as $post) {
				$post->reports = $this->get_reports($post->id, $user_id);
			}
		}

		return $result;
	}

	/**
 	 * Creates a new thread topic (and reply)
 	 *
 	 * @param  integer	$cat_id		The ID of the category where the topic is being put
 	 * @param  integer  $user_id	The ID of the creator of the topic
 	 * @param  string 	$topic		The topic/headline of the thread
	 * @param  string	$post		The forum post/question
	 * @param  date		$date		The date when the topic is supposed to be posted
 	 * @return integer	The new topic ID
 	 */
	function create_topic($cat_id, $user_id, $topic, $post, $date = '')
	{
		if(empty($topic) || empty($post))
			return false;

		$theTime = strtotime($date);

		// if unable to parse the date, use the current datetime
		if($theTime === false)
			$theTime = date("Y-m-d H:i:s", time());
		else
			$theTime = date("Y-m-d H:i:s", $theTime);

		// start transaction
		$this->db->trans_start();

		$data = array(	'cat_id' 		=> $cat_id,
						'user_id' 		=> $user_id,
						'topic'			=> $topic,
						'last_reply_id'	=> 0,
						);
		$query = $this->db->insert('forum_topic', $data);
		$topic_id = $this->db->insert_id();

		$first_reply = $this->add_reply($topic_id, $user_id, $post, $theTime);

		$this->db->update('forum_topic', array('first_reply_id' => $first_reply), array('id' => $topic_id));

		// completes the transaction, if anything has gone wrong, it rollbacks the changes
		$this->db->trans_complete();

		return $topic_id;
	}

	function create_guest_topic($cat_id, $topic, $post, $name, $email, $hash)
	{
		if(empty($topic) || empty($post) || empty($name) || !valid_email($email))
			return false;

		$theTime = date("Y-m-d H:i:s", time());

		// start transaction
		$this->db->trans_start();

		$data = array(	'cat_id' 		=> $cat_id,
						'user_id' 		=> 0,
						'topic'			=> $topic,
						'last_reply_id'	=> 0,
						'first_reply_id' => 0
						);
		$query = $this->db->insert('forum_topic', $data);
		$topic_id = $this->db->insert_id();

		$first_reply = $this->add_guest_reply($topic_id, $post, $name, $email, $hash);
		$this->db->update('forum_topic', array('first_reply_id' => $first_reply), array('id' => $topic_id));

		// completes the transaction, if anything has gone wrong, it rollbacks the changes
		$this->db->trans_complete();

		return $topic_id;
	}

	/**
	 * Add a reply to a thread
	 *
	 * @param  integer	$id		The ID of the topic
	 * @param  integer	$user_id	The user id
	 * @param  string	$reply	The actual reply
	 * @param  date		$date	The date when the reply is supposed to be posted
	 */
	function add_reply($topic_id, $user_id, $reply, $date = '')
	{
		$theTime = strtotime($date);
		if($theTime === false)
		{
			$theTime = date("Y-m-d H:i:s", time());
		} else {
			$theTime = date("Y-m-d H:i:s", $theTime);
		}

		$data = array(	'topic_id' 		=> $topic_id,
						'user_id' 		=> $user_id,
						'reply'			=> $reply,
						'reply_date'	=> $theTime,
						);
		$query = $this->db->insert('forum_reply', $data);
		$reply_id = $this->db->insert_id();

		$data = array('last_reply_id' => $reply_id);

		$this->db->where('id', $topic_id);
		$this->db->update('forum_topic', $data);

		return $reply_id;
	}

	function add_guest_reply($topic_id, $reply, $name, $email, $hash)
	{
		if(empty($reply) || empty($name) || !valid_email($email))
			return false;

		$data = array(	'topic_id' 		=> $topic_id,
						'reply'			=> $reply,
						'reply_date'	=> date("Y-m-d H:i:s"),
						'user_id'		=> 0
						);
		$query = $this->db->insert('forum_reply', $data);
		$reply_id = $this->db->insert_id();

		log_message('info', 'Guest reply #'.$reply_id.' from '.$name.' ('.$email.'), IP:'.get_client_ip_addr());

		// add guest user data and save hash as variable
		$hash = $this->add_guest_data($reply_id, $name, $email, $hash);

		$data = array('last_reply_id' => $reply_id);

		$this->db->where('id', $topic_id);
		$this->db->update('forum_topic', $data);

		return $reply_id;
	}

	function add_guest_data($reply_id, $name, $email, $hash)
	{
		$data = array(
				'reply_id' 	=> $reply_id,
				'name' 		=> $name,
				'email' 	=> $email,
				'hash' 		=> $hash,
				'verified' 	=> $this->login->is_verified($email)
			);

		if($this->db->insert('forum_reply_guest', $data))
			return $data['hash'];

		return false;
	}

	/**
	 * checks if a user is verified
	 * @param  string  $email the user email
	 * @return boolean
	 */
	function is_verified($email)
	{
		$this->db->where('email', $email);
		$this->db->where('verified', 1);
		$q = $this->db->get('forum_reply_guest');

		return $q->num_rows();
	}

	/**
	 * verifies a user using email AND hash
	 * @param  string $hash  the hash
	 * @param  string $email the email
	 * @return bool
	 */
	function verify($hash, $email)
	{
		$where = array(
				'hash' 	=> $hash,
				'email' => $email
			);
		return $this->db->update('forum_reply_guest', array('verified' => 1), $where);
	}

	/**
	 * mark a guest forum reply as ok
	 * @param  int $reply_id the reply id
	 * @return bool
	 */
	function verify_id($reply_id)
	{
		return $this->db->update('forum_reply_guest', array('verified' => 1), array('reply_id' => $reply_id));
	}

	/**
	 * check if a hash/email combination is valid
	 * @param  string $hash  the hash
	 * @param  string $email the email
	 * @return bool/int
	 */
	function hash_check($hash, $email)
	{
		$this->db->where('hash', $hash);
		$this->db->where('email', $email);
		$query = $this->db->get('forum_reply_guest');

		return $query->num_rows();
	}

	/**
	 * find out what topic the guest forum reply was posted to
	 * @param  string $hash  the hash to search for
	 * @param  string $email the email who posted the reply
	 * @return array        the topic id and the reply id
	 */
	function get_topic_id_from_hash($hash, $email)
	{
		$this->db->select("forum_reply.topic_id, forum_reply.id as reply_id");
		$this->db->from("forum_reply_guest");
		$this->db->where("hash", $hash);
		$this->db->where("email", $email);
		$this->db->join("forum_reply", "forum_reply_guest.reply_id = forum_reply.id", "");
		$query = $this->db->get();
		$res = $query->result();

		if($query->num_rows() > 0)
			return $res[0];

		return false;
	}

	/**
	 * report a forum reply
	 * @param  int $post_id the forum post to report
	 * @param  int $user_id the user who reports the post
	 * @return int/false          the report id
	 */
	function report_post($post_id, $user_id)
	{
		if($this->report_exists($post_id, $user_id))
			return true;

		$data = array('reply_id' => $post_id, 'user_id' => $user_id);
		$insert = $this->db->insert('forum_report', $data);
		return ($insert ? $this->db->insert_id() : false);
	}

	/**
	 * check if a user has reported a post
	 * @param  int $post_id the reply id
	 * @param  int $user_id the user id
	 * @return int/bool
	 */
	function report_exists($post_id, $user_id)
	{
		$this->db->where('reply_id', $post_id);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('forum_report');
		return $query->num_rows();
	}

	/**
	 * get reports for a forum post. either per user or all.
	 * @param  int  $post_id the forum post id
	 * @param  int $user_id  optional. the user id.
	 * @return array           array with all the replies
	 */
	function get_reports($post_id, $user_id = 0)
	{
		if($user_id !== 0)
			$this->db->where('user_id', $user_id);

		$this->db->where('reply_id', $post_id);
		$query = $this->db->get('forum_report');

		return $query->result();
	}

	/**
	 * get all reports
	 * @return array array of objects
	 */
	function get_all_reports()
	{
		$this->db->select('forum_report.*, forum_reply.*, users.lukasid, poster.lukasid as p_lukasid');
		$this->db->join('forum_reply', 'forum_reply.id = forum_report.reply_id', '');
		$this->db->join('users', 'users.id = forum_report.user_id', '');
		$this->db->join('users AS poster', 'poster.id = forum_reply.user_id', 'left');
		$query = $this->db->get('forum_report');
		return $query->result();
	}

	/**
	 * get all active reports
	 * @return array array of objects
	 */
	function get_all_active_reports()
	{
		$this->db->select('forum_report.id as report_id, forum_report.*, forum_reply.*, users.lukasid, poster.lukasid as p_lukasid');
		$this->db->join('forum_reply', 'forum_reply.id = forum_report.reply_id', '');
		$this->db->join('users', 'users.id = forum_report.user_id', '');
		$this->db->join('users AS poster', 'poster.id = forum_reply.user_id', 'left');
		$this->db->where('forum_report.handled', 0);
		$query = $this->db->get('forum_report');
		return $query->result();
	}

	/**
	 * deletes a report
	 * @param  int $report_id the report id
	 * @return bool
	 */
	function remove_report($report_id)
	{
		return $this->db->delete('forum_report', array('id' => $report_id));
	}

	/**
	 * mark a report as handled
	 * @param  int $report_id the report id
	 * @return bool
	 */
	function handle_report($report_id)
	{
		$this->db->where('id', $report_id);
		return $this->db->update('forum_report', array('handled' => 1));
	}

	/**
	 * get all unverified replies
	 * @return array array of objects
	 */
	function get_all_pending_posts()
	{
		$this->db->select('forum_reply_guest.*, forum_reply.*, forum_topic.topic, forum_topic.cat_id');
		$this->db->join("forum_reply", "forum_reply.id = forum_reply_guest.reply_id", "");
		$this->db->join("forum_topic", "forum_topic.id = forum_reply.topic_id", "");
		$this->db->where('verified', 0);
		$query = $this->db->get('forum_reply_guest');

		return $query->result();
	}

	function remove_reply($reply_id)
	{
		$data = array('reply' => $this->config->item('forum_deleted_string'));
		return $this->db->update('forum_reply', $data, array('id' => $reply_id));
	}

	function admin_remove_reply($reply_id)
	{
		if($this->is_first_reply($reply_id))
		{
			// get topic id
			$topic_id = $this->get_topic_id_from_reply($reply_id);
			// remove the whole thread
			$this->remove_topic($topic_id);
		}
		else
		{
			$replies 	= $this->db->delete('forum_reply', array('id' => $reply_id));
			$guest 		= $this->db->delete('forum_reply_guest', array('reply_id' => $reply_id));
			$reports 	= $this->db->delete('forum_reply_reports', array('reply_id' => $reply_id));

			return $replies && $guest && $reports;
		}
	}

	function remove_topic($topic_id)
	{
		$topic = $this->db->delete('forum_topic', array('id' => $topic_id));
		$reply = $this->db->delete('forum_reply', array('id' => $topic_id));

		return $topic && $reply;
	}

	function is_first_reply($id)
	{
		$this->db->where('first_reply', $id);
		$q = $this->db->get('forum_topic');

		return $q->num_rows();
	}

	function get_topic_id_from_reply($reply_id)
	{
		$this->db->select('topic_id');
		$this->db->where('id', $reply_id);
		$q = $this->db->get('forum_reply');
		$result = $q->result_array();

		if($q && $q->num_rows() > 0)
			return $result[0]['topic_id'];

		// if we got to this point, something went wrong
		return false;
	}

	function get_reply_info($reply_id, $what = '*')
	{
		$this->db->select($what);
		$this->db->where('id', $reply_id);
		$q = $this->db->get('forum_reply');
		$result = $q->result();

		if($q->num_rows() > 0)
			return $result[0];

		return false;
	}
}

