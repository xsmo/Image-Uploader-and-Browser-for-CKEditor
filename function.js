// Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved.
// For licensing, see LICENSE.md

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

function extensionSettings(setting){
    var setting = setting;
    $.ajax({
      method: "POST",
      url: "pluginconfig.php",
      data: { 
          extension: setting,
      }
    }).done(function( msg ) {
        location.reload();
    });
}

function checkUpload(){
    if( document.getElementById("upload").files.length == 0 ){
        alert("Please select a file to upload.");
        return false;
    }
}