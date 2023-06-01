<?PHP
require($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');
header('Content-type: text/plain; charset=utf8', true);

$ota = new OTA();

// $datalog;
// foreach ($_SERVER as $key => $value) {
//     $datalog .= $key . ": " . $value . "\n";
// }
// file_put_contents('var_dump.log', $datalog, FILE_APPEND);
// file_put_contents('var_dump.log', $datalog);

if (!$ota->check_header('HTTP_USER_AGENT', 'ESP8266-http-Update')) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 403 Forbidden', true, 403);
    echo "only for ESP8266 updater!\n";
    exit();
}

if (
    !$ota->check_header('HTTP_X_ESP8266_CHIP_ID') ||
    !$ota->check_header('HTTP_X_ESP8266_STA_MAC') ||
    !$ota->check_header('HTTP_X_ESP8266_AP_MAC') ||
    !$ota->check_header('HTTP_X_ESP8266_FREE_SPACE') ||
    !$ota->check_header('HTTP_X_ESP8266_SKETCH_SIZE') ||
    !$ota->check_header('HTTP_X_ESP8266_CHIP_SIZE') ||
    !$ota->check_header('HTTP_X_ESP8266_SDK_VERSION') ||
    !$ota->check_header('HTTP_X_ESP8266_VERSION')
) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 403 Forbidden', true, 403);

    echo "only for ESP8266 updater! (header)\n";
    exit();
}

// var_dump($ota->getBinByID($_GET['id'],$_GET['p_id'], isset($_GET['optional_version']) ? $_GET['optional_version'] : ""));exit;

if ($bininfo = $ota->getBinByID($_SERVER['HTTP_X_ESP8266_CHIP_ID'], $_GET['p_id'], isset($_GET['optional_version']) ? $_GET['optional_version'] : ""));
else {
    $bininfo = $ota->getBin($_GET['p_id'], isset($_GET['optional_version']) ? $_GET['optional_version'] : "");
}

// $localBinary = "./bin/" . $db[$_SERVER['x-ESP8266-STA-MAC']] . ".bin";
$localBinary = $_SERVER['DOCUMENT_ROOT']  . $bininfo['path'];

// Check if version has been set and does not match, if not, check if
// MD5 hash between local binary and ESP8266 binary do not match if not.
// then no update has been found.
if (($ota->check_header('HTTP_X_ESP8266_VERSION') && $bininfo['lastversion'] != $_SERVER['HTTP_X_ESP8266_VERSION']) ||
    $_SERVER["HTTP_X_ESP8266_SKETCH_MD5"] != md5_file($localBinary) ||
    isset($_GET['force']) // if force update
) {
    $db = new Database();
    $conn = $db->getConn();
    Esp_ID::setNeedOTA($conn, $_SERVER['HTTP_X_ESP8266_CHIP_ID'], 2); // set state to wait for result
    $ota->sendFile($localBinary);
} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 304 Not Modified', true, 304);
}
exit();

header($_SERVER["SERVER_PROTOCOL"] . ' 500 no version for ESP MAC', true, 500);
