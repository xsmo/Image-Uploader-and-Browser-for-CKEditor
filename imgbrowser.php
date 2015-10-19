
<?php
session_start();
?>

<!-- Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved. -->
<!-- For licensing, see LICENSE.md -->

<?php

// Don't remove the following two rows
$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$root = "http://$_SERVER[HTTP_HOST]";

// Including the plugin config file, don't delete the following row!
require(__DIR__ . '/pluginconfig.php');
// Including the functions file, don't delete the following row!
require(__DIR__ . '/function.php');
// Including the check_permission file, don't delete the following row!
require(__DIR__ . '/check_permission.php');

if ($username == "" and $password == "") {
    if(!isset($_SESSION['username'])){
        include(__DIR__ . '/new.php');
        exit;	
    }
} else {
    if(!isset($_SESSION['username'])){
        include(__DIR__ . '/loginindex.php');
        exit;	
    }
}

?>

<!DOCTYPE html>
<html lang="en"
      ondragover="toggleDropzone('show')"
      ondragleave="toggleDropzone('hide')">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Image Browser for CKEditor :: Fujana Solutions</title>
    <meta name="author" content="Moritz Maleck">
    <link rel="icon" href="img/cd-ico-browser.ico">
    
    <link rel="stylesheet" href="styles.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ibm.bplaced.com/imageuploader/plugininfo.js"></script>
    <script src="dist/jquery.lazyload.min.js"></script>
    <script src="dist/js.cookie-2.0.3.min.js"></script>
    
    <script src="dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
    
    <script src="function.js"></script>
    
    <script> 
        // Plugin version
        var currentpluginver = "<?php echo $currentpluginver; ?>";
        // ajax request to register the plugin for better support
        $.ajax({
          method: "POST",
          url: "http://ibm.bplaced.com/imageuploader/register.php",
          data: { root: "<?php echo $root; ?>", link: "<?php echo $link; ?>", ver: ""+ currentpluginver +"" }
        })
    </script>
    
</head>
<body ontouchstart="">
    
<div id="header">
    <a class="" href="http://imageuploaderforckeditor.altervista.org/" target="_blank"><img src="img/cd-icon-image.png" class="headerIconLogo"></a>
    <img onclick="Cookies.remove('qEditMode');window.close();" src="img/cd-icon-close-grey.png" class="headerIconRight iconHover">
    <img onclick="reloadImages();" src="img/cd-icon-refresh.png" class="headerIconRight iconHover">
    <img onclick="uploadImg();" src="img/cd-icon-upload-grey.png" class="headerIconCenter iconHover">
    <img onclick="pluginSettings();" src="img/cd-icon-settings.png" class="headerIconRight iconHover">
</div>
    
<div id="editbar">
    <div id="editbarView" onclick="#" class="editbarDiv"><img src="img/cd-icon-images.png" class="editbarIcon editbarIconLeft"><p class="editbarText">View</p></div>
    <a href="#" id="editbarDownload" download><div class="editbarDiv"><img src="img/cd-icon-download.png" class="editbarIcon editbarIconLeft"><p class="editbarText">Download</p></div></a>
    <div id="editbarUse" onclick="#" class="editbarDiv"><img src="img/cd-icon-use.png" class="editbarIcon editbarIconLeft"><p class="editbarText">Use</p></div>
    <div id="editbarDelete" onclick="#" class="editbarDiv"><img src="img/cd-icon-qtrash.png" class="editbarIcon editbarIconLeft"><p class="editbarText">Delete</p></div>
    <img onclick="hideEditBar();" src="img/cd-icon-close-black.png" class="editbarIcon editbarIconRight">
</div>
    
<div id="updates" class="popout"></div>
    
<div id="dropzone" class="dropzone" 
     ondragenter="return false;"
     ondragover="return false;"
     ondrop="drop(event)">
    <p>
        <img src="img/cd-icon-upload-big.png"><br>
        Drop your files here
    </p>
</div>

<p class="folderInfo">In total: <span id="finalcount"></span> Images - <span id="finalsize"></span>
    <?php if($file_style == "block") { ?>
        <img title="List" src="img/cd-icon-list.png" class="headerIcon floatRight" onclick="window.location.href = 'pluginconfig.php?file_style=list';">
    <?php } elseif($file_style == "list") { ?>
        <img title="Block" src="img/cd-icon-block.png" class="headerIcon floatRight" onclick="window.location.href = 'pluginconfig.php?file_style=block';">
        <img title="Quick Edit" id="qEditBtnOpen" src="img/cd-icon-qedit.png" class="headerIcon floatRight" onclick="toogleQEditMode();">
        <img title="Quick Edit" id="qEditBtnDone" src="img/cd-icon-done.png" class="headerIcon floatRight" onclick="toogleQEditMode();">
    <?php } ?>
</p>

<div id="files">
    <?php
    loadImages();
    ?>
</div>

    
<?php if($file_style == "block") { ?>
    <div class="fileDiv" onclick="window.location.href = 'http://imageuploaderforckeditor.altervista.org';">
        <div class="imgDiv">Image Uploader for CKEditor</div>
        <p class="fileDescription">&copy; 2015 by Moritz Maleck</p>
        <p class="fileTime">imageuploaderforckeditor.altervista.org</p>
        <p class="fileTime">180 KB</p>
    </div>
<?php } elseif($file_style == "list") { ?>
    <div class="fullWidthFileDiv" onclick="window.location.href = 'http://imageuploaderforckeditor.altervista.org';">
        <div class="fullWidthimgDiv"><img class="fullWidthfileImg lazy" data-original="img/cd-icon-credits.png"></div>
        <p class="fullWidthfileDescription">Image Uploader for CKEditor</p>
        <p class="fullWidthfileTime fullWidthfileMime">png</p>
        <p class="fullWidthfileTime">180 KB</p>
        <p class="fullWidthfileTime fullWidth30percent">imageuploaderforckeditor.altervista.org</p>
    </div>
<?php } ?>

<div id="imageFullSreen" class="lightbox popout">
    <div class="buttonBar">
        <button id="imageFullSreenClose" class="headerBtn" onclick="$('#imageFullSreen').hide(); $('#background').slideUp(250, 'swing');"><img src="img/cd-icon-close.png" class="headerIcon"></button>
        <button class="headerBtn" id="imgActionDelete"><img src="img/cd-icon-delete.png" class="headerIcon"></button>
        <a href="#" id="imgActionDownload" download><button class="headerBtn"><img src="img/cd-icon-download.png" class="headerIcon"></button></a>
        <button class="headerBtn greenBtn" id="imgActionUse" onclick="#" class="imgActionP"><img src="img/cd-icon-use.png" class="headerIcon"> Use</button>
    </div><br><br>
    <img id="imageFSimg" src="#" style="#"><br>
</div>
    
<div id="uploadImgDiv" class="lightbox popout">
    <div class="buttonBar">
        <button class="headerBtn" onclick="$('#uploadImgDiv').hide(); $('#background2').slideUp(250, 'swing');"><img src="img/cd-icon-close.png" class="headerIcon"></button>
        <button class="headerBtn greenBtn" name="submit" onclick="$('#uploadImgForm').submit();"><img src="img/cd-icon-upload.png" class="headerIcon"> Upload</button>
    </div><br><br><br>
    <form action="imgupload.php" method="post" enctype="multipart/form-data" id="uploadImgForm" onsubmit="return checkUpload();">
        <p class="uploadP"><img src="img/cd-icon-select.png" class="headerIcon"> Please select a file:</p>
        <input type="file" name="upload" id="upload">
        <br><h3 class="settingsh3" style="font-size:12px;font-weight:lighter;">The image will be uploaded to:<br><span style="font-weight:bolder;">"<?php echo $useruploadfolder; ?>"</span> (The upload path can be changed in the settings)</h3>
        <br>
    </form>
</div>
    
<div id="settingsDiv" class="lightbox popout">
    <div class="buttonBar">
        <button class="headerBtn" onclick="$('#settingsDiv').hide(); $('#background3').slideUp(250, 'swing');"><img src="img/cd-icon-close.png" class="headerIcon"></button>
    </div><br><br><br>
    
    <h3 class="settingsh3">Upload path:</h3>
    <p class="settingsh3 saveUploadPathP">Please choose an existing folder:</p>
    <p class="uploadP editable" id="uploadpathEditable"><?php echo $useruploadfolder; ?></p>
    <p class="settingsh3 saveUploadPathP">Path history:</p>
    <?php
    pathHistory();
    ?>
    <button class="headerBtn greyBtn saveUploadPathA" id="pathCancel">Cancel</button>
    <button class="headerBtn saveUploadPathA" onclick="updateImagePath();">Save</button><br class="saveUploadPathA">
    
    <br><h3 class="settingsh3">Settings:</h3>
    <?php if($file_extens == "yes"){ ?>
        <p class="uploadP" onclick="extensionSettings('no');"><img src="img/cd-icon-hideext.png" class="headerIcon"> Hide file extension</p>
    <?php } elseif($file_extens == "no") { ?>
        <p class="uploadP" onclick="extensionSettings('yes');"><img src="img/cd-icon-showext.png" class="headerIcon"> Show file extension</p>
    <?php } ?>
    
    <?php if($_SESSION["username"] != "disabled_pw"){ ?>
        <br><h3 class="settingsh3">Password:</h3>
        <p class="uploadP" onclick="window.location.href = 'logout.php';"><img src="img/cd-icon-logout.png" class="headerIcon"> Logout</p>
        <p class="uploadP" onclick="window.open('http://imageuploaderforckeditor.altervista.org/disable_pw.html','about:blank', 'toolbar=no, scrollbars=yes, resizable=no, width=900, height=600');"><img src="img/cd-icon-disable.png" class="headerIcon"> Disable password</p>
    <?php } ?>
    
    <br><h3 class="settingsh3">Do you like our plugin?</h3>
    <p class="uploadP" onclick="$( '#donate' ).submit();"><img src="img/cd-icon-coffee.png" class="headerIcon"> Buy Us A Coffee!</p>
    
    <br><h3 class="settingsh3">Support:</h3>
    <p class="uploadP" onclick="window.open('http://imageuploaderforckeditor.altervista.org/support/','_blank');"><img src="img/cd-icon-faq.png" class="headerIcon"> Plugin FAQ</p>
    <p class="uploadP" onclick="window.open('http://ibm.bplaced.com/contact/index.php?cdproject=Image%20Uploader%20and%20Browser%20for%20CKEditor&cdlink=<?php echo $link; ?>&cdver='+currentpluginver,'_blank');"><img src="img/cd-icon-bug.png" class="headerIcon"> Report a bug</p>
    
    <br><h3 class="settingsh3">Version:</h3>
    <p class="uploadP"><img src="img/cd-icon-version.png" class="headerIcon"> <?php echo $currentpluginver; ?></p>
    
    <br><h3 class="settingsh3">Credits:</h3>
    <p class="uploadP"><img src="img/cd-icon-credits.png" class="headerIcon"> Made with love by Moritz Maleck</p>
    
    <br><h3 class="settingsh3">Icons:</h3>
    <p class="uploadP" onclick="window.open('https://icons8.com','_blank');"><img src="img/cd-icon-images.png" class="headerIcon"> Icon pack by Icons8</p>
    
    <br>
</div>
    
<form id="donate" target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BTEL7F2ZLR3T6">
</form> 
    
<div id="background" class="background" onclick="$('#imageFullSreenClose').trigger('click');"></div>
<div id="background2" class="background" onclick="$('#uploadImgDiv').hide(); $('#background2').slideUp(250, 'swing');"></div>
<div id="background3" class="background" onclick="$('#settingsDiv').hide(); $('#background3').slideUp(250, 'swing');"></div>

<!--Noscript part if js is disabled-->
<noscript> <div class="noscript"> <div id="folderError" class="noscriptContainer popout"> <b>Thanks for choosing Image Uploader and Browser for CKEditor!</b><br><br>To use this plugin you need to <b>enable JavaScript</b> in your web browser. <a href="http://www.enable-javascript.com/" target="_blank">How to enable JavaScript in your browser (external link)</a><br><br>Check out the <a href="http://imageuploaderforckeditor.altervista.org/" target="_blank">Documentation</a> or the <a href="http://imageuploaderforckeditor.altervista.org/support/" target="_blank">Plugin FAQ</a> for more help. </div></div></noscript>

</body>
</html>