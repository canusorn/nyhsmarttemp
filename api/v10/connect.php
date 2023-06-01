<?php

//     json format
// {
//     "email" : "1",
//     "pass" : "1",
//     "esp_id" : 123456,
//     "project_id" : "1"
//     "version" : 5
// }

require($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['email'])) {

    // delete spacebar
    $email = trim($_POST['email'], " ");

    $db = new Database();
    $conn = $db->getConn();

    //authen user
    $user_id = User::authenticate($conn, $email, $_POST['pass']);

    //if have this user
    if ($user_id >= 1) {

        //check this esp_id are already
        $esp_id = Esp_ID::getByESPID($conn, $_POST['esp_id']);

        //if have in database
        if ($esp_id) {

            // if already user
            if (isset($esp_id->user_id)) {
                // if same user id and project_id
                if (
                    $esp_id->esp_id == $_POST['esp_id']
                    && $esp_id->project_id == $_POST['project_id']
                    && $esp_id->user_id == $user_id
                    && (!isset($_POST['version']) || $esp_id->version == $_POST['version'])
                ) {
                    echo ($esp_id->user_id);
                }

                // if not same user id or project id replace new data
                else {
                    $device_name = $esp_id->device_name;
                    $esp_id = new Esp_ID();
                    $esp_id->esp_id = $_POST['esp_id'];
                    $esp_id->user_id = $user_id;
                    $esp_id->project_id = $_POST['project_id'];

                    $projects = explode(",", $esp_id->project_id);
                    $projectname = "";
                    foreach ($projects as $i => $project_id) {
                        $projectname .= (Projectname::getName($conn, $project_id))['project_name'] . "-";
                    }
                    if ($device_name == "" || is_nan($device_name))
                        $esp_id->device_name = $projectname . $_POST['esp_id'];
                    else $esp_id->device_name = $device_name;

                    $esp_id->version = (isset($_POST['version']) ? $_POST['version'] : null);
                    $esp_id->update($conn);
                    echo $user_id;
                }

                // if reboot from ota update -> check for update status
                try {
                    if ($esp_id->need_ota == 2) {
                        if ($_POST['version'] ==  OTA::getLastVersion($_POST['project_id'])) {
                            Esp_ID::setNeedOTA($conn, $esp_id->esp_id, 0); // set state to success update
                        } else {
                            Esp_ID::setNeedOTA($conn, $esp_id->esp_id, 3); // set state to fail update
                        }
                    }
                } catch (Throwable | Exception $e) {
                    file_put_contents('ota.log', $e->getMessage(), FILE_APPEND);
                }
            }

            // if no user
            else {
                // regis new espid to userid
                $esp_id = new Esp_ID();
                $esp_id->esp_id = $_POST['esp_id'];
                $esp_id->user_id = $user_id;
                $esp_id->project_id = $_POST['project_id'];

                $projects = explode(",", $esp_id->project_id);
                $projectname = "";
                foreach ($projects as $i => $project_id) {
                    $projectname .= (Projectname::getName($conn, $project_id))['project_name'] . "-";
                }
                $esp_id->device_name = $projectname . $_POST['esp_id'];

                $esp_id->version = (isset($_POST['version']) ? $_POST['version'] : null);
                $esp_id->update($conn);
                echo $user_id;

                // set offset energy
            }
        } else {
            if (ALLOWNEWESPID) {
                $esp_id = new Esp_ID();
                $esp_id->esp_id = $_POST['esp_id'];
                $esp_id->user_id = $user_id;
                $esp_id->project_id = $_POST['project_id'];
                $projectname = Projectname::getName($conn, $_POST['project_id']);
                $esp_id->device_name = $projectname['project_name'] . '-' . $_POST['esp_id'];
                $esp_id->version = (isset($_POST['version']) ? $_POST['version'] : null);
                $esp_id->create($conn);
                echo $user_id;
            } else {
                date_default_timezone_set('Asia/Bangkok');
                $dateTime = new DateTime();
                $time = $dateTime->format('Y-m-d H:i:s');
                Data_noauth::create($email, $_POST['esp_id'], $_POST['project_id'], $time);
                echo "no auth device";
            }
        }
        // $line_notify = new StatusNoti();
        // $line_notify->checkOnline($_POST['esp_id']);
    }
    //if wrong password
    else {
        echo $user_id;
        Auth::saveLogNoAuth("logindevice:" . $user_id);
    }
} else {
    Auth::saveLogNoAuth("logindevice no data");
}
