<?php
require_once 'lib.php';
$vkcoin = new VKCoinClient(135840034, '');
var_dump($vkcoin->sendTransfer(143505965, 1));