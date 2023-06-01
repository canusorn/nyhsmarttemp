<?php

class Data_noauth
{
    public static function create($email, $esp_id, $project_id, $time)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/data_noauth.db");
        $sql="replace into esp_id values($esp_id, '{$email}', $project_id, '{$time}' );";
        return $pdo->exec($sql);
    }


    public function createTables()
    {
        $commands = [
            'CREATE TABLE "esp_id" (
                "esp_id"	INTEGER NOT NULL,
                "email"	TEXT,
                "project_id"	INTEGER,
                "time"	TEXT,
                PRIMARY KEY("esp_id")
            );',
            'CREATE INDEX IF NOT EXISTS esp_id_index ON \'' . 'control_io' . '\' (esp_id);'
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
}
