<?php
class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function validate($lukasid = '', $password = '')
	{
		$lid = preg_replace("/(@.*)/", "", $lukasid);
		
		$this->db->where('lukasid', $lid);
		$this->db->where('password_hash', encrypt_password($password));
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return $query;
		}
		return false;
		
	}
	
	function has_privilege($user_id, $privilege) {
		if(!is_array($privilege)) {
			$thePrivileges = array($privilege);
		} else {
			$thePrivileges = $privilege;
		}
		$first = true;
		
		$this->db->select("*");
		$this->db->from("privileges");
		$this->db->join("users_privileges", "users_privileges.privilege_id = privileges.id", "");
		$this->db->where("users_privileges.user_id", $user_id);
		$this->db->where_in("privileges.privilege_name ", $thePrivileges);
		/*
		foreach($thePrivileges as $p) {
			if($first) {
				$this->db->where("privileges.privilege_name ", $p);
				$first = false;
			} else {
				$this->db->or_where("privileges.privilege_name ", $p);
			}
		}
		*/
		
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			return true;
		}
		return false;
/*
SELECT * FROM privileges
JOIN users_privileges ON users_privileges.privilege_id = privileges.id
WHERE privileges.privilege_name = 'admin' AND users_privileges.user_id = '1'
*/
	}
    
    function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }
    
    function get_user_profile($id) {
		$this->db->select("*");
		$this->db->from("users");
		$this->db->join("users_data", "users.id = users_data.users_id", "left");
		$this->db->where("users.id", $id);
		$this->db->limit(1);
		$query = $this->db->get();
		$res = $query->result();
		$res = $res[0];
		return $res;
	}
	
	function get_user_privileges($id) {
		$this->db->select("*");
		$this->db->from("users_privileges");
		$this->db->join("privileges", "privileges.id = users_privileges.privilege_id", "");
		$this->db->where("users_privileges.user_id", $id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function lukasid_exists($lid = '') {
		$this->db->where('lukasid', $lid);
		$query = $this->db->get('users');
		if($query->num_rows == 1)
		{
			return true;
		}
		return false;
	}

	function add_user($fname = '', $lname = '', $lukasid ='', $password = '') {
		// fixing and trimming
		$fn = trim(preg_replace("/[^A-Za-z]/", "", $fname ));
		$ln = trim(preg_replace("/[^A-Za-z]/", "", $lname ));
		$lid = trim(preg_replace("/[^A-Za-z0-9]/", "", $lukasid ));
		$pwd = trim($password);
		
		// check lengths
		if(strlen($fn) > 0 && strlen($ln) > 0 && strlen($lid) == 8 && strlen($pwd) > 5) {
			// if lukas_id not exists insert user
			if(!$this->lukasid_exists($lid)) {
				$data = array(
				   'first_name' => $fn ,
				   'last_name' => $ln,
				   'lukasid' => $lid,
				   'password_hash' => encrypt_password($pwd)
				);
				$q = $this->db->insert('users', $data);
				return $q;
			}
		} else {
			// something was not correct
			return false;
		}
	}
}

