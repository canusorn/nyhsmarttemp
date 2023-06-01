<?php

/**
 * SQLite Create Table Demo
 */
class ControlIO
{

    private $pdo;
    public $esp_id;
    public $io;
    public $time;
    public $needupdate;


    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/controlIO.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'output' . '\'(
                                        esp_id INTEGER NOT NULL UNIQUE,
                        	            io	INTEGER,
                                        needupdate NUMERIC,
	                                    time TEXT NOT NULL,
                                        PRIMARY KEY("esp_id"))',
            'CREATE INDEX IF NOT EXISTS esp_id_index ON \'' . 'output' . '\' (esp_id);'
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
        $sql="replace into output (esp_id, io, needupdate, time) values($this->esp_id, $this->io, $this->needupdate, '{$this->time}' );";
        // var_dump($sql);
        return $this->pdo->exec($sql);
    }

    public function getLast($columns= '*')
    {
        $sql = "SELECT $columns FROM output 
                WHERE esp_id = $this->esp_id
                ORDER BY time DESC LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }
}