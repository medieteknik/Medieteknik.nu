<?php

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