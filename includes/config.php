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

define('SECDATALIMIT',2);   //sec data limit in day
define('MINDATALIMIT',15);   //minute data limit in day
define('HRDATALIMIT',3);   //hr data limit in mounths
define('DAYDATALIMIT',4);   //day data limit in years

define('OFFLINETIME',40);  // offline state when no response in second



// free
define('FREE_READSAMPLE',10);   //read data sample rate in sec

define('FREE_SECDATALIMIT',1);   //sec data limit in day
define('FREE_MINDATALIMIT',2);   //minute data limit in day
define('FREE_HRDATALIMIT',15);   //hr data limit in day
define('FREE_DAYDATALIMIT',3);   //day data limit in month



// Pro
define('PRO_PRICE',29);   //  price per month in thb

define('PRO_READSAMPLE',5);   //read data sample rate in sec

define('PRO_SECDATALIMIT',2);   //sec data limit in day
define('PRO_MINDATALIMIT',15);   //minute data limit in day
define('PRO_HRDATALIMIT',3);   //hr data limit in mounths
define('PRO_DAYDATALIMIT',1);   //day data limit in years



// Enterprise
define('ENT_PRICE',59);   //  price per month in thb

define('ENT_READSAMPLE',5);   //read data sample rate in sec

define('ENT_SECDATALIMIT',7);   //sec data limit in day
define('ENT_MINDATALIMIT',60);   //minute data limit in day
define('ENT_HRDATALIMIT',6);   //hr data limit in mounths
define('ENT_DAYDATALIMIT',4);   //day data limit in years