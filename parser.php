<?php
require_once "load.php";
require_once "simple_html_dom.php";
$mysqli = new Mysqli("5.63.153.19", "osword", "", "word");
$mysqli->query("SET NAMES utf8");
$r = $mysqli->query("SELECT * FROM `words`");
while ($row = $r->fetch_object()) {
    $e = urlencode($row->word);
    echo $row->word;
    if($content = file_get_contents('https://wordassociation.ru/' . $e)) {
        $html = str_get_html($content);
        foreach ($html->find('.list-associations span') as $el) {
            $word = $el->innertext;
            $mysqli->query("INSERT INTO `associates` (word, count, word_id) VALUES ('$word', 0, $row->id)");
        }
    }

}
