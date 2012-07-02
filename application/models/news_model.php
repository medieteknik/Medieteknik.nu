<?php
class News_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_latest_news()
    {
		// check if approved to see not approved news
		$admin = $this->login->has_privilege('news_editor');
		
		$this->db->select("users.first_name, users.last_name");
		$this->db->select("news.date, news.id, news.draft, news.approved, news_translation_language.title, news_translation_language.text, news_translation_language.lang_id");
		$this->db->select("COALESCE(sticky_order, 0) as sticky_order",false);
		$this->db->from("news");
		$this->db->join("news_translation_language", 'news.id = news_translation_language.news_id', '');
		$this->db->join("users", 'news.user_id = users.id', '');
		$this->db->join("news_sticky", 'news.id = news_sticky.news_id', 'left');
		
		if(!$admin) {
			// not admin, forces news to be approved and not draft
			$this->db->where("news.draft",0);
			$this->db->where("news.approved",1);
		}
		//$this->db->where("news.date <=","DATE(NOW())");
		$this->db->where("DATE(news.date) <= DATE(NOW())");
		$this->db->order_by("sticky_order DESC, news.date DESC");
		$query = $this->db->get();
        return $query->result();
/*
SELECT users.first_name,users.last_name, news.date, news_translation.title, news_translation.text, COALESCE(sticky_order,0) as sticky_order FROM news
JOIN news_translation ON news.id = news_translation.news_id
JOIN language ON news_translation.lang_id = language.id
JOIN users ON news.user_id = users.id
LEFT JOIN news_sticky ON news.id = news_sticky.news_id
WHERE language.language_abbr = 'se'
ORDER BY sticky_order DESC, news.date DESC
*/
    }
    
    function get_news($id)
    {
		
		$this->db->select("users.first_name, users.last_name");
		$this->db->select("news.id, news.date, news_translation_language.title, news_translation_language.text, news_translation_language.lang_id");
		$this->db->from("news");
		$this->db->join("news_translation_language", 'news.id = news_translation_language.news_id', '');
		$this->db->join("users", 'news.user_id = users.id', '');
		$this->db->where("news.id",$id);
		$this->db->limit(1);
		$query = $this->db->get();
		$res = $query->result();
        return $res[0];
	}
	
	function admin_get_all_news_overview() {
		$this->db->select("news.*, language.language_name, language.language_abbr, news_translation.*");
		$this->db->from("news");
		$this->db->from("language");
		$this->db->join("news_translation", 'news_translation.news_id = news.id AND news_translation.lang_id = language.id', 'left');
		$query = $this->db->get();
		$translations = $query->result();
		
		$this->db->select("*");
		$this->db->from("news");
		$query = $this->db->get();
		$news_array = $query->result();
		
		foreach($news_array as $news) {
			$news->translations = array();
			foreach($translations as $t) {
				if($t->id == $news->id) {
					array_push($news->translations, $t);
				}
			}
		}
		return $news_array;
		
/*
SELECT * FROM news
JOIN language
LEFT JOIN news_translation ON news_translation.news_id = news.id AND news_translation.lang_id = language.id
*/
	}

	function add_news($user_id, $translations = array(), $post_date = '', $draft = 0, $approved = 0, $group_id = 0) {
		if(!is_array($translations)) {
			return false;
		}
		$arr_keys = array_keys($translations);
		if(!is_numeric($arr_keys[0])) {
			$theTranslations = array($translations);
		} else {
			$theTranslations = $translations;
		}
		foreach($theTranslations as &$translation) {
			$arr_keys = array_keys($translation);
			if((!in_array("lang_abbr",$arr_keys) && !in_array("lang",$arr_keys)) || !in_array("title",$arr_keys) || !in_array("text",$arr_keys)) {
				return false;
			}
			if(!in_array("lang_abbr",$arr_keys) && in_array("lang",$arr_keys)){
				$translation["lang_abbr"] = $translation["lang"];
			}
		}
		
		$this->db->where('id', $user_id);
		$query = $this->db->get('users');
		if($query->num_rows != 1) {
			return false;
		}
		
		if(is_numeric($group_id) && $group_id > 0) {
			$this->db->where('user_id', $user_id);
			$this->db->where('group_id', $group_id);
			$query = $this->db->get('users_groups');
			if($query->num_rows != 1) {
				$theGroup = 0;
			} else {
				$theGroup = $group_id;
			}
		} else {
			$theGroup = 0;
		}
		
		$theTime = strtotime($post_date);
		if($theTime === false) {
			$theTime = date("Y-m-d H:i:s", time());
		} else {
			$theTime = date("Y-m-d H:i:s", $theTime);
		}
		
		$this->db->trans_start();
		$data = array(
		   'user_id' => $user_id,
		   'group_id' => $theGroup,
		   'date' => $theTime,
		   'draft' => $draft,
		   'approved' => $approved,
		);
		$this->db->insert('news', $data);
		$news_id = $this->db->insert_id();
		
		$success = true;
		foreach($theTranslations as &$translation) { 
			$lang_abbr = $translation["lang_abbr"];
			$title = $translation["title"];
			$text = $translation["text"];
			$theSuccess = $this->add_translation($news_id, $lang_abbr, $title, $text);
			if(!$theSuccess) {
				$success = $theSuccess;
			}
			
		}
		if ($this->db->trans_status() === FALSE || !$success) {
		    $this->db->trans_rollback();
			return false;
		} else {
		    $this->db->trans_commit();
		}
		return $news_id;
	}
	
	function add_translation($news_id, $lang_abbr, $title, $text, $last_edit = '') {
		$theTitle = trim($title);
		$theText = trim($text);
		
		if(strlen($theTitle) < 1 || strlen($theText) < 1) {
			return false;
		}
		
		$theTime = strtotime($last_edit);
		if($theTime === false) {
			$theTime = "0000-00-00 00:00:00";
		} else {
			$theTime = date("Y-m-d H:i:s", $theTime);
		}
		
		$this->db->where('id', $news_id);
		$query = $this->db->get('news');
		if($query->num_rows != 1) {
			return false;
		}
		$this->db->where('language_abbr', $lang_abbr);
		$query = $this->db->get('language');
		if($query->num_rows != 1) {
			return false;
		}
		$lang_id = $query->result(); $lang_id = $lang_id[0]->id;
		
		$data = array(
		   'news_id' => $news_id,
		   'lang_id' => $lang_id,
		   'title' => $theTitle,
		   'text' => $theText,
		   'last_edit' => $theTime
		);
		$this->db->insert('news_translation', $data);
		
		return true;
	}
}

