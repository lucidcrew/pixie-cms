<?php

	$debug = 'no';	// Set this to yes to debug and see all the global vars coming into the file

	// Here we check to make sure that the GET/POST/COOKIE and SESSION variables have not been poisioned
	// by an intruder before they are extracted

	if (isset($_REQUEST['_GET'])) { exit('Pixie Installer - createuser.php - An attempt to modify get data was made.'); }
	if (isset($_REQUEST['_POST'])) { exit('Pixie Installer - createuser.php - An attempt to modify post data was made.'); }
	if (isset($_REQUEST['_COOKIE'])) { exit('Pixie Installer - createuser.php - An attempt to modify cookie data was made.'); }
	if (isset($_REQUEST['_SESSION'])) { exit('Pixie Installer - createuser.php - An attempt to modify session data was made.'); }

	extract($_REQUEST);

	include "../config.php";
	include "../lib/lib_db.php";       																				// load libraries order is important
	include "../lib/lib_misc.php";     																				//

	if (strnatcmp(phpversion(),'5.1.0') >= 0) 
	{ 
	date_default_timezone_set("$server_timezone");		/* !New built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */	# equal or newer 
	}

	print ($do);

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
	}

if ($user_new) {

	$table_name = "pixie_users";
	if (!$error) {

		$password = generate_password(6);
		$nonce = md5( uniqid( rand(), true ) );
		$sql = "user_name = '$uname', realname = '$realname', email = '$email', pass = password(lower('$password')), nonce = '$nonce', privs = '$privs', biography =''"; 

		$ok = safe_insert($table_name, $sql);

		if (!$ok) {
			$message = "Error saving new $table_name entry. Possible duplicate user name.";
		} else {
			// send email
			
				$emessage = "
Your account information for Pixie has been set to:

username: $uname
password: $password

";
			 
			$subject = "Pixie account information";
			mail($email, $subject, $emessage);
			
			$messageok = "Saved new user $uname, a temp password has been created (<b>$password</b>).";
		}
		
	} else {
		$err = explode("|",$error);
		$message = $err[0];
	}
} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

	<!-- 
	Pixie Powered (www.getpixie.co.uk)
	Licence: GNU General Public License v3                   		 
	Copyright (C) <?php print date("Y");?>, Scott Evans   
	                             
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see http://www.gnu.org/licenses/   
    
	www.getpixie.co.uk                          
	-->
	
	<title>Pixie (www.getpixie.co.uk) - Create User</title>
	
	<!-- meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="elev3n, eleven, 11, 3l3v3n, el3v3n, binary, html, xhtml, css, php, xml, mysql, flash, actionscript, action, script, web standards, accessibility, scott, evans, scott evans, sunk, media, www.sunkmedia.co.uk, scripts, news, portfolio, shop, blog, web, design, print, identity, logo, designer, fonts, typography, england, uk, london, united kingdom, staines, middlesex, computers, mac, apple, osx, os x, windows, linux, itx, mini, pc, gadgets, itunes, mp3, technology" />
	<meta name="description" content="elev3n.co.uk - web and print design portfolio for scott evans (uk)." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="Scott Evans" />
  	<meta name="copyright" content="Scott Evans" />
  	
	<!-- CSS -->
	<link rel="stylesheet" href="../admin/theme/style.php" type="text/css" media="screen"  />
	<style type="text/css">
		body, html
			{
			height: auto;
			background: #191919;
			}
		
		#bg
			{
			background: #191919 url(background.jpg) 7px 0px no-repeat;
			width: 790px;
			min-height: 670px;
			margin: 0 auto;
			padding-top: 100px;
			}
			
		#placeholder
			{
			border: 5px solid #e1e1e1;
			clear: left;
			padding: 15px 30px 20px 30px;
			margin: 0 auto;
			background-color: #fff;
			width: 400px;
			line-height: 15pt;
			min-height: 480px;
			}
		
		#logo
			{
			margin: 0 auto;
			width:470px;
			display: block;
			}
		
		p
			{
			font-size: 0.8em;
			padding: 15px 0;
			}
		
		legend
			{
			color: #109bd4;
			}
		
		.form_text
			{
			width: 322px;
			}

		.form_item_drop select
			{
			width: 333px;
			padding: 2px;
			}
		
		label
			{
			float: left;
			}
			
		.form_help
			{
			float: left;
			font-size: 0.7em;
			padding-left: 5px;
			position: relative;
			top: 2px;
			}
		
		.form_item_drop
			{
			clear: both;
			}
		
		.help
			{
			margin: 0;
			padding: 0;
			color: #898989;
			}

		.error, .notice, .success    
			{ 
			padding: 15px; 
			border: 2px solid #ddd; 
			width: 436px;
			margin: 0 auto;
			}
			
		.error      
			{ 
			background: #FBE3E4;
			color: #D12F19;
			border-color: #FBC2C4; 
			}
			
		.notice     
			{ 
			background: #FFF6BF; 
			color: #817134; 
			border-color: #FFD324; 
			}
			
		.success    
			{ 
			background: #E6EFC2; 
			color: #529214; 
			border-color: #C6D880; 
			}

	</style>
	
	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../../files/images/apple_touch_icon.jpg"/>
	
</head>

<body>
	<div id="bg">
	<?php
	if ($message) {
		print "<p class=\"error\">$message</p>";
	}
	if ($messageok) {
		print "<p class=\"success\">$messageok</p>";
	}
	?>
		<img src="banner.gif" alt="Pixie logo" id="logo">
		<div id="placeholder">
			<h3>Create a user</h3>
				<p>Please fill in the user details below:</p>
				<form action="createuser.php" method="post" class="form">
					<fieldset>
						<div class="form_row">
							<div class="form_label"><label for="uname">Username <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="uname" value="" size="20" maxlength="80" id="uname" /></div>
						</div>
						
						<div class="form_row">
							<div class="form_label"><label for="realname">Real Name <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="realname" value="" size="20" maxlength="80" id="realname" /></div>
						</div>

						<div class="form_row">
							<div class="form_label"><label for="email">Email <span class="form_required">*</span></label></div>
							<div class="form_item"><input type="text" class="form_text" name="email" value="" size="20" maxlength="80" id="email" /></div>
						</div>

						<div class="form_row">
							<div class="form_label"><label for="privs">Permissions <span class="form_required">*</span></label></div>
							<div class="form_item_drop"><select class="form_select" name="privs" id="privs">
								<option value="0">User</option>
								<option value="1">Client</option>
								<option value="2">Admin</option>
								<option value="3" selected="selected">Super User</option>
							</select></div>
						</div>
						<div class="form_row_button" id="form_button">
							<input type="submit" name="user_new" class="form_submit" value="Create" />
						</div>
					</fieldset>
				</form>
 			</div>
 		</div>
  <?php if ($debug == 'yes') {
  /* Show the defined global vars */ print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
  phpinfo();
  } ?>
</body> 	
