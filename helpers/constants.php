<?php

if (!defined('ESEWA_PAYMENT_METHOD_NAME')) {
    define('ESEWA_PAYMENT_METHOD_NAME', 'esewa');
}

if(!defined('ESEWA_PAYMENT_URL')){
    define('ESEWA_PAYMENT_URL', 'https://uat.esewa.com.np/epay/main');
    //define('ESEWA_PAYMENT_URL', 'https://esewa.com.np/epay/main');
}

if (!defined('ESEWA_VERIFICATION_URL')) {
    define('ESEWA_VERIFICATION_URL', 'https://uat.esewa.com.np/epay/transrec');
    //define('ESEWA_VERIFICATION_URL', 'https://esewa.com.np/epay/transrec');
}