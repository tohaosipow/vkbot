<?php
/**
 * Created by PhpStorm.
 * User: tohao
 * Date: 23.05.2019
 * Time: 22:14
 */

class Word
{
    public $id;
    public $word;
    public $associates = [];

    /**
     * Word constructor.
     */
    public function __construct($word_id, Mysqli $mysqli)
    {
        if($word_id == null) return null;
        $w_obj = $mysqli->query("SELECT * FROM `words` WHERE `id` = '$word_id' LIMIT 1")->fetch_object();
        $this->id = $w_obj->id;
        $this->word = $w_obj->word;
        $rs = $mysqli->query("SELECT * FROM `associates` WHERE `word_id` = '$word_id'");
        while ($row = $rs->fetch_object()){
            array_push($this->associates, new Associate($row->id, $mysqli));
        }
    }
    public static function getWordRand(Mysqli $mysqli){
        $obj = $mysqli->query("SELECT * FROM `words` WHERE 1 ORDER BY RAND() LIMIT 1")->fetch_object();
        return new Word($obj->id, $mysqli);
    }



}