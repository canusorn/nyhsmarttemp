<?php

require '../includes/init.php';

if (isset($_REQUEST['email'])) {

    // delete spacebar
    $email = trim($_REQUEST['email'], " ");

    $db = new Database();
    $conn = $db->getConn();

    //authen user
    $user_id = User::authenticate($conn, $email, $_REQUEST['pass']);

    //if have this user
    if ($user_id >= 1) {

        //check this esp_id are already
        $esp_id = Esp_ID::getByESPID($conn, $_REQUEST['esp_id']);

        //if have in database
        if ($esp_id) {
            // if already user
            if (isset($esp_id->user_id)) {
                // if same user id and project_id
                if (
                    $esp_id->esp_id == $_REQUEST['esp_id']
                    && $esp_id->project_id == $_REQUEST['project_id']
                    && $esp_id->user_id == $user_id
                    && (!isset($_REQUEST['version']) || $esp_id->version == $_REQUEST['version'])
                ) {
                    echo ($esp_id->user_id);
                }

                // if not same user id or project id replace new data
                else {
                    $device_name = $esp_id->device_name;
                    $esp_id = new Esp_ID();
                    $esp_id->esp_id = $_REQUEST['esp_id'];
                    $esp_id->user_id = $user_id;
                    $esp_id->project_id = $_REQUEST['project_id'];
                    $projectname = Projectname::getName($conn, $_REQUEST['project_id']);
                    if ($device_name == "" || is_nan($device_name))
                        $esp_id->device_name = $projectname  . '-' .  $_REQUEST['esp_id'];
                    else $esp_id->device_name = $device_name;
                    $esp_id->version = (isset($_REQUEST['version']) ? $_REQUEST['version'] : null);
                    $esp_id->update($conn);
                    echo $user_id;
                }
            }

            // if no user
            else {
                // regis new espid to userid
                $esp_id = new Esp_ID();
                $esp_id->esp_id = $_REQUEST['esp_id'];
                $esp_id->user_id = $user_id;
                $esp_id->project_id = $_REQUEST['project_id'];
                $projectname = Projectname::getName($conn, $_REQUEST['project_id']);
                $esp_id->device_name = $projectname['project_name'] . '-' . $_REQUEST['esp_id'];
                $esp_id->version = (isset($_REQUEST['version']) ? $_REQUEST['version'] : null);
                $esp_id->update($conn);
                echo $user_id;

                // set offset energy
            }
        } else {
            if (ALLOWNEWESPID) {
                $esp_id = new Esp_ID();
                $esp_id->esp_id = $_REQUEST['esp_id'];
                $esp_id->user_id = $user_id;
                $esp_id->project_id = $_REQUEST['project_id'];
                $projectname = Projectname::getName($conn, $_REQUEST['project_id']);
                $esp_id->device_name = $projectname['project_name'] . '-' . $_REQUEST['esp_id'];
                $esp_id->version = (isset($_REQUEST['version']) ? $_REQUEST['version'] : null);
                $esp_id->create($conn);
                echo $user_id;
            } else {
                date_default_timezone_set('Asia/Bangkok');
                $dateTime = new DateTime();
                $time = $dateTime->format('Y-m-d H:i:s');
                Data_noauth::create($email, $_REQUEST['esp_id'], $_REQUEST['project_id'], $time);
                echo "no auth device";
            }
        }
    }
    //if wrong password
    else {
        echo $user_id;
        Auth::saveLogNoAuth("logindevice:" . $user_id);
    }
}
