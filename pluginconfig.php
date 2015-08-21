<?php

if(isset($_POST["newpath"]) or isset($_GET["newfoldername"])){
    session_start();
}

if(isset($_SESSION['username'])){
    
    if(isset($_POST["newpath"])){
        $temppath = $_POST["newpath"];
        $newpath = htmlspecialchars($temppath, ENT_QUOTES);
        $data = '
    $useruploadfolder = "'.$newpath.'";
    $useruploadpath = "../../../'.$newpath.'/";
    $foldershistory[] = "'.$newpath.'";
        '.PHP_EOL;
        $fp = fopen('pluginconfig.php', 'a');
        fwrite($fp, $data);
    } 

    if(isset($_GET["newfoldername"])){
        $newfoldername = $_GET["newfoldername"];
        mkdir('../../../'.$newfoldername.'', 0777, true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } 
    
}

// Version of the plugin
$currentpluginver = "2.7.1";

// username and password
$encode = "yes";
$username = "";
$password = "";

// Path to the upload folder, please set the path using the Image Browser Settings menu.

$foldershistory = array();
$useruploadroot = "http://$_SERVER[HTTP_HOST]";

$useruploadfolder = "ckeditor/plugins/imageuploader/uploads";
$useruploadpath = "../../../$useruploadfolder/";
$foldershistory[] = $useruploadfolder;
