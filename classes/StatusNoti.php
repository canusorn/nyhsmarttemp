<?php

class StatusNoti
{
    private $conn;
    private $path;
    private $prevTime;

    public function __construct()
    {
        $this->path = $_SERVER['DOCUMENT_ROOT'] . "/db/lastupdate.txt";
    }

    public function checkOnline($esp_id)
    {
        if ($esp_id) {
            $devices =  $this->getOnlineEspID($esp_id);
            if (!empty($devices)) {

                $db = new Database();
                $this->conn = $db->getConn();

                Linenotify::saveOnlineState($devices[0]['esp_id'], 1);

                Linenotify::sentOnline($this->conn, $devices[0]['esp_id'], $devices[0]['line_token']);
            }
        }
    }

    public function checkOffline()
    {
        if (file_exists($this->path)) {
            $this->prevTime = file_get_contents($this->path);
        } else {
            file_put_contents($this->path, time());
            $this->prevTime = 0;
        }

        if (time() - $this->prevTime >= OFFLINETIME) {
            file_put_contents($this->path, time());
            $this->NotiOffline();
        }
        // $this->NotiOffline();
    }

    private function NotiOffline()
    {
        // get all device need to notify when offline
        $devices = $this->getOfflineEspID();
        // var_dump($devices);
        if (!empty($devices)) {
            $db = new Database();
            $this->conn = $db->getConn();

            // split to esp_id only
            $checkdevice = [];
            foreach ($devices as $value) {
                $checkdevice[] = $value['esp_id'];
            }

            // device offline and no notify
            $devices_to_offline = $this->getEspOffline($checkdevice);
            // echo "<br>devicetonoti:";
            // var_dump($devices_to_offline);

            $device_to_alert = [];
            foreach ($devices as $device) {
                foreach ($devices_to_offline as $offline) {
                    if ($device['esp_id'] == $offline['esp_id']) {
                        $device_to_alert[] = $device;
                        // var_dump($offline['esp_id']);
                        try {
                            Linenotify::saveOnlineState($offline['esp_id'], 0);
                        } catch (Throwable | Exception $e) {
                            // echo $e->getMessage() . "<br>";
                        }
                    }
                }
            }


            // var_dump($device_to_alert);

            foreach ($device_to_alert as $device) {
                Linenotify::sentOffline($this->conn, $device['esp_id'], $device['line_token']);
            }
        }
    }

    private function getOfflineEspID()
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        $sql = "SELECT  esp_id, line_token
        FROM '1'
        WHERE offline_notify = 1  AND online_state = 1
        UNION
        SELECT  esp_id, line_token
        FROM '2'
        WHERE offline_notify = 1 AND online_state = 1
        UNION
        SELECT  esp_id, line_token
        FROM '4'
        WHERE offline_notify = 1 AND online_state = 1
        UNION
        SELECT  esp_id, line_token
        FROM '5'
        WHERE offline_notify = 1 AND online_state = 1";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getOnlineEspID($esp_id)
    {
        $pdo = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/db/line_user_data.db");
        $sql = "SELECT  esp_id, line_token
        FROM '1'
        WHERE offline_notify = 1  AND online_state = 0 AND esp_id = $esp_id
        UNION
        SELECT  esp_id, line_token
        FROM '2'
        WHERE offline_notify = 1 AND online_state = 0 AND esp_id = $esp_id
        UNION
        SELECT  esp_id, line_token
        FROM '4'
        WHERE offline_notify = 1 AND online_state = 0 AND esp_id = $esp_id
        UNION
        SELECT  esp_id, line_token
        FROM '5'
        WHERE offline_notify = 1 AND online_state = 0 AND esp_id = $esp_id";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function getEspOffline($devices)
    {
        // echo "<br>devicetonoti:";
        // var_dump($devices);
        $devices = Esp_ID::getOffline($this->conn, $devices);
        return $devices;
    }
}
