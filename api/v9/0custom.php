<?php

if (file_exists("custom/" . $_POST['esp_id'] . ".php")) {
    require("custom/" . $_POST['esp_id'] . ".php");
    $default = false;
} else {
    $default = true;
}

if ($default) {
    require("custom/default.php");
}


// line notify timer
$line_timer = new LineTimer();
$line_timer->esp_id = $_POST['esp_id'];
$old_line_timer = $line_timer->getLast();
$timer = json_decode($old_line_timer["timer"], true);


if (@$old_line_timer) {
    if (@$timer[$old_line_timer["flag"]]) {
        if (fmod((new DateTime())->getTimestamp() + 7 * 3600, 86400) >= $timer[$old_line_timer["flag"]]) {
            $line_timer->flag = $old_line_timer["flag"] + 1;
            $line_token = Linenotify::getAll($_POST['esp_id'], 0);
            @Linenotify::sentCustomTime($conn, $data['c0'], $data['c1'], $data['c2'], $data['c3'], $data['c4'], $data['c5'], $data['c6'], $data['c7'], $data['c8'], $data['c9'], $_POST['esp_id'], $line_token['line_token']);

            $line_timer->timer = $old_line_timer["timer"];
            $line_timer->create();
        }
    } else if (@$payload["status"]["day"] == 'new day data') {   // no timer -> reset to 0

        foreach ($timer as $key => $value) {
            if ($value >= fmod((new DateTime())->getTimestamp() + 7 * 3600, 86400)) {
                $line_timer->flag = $key;
                break;
            }
        }

        $line_timer->timer = $old_line_timer["timer"];
        $line_timer->create();
    }
}
