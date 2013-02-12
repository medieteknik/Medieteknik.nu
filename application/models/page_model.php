<?php
class Page_model extends CI_Model 
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	/**
	 * Fetches one page by name and returns the content
	 *
	 * @return array 	
	 */ 
    function get_page_by_name($name)
    {
		// check if approved to see not approved news
		$admin = $this->login->has_privilege('news_editor');
		
		$this->db->select("*");
		$this->db->from("page");
		$this->db->join("page_content_language", 'page.id = page_content_language.page_id', '');
		$this->db->where("name",$name);
		$query = $this->db->get();
		
		
		if ($query->num_rows() == 0) 
		{
			$this->db->select("*");
			$this->db->from("page");
			$this->db->join("page_content_language", 'page.id = page_content_language.page_id', '');
			$this->db->where("name","404");
			$query = $this->db->get();
		}
		
		
		
        return $query->result();
    }
	
	/**
	 * fetches a specific page, admin-style => more data included
	 *
	 * @param  integer	$id		The ID of the news item
	 * @return array 	
	 */ 
	function admin_get_page($id)
    {
		$this->db->select("*");
		$this->db->from("page");
		$this->db->from("language");
		$this->db->join("page_content", 'page_content.page_id = page.id AND page_content.lang_id = language.id', 'left');
		$this->db->where("page.id",$id);
		$query = $this->db->get();
		$translations = $query->result();
		
		$this->db->select("*");
		$this->db->from("page");
		$this->db->where("page.id",$id);
		$this->db->limit(1);
		$query = $this->db->get();
		$page_array = $query->result();
		$page = $page_array[0];
		
		$page->translations = array();
		
		foreach($translations as $t) 
		{
			array_push($page->translations, $t);
		}
		
		return $page;
		
	}
	
	/**
	 * Fetches all pages for the admin overview
	 *
	 * @return array 	
	 */ 
	function admin_get_all_pages_overview() 
	{
		$this->db->select("*");
		$this->db->from("page");
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 * Create a new news
	 *
	 * @param  integer	$user_id		The ID os the user who creates the news
	 * @param  array 	$translations	All translations of the news item, array("lang_abbr" => "se", "title" => "Inte klistrad!", "text" => "Den här nyheten är inte klistrad eller översatt!")
	 * @param  date		$post_date		The date of the news item
	 * @param  integer	$draft			Specify if the news item is a draft, 1 = Draft, 0 = Not draft
	 * @param  integer	$approved		Specify if the news item is approved, 1 = Approved, 0 = Not approved
	 * @param  integer	$group_id		The id of the group the user belongs to when posting
	 * @return The news id 	
	 */ 
	function add_page($name, $translations = array(), $published = 0) 
	{
		if(!is_array($translations)) 
		{
			return false;
		}
		$arr_keys = array_keys($translations);
		if(!is_numeric($arr_keys[0])) 
		{
			$theTranslations = array($translations);
		} else {
			$theTranslations = $translations;
		}
		foreach($theTranslations as &$translation) 
		{
			$arr_keys = array_keys($translation);
			if((!in_array("lang_abbr",$arr_keys) && !in_array("lang",$arr_keys)) || !in_array("header",$arr_keys) || !in_array("content",$arr_keys)) {
				return false;
			}
			if(!in_array("lang_abbr",$arr_keys) && in_array("lang",$arr_keys)){
				$translation["lang_abbr"] = $translation["lang"];
			}
		}
		
		$this->db->trans_begin();	
		$data = array(
		   'name' => $name,
		   'published' => $published,
		);
		$this->db->insert('page', $data);
		$page_id = $this->db->insert_id();
		
		$success = true;
		foreach($theTranslations as &$translation) 
		{ 
			$lang_abbr = $translation["lang_abbr"];
			$header = $translation["header"];
			$content = $translation["content"];
			$theSuccess = $this->update_page_translation($page_id, $lang_abbr, $header, $content);
			if(!$theSuccess) 
			{
				$success = $theSuccess;
			}
			
		}
		if ($this->db->trans_status() === FALSE || !$success) 
		{
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
		}
		return $page_id;
	}
	
	/**
	 * Update a translation of a specific news item
	 *
	 * @param  integer	$news_id		The ID of the news item
	 * @param  string	$lang_abbr		The language translation abbreviation
	 * @param  string	$title			The title of the news item translation
	 * @param  string	$text			The text of the news item translation
	 * @return bool		True or false depending on success or failure
	 */ 
	function update_page_translation($page_id, $lang_abbr, $header, $content) 
	{
		$theHeader = trim($header);
		$theContent = trim($content);
		
		// check if the news exists
		$this->db->where('id', $page_id);
		$query = $this->db->get('page');
		if($query->num_rows != 1) 
		{
			return false;
		}
		
		// check if the language exists
		$this->db->where('language_abbr', $lang_abbr);
		$query = $this->db->get('language');
		if($query->num_rows != 1) 
		{
			return false;
		}
		$lang_id = $query->result(); $lang_id = $lang_id[0]->id;
		
		// if both title and text is null then delete the translation
		if($theHeader == '' && $theContent == '') 
		{
			$this->db->delete('page_content', array('page_id' => $page_id, 'lang_id' => $lang_id));
			return true;
		} 
		
		// if one of the title and the text is null then exit
		if($theHeader == '' || $theContent == '') 
		{
			return false;
		}
		
		$query = $this->db->get_where('page_content', array('page_id' => $page_id, 'lang_id' => $lang_id), 1, 0);
		if ($query->num_rows() == 0) 
		{
			// A record does not exist, insert one.
			$data = array(	'page_id' 	=> $page_id, 
							'lang_id' 	=> $lang_id,
							'header'		=> $theHeader,
							'content'		=> $theContent,
							'last_edit'	=>  date("Y-m-d H:i:s", time()),
						);
			$query = $this->db->insert('page_content', $data);
			// Check to see if the query actually performed correctly
			if ($this->db->affected_rows() > 0) 
			{
				return TRUE;
			}
		} else {
			// A record does exist, update it.
			// update the translation, and if the texts have not been changed then dont update the last_edit field
			$theTime = date("Y-m-d H:i:s", time());
			$sql = 'UPDATE page_content SET last_edit = IF(STRCMP(header, "'.$theHeader.'") = 0, IF(STRCMP(content, "'.$theContent.'") = 0, last_edit, "'.$theTime.'"), "'.$theTime.'"), header = "'.$theHeader.'", content = "'.$theContent.'" WHERE page_id = "'.$page_id.'" AND lang_id = "'.$lang_id.'" ';
			$this->db->query($sql);
			return true;
		}
		return FALSE;
	}
    
}

