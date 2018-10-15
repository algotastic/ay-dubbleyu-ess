<?php

require 'vendor/autoload.php'; 
    
date_default_timezone_set('America/Chicago');
    
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class TaskService {
    public function getAllTasks() {    
        $client = new DynamoDbClient([
            'region' => 'us-east-2',
            'version' => 'latest'
        ]);
    
        $marshaler = new Marshaler();
    
        $params = [
            'TableName' => 'Tasks',
            'ProjectionExpression' => 'TaskId, Description, Completed, ' .
                                        'CompleteByDateTime, CompletedDateTime'
        ];
    
        try {
            $result = $client->scan($params);
            
            $tasks = array();
                 
            foreach ($result['Items'] as $i) {
                $task = $marshaler->unmarshalItem($i);
                 
                $tasks[] = $task;
            }
        } catch (DynamoDbException $e) {
                echo "Unable to scan:\n";
                echo $e->getMessage() . "\n";
        }

        return $tasks;
    }
}

?>
