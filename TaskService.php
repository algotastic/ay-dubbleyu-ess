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
    
        echo "Scanning Tasks table.\n";
    
        try {
            while (true) {
                $result = $client->scan($params);
    
                foreach ($result['Items'] as $i) {
                    $task = $marshaler->unmarshalItem($i);
                    echo $task['TaskId'] . ': ' . $task['Description'] . 
                           ': complete by: ' . $task['CompleteByDateTime'] . 
                            ', Completed?: ' . $task['Completed'] . 
                            ', Time completed: ' . $task['CompletedDateTime'] . "\n";
                }
    
                if (isset($result['LastEvaluatedKey'])) {
                    $params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
                } else {
                    break;
                }
            }
        } catch (DynamoDbException $e) {
                echo "Unable to scan:\n";
                echo $e->getMessage() . "\n";
        }
    }
}

?>
