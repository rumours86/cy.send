<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('cysend.php');
$cysend = new CySend();
header("Content-Type: text/xml");
if(!isset($_GET['f'])) {
    // проверка номера
    echo $cysend->check_mobile($_GET['m']);
} else {
    // перевод денег на телефон (номер, сумма, свой_ид_от_8_до_16_символов)
    //echo $cysend->top_up('+79035371338', '100', '88888888');
    // статус перевод денег (свой_ид_от_8_до_16_символов, их_ид)
    //echo $cysend->transaction_status('test_tid2', 'API_dEuvqTk3'); // 100р Илья
    echo $cysend->transaction_status('88888888', 'API_sFwKXUPQ'); // 100р Макс
}
//echo $cysend->get_balance();








