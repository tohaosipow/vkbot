<?php

require_once "load.php";
use VK\EventHandler;
use VK\VkAPI;

$event = json_decode(file_get_contents('php://input'), true);
$api = new VkAPI("");
$handler = new EventHandler($event, $api);
