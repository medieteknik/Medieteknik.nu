<?php
class News_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_latest_news($lang = 'se')
    {
		$this->db->select("users.first_name, users.last_name");
		$this->db->select("news.date, news_translation.title, news_translation.text");
		$this->db->select("COALESCE(sticky_order, 0) as sticky_order",false);
		$this->db->from("news");
		$this->db->join("news_translation", 'news.id = news_translation.news_id', '');
		$this->db->join("language", 'news_translation.lang_id = language.id', '');
		$this->db->join("users", 'news.user_id = users.id', '');
		$this->db->join("news_sticky", 'news.id = news_sticky.news_id', 'left');
		$this->db->where("language.language_abbr", $lang);
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
}

