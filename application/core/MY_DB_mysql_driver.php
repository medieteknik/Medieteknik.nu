<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_DB_mysql_driver
 *
 * DB extension class to give various parsing
 * methods.  Generally speaking, these are
 * standard methods for converting a DB query
 * into an array/result.
 *
 * @author Simon Emms <simon@simonemms.com>
 */
class MY_DB_mysql_driver extends CI_DB_mysql_driver 
{
    final public function __construct($params) 
    {
        parent::__construct($params);
		
		$ci = & get_instance();
		$prim_abbr = $ci->config->item('language_abbr');
		$abbr_array = $ci->config->item('lang_uri_abbr');
		
		unset($abbr_array[$prim_abbr]);
		$sec_abbr = key($abbr_array);
		if($this->table_exists('language')) 
		{
			$query = $this->query("SELECT id FROM language WHERE language_abbr = '".$prim_abbr."' OR language_abbr = '".$sec_abbr."' ORDER BY FIELD(language_abbr, '".$prim_abbr."', '".$sec_abbr."')");
			$result = $query->result();
			$this->query("SET @primary_language_id = ".$result[0]->id.";");
			$this->query("SET @secondary_language_id = ".$result[1]->id.";");
		} else {
			$this->query("SET @primary_language_id = 1;");
			$this->query("SET @secondary_language_id = 2;");
		}
		
        log_message('debug', 'Extended DB driver class instantiated!');
    }
}
?>