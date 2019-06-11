<?php
require_once "load.php";
use VK\VkAPI;

$api = new VkAPI("", "5.93");
/*$key = (new \KeyboardBuilder())->addButton(new \Button("Payload", "positive", array("button" => "hell")))->addLine()->addButton(new \Button("Не согласиться", "negative"))->build();*/
$mysqli = new Mysqli("", "osword", "", "word");
$mysqli->query("SET NAMES utf8");
$user = new User(135840034, $mysqli);
//var_dump($user);

$as = new Associate(14378, $mysqli);
var_dump($as->c());