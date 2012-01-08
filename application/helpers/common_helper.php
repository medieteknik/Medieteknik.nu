<?php

function encrypt_password($password) {
	$salt = 'MT_sillystring_as_sal';
	if(CRYPT_SHA512 == 1){
		return substr(crypt($password, '$6$rounds=10000$'.$salt.'$'),33);
	}
	if (CRYPT_SHA256 == 1) {
	    return substr(crypt($password, '$5$rounds=10000$'.$salt.'$'),33);
	}
	if (CRYPT_MD5 == 1) {
	    return substr(crypt($password, '$1$'.$salt.'$'),12);
	}
	
	return false;
}

function get_full_name($arr) {
	$fullname = '';
	if(isset($arr->first_name)) $fullname .= $arr->first_name;
	if(isset($arr->last_name)) $fullname .= " ". $arr->last_name;
	return trim($fullname);
}

function readable_date($date, $lang = '') {
	if($lang == '') {
		$lang = array('date_today' => 'Idag', 'date_yesterday' => 'Igår');
	}
	
	$theDate = new DateTime($date);
	$today = new DateTime(date("Y-m-d H:i:s"));
	$interval = $theDate->diff($today);
	$n = $interval->format("%a"); // get total number of days that differ (always positive number)
	
	$string = '';
	if($n == 0) {
		$string = $lang['date_today'] . " " . $theDate->format('H:i');
	} else if ($n == 1) {
		$string = $lang['date_yesterday'] . " " . $theDate->format('H:i');
	} else {
		$string = $theDate->format('Y-m-d H:i');
	}
	return $string;
}

function compact_name($name) {
	$string = strtolower($name);
	$string = preg_replace("/(å|ä)/","a",$string);
	$string = preg_replace("/(ö)/","o",$string);
	return preg_replace("/[^A-Za-z0-9_]/","_",strtolower($string));
}

function uncompact_name($name) {
	$string = preg_replace("/^_*/", "", $name);
	$string = preg_replace("/_*$/", "", $string);
	$string = preg_replace("/[_]+/i", ".{1}", $string);
	$string = preg_replace("/a/i", "(a|å|ä){1}", $string);
	return preg_replace("/o/i", "(o|ö){1}", $string);
}