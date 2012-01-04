<?php
class Forum_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_categories_sub_to($id = 0, $lang = 'se')
    {
		$this->db->select("forum_categories.id, forum_categories.guest_allowed, forum_categories.posting_allowed");
		$this->db->select("forum_categories_descriptions.title, forum_categories_descriptions.description");
		$this->db->from("forum_categories");
		$this->db->join("forum_categories_descriptions", 'forum_categories.id = forum_categories_descriptions.cat_id', 'left');
		$this->db->join("language", 'forum_categories_descriptions.lang_id = language.id', 'left');
		$this->db->order_by("forum_categories_descriptions.title ASC");
		$this->db->where('language.language_abbr', $lang);
		$this->db->where('forum_categories.sub_to_id', $id);
		$query = $this->db->get();
		
		$result = $query->result();
		foreach($result as $res) {
			$res->sub_categories = $this->get_all_categories_sub_to($res->id, $lang);
		}
		
        return $result;
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
	*/
}

