<?php

/**
 * SQLite Create Table Demo
 */
class Data_5_day
{

    private $pdo;
    public $esp_id;
    public $humid;
    public $temp;
    public $vbatt;
    public $valve;
    public $time;

    public function __construct()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_5_day.db");
    }

    public function createTables()
    {
        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . $this->esp_id . '\'(
                humid	REAL,
                temp	REAL,
                vbatt	REAL,
                valve	REAL,
                time TEXT NOT NULL UNIQUE)',
'CREATE INDEX IF NOT EXISTS time_index ON \'' . $this->esp_id . '\' (time);'
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
        $sql = "INSERT INTO '{$this->esp_id}' VALUES(:humid,:temp,:vbatt,:valve,:time)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':humid', $this->humid);
        $stmt->bindValue(':temp', $this->temp);
        $stmt->bindValue(':vbatt', $this->vbatt);
        $stmt->bindValue(':valve', $this->valve);
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
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_5_day.db");
        $sql = "SELECT $columns FROM '{$esp_id}' ORDER BY time DESC LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getLastMulti($esp_id, $limit = 10, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_5_day.db");
        $sql = "SELECT $columns FROM '{$esp_id}' ORDER BY time DESC LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getRange($esp_id, $start,$end, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_5_day.db");
        $sql = "SELECT $columns FROM '{$esp_id}' 
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

    public static function deleteOldData($esp_id){
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_5_day.db");
        $sql = "DELETE FROM '{$esp_id}' 
        WHERE date(time) <= date('now', '-" . DAYDATALIMIT . " years')";
        $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':esp_id', $esp_id);
        return $stmt->execute();
    }

}
