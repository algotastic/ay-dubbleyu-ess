<?php
    require __DIR__ . '/vendor/autoload.php';
    require 'uuid.php';
    require 'TaskService.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <script type="text/javascript">
           $(document).ready(function(e) {
               $(".completed").change(function() {
                    if (this.checked) {
                        var returnVal = confirm("Are you sure?");
                        $(this).prop("checked", returnVal);
                    }
                });
           });
        </script>
    </head>
    <body>
        <h1>TO DO</h1>
    
        <p>This is a UUID v4: <?php echo UUID::v4();?></p>
        <?php 
        
        $taskService = new TaskService();
        $tasks = $taskService->getAllTasks();
        echo '<form>';
        foreach ($tasks as $task) {
            $checked = ($task['Completed']) ? ' checked' : '';
            echo '<input class="completed" type="checkbox" name="task' . $task['TaskId'] . '"'
                                                        . $checked
                 . '>'
                 . $task['Description'];
            echo '<br />';
        }
    
    
     ?>
    </body>
</html>
