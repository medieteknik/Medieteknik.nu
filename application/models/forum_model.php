<?php
class Forum_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
		$this->db->select("forum_categories.*, forum_categories_descriptions_language.title, forum_categories_descriptions_language.description");
		$this->db->from("forum_categories");
		$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
		$this->db->join("forum_topic", "forum_topic.cat_id = forum_categories.id", "left");
		$this->db->join("forum_reply", "forum_reply.topic_id = forum_topic.id", "left");
		$this->db->group_by("forum_categories.id");
		$this->db->where("forum_categories.sub_to_id", $id);
		$this->db->order_by("order ASC");
		$query = $this->db->get();
		$result = $query->result();
		if($levels > 1) {
			foreach($result as $res) {
				$res->sub_categories = $this->get_all_categories_sub_to($res->id, $levels - 1, TRUE);
				/*
				foreach($res->sub_categories as $cat) {
					$cat->threads = $this->get_latest_threads($cat->id,5);
				}
				*/
			}
		}
		
		// if not a recursive call and not the root node, fetch also the title of the current category
		if(!$recursive && $id != 0) {
			$this->db->select("forum_categories.*, forum_categories_descriptions_language.title, forum_categories_descriptions_language.description");
			$this->db->from("forum_categories");
			$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
			$this->db->where("forum_categories.id", $id);
			$this->db->limit(1);
			
			$query = $this->db->get();
			$result2 = $query->result();
			foreach($result2 as $res) {
				$res->sub_categories = $result;
			}
			$result = $result2;
			
		}
		
        return $result;
    }
    
	/**
	 * Fetches all latest threads in a specific category
	 *
	 * @param  integer	$id		The ID of the category from which to fetch threads
	 * @param  integer  $max_threads	How many threads to fetch
	 * @return array 	
	 */ 
    function get_latest_threads($id, $max_threads = 5) {
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
	 * Fetches all topics in a category
	 *
	 * @param  integer	$id		The ID of the category from which to fetch topics
	 * @return array 	
	 */ 
	function get_topics($id) {
		$this->db->select("*");
		$this->db->from("forum_topic");
		$this->db->join("forum_reply", "forum_reply.id = forum_topic.last_reply_id", "");
		$this->db->where("forum_topic.cat_id", $id);
		$this->db->order_by("forum_reply.reply_date DESC");
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * Fetches the latest threads in all categories
	 *
	 * @param  integer	$max_threads	Maximum number of threads to fetch
	 * @return array 	
	 */ 
	function get_all_latest_threads($max_threads = 5) {
		$this->db->select("forum_topic.id, forum_topic.topic, MAX(forum_reply.reply_date) as date");
		$this->db->from("forum_reply");
		$this->db->join("forum_topic", "forum_reply.topic_id = forum_topic.id", "");
		$this->db->order_by("date DESC");
		$this->db->group_by("forum_topic.id"); 
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
	function get_topic($id) {
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
	function get_replies($id) {
		$this->db->select("forum_reply.*, users.first_name, users.last_name");
		$this->db->from("forum_reply");
		$this->db->join("users", "forum_reply.user_id = users.id", "");
		$this->db->where("forum_reply.topic_id", $id);
		$this->db->order_by("forum_reply.reply_date ASC");
		$query = $this->db->get();
		return $query->result();
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
	function create_topic($cat_id, $user_id, $topic, $post, $date = '') {
		$theTime = strtotime($date);
		
		// if unable to parse the date, use the current datetime
		if($theTime === false) {
			$theTime = date("Y-m-d H:i:s", time());
		} else {
			$theTime = date("Y-m-d H:i:s", $theTime);
		}
		
		// start transaction
		$this->db->trans_start();
		
		$data = array(	'cat_id' 		=> $cat_id, 
						'user_id' 		=> $user_id,
						'topic'			=> $topic,
						'last_reply_id'	=> 0,
						);
		$query = $this->db->insert('forum_topic', $data);
		$topic_id = $this->db->insert_id();
		$this->add_reply($topic_id, $user_id, $post, $theTime);
		
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
	function add_reply($topic_id, $user_id, $reply, $date = '') {
		$theTime = strtotime($date);
		if($theTime === false) {
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
		
		$data = array(
               'last_reply_id' => $reply_id,
            );

		$this->db->where('id', $topic_id);
		$this->db->update('forum_topic', $data);
	}
}

