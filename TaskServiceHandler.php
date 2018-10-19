<?php

require_once 'TaskService.php';

header('Content-Type: application/json');

$result = array();

$taskService = new TaskService();

$result['request'] = $_POST;

$result['result'] = 'good';
echo json_encode($result);

?>
