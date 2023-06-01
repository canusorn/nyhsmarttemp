<?php

if (isset($_GET['p'])) {
    if ($_GET['p'] == '1') {
        Url::redirect('/blog/docs/acmeter/');
    }
    else if ($_GET['p'] == '2') {
        Url::redirect('/blog/docs/pmmeter/');
    }
    else if ($_GET['p'] == '3') {
        Url::redirect('/blog/docs/dcmeter/');
    }
    else if ($_GET['p'] == '4') {
        Url::redirect('/blog/docs/dht11_dht22/');
    }
    else if ($_GET['p'] == '6') {
        Url::redirect('/blog/docs/acmeter-3phase/');
    }
}