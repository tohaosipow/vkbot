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
        echo "OK";

    }

    public function confirmation(){
        echo  "09900bcd";

    } 


}