<?php

session_start();
if(!isset($_SESSION['username'])) {
    exit;
}

$data = '
$encode = "no";
'.PHP_EOL;
$fp = fopen('pluginconfig.php', 'a');
fwrite($fp, $data);
session_destroy();
unlink("disable.php");
header("Location: imgbrowser.php");
