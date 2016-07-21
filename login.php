<?php
// Including the plugin init file, don't delete the following row!
require_once(__DIR__ . '/plugininit.php');

$tmpusername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$tmppassword = md5(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

if($tmpusername == $username and $password == $tmppassword) {
    $_SESSION['username'] = $tmpusername;
    header("Location: imgbrowser.php");
} else {
	header('content-type: text/html; charset=utf-8');
    echo '
        <script>
        alert("'.$loginerrors1.'");
        history.back();
        </script>
    ';
}

