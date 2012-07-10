<?php
class Forum_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

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
    
    function get_latest_threads($id, $max_threads = 5) {
		//$this->db->distinct();
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
	
	function get_topics($id) {
		//$this->db->distinct();
		$this->db->select("*");
		$this->db->from("forum_topic");
		$this->db->join("forum_reply", "forum_reply.id = forum_topic.last_reply_id", "");
		$this->db->where("forum_topic.cat_id", $id);
		$this->db->order_by("forum_reply.reply_date DESC");
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_all_latest_threads($max_threads = 5) {
		//$this->db->distinct();
		$this->db->select("forum_topic.id, forum_topic.topic, MAX(forum_reply.reply_date) as date");
		$this->db->from("forum_reply");
		$this->db->join("forum_topic", "forum_reply.topic_id = forum_topic.id", "");
		$this->db->order_by("date DESC");
		$this->db->group_by("forum_topic.id"); 
		$this->db->limit($max_threads);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_topic($id) {
		$this->db->select("forum_topic.*");
		$this->db->from("forum_topic");
		//$this->db->join("forum_categories", "forum_categories.id = forum_topic.cat_id");
		//$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
		$this->db->where("forum_topic.id", $id);
		$this->db->limit(1);
		$query = $this->db->get();
		$theone = $query->result();
		return $theone[0];
	}
	
	function get_replies($id) {
		$this->db->select("forum_reply.*, users.first_name, users.last_name");
		$this->db->from("forum_reply");
		$this->db->join("users", "forum_reply.user_id = users.id", "");
		$this->db->where("forum_reply.topic_id", $id);
		$this->db->order_by("forum_reply.reply_date ASC");
		$query = $this->db->get();
		return $query->result();
	}

	/*
	SELECT * 
	FROM forum_categories
	JOIN forum_categories_descriptions ON forum_categories.id = forum_categories_descriptions.cat_id
	LEFT JOIN language ON forum_categories_descriptions.lang_id = language.id
	WHERE forum_categories.sub_to_id =0
	AND language.language_abbr =  'se'
	OR language.language_abbr IS NULL 
	LIMIT 0 , 30
	
	SELECT COALESCE( title_se, title_en ) AS title
	FROM forum_categories
	LEFT JOIN (

	SELECT cat_id, title AS title_se
	FROM forum_categories_descriptions
	JOIN language ON forum_categories_descriptions.lang_id = language.id
	WHERE language.language_abbr =  'se'
	) AS prim ON prim.cat_id = forum_categories.id
	LEFT JOIN (

	SELECT cat_id, title AS title_en
	FROM forum_categories_descriptions
	JOIN language ON forum_categories_descriptions.lang_id = language.id
	WHERE language.language_abbr =  'en'
	) AS sec ON sec.cat_id = forum_categories.id
	
	SELECT
	    e.cat_id,COALESCE(o.title,e.title)
	    FROM forum_categories_descriptions                e
	        LEFT OUTER JOIN forum_categories_descriptions o ON e.cat_id=o.cat_id and o.lang_id='1'
	    WHERE e.lang_id='2'
	
	SET @prim = 1;
	SET @sec = 2;

SET @primary_language_id = 1;
SET @secondary_language_id = 2;

CREATE FUNCTION get_primary_language_id()
RETURNS INT(5)
RETURN @primary_language_id;

CREATE FUNCTION get_secondary_language_id()
RETURNS INT(5)
RETURN @secondary_language_id;

CREATE OR REPLACE VIEW forum_categories_descriptions_language AS (SELECT e.cat_id,e.lang_id,COALESCE(o.title,e.title) as title, COALESCE(o.description,e.description) as description  
FROM forum_categories_descriptions               e
LEFT OUTER JOIN forum_categories_descriptions o ON e.cat_id=o.cat_id AND o.lang_id<>e.lang_id AND o.lang_id=get_primary_language_id()
WHERE (e.lang_id = get_primary_language_id() AND o.lang_id IS NULL) OR (e.lang_id = get_secondary_language_id() AND o.lang_id IS NULL))
	*/
	
	function create_topic($cat_id, $user_id, $topic, $post, $date = '') {
		
		
		$theTime = strtotime($date);
		if($theTime === false) {
			$theTime = date("Y-m-d H:i:s", time());
		} else {
			$theTime = date("Y-m-d H:i:s", $theTime);
		}
		
		$this->db->trans_start();
		
		$data = array(	'cat_id' 		=> $cat_id, 
						'user_id' 		=> $user_id,
						'topic'			=> $topic,
						'last_reply_id'	=> 0,
						);
		$query = $this->db->insert('forum_topic', $data);
		$topic_id = $this->db->insert_id();
		
		$this->add_reply($topic_id, $user_id, $post, $theTime);
		
		$this->db->trans_complete();
		
		return $topic_id;
		
	}
	
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

