<?php

// local server
// define('DB_HOST','localhost');
// define('DB_NAME','nyhsmarttemp');
// define('DB_USER','root');
// define('DB_PASS','');


define('DB_HOST','localhost');
define('DB_NAME','nyhsmar_db');
define('DB_USER','nyhsmar_admin');
define('DB_PASS','4d9i2V3x*');


// allow no authen espid which not regis before to use
define('ALLOWNEWESPID',true);

define('SECDATALIMIT',30);   //sec data limit in day
define('HRDATALIMIT',12);   //hr data limit in mounths
define('DAYDATALIMIT',10);   //day data limit in years

define('OFFLINETIME',40);  // offline state when no response in second