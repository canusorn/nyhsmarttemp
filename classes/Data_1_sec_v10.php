<?php

/**
 * SQLite Create Table Demo
 */
class Data_1_sec_v10
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
            'CREATE TABLE IF NOT EXISTS \'1_sec\'(
                        	            voltage	REAL,
	                                    current	REAL,
	                                    power	REAL,
	                                    energy	REAL,
	                                    frequency	REAL,
	                                    pf	REAL,
	                                    time TEXT NOT NULL UNIQUE)',
            'CREATE INDEX IF NOT EXISTS time_index ON \'1_sec\' (time);'
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
        $sql = "INSERT INTO '1_sec' VALUES(:voltage,:current,:power,:energy,:frequency,:pf,:time)";
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


    public static function getByESPID($pdo, $esp_id, $columns = '*')
    {
        $sql = "SELECT {$columns}
                FROM '1_sec'
                ORDER BY 'time' DESC;";
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $stmt = $pdo->query($sql);
        //var_dump($sql);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function checkExist($pdo, $tablename)
    {
        $sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='{$tablename}'";
        //var_dump($sql);
        $stmt = $pdo->query($sql);
        return $stmt->fetch();
    }


    public static function getLast($esp_id, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_sec' ORDER BY time DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function delLast($esp_id)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "DELETE FROM '1_sec' WHERE time=(select max(time) from '1_sec')";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getMinEnergy($esp_id, $time)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT min(energy) 
        FROM '1_sec' 
        WHERE DATE(time) = DATE('{$time}');";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['min(energy)'];
        }
    }

    public static function getLastMulti($esp_id, $limit = 10, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_sec' ORDER BY time DESC LIMIT {$limit}";
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function getDaily($esp_id, $time)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT max(energy)-min(energy) 
                FROM '1_sec' 
                WHERE DATE(time) = DATE('{$time}');";
        //var_dump($sql);
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            return $result[0];
        }
    }

    public static function getAvMin($esp_id, $time)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT printf('%.1f',avg(voltage)),printf('%.3f',avg(current)),printf('%.1f',avg(power)),printf('%.3f',max(energy)),printf('%.1f',avg(frequency)),printf('%.2f',avg(pf))
                FROM '1_sec' 
                WHERE time LIKE '{$time}%';";
        //var_dump($sql);
        $stmt = $pdo->prepare($sql);
        //$stmt->bindValue(':esp_id', $esp_id);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            // var_dump($result);
            return $result;
        }
    }

    public static function getRange($esp_id, $start, $end, $columns = '*')
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/$esp_id.db");
        $sql = "SELECT $columns FROM '1_sec' 
        WHERE datetime(time) 
        BETWEEN datetime('{$start}') AND datetime('{$end}')
        ORDER BY time DESC";
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
        $sql = "DELETE FROM '1_sec' 
        WHERE date(time) <= date('now', '-" . SECDATALIMIT . " days')";
        $stmt = $pdo->prepare($sql);
        // $stmt->bindValue(':esp_id', $esp_id);
        return $stmt->execute();
    }
}
