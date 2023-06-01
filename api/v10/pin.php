<?php

// pin update
// echo format &1={pin}:{mode}:{value},{pin}:{mode}:{value}

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');

$pin = new ControlPin();
$pin->esp_id = $_POST['esp_id'];
$pin_fetch = $pin->getLast();
$cpin = json_decode($pin_fetch['pindata'], true);



// output update from server to client
if (isset($_POST['pin_s'])) { //request pin from server
    $pin_out = "&1=";
    if ($cpin) {
        foreach ($cpin as $key => $value) {
            $p = (str_split($value['pin']))[1];
            $modearr = str_split(($value['mode']))[0]; //split strint for first char only
            if ($key != 0) $pin_out .= ",";
            $pin_out .= $p . ":" . $modearr . ":" . $value['value'];
        }
    } else {
        $pin_out .= "0";  // no data
    }
    echo $pin_out;
} else if ($cpin) {
    if ($pin_fetch['needupdate'] == 1) { // need update == 1 is new update from server
        $pin_out = "&1=";

        foreach ($cpin as $key => $value) {
            date_default_timezone_set('Asia/Bangkok');
            $p = (str_split($value['pin']))[1];
            $modearr = str_split(($value['mode']))[0]; //split strint for first char only
            if ($key != 0) $pin_out .= ",";
            $pin_out .= $p . ":" . $modearr . ":" . $value['value'];
        }
        $pin->pindata = json_encode($cpin);
        $pin->needupdate = 2;
        $pin->create();

        echo $pin_out;
    } else if (isset($_POST['pin_c'])) {  // pin to client had updated
        $pin->pindata = json_encode($cpin);
        $pin->needupdate = 0;
        $pin->create();
    } else if ($pin_fetch['needupdate'] == 2) { // need update == 2 is new update had sent to client but no ack
        $pin_out = "&1=";

        foreach ($cpin as $key => $value) {
            date_default_timezone_set('Asia/Bangkok');
            $p = (str_split($value['pin']))[1];
            $modearr = str_split(($value['mode']))[0]; //split strint for first char only
            if ($key != 0) $pin_out .= ",";
            $pin_out .= $p . ":" . $modearr . ":" . $value['value'];
        }
        $pin->pindata = json_encode($cpin);
        $pin->needupdate = 2;
        $pin->create();

        echo $pin_out;
    } else if (isset($_POST['pin_change'])) { // input update from client to server

        if ($cpin) {
            $newIO = [];
            foreach ($cpin as $key => $value) {
                if ($value["mode"] == "INPUT" || $value["mode"] == "OUTPUT") { // change if input and output mode (no pwm)
                    $buffpin = [["pin" => $value["pin"], "mode" => $value["mode"], "value" => (string)($_POST['pin_change'] >> (int)((str_split($value['pin']))[1])) & 0b1, "detail" => $value["detail"]]];
                    $newIO = array_merge($newIO, $buffpin);
                } else {
                    $buffpin = [["pin" => $value["pin"], "mode" => $value["mode"], "value" => $value["value"], "detail" => $value["detail"]]];
                    $newIO = array_merge($newIO, $buffpin);
                }
            }
            $cpin = $newIO;
            usort($cpin, function ($a, $b) {
                return $a['pin'] <=> $b['pin'];
            });
            $pin->pindata = json_encode($cpin);
            $pin->needupdate = $pin_fetch['needupdate'];
            if ($pin->create() == 1) {
                echo "&2=" . $_POST['pin_change'];
            }
        }
    }
}
