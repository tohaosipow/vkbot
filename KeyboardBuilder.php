<?php

class KeyboardBuilder
{
    private $one_time = false;
    private $buttons = [];
    /**
     * KeyboardBuilder constructor.
     */
    public function __construct($one_time = false)
    {
        $this->one_time = $one_time;
    }

    public function addButton(Button $button){
        if(count($this->buttons) == 0) array_push($this->buttons, []);
        array_push($this->buttons[count($this->buttons)-1], $button);
        return $this;
    }

    public function addLine(){
        array_push($this->buttons, []);
        return $this;
    }

    public function build(){
        return json_encode(array("one_time" => $this->one_time, "buttons" => $this->buttons), JSON_UNESCAPED_UNICODE);
    }
}