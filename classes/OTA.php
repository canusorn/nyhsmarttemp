<?php

class OTA
{
    private $pdo;
    private $server;

    public function __construct()
    {
    }



    public function check_header($name, $value = false)
    {
        if (!isset($_SERVER[$name])) {
            return false;
        }
        if ($value && $_SERVER[$name] != $value) {
            return false;
        }
        return true;
    }

    public function sendFile($path)
    {
        header($_SERVER["SERVER_PROTOCOL"] . ' 200 OK', true, 200);
        header('Content-Type: application/octet-stream', true);
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Length: ' . filesize($path), true);
        header('x-MD5: ' . md5_file($path), true);
        readfile($path);
    }

    public function createTables()
    {
        $this->pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/firmware.db");

        $commands = [
            'CREATE TABLE IF NOT EXISTS \'' . 'firmware' . '\'(
                                        project_id TEXT NOT NULL,
                        	            optional_sensor	TEXT,
                                        lastversion NUMERIC NOT NULL,
                                        path TEXT NOT NULL,
	                                    time TEXT DEFAULT CURRENT_TIMESTAMP)',
            'CREATE TABLE IF NOT EXISTS \'' . 'esp' . '\'(
                                        esp_id INTEGER UNIQUE,
                                        project_id TEXT NOT NULL,
                                        optional_sensor	TEXT,
                                        lastversion NUMERIC NOT NULL,
                                        path TEXT NOT NULL,
                                        time TEXT DEFAULT CURRENT_TIMESTAMP,
                                        note TEXT)'
        ];
        // var_dump($commands);exit;

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

    public function getBin($project_id, $optional_sensor = "")
    {
        $this->createTables();

        $sql = "SELECT * 
          FROM firmware
          WHERE project_id = :project_id";

        if ($optional_sensor != "") {
            $sql .= " AND optional_sensor = :optional_sensor";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_STR);
        if ($optional_sensor != "") {
            $stmt->bindValue(':optional_sensor', $optional_sensor, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result;
        }
    }

    public function getBinByID($esp_id,$project_id, $optional_sensor = "")
    {
        $this->createTables();

        $sql = "SELECT * 
          FROM esp
          WHERE esp_id = :esp_id
          AND project_id = :project_id";

        if ($optional_sensor != "") {
            $sql .= " AND optional_sensor = :optional_sensor";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_STR);
        if ($optional_sensor != "") {
            $stmt->bindValue(':optional_sensor', $optional_sensor, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result;
        }
    }

    public static function getLastVersion($project_id)
    {
        // self::createTables();

        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/firmware.db");

        $sql = "SELECT lastversion 
        FROM firmware
        WHERE project_id = :project_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result["lastversion"];
        }
    }
}
