<?php
require_once "load.php";
require_once "simple_html_dom.php";
$handle = fopen("base.txt", "r");
$mysqli = new Mysqli("5.63.153.19", "osword", "", "word");
$mysqli->query("SET NAMES utf8");

while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    $buffer = trim(str_replace(" ", "", $buffer));
    if(mb_strlen($buffer, "utf-8") > 5 &&mb_strlen($buffer, "utf-8") < 1000){
        $word  = $buffer;
        $e = urlencode($word);
        $c = curl_init('https://wordassociation.ru/' . $e);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($c);
        $httpcode = curl_getinfo($c, CURLINFO_HTTP_CODE);
        print $httpcode;
        if($httpcode == 200) {
            $html = str_get_html($content);
            $mysqli->query("INSERT INTO `words` (word) VALUES ('$word')");
            $word_id = $mysqli->insert_id;
            if(count($html->find('.list-associations span')) > 5) {
                foreach ($html->find('.list-associations span') as $el) {
                    $associate = $el->innertext;
                    $mysqli->query("INSERT INTO `associates` (word, count, word_id) VALUES ('$associate', 0, $word_id)");

                }
                print($word) . "\n";
            }
        }

    }

}
fclose($handle);



