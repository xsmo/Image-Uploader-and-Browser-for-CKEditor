<?php
// checking lang value
if(isset($_COOKIE['sy_lang'])) {
    $load_lang_code = $_COOKIE['sy_lang'];
} else {
    $load_lang_code = "en";
}

// including lang files
switch ($load_lang_code) {
    case "en":
        require(__DIR__ . '/lang/en.php');
        break;
    case "pl":
        require(__DIR__ . '/lang/pl.php');
        break;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title><?php echo $imagebrowser1; ?> :: Fujana Solutions</title>

<!-- Jquery -->
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script>
</script>

<style>
	body {
		background-color: #073C49;
		max-width:400px;
		margin:auto;
		padding:12px;
		margin-top:5%;
		margin-bottom:6%;
		font-family:Verdana, Geneva, sans-serif;
      text-align: center;
	}
	
	.container {
		background-color:rgb(255, 255, 255);
		padding:30px;
      padding-bottom: 45px;
		border-radius:0px;
    -webkit-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2), 0px 1px 3px 0px rgba(0, 0, 0, 0.05), 0px 1px 0px rgba(255, 255, 255, 0.25) inset;
    -moz-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2), 0px 1px 3px 0px rgba(0, 0, 0, 0.05), 0px 1px 0px rgba(255, 255, 255, 0.25) inset;
    box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2), 0px 1px 3px 0px rgba(0, 0, 0, 0.05), 0px 1px 0px rgba(255, 255, 255, 0.25) inset;
		text-align:center;
      border-radius: 5px;
	}
	
	.logo {
		width:70%;
	}
	
	input {
		border-radius:0px;
		width:100%;
		border:solid;
		border-width: 2px 0px;
		border-color:#687788;
		padding:12px 7px;
		margin-bottom:12px;
		font-size:18px;
		font-weight:600;
      color: #AEB4BB;
		
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
				
		-webkit-appearance: none;
		-webkit-border-radius:0px;


	}
	
	input:focus {
    border-color: #34495E;
    opacity: 1;
	}
	
	.nameOfInput {
		font-size:14px;
		margin-bottom:12px;
		text-align:left;
		font-weight:300;
		color:#687788;
      margin-left: 7px;
	}
	
	.login_btn {
    margin-top:24px;
    background-color:#ffffff;
    border-radius:5px;
    color:#666;
    font-weight:400;
    font-size:16px;
    width:100%;
    padding:10px 10px;
    border: solid 2px #848484;
    cursor:pointer;
	}
    
    .login_btn:hover {
        background-color: #848484;
        color: #fff;
    }
	
	.hrNews {
		margin:auto;
		margin-top:7px;
      background-color: #eaeaea;
      padding: 1px 18px;
      padding-bottom: 7px;
      border-radius: 5px;
	}
    h1 { 
        color: #073c49; 
        font-family: 'Open Sans', sans-serif; 
        font-size: 34px; 
        font-weight: 300; 
        line-height: 40px; 
        margin: 0 0 16px; 
    }

    h2 { 
        color: #39424D; 
        font-family: 'Open Sans', sans-serif; 
        font-size: 20px; 
        font-weight: 300; 
        line-height: 32px; 
        margin: -10px 0px 14px;
    }
    .disable {
        color: #39424D;
        font-family: 'Open Sans', sans-serif; 
        font-size: 15px; 
        font-weight: 500; 
        line-height: 17px; 
        margin: 0px 0px 30px;
        cursor: pointer;
        text-decoration: underline;
    }
    .disable:hover { 
        color: #1862A8;
    }
    .description { 
        color: #39424D; 
        font-family: 'Open Sans', sans-serif; 
        font-size: 13px; 
        font-weight: 300; 
        line-height: 17px; 
        margin: 10px 0px -10px;
        padding-bottom: 14px;
        text-align: left;
    }
</style>
</head>
<body>
<div class="container">
	<div class="login">    
    <h1><?php echo $loginsite1; ?></h1>
    <h2><?php echo $loginsite2; ?></h2>
	<form name="form2" action="login.php" method="post">
    <p class="nameOfInput"><?php echo $loginsite3; ?></p>
    <input type="text" name="username" class="login_form">
    <p class="nameOfInput"><?php echo $loginsite4; ?></p>
    <input type="password" name="password">
    <div style="text-align:right;">
    <input class="login_btn" type="submit" value="<?php echo $loginsite5; ?>">
    </div>
    </form>
    </div>
    <br />
    <div class="hrNews"></div>
    <p style="text-align:left; font-size:13px; font-family:Verdana, Geneva, sans-serif;">
    <a href="https://imagebrowser.maleck.org/" style="font-weight:bolder; color:#1862A8; text-decoration:none; font-family:Georgia, 'Times New Roman', Times, serif; font-size:14px;">2015-2019 Image Uploader for CKEditor</a><br />
    <a href="https://support.maleck.org/index.php?p=support" style="text-decoration:underline; color:#484947;">Documentation</a>  <a href="https://support.maleck.org/index.php?p=faq" style="text-decoration:underline; color:#484947;">FAQ</a></p> 
    <div class="hrNews hrNews2"></div>
</div>
</body>
</html>