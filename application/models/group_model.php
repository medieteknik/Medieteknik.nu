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
		//$this->db->where('groups.sub_to_id', 0);
		$query = $this->db->get();
		
        return $query->result();
    }
	
	function get_group_name($name, $lang = 'se') {
		if (preg_match ('/[^A-Za-z0-9_]/i', $name)) {
		    return null;
		}
		
		$use_name = uncompact_name($name);
		
		//echo $use_name;
		
		$query = $this->db->query("
			SELECT groups.id, groups.group_name, groups_descriptions.description FROM groups
			LEFT JOIN groups_descriptions ON groups.id = groups_descriptions.group_id
			LEFT JOIN language ON groups_descriptions.lang_id = language.id
			WHERE groups.id IN (SELECT groups.id FROM groups WHERE groups.group_name REGEXP '^(".$use_name.")$' ) AND (language.language_abbr = '".$lang."' OR language.language_abbr IS NULL)
			LIMIT 1
		");
		
	    return $query->result();
		/*
		$this->db->select("groups.id, groups.group_name, groups_descriptions.description");
		$this->db->from("groups");
		$this->db->join("groups_descriptions", 'groups.id = groups_descriptions.group_id', 'left');
		$this->db->join("language", 'groups_descriptions.lang_id = language.id', 'left');
		$this->db->like('groups.group_name', $name, 'none');
		$this->db->where('language.language_abbr', $lang);
		$this->db->or_where('language.language_abbr IS NULL');
		$this->db->limit(1);
		$query = $this->db->get();

	    return $query->result();
	*/
/*
SELECT groups.id, groups.group_name, groups_descriptions.description FROM groups
LEFT JOIN groups_descriptions ON groups.id = groups_descriptions.group_id
LEFT JOIN language ON groups_descriptions.lang_id = language.id
WHERE groups.group_name LIKE 'styrelsen_2011_2012' AND language.language_abbr = 'se' OR language.language_abbr IS NULL

SELECT groups.id, groups.group_name, groups_descriptions.description FROM groups
LEFT JOIN groups_descriptions ON groups.id = groups_descriptions.group_id
LEFT JOIN language ON groups_descriptions.lang_id = language.id
WHERE groups.group_name REGEXP 'styrelsen' AND language.language_abbr = 'se' OR language.language_abbr IS NULL

SELECT groups.id, groups.group_name, groups_descriptions.description FROM groups
LEFT JOIN groups_descriptions ON groups.id = groups_descriptions.group_id
LEFT JOIN language ON groups_descriptions.lang_id = language.id
WHERE groups.id IN (SELECT groups.id FROM groups WHERE groups.group_name REGEXP '^(styrelsen)$' ) AND language.language_abbr = 'se' OR language.language_abbr IS NULL

*/
	}
}

