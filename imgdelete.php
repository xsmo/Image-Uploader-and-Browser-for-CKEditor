<?php

session_start();
if(isset($_SESSION['username'])){
    
    $imgSrc = $_GET["img"];
    
    $a = getimagesize($imgSrc);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG))) {
        unlink($imgSrc);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo '
            <script>
            alert("You can only delete images. Please try again or delete another image.");
            history.back();
            </script>
        ';
    }
    
}
