<?php

/**
 * SQLite Create Table Demo
 */
class Data_1_day
{

    private $pdo;
    public $esp_id;
    public $voltage;
    public $current;
    public $power;
    public $energy;
    public $frequency;
    public $pf;
    public $time;

    public function __construct($esp_id)
    {
        $this->esp_id = $esp_id;
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'1_day\'(
                        	            voltage	REAL,
	                                    current	REAL,
	                                    power	REAL,
	                                    energy	REAL,
	                                    frequency	REAL,
	                                    pf	REAL,
	                                    time TEXT NOT NULL UNIQUE)',
            'CREATE INDEX IF NOT EXISTS time_index ON \'1_day\' (time);'
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

    public function insert()
    {
        $sql = "INSERT INTO '1_day' VALUES(:voltage,:current,:power,:energy,:frequency,:pf,:time)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':voltage', $this->voltage);
        $stmt->bindValue(':current', $this->current);
        $stmt->bindValue(':power', $this->power);
        $stmt->bindValue(':energy', $this->energy);
        $stmt->bindValue(':frequency', $this->frequency);
        $stmt->bindValue(':pf', $this->pf);
        $stmt->bindValue(':time', $this->time);
        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->errorInfo();
        }

        //$this->pdo->lastInsertId();
    }

    public static function getLast($esp_id, $limit = 1, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_day' ORDER BY time DESC LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getLastMulti($esp_id, $limit = 10, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_day' ORDER BY time DESC LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getRange($esp_id, $start, $end, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_day' 
        WHERE datetime(time) 
        BETWEEN datetime('{$start}') AND datetime('{$end}')
        ORDER BY time DESC LIMIT 49999";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getLastCostom($esp_id, $datetimerange, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_day' 
                WHERE date(time) >= date('now', '-" . $datetimerange .  "')";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function deleteOldData($esp_id)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "DELETE FROM '1_day' 
                WHERE date(time) <= date('now', '-" . DAYDATALIMIT . " years')";
        $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':esp_id', $esp_id);
        return $stmt->execute();
    }
    
    public function vacuum()
    {
        $sql = "VACUUM";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }
}
