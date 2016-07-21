<?php
// Including the plugin init file, don't delete the following row!
require_once(__DIR__ . '/plugininit.php');

//Ensure user connected, otherwise fallback on login page
if(!isset($_SESSION['username'])){
	require_once(__DIR__ . '/loginindex.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="<?=$load_lang_code?>">
<head>
    <meta charset="utf-8">
    <title><?php echo $imagebrowser1; ?> :: Delete</title>
    <script src="dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
</head>
<body>

<?php

$imgName = filter_input(INPUT_GET, 'img', FILTER_SANITIZE_STRING);
$imgSrc = $useruploadpath.$imgName;

// ckeck if file exists
if(file_exists($imgSrc)){
	// check if file is available to delete
	if (is_writable($imgSrc)) {
		// check if file is a sytem file
		$imgBasepath = pathinfo($imgSrc);
		$imgBasename = $imgBasepath['basename'];
		if(!in_array($imgBasename, $sy_icons)){
			// check if the selected file is in the upload folder
			$imgDirname = $imgBasepath['dirname'];
			$preExamplePath = "$useruploadpath/test.txt";
			$tmpUserUPath = pathinfo($preExamplePath);
			$useruploadpathDirname = $tmpUserUPath['dirname'];
			if($imgDirname == $useruploadpathDirname){
				// check if file is an image
				$a = getimagesize($imgSrc);
				$image_type = $a[2];
				if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG , IMAGETYPE_PNG , IMAGETYPE_ICO))) {
					unlink($imgSrc);
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				} else {
					echo '
                        <script>
                        swal({
                          title: "'.$dltimageerrors1.'",
                          text: "'.$dltimageerrors2.'",
                          type: "error",
                          closeOnConfirm: false
                        },
                        function(){
                          history.back();
                        });
                        </script>
                    ';
				}
			} else {
				echo '
                    <script>
                    swal({
                      title: "'.$dltimageerrors1.'",
                      text: "'.$dltimageerrors3.'",
                      type: "error",
                      closeOnConfirm: false
                    },
                    function(){
                      history.back();
                    });
                    </script>
                ';
			}
		} else {
			echo '
                <script>
                swal({
                  title: "'.$dltimageerrors1.'",
                  text: "'.$dltimageerrors4.'",
                  type: "error",
                  closeOnConfirm: false
                },
                function(){
                  history.back();
                });
                </script>
            ';
		}
	} else {
		echo '
            <script>
            swal({
              title: "'.$dltimageerrors1.'",
              text: "'.$dltimageerrors5.'",
              type: "error",
              closeOnConfirm: false
            },
            function(){
              history.back();
            });
            </script>
        ';
	}
} else {
	echo '
        <script>
        swal({
          title: "'.$dltimageerrors1.'",
          text: "'.$dltimageerrors6.'",
          type: "error",
          closeOnConfirm: false
        },
        function(){
          history.back();
        });
        </script>
    ';
}

?>

</body>
</html>
