<?php

/**
 * SQLite Create Table Demo
 */
class LineTimer
{

    private $pdo;
    public $esp_id;
    public $timer;
    public $flag;


    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'timer' . '\'(
                                        esp_id INTEGER NOT NULL UNIQUE,
	                                    timer TEXT,
                                        flag INTEGER DEFAULT 0,
                                        PRIMARY KEY("esp_id"))'
        ];
        //var_dump($commands);
        // execute the sql commands to create new tables
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

    public function create()
    {
        $sql = "replace into timer (esp_id, timer, flag) values('$this->esp_id', '$this->timer', '$this->flag');";
        // var_dump($sql);
        return  $this->pdo->exec($sql);
    }

    public function getLast($columns = '*')
    {
        $sql = "SELECT $columns FROM timer 
                WHERE esp_id = $this->esp_id";

        $stmt = $this->pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    
}
