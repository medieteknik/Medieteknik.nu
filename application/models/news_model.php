<?php
class News_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_latest_news()
    {
		
		$this->db->select("users.first_name, users.last_name");
		$this->db->select("news.date, news_translation_language.title, news_translation_language.text");
		$this->db->select("COALESCE(sticky_order, 0) as sticky_order",false);
		$this->db->from("news");
		$this->db->join("news_translation_language", 'news.id = news_translation_language.news_id', '');
		$this->db->join("users", 'news.user_id = users.id', '');
		$this->db->join("news_sticky", 'news.id = news_sticky.news_id', 'left');
		$this->db->order_by("sticky_order DESC, news.date DESC");
		$query = $this->db->get();
		/*
		$arr = array("title", "text");
		$q = "SELECT users.first_name, users.last_name, news.date, COALESCE(sticky_order, 0) as sticky_order ";
		$q .= $this->db->get_select_lang($arr, $prim, $sec);
		$q .= "FROM news ";
		$q .= $this->db->get_join_language("news_translation", "news_id",'news.id', $prim, $arr);
		$q .= $this->db->get_join_language("news_translation", "news_id",'news.id', $sec, $arr);
		$q .= "JOIN users ON news.user_id = users.id LEFT JOIN news_sticky ON news.id = news_sticky.news_id ";
		$q .= "ORDER BY sticky_order DESC, news.date DESC";
		$query = $this->db->query($q);
		*/
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
}

