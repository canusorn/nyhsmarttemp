<?php

class Data_queue
{
    private $pdo;
    public $esp_id;
    public $project_id;
    public $time;

    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_queue.db");
        $this->createTables();
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) FROM esp_queue;";
        $stmt = $this->pdo->query($sql);
        return ($stmt->fetch(\PDO::FETCH_ASSOC))['COUNT(*)'];
    }

    public function create()
    {
        $sql = "replace into esp_queue values($this->esp_id, '{$this->project_id}', '{$this->time}');";
        return $this->pdo->exec($sql);
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE "esp_queue" (
                "esp_id"	INTEGER NOT NULL,
                "project_id"	TEXT,
                "time"	TEXT,
                PRIMARY KEY("esp_id")
            );',
            'CREATE TABLE "error" (
                "esp_id"	INTEGER NOT NULL,
                "project_id"	TEXT,
                "error"	TEXT,
                "time"	TEXT
            );'
        ];

        $error = [];
        foreach ($commands as $command) {
            if (!$this->pdo->exec($command)) {
                $error[] = 1;
            }
        }
        if (empty($error)) {
            return true;
        }
    }

    public function getLast($columns = '*')
    {
        $sql = "SELECT $columns FROM 'esp_queue' ORDER BY time DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->esp_id = $result['esp_id'];
            return $result;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM 'esp_queue' WHERE esp_id = $this->esp_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function moveToError($error)
    {
        if($this->createError($error)){
            $this->delete($this->esp_id);
        }
        
    }

    public function createError($error)
    {
        $sql = "replace into error values($this->esp_id, '{$this->project_id}', '$error' '{$this->time}');";
        return $this->pdo->exec($sql);
    }

    public function vacuum()
    {
        $sql = "VACUUM";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }
}
