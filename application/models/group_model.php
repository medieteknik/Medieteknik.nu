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
		$this->db->select("*");
		$this->db->from("groups");
		$this->db->order_by("group_name ASC");
		$query = $this->db->get();
		
        return $query->result();
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
}

