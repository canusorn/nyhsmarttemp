<?php

if ($_POST['p_id'] == 0) {
    require '../includes/custom/custom.php';
} elseif ($_POST['p_id'] == 1) {

    if (isset($_GET['v']) && $_GET['v'] >= 9)
        require '../includes/01acmeter_v9.php';
    else
        require '../includes/01acmeter.php';
} elseif ($_POST['p_id'] == 2) {

    if (isset($_GET['v']) && $_GET['v'] >= 9)
        require '../includes/02pmmeter_v9.php';
    else
        require '../includes/02pmmeter.php';
} elseif ($_POST['p_id'] == 3) {

    if (isset($_GET['v']) && $_GET['v'] >= 9)
        require '../includes/03dcmeter_v9.php';
    else
        require '../includes/03dcmeter.php';
} elseif ($_POST['p_id'] == 4) {

    if (isset($_GET['v']) && $_GET['v'] >= 9)
        require '../includes/04dht_v9.php';
    else
        require '../includes/04dht.php';
} elseif ($_POST['p_id'] == 5) {
    require '../includes/05smartfarm-solar.php';
} elseif ($_POST['p_id'] == 6) {
    require '../includes/06acmeter_3p_v9.php';
}
