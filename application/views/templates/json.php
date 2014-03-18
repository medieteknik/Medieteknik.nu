<?php

$output = array();

$output['result'] = $result;
$output['date'] = date('Y-m-d H:i:s');
$output['status'] = ($result ? 'success' : 'fail');
$output['message'] = isset($message) ? $message : '';

// format data
header("Content-type: application/json");

echo json_encode($output);
