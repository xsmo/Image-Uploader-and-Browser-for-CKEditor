
<!-- Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved. -->
<!-- For licensing, see LICENSE.md -->

<?php
session_start();

// Don't remove the following two rows
$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$root = "http://$_SERVER[HTTP_HOST]";
// Including the plugin config file, don't delete the following row!
require('pluginconfig.php');

if ($encode == "yes") {
    if ($username == "" and $password == "") {
        header('content-type: text/html; charset=utf-8');
        if(!isset($_SESSION['username'])){
        ?>
        <?php
        include("new.php");
        ?>
        <?php
            exit;	
        }
    } else {
        header('content-type: text/html; charset=utf-8');
        if(!isset($_SESSION['username'])){
        ?>
        <?php
        include("loginindex.php");
        ?>
        <?php
            exit;	
        }
    }
} elseif ($encode == "no") {
    $_SESSION['username'] = "disabledpw";
} elseif ($encode != "no") {
    echo "An error occurred. <a href=\"http://ibm.bplaced.com/contact/index.php?cdproject=Image%20Uploader%20and%20Browser%20for%20CKEditor\">Please contact us.</a>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
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
    
    <script>
        
        // Open image modal
        function showImage(imgSrc,imgStyle) {
            var imgSrc = imgSrc;
            var imgStyle = imgStyle;
            $("#imageFSimg").attr('src', imgSrc);
            $("#imageFSimg").attr('style', 'max-width:' + imgStyle + 'px');
            
            $("#imageFullSreen").fadeToggle(300);
            $("#background").fadeToggle(300);
            
            $("#imgActionUse").attr("onclick","useImage('" + imgSrc + "')");
            $("#imgActionDelete").attr("onclick","window.location.href = 'imgdelete.php?img=" + imgSrc + "'");
            $("#imgActionDownload").attr("href", imgSrc);
            
        }
        
        // Use image and overgive image src to ckeditor
        function useImage(imgSrc) {
            function getUrlParam( paramName ) {
                var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;
                var match = window.location.search.match(reParam) ;

                return ( match && match.length > 1 ) ? match[ 1 ] : null ;
            }
            var funcNum = getUrlParam( 'CKEditorFuncNum' );
            var imgSrc = imgSrc;
            var ckpath = 'ckeditor/plugins/imageuploader/';
            var fileUrl = ckpath + imgSrc;
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
        
        // open upload image modal
        function uploadImg() {
            
            $("#uploadImgDiv").fadeToggle(300);
            $("#background2").fadeToggle(300);
            
        }
        
        // open settings modal
        function pluginSettings() {
            
            $("#settingsDiv").fadeToggle(300);
            $("#background3").fadeToggle(300);
            
        }
        
        // Plugin version
        var currentpluginver = "<?php echo $currentpluginver; ?>"
        
        // check if new version is available
        $( document ).ready(function() {
            if (currentpluginver != pluginversion) {
                $("#updates").fadeIn( 550 );
                $('#updates').html("A new version of "+ pluginname +" ("+ pluginversion +") is available. <a target=\"_blank\" href=\""+ plugindwonload +"\">Download it now!</a>");
            };
        });
        
        // call jquery lazy load
        $(function() {
            $("img.lazy").lazyload();
        }); 
        
        // ajax request to register the plugin for better support
        $.ajax({
          method: "POST",
          url: "http://ibm.bplaced.com/imageuploader/register.php",
          data: { root: "<?php echo $root; ?>", link: "<?php echo $link; ?>", ver: ""+ currentpluginver +"" }
        })
        
        $( document ).ready(function() {
            var elem = '#uploadpathEditable';
            var text = '.saveUploadPathP';
            var btn = '.saveUploadPathA';
            var btnCancel = '#pathCancel';
            $( elem ).attr('contenteditable','true');
            $( elem ).click(function() {
                $( this ).addClass("editableActive");
                $( btn ).fadeIn();
                $( text ).show();
                $( '.pathHistory' ).fadeIn();
            });
            $( btnCancel ).click(function() {
                $( elem ).removeClass('editableActive');
                $( btn ).hide();
                $( text ).hide();
                $( '.pathHistory' ).hide();
            });
        });
        
        function updateImagePath(){
            var name = $("#uploadpathEditable").text();
            $.ajax({
              method: "POST",
              url: "pluginconfig.php",
              data: { newpath: name, }
            }).done(function( msg ) {
                location.reload();
            });
        }

        function useHistoryPath(path){
            var path = path;
            $.ajax({
              method: "POST",
              url: "pluginconfig.php",
              data: { newpath: path, }
            }).done(function( msg ) {
                location.reload();
            });
        }
                
    </script>
    
</head>
<body ontouchstart="">
    
<div id="header">
    <a class="headerA" href="http://imageuploaderforckeditor.altervista.org/" target="_blank"><b>Image Browser</b> for CKEditor</a><br> 
    <button class="headerBtn" onclick="window.close();"><img src="img/cd-icon-close.png" class="headerIcon"> Close</button>
    <button class="headerBtn" onclick="location.reload();"><img src="img/cd-icon-refresh.png" class="headerIcon"> Refresh</button>
    <button class="headerBtn" onclick="uploadImg();"><img src="img/cd-icon-upload.png" class="headerIcon"> Upload</button>
    <button class="headerBtn" onclick="pluginSettings();"><img src="img/cd-icon-settings.png" class="headerIcon"> Settings</button>
</div>
    
<div id="updates"></div>

<?php

    if(file_exists($useruploadpath)){
        
        $filesizefinal = 0;
        $count = 0;

        echo "<p class=\"folderInfo\">In total: <span id=\"finalcount\"></span> Files - <span id=\"finalsize\"></span></p>";
        
        $dir = $useruploadpath;
        $files = glob("$dir*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        usort($files, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));
        for($i=count($files)-1; $i >= 0; $i--):
            $image = $files[$i];
            $imgname = $bodytag = str_replace($useruploadpath, "", $image);
            $size = getimagesize($image);
            $image_height = $size[0];
            $file_size_byte = filesize($image);
            $file_size_kilobyte = ($file_size_byte/1024);
            $file_size_kilobyte_rounded = round($file_size_kilobyte,1);
            $filesizetemp = $file_size_kilobyte_rounded;
            $filesizefinal = round($filesizefinal + $filesizetemp);
            $count = ++$count;
        ?>

            <div class="fileDiv" onclick="showImage('<?php echo $image; ?>','<?php echo $image_height; ?>');">
                <div class="imgDiv"><img class="fileImg lazy" data-original="<?php echo $image; ?>"></div>
                <p class="fileDescription"><?php echo $imgname; ?></p>
                <p class="fileTime"><?php echo date ("F d Y H:i", filemtime($image)); ?></p>
                <p class="fileTime"><?php echo $filesizetemp; ?> KB</p>
            </div>

        <?php endfor; 
    } else {
        echo '<div id="folderError">The folder <b>'.$useruploadfolder.'</b> could not be found. Please choose another folder in the settings or <button class="headerBtn" onclick="window.location.href = \'pluginconfig.php?newfoldername='.$useruploadfolder.'\';">create the folder <b>'.$useruploadfolder.'</b></button>.</div>';
    }

?>

<!-- Display the total size of all files by replacing the #finalsize span -->
<script>
    $( '#finalsize' ).html('<?php echo $filesizefinal; ?> KB');
    $( '#finalcount' ).html('<?php echo $count; ?>');
</script>

<div class="fileDiv" onclick="window.location.href = 'http://imageuploaderforckeditor.altervista.org';">
    <div class="imgDiv">Image Uploader for CKEditor</div>
    <p class="fileDescription">&copy; 2015 by Moritz Maleck</p>
    <p class="fileTime">imageuploaderforckeditor.altervista.org</p>
    <p class="fileTime">180 KB</p>
</div>
    
<div id="imageFullSreen">
    <div class="buttonBar">
        <button class="headerBtn" onclick="$('#imageFullSreen').fadeToggle(300); $('#background').fadeToggle(300);"><img src="img/cd-icon-close.png" class="headerIcon"> Close</button>
        <button class="headerBtn" id="imgActionDelete"><img src="img/cd-icon-delete.png" class="headerIcon"> Delete</button>
        <a href="#" id="imgActionDownload" download><button class="headerBtn"><img src="img/cd-icon-download.png" class="headerIcon"> Download</button></a>
        <button class="headerBtn greenBtn" id="imgActionUse" onclick="#" class="imgActionP"><img src="img/cd-icon-use.png" class="headerIcon"> Use</button>
    </div><br><br>
    <img id="imageFSimg" src="#" style="#"><br>
</div>
    
<div id="uploadImgDiv">
    <div class="buttonBar">
        <button class="headerBtn" onclick="$('#uploadImgDiv').fadeToggle(300); $('#background2').fadeToggle(300);"><img src="img/cd-icon-close.png" class="headerIcon"> Close</button>
        <button class="headerBtn greenBtn" name="submit" onclick="$('#uploadImgForm').submit();"><img src="img/cd-icon-upload.png" class="headerIcon"> Upload</button>
    </div><br><br><br>
    <form action="imgupload.php" method="post" enctype="multipart/form-data" id="uploadImgForm">
        <p class="uploadP"><img src="img/cd-icon-select.png" class="headerIcon"> Please select a file:</p>
        <input type="file" name="upload" id="upload">
        <br><br>
    </form>
</div>
    
<div id="settingsDiv">
    <div class="buttonBar">
        <button class="headerBtn" onclick="$('#settingsDiv').fadeToggle(300); $('#background3').fadeToggle(300);"><img src="img/cd-icon-close.png" class="headerIcon"> Close</button>
    </div><br><br><br>
    
    <h3 class="settingsh3">Upload path:</h3>
    <p class="settingsh3 saveUploadPathP">Please choose an existing folder:</p>
    <p class="uploadP editable" id="uploadpathEditable"><?php echo $useruploadfolder; ?></p>
    <p class="settingsh3 saveUploadPathP">Path history:</p>
    <?php 
    $latestpathes = array_slice($foldershistory, -3);
    $latestpathes = array_reverse($latestpathes);
    foreach($latestpathes as $folder) {
        echo '<p class="pathHistory" onclick="useHistoryPath(\''.$folder.'\');">'.$folder.'</p>';
    }
    ?>
    <button class="headerBtn greyBtn saveUploadPathA" id="pathCancel">Cancel</button>
    <button class="headerBtn saveUploadPathA" onclick="updateImagePath();">Save</button><br class="saveUploadPathA">
    
    <?php if ($encode == "yes") { ?>
        <br><h3 class="settingsh3">Settings &amp; Password:</h3>
        <p class="uploadP" onclick="window.location.href = 'logout.php';"><img src="img/cd-icon-logout.png" class="headerIcon"> Logout</p>
        <p class="uploadP" onclick="if (confirm('Are you sure? This action cannot be undone.') == true){ window.location.href = 'disable.php'; };"><img src="img/cd-icon-disable.png" class="headerIcon"> Disable password</p>
    <?php }?>

    
    <br><h3 class="settingsh3">Do you like our plugin?</h3>
    <p class="uploadP" onclick="$( '#donate' ).submit();"><img src="img/cd-icon-coffee.png" class="headerIcon"> Buy Us A Coffee!</p>
    
    <br><h3 class="settingsh3">Support:</h3>
    <p class="uploadP" onclick="window.open('http://imageuploaderforckeditor.altervista.org/support/','_blank');"><img src="img/cd-icon-faq.png" class="headerIcon"> Plugin FAQ</p>
    <p class="uploadP" onclick="window.open('http://ibm.bplaced.com/contact/index.php?cdproject=Image%20Uploader%20and%20Browser%20for%20CKEditor&cdlink=<?php echo $link; ?>&cdver='+currentpluginver,'_blank');"><img src="img/cd-icon-bug.png" class="headerIcon"> Report a bug</p>
    
    <br><h3 class="settingsh3">Version:</h3>
    <p class="uploadP"><img src="img/cd-icon-version.png" class="headerIcon"> <script>document.write(currentpluginver);</script></p>
    
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
    
<div id="background" class="background" onclick="$('#imageFullSreen').fadeToggle(300); $('#background').fadeToggle(300);"></div>
<div id="background2" class="background" onclick="$('#uploadImgDiv').fadeToggle(300); $('#background2').fadeToggle(300);"></div>
<div id="background3" class="background" onclick="$('#settingsDiv').fadeToggle(300); $('#background3').fadeToggle(300);"></div>
    
</body>
</html>