<?php

require 'vendor/autoload.php'; 
    
date_default_timezone_set('America/Chicago');
    
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class TaskService {
    
    private $client;
    private $marshaler;
    public static $tableName = 'Tasks';
    
    public function __construct() {
        $this->client = new DynamoDbClient([
            'region' => 'us-east-2',
            'version' => 'latest'
        ]);
        $this->marshaler = new Marshaler();
    }

    public function getAllTasks() {    
        $params = [
            'TableName' => self::$tableName,
            'ProjectionExpression' => 'TaskId, Description, Completed'
        ];
    
        try {
            $result = $this->client->scan($params);
            
            $tasks = array();
                 
            foreach ($result['Items'] as $i) {
                $task = $this->marshaler->unmarshalItem($i);
                 
                $tasks[] = $task;
            }
        } catch (DynamoDbException $e) {
                echo "Unable to scan:\n";
                echo $e->getMessage() . "\n";
        }

        return $tasks;
    }

    public function getTask($taskId) {
        $key = $this->marshaler->marshalJson('
            {
                "TaskId": "' . $taskId . '"
            }
        ');

        $params = [
            'TableName' => self::$tableName,
            'Key' => $key
        ];

        try {
            $result = $this->client->getItem($params);
            return $result["Item"];
        } catch(DynamoDbException $e) {
            echo "Unable to get task:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function setComplete($taskId, $value) {
        $key = $this->marshaler->marshalJson('
                {
                    "TaskId": "' . $taskId . '"
                }
        '); 
        
        $eav = $this->marshaler->marshalJson('
                {
                    ":c": ' . $value . '
                }
        ');

        $params = [
            'TableName' => self::$tableName,
            'Key' => $key,
            'UpdateExpression' =>
                'set Completed = :c',
            'ExpressionAttributeValues' => $eav,
            'ReturnValues' => 'UPDATED_NEW'
        ];
    
        try {
            $result = $this->client->updateItem($params);
            return $result['Attributes'];
        } catch (DynamoDbException $e) {
            echo "Unable to update task:\n";
            echo $e->getMessage() . "\n";
        }
    }
}

?>
