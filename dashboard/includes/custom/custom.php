<?php

if (!isset($activedevice)) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');
    $db = new Database();
    $conn = $db->getConn();

    $activedevice = Esp_ID::getByESPID($conn, $_POST['id'],'*',"array");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/dashboard/includes/custom/" . $_REQUEST['id'] . ".php")) {
    require($_SERVER['DOCUMENT_ROOT'] . "/dashboard/includes/custom/" . $_REQUEST['id'] . ".php");
} else {
    require($_SERVER['DOCUMENT_ROOT'] . "/dashboard/includes/custom/default.php");
}
