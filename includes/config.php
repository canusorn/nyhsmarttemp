<?php

// local server
define('DB_HOST','localhost');
define('DB_NAME','iotbundle');
define('DB_USER','root');
define('DB_PASS','');

// awardspace server
// define('DB_HOST','pdb53.awardspace.net');
// define('DB_NAME','1305435_iotbundle');
// define('DB_USER','1305435_iotbundle');
// define('DB_PASS','nang160139');

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