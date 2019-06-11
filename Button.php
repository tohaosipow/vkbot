<?php
/**
 * Created by PhpStorm.
 * User: tohao
 * Date: 23.05.2019
 * Time: 0:11
 */

class Button
{
    public $action;
    public $color;

    /**
     * Button constructor.
     */
    public function __construct($label, $color, $payload = "")
    {
        $p = json_encode($payload);
        $this->color = $color;
        $this->action = array("type" => "text", "payload" => $p, "label" => $label);
    }
}