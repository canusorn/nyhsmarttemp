<?php

class ControlPin{
    private $pdo;
    public $esp_id;
    public $pindata;
    public $needupdate;

    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/controlIO.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'pin' . '\'(
                                        esp_id INTEGER NOT NULL UNIQUE,
	                                    pindata TEXT NOT NULL,
                                        needupdate NUMERIC,
                                        PRIMARY KEY("esp_id"))',
            'CREATE INDEX IF NOT EXISTS esp_id_index ON \'' . 'pin' . '\' (esp_id);'
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
        $sql = "replace into pin (esp_id, pindata, needupdate) values('$this->esp_id', '$this->pindata', $this->needupdate);";
        // var_dump($sql);
        return  $this->pdo->exec($sql);
    }

    public function getLast($columns = '*')
    {
        $sql = "SELECT $columns FROM pin 
                WHERE esp_id = $this->esp_id";

        $stmt = $this->pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }
}