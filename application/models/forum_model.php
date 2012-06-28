<?php
class Forum_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_categories_sub_to($id = 0)
    {
		$this->db->select("*");
		$this->db->from("forum_categories");
		$this->db->join("forum_categories_descriptions_language", "forum_categories.id = forum_categories_descriptions_language.cat_id", "");
		$this->db->where("forum_categories.sub_to_id", $id);
		$this->db->order_by("order ASC");
		$query = $this->db->get();
		$result = $query->result();
		foreach($result as $res) {
			$res->sub_categories = $this->get_all_categories_sub_to($res->id);
			foreach($res->sub_categories as $cat) {
				$cat->threads = $this->get_latest_threads($cat->id,5);
			}
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
}

