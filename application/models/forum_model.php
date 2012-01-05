<?php
class Forum_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_all_categories_sub_to($id = 0, $lang = 'se')
    {
		$prim = $lang;
		if($prim == 'se') $sec = 'en';
		if($prim == 'en') $sec = 'se';
		
		$arr = array("title", "description");
		
		$q = "SELECT forum_categories.id, forum_categories.guest_allowed, forum_categories.posting_allowed ";
		$q .= $this->db->get_select_lang($arr, $prim, $sec);
		$q .= "FROM forum_categories ";
		$q .= $this->db->get_join_language("forum_categories_descriptions", "cat_id",'forum_categories.id', $prim, $arr);
		$q .= $this->db->get_join_language("forum_categories_descriptions", "cat_id",'forum_categories.id', $sec, $arr);
		$q .= "WHERE forum_categories.sub_to_id = '".$id."' ORDER BY title ASC";
		
		$query = $this->db->query($q);
		
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
	
title
	*/
}

