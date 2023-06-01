<?php

// local server
define('DB_HOST','localhost');
define('DB_NAME','nyhsmarttemp');
define('DB_USER','root');
define('DB_PASS','');

// hostinger server
// define('DB_HOST','localhost');
// define('DB_NAME','u189879599_iotkiddie');
// define('DB_USER','u189879599_iotkiddie');
// define('DB_PASS',"vo6liIN=6,mv'");

// allow no authen espid which not regis before to use
define('ALLOWNEWESPID',true);

define('SECDATALIMIT',30);   //sec data limit in day
define('HRDATALIMIT',12);   //hr data limit in mounths
define('DAYDATALIMIT',10);   //day data limit in years

define('OFFLINETIME',40);  // offline state when no response in second