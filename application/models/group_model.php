<?php
class Group_model extends CI_Model 
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all_groups()
    {
		$this->db->select("groups.id, groups_descriptions_language.name, groups_descriptions_language.description,  COUNT(groups_year.groups_id) as count");
		$this->db->from("groups");
		$this->db->join("groups_descriptions_language", "groups.id = groups_descriptions_language.groups_id", "");
		$this->db->join("groups_year", "groups.id = groups_year.groups_id", "left");
		$this->db->group_by("groups.id");
		$query = $this->db->get();
		
        return $query->result();
    }
	
	function get_group($id)
	{
		$this->db->select("groups.id, groups_descriptions_language.name, groups_descriptions_language.description");
		$this->db->from("groups");
		$this->db->join("groups_descriptions_language", "groups.id = groups_descriptions_language.groups_id", "");
		$this->db->where("groups.id", $id);
		$query = $this->db->get();
		$result = $query->result();
			
		foreach($result as &$res)
		{
			$res->members = $this->get_group_members($res->id);
		}
		
		return $result;
	}
	function admin_get_group($id)
	{
		$this->db->select("groups.id, groups_descriptions.name, groups_descriptions.description, language.language_name, language.language_abbr");
		$this->db->from("groups");
		$this->db->from("language");
		$this->db->join("groups_descriptions", 'groups_descriptions.groups_id = groups.id AND groups_descriptions.lang_id = language.id', 'left');
		$this->db->where("groups.id",$id);
		$query = $this->db->get();
		$translations = $query->result();

		$this->db->select("*");
		$this->db->from("groups");
		$this->db->where("groups.id",$id);
		$this->db->limit(1);
		$query = $this->db->get();
		$news_array = $query->result();
		$news = $news_array[0];
		$news->translations = array();
		foreach($translations as $t) 
		{
			array_push($news->translations, $t);
		}

		return $news;
	}



	
	function get_group_members($id)
	{
		$this->db->select("groups_year.id, groups_year.start_year, groups_year.stop_year");
		$this->db->select("users.first_name, users.last_name");
		$this->db->select("users_groups_year.position, users_groups_year.email");
		$this->db->select("users_data.gravatar");
		$this->db->from("groups");
		$this->db->join("groups_year", "groups_year.groups_id = groups.id", 'left');
		$this->db->join("users_groups_year", "users_groups_year.groups_year_id = groups_year.id", 'left');
		$this->db->join("users", "users.id = users_groups_year.user_id", 'left');
		$this->db->join("users_data", "users_data.users_id = users.id", 'left');
		$this->db->where("groups.id", $id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function get_group_name($name, $lang = 'se') 
	{
		if (preg_match ('/[^A-Za-z0-9_]/i', $name)) 
		{
		    return null;
		}
		
		$use_name = uncompact_name($name);
		
		$this->db->select("groups.id, groups.group_name, groups_descriptions_language.description");
		$this->db->from("groups");
		$this->db->join("groups_descriptions_language", "groups.id = groups_descriptions_language.group_id", "");
		$this->db->where("groups.id IN (SELECT groups.id FROM groups WHERE groups.group_name REGEXP '^(".$use_name.")$' )");
		$this->db->limit(1);
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
	function add_group($translations = array(), $official = 1) 
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
			if((!in_array("lang_abbr",$arr_keys) && !in_array("lang",$arr_keys)) || !in_array("name",$arr_keys) || !in_array("description",$arr_keys)) {
				return false;
			}
			if(!in_array("lang_abbr",$arr_keys) && in_array("lang",$arr_keys)){
				$translation["lang_abbr"] = $translation["lang"];
			}
		}
		
		//if($use_transaction)
		$this->db->trans_begin();
			
		$data = array(
		   'official' => $official,
		);
		$this->db->insert('groups', $data);
		$group_id = $this->db->insert_id();
		
		$success = true;
		foreach($theTranslations as &$translation) 
		{ 
			$lang_abbr = $translation["lang_abbr"];
			$title = $translation["name"];
			$text = $translation["description"];
			$theSuccess = $this->update_translation($group_id, $lang_abbr, $title, $text);
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
		return $group_id;
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
	function update_translation($news_id, $lang_abbr, $title, $text) 
	{
		$theTitle = trim($title);
		$theText = trim($text);
		
		// check if the group exists
		$this->db->where('id', $news_id);
		$query = $this->db->get('groups');
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
		if($theTitle == '' && $theText == '') 
		{
			$this->db->delete('groups_descriptions', array('groups_id' => $news_id, 'lang_id' => $lang_id));
			return true;
		} 
		
		// if one of the title and the text is null then exit
		if($theTitle == '' || $theText == '') 
		{
			return false;
		}
		
		$query = $this->db->get_where('groups_descriptions', array('groups_id' => $news_id, 'lang_id' => $lang_id), 1, 0);
		if ($query->num_rows() == 0) 
		{
			// A record does not exist, insert one.
			$data = array(	'groups_id' 	=> $news_id, 
							'lang_id' 	=> $lang_id,
							'name'		=> $theTitle,
							'description'		=> $theText,
						);
			$query = $this->db->insert('groups_descriptions', $data);
			// Check to see if the query actually performed correctly
			if ($this->db->affected_rows() > 0) 
			{
				return TRUE;
			}
		} else {
			// A record does not exist, insert one.
			$data = array(	'name'		=> $theTitle,
							'description'		=> $theText,
						);
			$this->db->where('groups_id', $news_id);
			$this->db->where('lang_id', $lang_id);
			$this->db->update('groups_descriptions', $data);
			return true;
		}
		return FALSE;
	}
	
	function add_group_year($groups_id, $start_year, $stop_year, $user_list = array())
	{
		$query = $this->db->get_where('groups', array('id' => $groups_id), 1, 0);
		if ($query->num_rows() == 0)
			return false;
		
		$data = array(	'groups_id' 	=> $groups_id,
						'start_year'		=> $start_year,
						'stop_year'		=> $stop_year,
					);
		$query = $this->db->insert('groups_year', $data);
		$group_year_id = $this->db->insert_id();
		$this->add_users_to_group_year($group_year_id, $user_list);
		return $group_year_id;
		
	}
	
	function add_users_to_group_year($groups_year_id, $user_list = array()) 
	{
		$list = $user_list;
		
		if(!is_array($list))
		{
			return false;
		}
		
		$arr_keys = array_keys($list);
		if(!is_numeric($arr_keys[0])) 
		{
			$list = array($list);
		}
		
		foreach($list as &$l) 
		{
			$arr_keys = array_keys($l);
			if(!in_array("position",$arr_keys) || !in_array("user_id",$arr_keys)) {
				return false;
			}
			if(!in_array("email",$arr_keys)) {
				$l['email'] = '';
			}
			$l['groups_year_id'] = $groups_year_id;
		}
		
		$this->db->insert_batch('users_groups_year', $list); 
	}
}

