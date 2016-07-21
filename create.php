<?php
// Including the plugin init file, don't delete the following row!
require_once(__DIR__ . '/plugininit.php');

if ($username != "") {
	echo $inappropriateUse;
	exit;
}

// Including the check_permission file, don't delete the following row!
require_once(__DIR__ . '/check_permission.php');


if(isset($_POST["username"]) or isset($_POST["password"])){
    $tmpusername = strip_tags($_POST["username"]);
    $tmpusername = htmlspecialchars($tmpusername, ENT_QUOTES);
    $tmppassword = md5($_POST["password"]);
    $data = '$username = "'.$tmpusername.'"; $password = \''.$tmppassword.'\';'.PHP_EOL;
    $fp = fopen($pluginConfigFile, 'a');
    fwrite($fp, $data);
    fclose($fp);
    header("Location: imgbrowser.php");
} 

