<?php

// io update
//check update io control
$io = new ControlIO();
$io->esp_id = $_POST['esp_id'];
$io->createTables();
$co = $io->getLast();


if (isset($_POST['io_c'])) { // io from client is higher priority
    $io->time = $dateTime->format('Y-m-d H:i:s');
    $io->needupdate = 0;
    $io->io = $_POST['io_c'];
    $payload["io"]["updated_c"] =  (boolval($io->create()) ? 'true' : 'false');
} else if (isset($_POST['io_s'])) { //request io from server
    if ($_POST['io_s'] == $co['io']) { // if feedback data is the same then delete needupdate flag
        $io->time = $dateTime->format('Y-m-d H:i:s');
        $io->needupdate = 0;
        $co['needupdate'] = 0;
        $io->io = $_POST['io_s'];
        // $payload["io"]["updated_s"] =  (boolval($io->create()) ? 'true' : 'false');
        $payload["io"]["updated_s"] =  $io->create();
    } else if (is_null($co['io'])) {
        $payload["io"]["updated_s"] =  1;
    } else {
        $payload["io"]["new"] = $co['io'];
    }
}

if ($co) {
    if ($co['needupdate']) {  // if needupdate flag then sent new io data
        $payload["io"]["new"] = $co['io'];
    }
}

// code echo
// if (isset($payload["error"])) echo ("&0=" . $payload["error"]);  // if error
if (isset($payload['io']['new'])) echo ("&1=" . $payload['io']['new']);   // new io control from server
else if (isset($payload["io"]["updated_s"])) echo "&32767";   // io from server updated
else if (isset($payload["io"]["updated_c"])) echo "&32766";   // io from client updated