<?php
class Group_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_all_groups()
    {
		$this->db->select("*");
		$this->db->from("groups");
		$this->db->order_by("group_name ASC");
		$query = $this->db->get();
		
        return $query->result();
    }
	
	function get_group_name($name, $lang = 'se') {
		$mod_name = preg_replace("/\_/", " ", $name);
		
		$this->db->select("groups.id, groups.group_name, groups_descriptions.description");
		$this->db->from("groups");
		$this->db->join("groups_descriptions", 'groups.id = groups_descriptions.group_id', '');
		$this->db->join("language", 'groups_descriptions.lang_id = language.id', '');
		$this->db->like('groups.group_name', $mod_name, 'none');
		$this->db->where('language.language_abbr', $lang);
		$this->db->limit(1);
		$query = $this->db->get();

	    return $query->result();
/*
SELECT groups.id, groups.group_name, groups_descriptions.description FROM groups
JOIN groups_descriptions ON groups.id = groups_descriptions.group_id
JOIN language ON groups_descriptions.lang_id = language.id
WHERE groups.group_name LIKE 'medietekniksektionens styrelse' AND language.language_abbr = 'se'
*/
	}
}

