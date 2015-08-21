<?php

if(isset($_POST["username"]) or isset($_POST["password"])){
    $tmpusername = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $tmppassword = md5($_POST["password"]);
    $data = '
$username = "'.$tmpusername.'";
$password = \''.$tmppassword.'\';
    '.PHP_EOL;
    $fp = fopen('pluginconfig.php', 'a');
    fwrite($fp, $data);
    unlink("new.php");
    unlink("create.php");
    header("Location: imgbrowser.php");
} 

