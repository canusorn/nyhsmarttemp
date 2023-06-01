<?php

/**
 * SQLite Create Table Demo
 */
class ControlTimer
{

    private $pdo;
    public $esp_id;
    public $timedata;
    public $needupdate;


    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/controlIO.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'timer' . '\'(
                                        esp_id INTEGER NOT NULL UNIQUE,
	                                    timedata TEXT NOT NULL,
                                        needupdate NUMERIC,
                                        PRIMARY KEY("esp_id"))',
            'CREATE INDEX IF NOT EXISTS esp_id_index ON \'' . 'timer' . '\' (esp_id);'
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
        $sql = "replace into timer (esp_id, timedata, needupdate) values('$this->esp_id', '$this->timedata', $this->needupdate);";
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
