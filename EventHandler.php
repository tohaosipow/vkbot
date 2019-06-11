<?php
namespace VK;

use Button;
use KeyboardBuilder;
use mysqli;
use User;

class EventHandler
{

    private $event;
    private $vk;

    /**
     * EventHandler constructor.
     * @param array $event
     * @param VkAPI $vk
     * @param mysqli $mysqli
     */
    public function __construct(Array $event, VkAPI $vk)
    {
        $this->vk = $vk;
        $this->event = $event;
        $type = $event['type'];
        $this->$type($event['object']);
     //   $this->vk->sendMessage(json_encode($event), $event['object']['peer_id']);

    }

    public function message_new($message){


        $payload = isset($message['payload'])?json_decode($message["payload"]):null;
        $peer_id = isset($message['peer_id'])?$message['peer_id']: $message['user_id'];
        $text = mb_strtolower($message['text'], "utf-8");
        if($text == "hello") $this->vk->sendMessage("Hello!",  $peer_id);
        if($text == "kak si?") $this->vk->sendMessage("Dobre!",  $peer_id);
        if($text == "Zasto") $this->vk->sendMessage("emi taka!",  $peer_id);
       // if($text == "пока") $this->vk->sendMessage("До скорой встречи", );
        $kb = new KeyboardBuilder();
        $key = $kb->addButton(new Button("привет", "positive"))->addButton(new Button("пока", "negative"))->build();
        if($text == "где мы находимся?") $this->vk->sendMessage("На IT-форуме.",  $peer_id, $key);


    }

    public function confirmation(){
        echo  "09900bcd";

    } 


}