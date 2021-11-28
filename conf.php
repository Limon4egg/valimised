<?php
$kasutaja="daniilmihhailov20";
$andmebaas="daniilmihhailov20";
$parool="122345";
$serverinimi="localhost";
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset("utf8");
?>
