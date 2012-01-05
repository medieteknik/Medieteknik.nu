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
class MY_DB_mysql_driver extends CI_DB_mysql_driver {
    final public function __construct($params) {
        parent::__construct($params);
        log_message('debug', 'Extended DB driver class instantiated!');
    }

	final public function get_select_lang($in, $prim = 'se', $sec  = "en")
	{
		$q = " ";
		if(is_array($in)) {
			foreach($in as $a) {
				$q .= ", COALESCE(".$a."_".$prim.",".$a."_".$sec.") as ".$a." ";
			}
		} else {
			$q .= ", COALESCE(".$a."_".$prim.",".$a."_".$sec.") as ".$a." ";
		}
		return $q;
		
	}
	final public function get_join_language($table, $cond1, $cond2, $lang = '', $in)
	{
		
		$prim = $lang;
		$name = $table."_".$lang;
		
		$q = "LEFT JOIN (SELECT ". $cond1 . " ";
		if(is_array($in)) {
			foreach($in as $a) {
				$q .= "," . $a . " as ". $a . "_". $prim;
			}
		} else {
			$q .= $in . " as ". $in . "_". $prim;
		}
		$q .= " FROM " . $table ." JOIN language ON ".$table.".lang_id = language.id WHERE language.language_abbr =  '".$prim."') as ".$name." ON ".$name.".".$cond1." = ". $cond2 . " ";
		
		return $q;
		
	}
}
?>