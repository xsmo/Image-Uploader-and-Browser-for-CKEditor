<?php

if(isset($_POST["newpath"]) or isset($_POST["extension"]) or isset($_GET["newfoldername"])){
    session_start();
}

if(isset($_SESSION['username'])){
    
    if(isset($_POST["newpath"])){
        $temppath = $_POST["newpath"];
        $newpath = strip_tags($temppath);
        $newpath = htmlspecialchars($newpath, ENT_QUOTES);
        $data = '
    $useruploadfolder = "'.$newpath.'";
    $useruploadpath = "../../../'.$newpath.'/";
    $foldershistory[] = "'.$newpath.'";
        '.PHP_EOL;
        $fp = fopen(__DIR__ . '/pluginconfig.php', 'a');
        fwrite($fp, $data);
    } 

    if(isset($_GET["newfoldername"])){
        $newfoldername = strip_tags($_GET["newfoldername"]);
        $newfoldername = htmlspecialchars($newfoldername, ENT_QUOTES);
        mkdir('../../../'.$newfoldername.'', 0777, true);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } 
    
    if(isset($_POST["extension"])){
        $extension_setting = strip_tags($_POST["extension"]);
        $extension_setting = htmlspecialchars($extension_setting, ENT_QUOTES);
        if($extension_setting == "no" or $extension_setting == "yes"){
            $data = '$file_extens = "'.$extension_setting.'";'.PHP_EOL;
            $fp = fopen(__DIR__ . '/pluginconfig.php', 'a');
            fwrite($fp, $data);
        } else {
            echo '
                <script>
                alert("An error occurred.\r\n\r\nPlease use the plugin settings to change the visibility or try again.");
                history.back();
                </script>
            ';
        }
    } 
    
}

// Version of the plugin
$currentpluginver = "4.0.1";

// username and password
$username = "";
$password = "";

// ststem icons
$sy_icons = array(
    "cd-ico-browser.ico",
    "cd-icon-browser.png",
    "cd-icon-bug.png",
    "cd-icon-close.png",
    "cd-icon-coffee.png",
    "cd-icon-credits.png",
    "cd-icon-delete.png",
    "cd-icon-disable.png",
    "cd-icon-download.png",
    "cd-icon-faq.png",
    "cd-icon-images.png",
    "cd-icon-logout.png",
    "cd-icon-password.png",
    "cd-icon-refresh.png",
    "cd-icon-select.png",
    "cd-icon-settings.png",
    "cd-icon-upload.png",
    "cd-icon-use.png",
    "cd-icon-version.png",
    "cd-icon-edit.png",
    "cd-icon-showext.png",
    "cd-icon.showext.png"
);

// show/hide file extension
$file_extens = "no";

// Path to the upload folder, please set the path using the Image Browser Settings menu.

$foldershistory = array();
$useruploadroot = "http://$_SERVER[HTTP_HOST]";

$useruploadfolder = "ckeditor/plugins/imageuploader/uploads";
$useruploadpath = "../../../$useruploadfolder/";
$foldershistory[] = $useruploadfolder;
