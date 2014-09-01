<?php
$output = array();

$output['date'] = date('Y-m-d H:i:s');
$output['status'] = ($result ? 'success' : 'fail');
$output['message'] = isset($message) ? $message : '';
if(is_array($result))
	$output['count'] = count($result);
$output['result'] = $result;

// format data
header("Content-type: application/json");

echo json_encode($output);
