<?php
date_default_timezone_set('europe/paris');

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
else
    $link = "http";

$link .= "://";
$link .= $_SERVER['HTTP_HOST'];
$link .= $_SERVER['REQUEST_URI'];

if(substr_count($link, 'dev-devisvdma.act-cs.fr') == 0){
    $connexion = new PDO('pgsql:host=localhost;port=5432;dbname=vdmadbactcs', 'vdmauserdbact', 'Mjr%r4720Mjr%r4720',array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

?>