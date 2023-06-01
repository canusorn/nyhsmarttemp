<?php

class Linenotify
{

    public static function createTables($project_id)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        if ($project_id == 0) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 1) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 2) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 3) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 4) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 5) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        } else if ($project_id == 6) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS \'' . $project_id . '\'(
                "esp_id"	INTEGER NOT NULL UNIQUE,
                "line_token"	TEXT,
                "daily_notify"	INTEGER COLLATE BINARY,
                "offline_notify"	INTEGER COLLATE BINARY,
                "online_state"	INTEGER COLLATE BINARY,
                "online_notify"	INTEGER COLLATE BINARY,
                PRIMARY KEY("esp_id")
            )'
            ];
            //var_dump($commands);
        }

        // execute the sql commands to create new tables
        $error = [];
        foreach ($commands as $command) {
            if (!$pdo->exec($command)) {
                $error[] = 1;
            }
        }
        if (empty($error)) {
            return true;
        }
    }

    public static function getToken($esp_id, $project_id)
    {
        self::createTables($project_id);
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        $sql = "SELECT line_token 
          FROM '$project_id'
          WHERE esp_id = :esp_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['line_token'];
        }
    }

    public static function getAll($esp_id, $project_id)
    {
        self::createTables($project_id);
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        $sql = "SELECT *
          FROM '$project_id'
          WHERE esp_id = :esp_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    public static function saveSetting($esp_id, $project_id, $token, $dailynotify = 1, $offlinenotify = 0, $onlinestate = 1)
    {
        self::createTables($project_id);
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        $sql = "REPLACE INTO '$project_id'(esp_id,line_token,daily_notify,offline_notify,online_state)
                VALUES(:esp_id,:line_token,:daily_notify,:offline_notify,:online_state)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);
        $stmt->bindValue(':line_token', $token, PDO::PARAM_STR);
        $stmt->bindValue(':daily_notify', $dailynotify, PDO::PARAM_BOOL);
        $stmt->bindValue(':offline_notify', $offlinenotify, PDO::PARAM_BOOL);
        $stmt->bindValue(':online_state', $onlinestate, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public static function saveOnlineState($esp_id, $onlinestate)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");

        $ids = [1, 2, 4, 5];
        foreach ($ids as $id) {
            try {
                $sql = "UPDATE '$id'
                    SET online_state = $onlinestate
                    WHERE esp_id = $esp_id";

                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            } catch (Throwable | Exception $e) {
                // echo $e->getMessage() . "<br>";
            }
        }
    }

    public static function getCode($esp_id)
    {
        $client_id = 'nO6GipSo72tHnd7wh4FRhe';
        $api_url = 'https://notify-bot.line.me/oauth/authorize?';
        $callback_url = 'https://iotkiddie.com/dashboard/linetoken_get.php';

        $query = [
            'response_type' => 'code',
            'client_id' => $client_id,
            'redirect_uri' => $callback_url,
            'scope' => 'notify',
            'state' => $esp_id
        ];

        header("Location: " . $api_url . http_build_query($query));
        exit;
    }

    public static function getAccessToken()
    {

        $client_id = 'nO6GipSo72tHnd7wh4FRhe';
        $client_secret = '39tSqi9mRfvlLSMOo8DhZOzdRYWeEREO88IuBW2QF8U';

        $api_url = 'https://notify-bot.line.me/oauth/token';
        $callback_url = 'https://iotkiddie.com/dashboard/linetoken_get.php';

        parse_str($_SERVER['QUERY_STRING'], $queries);

        //var_dump($queries);
        $fields = [
            'grant_type' => 'authorization_code',
            'code' => $queries['code'],
            'redirect_uri' => $callback_url,
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $res = curl_exec($ch);
            curl_close($ch);

            if ($res == false)
                throw new Exception(curl_error($ch), curl_errno($ch));

            $json = json_decode($res, true);

            // var_dump($json);
            // exit;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            //var_dump($e);
        }
        return $json;
    }

    public static function sentOffline($conn, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : อุปกรณ์ออฟไลน์";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            // echo "status : " . $result_['status'];
            // echo " message : " . $result_['message'];
        }
        curl_close($chOne);
    }


    public static function sentOnline($conn, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : อุปกรณ์ออนไลน์แล้ว";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            // echo "status : " . $result_['status'];
            // echo " message : " . $result_['message'];
        }
        curl_close($chOne);
    }

    public static function sentCustom($conn, $c0, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $data_sec = new Data_0_sec($esp_id);
        $label = json_decode(($data_sec->getLabel())['label']);

        $sMessage = $device . " : ค่าเฉลี่ยประจำวัน\n" . $label->c0 . " : " . round($c0, 1);
        if (!is_null($c1) && $c1 != "0.0") $sMessage .= "\n" . $label->c1 . " : " . round($c1, 1);
        if (!is_null($c2) && $c2 != "0.0") $sMessage .= "\n" . $label->c2 . " : " . round($c2, 1);
        if (!is_null($c3) && $c3 != "0.0") $sMessage .= "\n" . $label->c3 . " : " . round($c3, 1);
        if (!is_null($c4) && $c4 != "0.0") $sMessage .= "\n" . $label->c4 . " : " . round($c4, 1);
        if (!is_null($c5) && $c5 != "0.0") $sMessage .= "\n" . $label->c5 . " : " . round($c5, 1);
        if (!is_null($c6) && $c6 != "0.0") $sMessage .= "\n" . $label->c6 . " : " . round($c6, 1);
        if (!is_null($c7) && $c7 != "0.0") $sMessage .= "\n" . $label->c7 . " : " . round($c7, 1);
        if (!is_null($c8) && $c8 != "0.0") $sMessage .= "\n" . $label->c8 . " : " . round($c8, 1);
        if (!is_null($c9) && $c9 != "0.0") $sMessage .= "\n" . $label->c9 . " : " . round($c9, 1);

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
    }

    public static function sentCustomTime($conn, $c0, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $data_sec = new Data_0_sec($esp_id);
        $label = json_decode(($data_sec->getLabel())['label']);

        date_default_timezone_set('Asia/Bangkok');
        $dateTime = new DateTime();

        $sMessage = $device . " : " . $dateTime->format('H:i d/m/Y') . "\n" . $label->c0 . " : " . round($c0, 1);
        if (!is_null($c1) && $c1 != "0.0") $sMessage .= "\n" . $label->c1 . " : " . round($c1, 1);
        if (!is_null($c2) && $c2 != "0.0") $sMessage .= "\n" . $label->c2 . " : " . round($c2, 1);
        if (!is_null($c3) && $c3 != "0.0") $sMessage .= "\n" . $label->c3 . " : " . round($c3, 1);
        if (!is_null($c4) && $c4 != "0.0") $sMessage .= "\n" . $label->c4 . " : " . round($c4, 1);
        if (!is_null($c5) && $c5 != "0.0") $sMessage .= "\n" . $label->c5 . " : " . round($c5, 1);
        if (!is_null($c6) && $c6 != "0.0") $sMessage .= "\n" . $label->c6 . " : " . round($c6, 1);
        if (!is_null($c7) && $c7 != "0.0") $sMessage .= "\n" . $label->c7 . " : " . round($c7, 1);
        if (!is_null($c8) && $c8 != "0.0") $sMessage .= "\n" . $label->c8 . " : " . round($c8, 1);
        if (!is_null($c9) && $c9 != "0.0") $sMessage .= "\n" . $label->c9 . " : " . round($c9, 1);

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
    }

    public static function sentEnergy($conn, $energy, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : เมื่อวานใช้ไฟไป " . round($energy, 3) . " หน่วย[kWh]";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
    }

    public static function sentPm($conn, $pm1, $pm2, $pm10, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : ค่าฝุ่นเฉลี่ยสำหรับเมื่อวานนี้\nPM1.0: " . $pm1 . " ug/m3\nPM2.5: " . $pm2 . " ug/m3\nPM10.0: " . $pm10 . " ug/m3";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
    }

    public static function sentDHT($conn, $humid, $temp, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : ค่าเฉลี่ยสำหรับเมื่อวานนี้\nความชื้น: " . $humid .  " RH\nอุณหภูมิ: " . $temp . " °C";
        // $sMessage = $device . "test";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
    }

    public static function sentSmartFarmSolar($conn, $humid, $temp, $valve, $esp_id, $sToken)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");

        if (!is_null($esp_name = Esp_ID::getByESPID($conn, $esp_id))) {
            $device = $esp_name->device_name;
        } else {
            $device = $esp_id;
        }

        $sMessage = $device . " : ค่าเฉลี่ยสำหรับเมื่อวานนี้\nความชื้น: " . $humid .  " RH\nอุณหภูมิ: " . $temp . " °C\nรดน้ำ: " . $valve . " นาที";
        // $sMessage = $device . "test";

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);

        //Result error 
        if (curl_error($chOne)) {
            // echo 'error:' . curl_error($chOne);
            curl_close($chOne);
            return "error:" . curl_error($chOne);
        } else {
            $result_ = json_decode($result, true);
            curl_close($chOne);
            if ($result_['status'] == 200) {
                return "success";
            } else {
                return "error:" . $result_['status'];
            }
        }
        curl_close($chOne);
    }
}
