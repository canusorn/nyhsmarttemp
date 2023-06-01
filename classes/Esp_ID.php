<?php
class Esp_ID
{
    public $esp_id;
    public $device_name = "new device";
    public $user_id;
    public $project_id;
    public $version;

    public function create($conn)
    {

        $sql = "INSERT INTO esp_id (esp_id, device_name, user_id, project_id, version)
                VALUES(:esp_id,:device_name,:user_id,:project_id,:version)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':esp_id', $this->esp_id, PDO::PARAM_INT);
        $stmt->bindValue(':device_name', $this->device_name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(':project_id', $this->project_id, PDO::PARAM_STR);
        $stmt->bindValue(':version', $this->version, $this->version == null ? PDO::PARAM_NULL : PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function getAllByUSERID($conn, $user_id, $columns = 'esp_id.esp_id,esp_id.device_name,esp_id.project_id,esp_id.version,esp_id.need_ota,project_id.project_name,user.email,user.position')
    {
        $sql = "SELECT $columns FROM 
        ((esp_id
         JOIN project_id ON esp_id.project_id = project_id.project_id AND user_id = $user_id)
         JOIN user ON esp_id.user_id=user.user_id)";

        $result = $conn->query($sql);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($data);
        return $data;
    }

    public static function getByESPID($conn, $esp_id, $columns = '*', $fetch = "class")
    {
        $sql = "SELECT $columns
        FROM esp_id
        WHERE esp_id = :esp_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);

        if ($fetch == "class") {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Esp_ID');
            if ($stmt->execute()) {
                return $stmt->fetch();
            }
        } elseif ($fetch == "array") {
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
    }


    public static function getDevice($conn, $user_id, $columns = '*')
    {
        $sql = "SELECT $columns
    FROM esp_id
    WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Esp_ID');

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function update($conn)
    {

        $sql = "UPDATE esp_id
                SET user_id = :user_id,
                    project_id = :project_id,
                    device_name = :device_name,
                    version = :version
                WHERE esp_id = :esp_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(':project_id', $this->project_id, PDO::PARAM_STR);
        $stmt->bindValue(':device_name', $this->device_name, PDO::PARAM_STR);
        $stmt->bindValue(':version', $this->version, $this->version == null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':esp_id', $this->esp_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function rename($conn, $esp_id, $device_name)
    {

        $sql = "UPDATE esp_id
                SET device_name = :device_name
                WHERE esp_id = :esp_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':device_name', $device_name, PDO::PARAM_STR);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function lastTimeUpdate($conn, $esp_id, $time)
    {

        $sql = "UPDATE esp_id
                SET lastupdate = :time
                WHERE esp_id = :esp_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':time', $time, PDO::PARAM_STR);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function setNeedOTA($conn, $esp_id, $valve)
    {

        $sql = "UPDATE esp_id
                SET need_ota = :valve
                WHERE esp_id = :esp_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':valve', $valve, PDO::PARAM_INT);
        $stmt->bindValue(':esp_id', $esp_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function getOffline($conn, $esp_id = NULL, $time = NULL)
    {
        if (is_null($time)) {
            date_default_timezone_set('Asia/Bangkok');
            $dateTime = new DateTime('-' . OFFLINETIME . ' seconds');
            $time = $dateTime->format('Y-m-d H:i:s');
        }
        $sql = "SELECT esp_id FROM `esp_id` WHERE time(lastupdate) < '$time' AND lastupdate IS NOT NULL";

        if (!is_null($esp_id)) {
            if (is_int($esp_id))
                $sql .= " AND esp_id = $esp_id";
            else if (is_array($esp_id) && !empty($esp_id)) {
                $sql .= " AND (";
                foreach ($esp_id as $i => $id) {
                    if ($i) $sql .= " OR ";
                    $sql .= "esp_id = " . $id;
                }
                $sql .= ")";
            }
        }
        // echo "<br>sql:";
        // var_dump($sql);
        $result = $conn->query($sql);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        // echo "<br>datafrommysql:";
        // var_dump($data);
        return $data;
    }

    /*public static function getByUserID($conn, $user_id, $columns = '*')
    {
        $sql = "SELECT $columns
        FROM esp_id
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Esp_ID');

        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }*/
}
