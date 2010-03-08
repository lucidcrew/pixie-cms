<?php
error_reporting(0); error_reporting(-1); /* Turns on error reporting */
if (!file_exists('../config.php') or filesize('../config.php') < 10) {		// check for config
require '../lib/lib_db.php'; db_down(); exit();
}
if (!defined('DIRECT_ACCESS')) { define('DIRECT_ACCESS', 1); }	/* very important to set this first, so that we can use the new config.php */
	require '../lib/lib_misc.php';

	globalSec('Pixie Installer upgrade.php', 1);

	require '../config.php';
	include '../lib/lib_db.php';
	if (strnatcmp(phpversion(),'5.1.0') >= 0) { if (!isset($server_timezone)) { $server_timezone = 'Europe/London'; } date_default_timezone_set("$server_timezone"); }	/* New! Built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */ 
	define('TZ', "$timezone");	/* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
  /* This should become a core function in the admin area as part of an auto updater. Wdyt? */
include '../lib/lib_date.php';
include '../lib/lib_validate.php';
include '../lib/lib_core.php';
include '../lib/lib_backup.php';

extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie'); /* Access to form vars */

if ( (isset($pixie_switch_charset)) && ($pixie_switch_charset = 'yes') ) {

    $tables = safe_query('SHOW TABLES');
    $error = NULL;
    while ( $row = mysql_fetch_array($tables) )
    {
	foreach ($row as $key => $table)
	{
	    $query = safe_query("ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
		if ($query) { } else { $error .= "<span>{$key} =&gt; {$table} CONVERSION FAILED</span><br />"; }
	}
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
	Copyright (C) 2008 <?php print date('Y');?>, Scott Evans   

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
	
	<!-- meta tags -->
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="keywords" content="toggle, binary, html, xhtml, css, php, xml, mysql, flash, actionscript, action, script, web standards, accessibility, scott, evans, scott evans, sunk, media, www.getpixie.co.uk, scripts, news, portfolio, shop, blog, web, design, print, identity, logo, designer, fonts, typography, england, uk, london, united kingdom, staines, middlesex, computers, mac, apple, osx, os x, windows, linux, itx, mini, pc, gadgets, itunes, mp3, technology, www.toggle.uk.com" />
	<meta name="description" content="http://www.toggle.uk.com/ - web and print design portfolio for scott evans (uk)." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="Scott Evans" />
  	<meta name="copyright" content="Scott Evans" />

	<title>Pixie (www.getpixie.co.uk) - Upgrade Utility</title>

	<!-- CSS -->
	<link rel="stylesheet" href="../admin/theme/style.php" type="text/css" media="screen"  />
	<link rel="stylesheet" href="install.css" type="text/css" media="screen" />

	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../../files/images/apple_touch_icon.jpg"/>
	
</head>
<body>
	<div id="bg-wrap">
	<div id="bg">

	<?php if ( (isset($error)) && ($error) ) { print "<p class=\"error\">$error</p>"; } ?>

	<div id="logo-holder"><img src="banner.gif" alt="Pixie logo" id="logo"></div>
	<div id="placeholder">

<?php switch ($pixie_step) { case 1 :
$upgrades = 'upgrade.sql'; /* Load external sql */
$upgrade = file($upgrades);
foreach($upgrade as $query) { safe_query($query); }

?>
		<h3>Complete!</h3>

		<p class="toptext">The <a href="http://www.getpixie.co.uk" alt="Get Pixie!" target="_blank">Pixie</a> Upgrade Utility has finished it's task.<br /><br />Please read the warnings listed below to avoid problems.<br />Please also make sure that you delete the install directory and ensure that Pixie's files are not world writeable.<br /></p>
<p class="toptext">You can return to your homepage by clicking <a href="../../" alt="Get Pixie!">here</a>.</p>
			<fieldset>
			<legend>Important upgrade information</legend>

<div class="form_item"><span class="form_help">No information available at this time.<br /><br /></span></div><br /><br />

				<div class="safclear"></div>

			</fieldset>

<div class="divcentertext2"><br /><b>Thank you for installing Pixie!</b></div><br />
<?php break; ?>

<?php default : ?>

		<h3>Mmm... Upgrades!</h3>

		<p class="toptext">Welcome to the <a href="http://www.getpixie.co.uk" alt="Get Pixie!" target="_blank">Pixie</a> Upgrade Utility.<br />Please first review your options and then on click the OK button below to upgrade your Pixie powered site.<br /><br /><b>WARNING!</b><br />Please ensure that you have backed up your database along with the files .htaccess and admin/config.php before proceeding.<br />Thank You.<br />
<?php
    echo "<br /><b>For your information :</b><br />Your server is running <a href=\"http://www.php.net/\" alt=\"PHP is a widely-used general-purpose scripting language that is especially suited for Web development and can be embedded into HTML.\" target=\"_blank\">PHP</a> " . phpversion() . "";
    $mysql_version = getSqlVersion();
	if ( $mysql_version !== FALSE ) { echo "<br />and <a href=\"http://www.mysql.com/\" alt=\"MySQL is the world's most popular open source database software, with over 100 million copies of its software downloaded or distributed throughout it's history.\" target=\"_blank\">MySQL</a> {$mysql_version}.<br />"; }

?>
		</p>
		
		<form accept-charset="UTF-8" action="upgrade.php" method="post" id="form_db" class="form">
			<fieldset>
			<legend>Upgrade Options</legend>

<div class="form_item"><span class="form_help">No basic options available at this time.<br /><br />You can proceed by clicking OK.</span></div><br /><br />

				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="1" />
					<input type="submit" name="next" class="form_submit" value="OK" />
				</div><br /><br /><br /><br />

<div id="switch"></div>
			<div class="extra"><p class="advanced-heading"><span class="small-heading">Optional Extra Settings</span></p><div class="divider"></div>
				<div class="form_row">
					<div class="form_item"><input id="create-db" type="checkbox" name="switch_charset" value="yes">Convert the database </input><span class="form_help">Do you want to try to convert your database to use character set utf8 and collate utf8_unicode_ci?</span></div><br /><br />
				</div>
	</div>
				<div class="safclear"></div>

			</fieldset>
 		</form>

<?php break; ?>

<?php } ?>
	      </div>
	</div>
  </div>
	<!-- If javascript is disabled -->
	<noscript><style type="text/css">#bg-wrap{display:block;}.extra{display:block;}</style></noscript>
	<!-- javascript -->
	<script type="text/javascript" src="../jscript/jquery.js"></script>
	<script type="text/javascript" src="install.js"></script>

</body>
</html>
