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
        <script type="text/javascript" src="form.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>TO DO</h1>
    
        <p>This is a UUID v4: <?php echo UUID::v4();?></p>
        <?php 
        
        $taskService = new TaskService();
        $tasks = $taskService->getAllTasks();?>
        <form id="taskForm">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>Tasks</th>
                        <th>Task ID</th>
                        <th>Checked</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $task) {
                          $checked = htmlspecialchars(($task['Completed']) ? ' checked' : ''); 
                          $taskId = htmlspecialchars($task['TaskId']); ?>
                    <tr>
                        <td>
                            <input id="<?php echo $taskId ?>" 
                                   name="completed[<?php echo $taskId ?>]"
                                   value="true" 
                                   class="completed"
                                   type="checkbox" 
                                   <?php echo ($checked); ?>>
                            <label for="completed[<?php echo $taskId ?>]">
                                <?php echo $task['Description'] ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $taskId ?>
                        </td>
                        <td>
                            <?php echo $checked ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <button type="submit">Submit</button>
        </form>
        <p id="output" />

        <script type="text/javascript">
            $(document).ready(function() {
                TASKS.form.init();
            });
        </script>
    </body>
</html>
