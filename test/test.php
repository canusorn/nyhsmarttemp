<?php

require($_SERVER['DOCUMENT_ROOT'] . '/includes/init.php');


$data_min_av = Data_4_sec::getAvMin(123456, '2023-06-01 16');
var_dump($data_min_av);