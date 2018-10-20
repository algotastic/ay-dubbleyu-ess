<?php

    require_once 'TaskService.php';
    
    header('Content-Type: application/json');
    
    $result = array();
    
    $taskService = new TaskService();
    
    $result['request'] = $_POST;
    
    if (!isset($_POST['completed'])) {
        $result['error'] = 'No checkbox data!';
    }

    if (!isset($result['error'])) {
        foreach ($_POST['completed'] as $taskId => $isCheckedString) {
            $isChecked = $isCheckedString === 'true' ? true : false;
            $task = $taskService->getTask($taskId);
            if ($isChecked !== $task['Completed']['BOOL']) {
                $result[$taskId] = $taskService->setComplete($taskId, $isCheckedString);
            }
        }
    }
    
    echo json_encode($result);

?>
