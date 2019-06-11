<?php
/**
 * Created by PhpStorm.
 * User: tohao
 * Date: 23.05.2019
 * Time: 22:09
 */

class User
{
    private $mysqli;
    public $id;
    public $vk_id;
    public $balance;
    private $word_id;
    /**
     * @var Word $word
     */
    public $word;


    /**
     * User constructor.
     * @param int $vk_id
     * @param Mysqli $mysqli
     */
    public function __construct(int $vk_id, Mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
        $this->vk_id = $vk_id;
        $this->loadFromBD();

    }

    public function setWord($word){
        if($word == null || $word->id == null) $this->mysqli->query("UPDATE `users` SET `word_id` = NULL WHERE `id` = '{$this->id}'");
        else $this->mysqli->query("UPDATE `users` SET `word_id` = '{$word->id}' WHERE `id` = '{$this->id}'");
        $this->loadFromBD();
    }

    public function getAssociateByWord(String $ass){
        foreach ($this->word->associates as $associate){
            if($associate->word == $ass) return new Associate($associate->id, $this->mysqli);
        }
        return null;
    }

    public function upBalance($int){
        $this->mysqli->query("UPDATE `users` SET `balance` = `balance` + $int WHERE `id` = '$this->id' LIMIT 1");
        $this->loadFromBD();
        $vkcoin = new VKCoinClient(135840034, '],,mmZVXgaCuIA]Z&d!Nf-=*qSdN0ILx=uH3QF2K;JofQ6l7Bv');
        if($this->vk_id != 135840034) $vkcoin->sendTransfer($this->vk_id, $int);
    }

    private function loadFromBD(){
        $vk_id = $this->vk_id;
        $r = $this->mysqli->query("SELECT * FROM `users` WHERE `vk_id` = '$vk_id' LIMIT 1");
        if($r->num_rows < 1){
            $this->mysqli->query("INSERT INTO `users` (`vk_id`, `word_id`, `balance`) VALUES ('$vk_id', NULL, 0)");
            $r = $this->mysqli->query("SELECT * FROM `users` WHERE `vk_id` = '$vk_id' LIMIT 1");
        }
        $u_ob = $r->fetch_object();
        $this->id = $u_ob->id;
        $this->word_id = $u_ob->word_id;
        $this->balance = $u_ob->balance;
        $this->word = new Word($this->word_id, $this->mysqli);
    }
}