<?php
    require __DIR__ . '/vendor/autoload.php';
    require 'uuid.php';
    require 'TaskService.php';
?>
<!DOCTYPE html>
<html>
    <h1>TO DO</h1>

    <p>This is a UUID v4: <?php echo UUID::v4();?></p>
    <?php echo __DIR__;
    
    $taskService = new TaskService();
    $taskService->getAllTasks();

 ?>
</html>
