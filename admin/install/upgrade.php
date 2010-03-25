<?php
error_reporting(0);
/* error_reporting(-1); */
/* Turns off or on error reporting */
if (!file_exists('../config.php') or filesize('../config.php') < 10) { // check for config
	require '../lib/lib_db.php';
	db_down();
	exit();
}
if (!defined('DIRECT_ACCESS')) {
	define('DIRECT_ACCESS', 1);
}
/* very important to set this first, so that we can use the new config.php */
require '../lib/lib_misc.php';
globalSec('Pixie Installer upgrade.php', 1);
require '../config.php';
include '../lib/lib_db.php';
$prefs = get_prefs();
/* turn the prefs into an array */
extract($prefs);
/* add prefs to globals using php's extract function */
if (strnatcmp(phpversion(), '5.1.0') >= 0) {
	if (!isset($server_timezone)) {
		$server_timezone = 'Europe/London';
	}
	date_default_timezone_set("$server_timezone");
}
/* New! Built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */
define('TZ', "$timezone");
/* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
/* This should become a core function in the admin area as part of an auto updater. Wdyt? */
include '../lib/lib_date.php';
include '../lib/lib_validate.php';
include '../lib/lib_core.php';
include '../lib/lib_backup.php';
$pixie_switch_charset = NULL;
$pixie_new_htaccess   = NULL;
$pixie_db_patch       = NULL;
if (isset($pixie_step)) {
} else {
	$pixie_step = NULL;
}
/* List of timezones to use to set pixie's timezone with */
$zonelist = array(
	'Pacific/Midway',
	'Pacific/Samoa',
	'Pacific/Honolulu',
	'America/Anchorage',
	'America/Los_Angeles',
	'America/Tijuana',
	'America/Denver',
	'America/Chihuahua',
	'America/Mazatlan',
	'America/Phoenix',
	'America/Regina',
	'America/Tegucigalpa',
	'America/Chicago',
	'America/Mexico_City',
	'America/Monterrey',
	'America/New_York',
	'America/Bogota',
	'America/Lima',
	'America/Rio_Branco',
	'America/Indiana/Indianapolis',
	'America/Caracas',
	'America/Halifax',
	'America/Manaus',
	'America/Santiago',
	'America/La_Paz',
	'America/St_Johns',
	'America/Argentina/Buenos_Aires',
	'America/Sao_Paulo',
	'America/Godthab',
	'America/Montevideo',
	'Atlantic/South_Georgia',
	'Atlantic/Azores',
	'Atlantic/Cape_Verde',
	'Europe/Dublin',
	'Europe/Lisbon',
	'Africa/Monrovia',
	'Atlantic/Reykjavik',
	'Africa/Casablanca',
	'Europe/Belgrade',
	'Europe/Bratislava',
	'Europe/Budapest',
	'Europe/Ljubljana',
	'Europe/Prague',
	'Europe/Sarajevo',
	'Europe/Skopje',
	'Europe/Warsaw',
	'Europe/Zagreb',
	'Europe/Brussels',
	'Europe/Copenhagen',
	'Europe/Madrid',
	'Europe/Paris',
	'Africa/Algiers',
	'Europe/Amsterdam',
	'Europe/Berlin',
	'Europe/Rome',
	'Europe/Stockholm',
	'Europe/Vienna',
	'Europe/Minsk',
	'Africa/Cairo',
	'Europe/Helsinki',
	'Europe/Riga',
	'Europe/Sofia',
	'Europe/Tallinn',
	'Europe/Vilnius',
	'Europe/Athens',
	'Europe/Bucharest',
	'Europe/Istanbul',
	'Asia/Jerusalem',
	'Asia/Amman',
	'Asia/Beirut',
	'Africa/Windhoek',
	'Africa/Harare',
	'Asia/Kuwait',
	'Asia/Riyadh',
	'Asia/Baghdad',
	'Africa/Nairobi',
	'Asia/Tbilisi',
	'Europe/Moscow',
	'Europe/Volgograd',
	'Asia/Tehran',
	'Asia/Muscat',
	'Asia/Baku',
	'Asia/Yerevan',
	'Asia/Yekaterinburg',
	'Asia/Karachi',
	'Asia/Tashkent',
	'Asia/Kolkata',
	'Asia/Colombo',
	'Asia/Katmandu',
	'Asia/Dhaka',
	'Asia/Almaty',
	'Asia/Novosibirsk',
	'Asia/Rangoon',
	'Asia/Krasnoyarsk',
	'Asia/Bangkok',
	'Asia/Jakarta',
	'Asia/Brunei',
	'Asia/Chongqing',
	'Asia/Hong_Kong',
	'Asia/Urumqi',
	'Asia/Irkutsk',
	'Asia/Ulaanbaatar',
	'Asia/Kuala_Lumpur',
	'Asia/Singapore',
	'Asia/Taipei',
	'Australia/Perth',
	'Asia/Seoul',
	'Asia/Tokyo',
	'Asia/Yakutsk',
	'Australia/Darwin',
	'Australia/Adelaide',
	'Australia/Canberra',
	'Australia/Melbourne',
	'Australia/Sydney',
	'Australia/Brisbane',
	'Australia/Hobart',
	'Asia/Vladivostok',
	'Pacific/Guam',
	'Pacific/Port_Moresby',
	'Asia/Magadan',
	'Pacific/Fiji',
	'Asia/Kamchatka',
	'Pacific/Auckland',
	'Pacific/Tongatapu'
);
/* Add more here if you want to... */
sort($zonelist);
/* Sort by area/city name. */
extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');
/* Access to form vars */
if ((isset($pixie_server_timezone)) && ($pixie_server_timezone)) {
} else {
	if ((isset($pixieconfig['server_timezone'])) && ($pixieconfig['server_timezone'])) {
		$pixie_server_timezone = $pixieconfig['server_timezone'];
	} else {
		$pixie_server_timezone = 'Europe/London';
	}
}
if ((isset($pixie_charset)) && ($pixie_charset)) {
} else {
	if ((isset($pixieconfig['site_charset'])) && ($pixieconfig['site_charset'])) {
		$pixie_charset = $pixieconfig['site_charset'];
	} else {
		$pixie_charset = 'UTF-8';
	}
}
if ((isset($pixie_switch_charset)) && ($pixie_switch_charset == 'yes')) {
	$tables = safe_query('SHOW TABLES');
	$error  = NULL;
	while ($row = mysql_fetch_array($tables)) {
		foreach ($row as $key => $table) {
			$query = safe_query("ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
			if ($query) {
			} else {
				$error .= "<span>{$key} =&gt; {$table} CONVERSION FAILED</span><br />";
			}
		}
	}
}
if ((file_exists('../../.htaccess')) && (isset($pixie_new_htaccess)) && ($pixie_new_htaccess == 'yes')) {
	@chmod('../../.htaccess', 0777); // Try to chmod the .htaccess file
	$fh = fopen('../../.htaccess', 'w') or $error .= "Please check the permissions of the file .htaccess and enable writing to it. Then please click <a href=\"./upgrade.php\">here</a> and try again.";
	$clean = str_replace('/admin/install/upgrade.php', "", $_SERVER["REQUEST_URI"]);
	if (!$clean) {
		$clean = '/';
	}
	$data_1 = "#
# Apache-PHP-Pixie .htaccess
#
# Pixie Powered (www.getpixie.co.uk)
# Licence: GNU General Public License v3

# Pixie. Copyright (C) 2008 - Scott Evans

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program. If not, see http://www.gnu.org/licenses/   

# www.getpixie.co.uk                          

# This file was automatically created for you by the Pixie Installer.

# .htaccess rules  - Start :

# Set the default charset
AddDefaultCharset UTF-8

# Set the default handler.
DirectoryIndex index.php

# Rewrite rules - Start :
<IfModule mod_rewrite.c>
Options +FollowSymLinks
RewriteEngine On

# If your site can be accessed both with and without the 'www.' prefix, you
# can use one of the following settings to redirect users to your preferred
# URL, either WITH or WITHOUT the 'www.' prefix.
# By default your users can usually access your site using http://www.yoursite.com
# or http://yoursite.com but it is highly advised that you use the
# actual domain http://yoursite.com by redirecting to it using this file
# because http://www.yoursite.com is simply a subdomain of http://yoursite.com
# the www. is pointless in most applications.
# Choose ONLY one option:

# To redirect all users to access the site WITH the 'www.' prefix,
# (http://yoursite.com/... will be redirected to http://www.yoursite.com/...)
# adapt and uncomment the following two lines :

# RewriteCond %{HTTP_HOST} ^yoursite\.com$ [NC]
# RewriteRule ^(.*)$ http://www.yoursite.com/$1 [L,R=301]

# This next one is the one everyone is advised to select.

# To redirect all users to access the site WITHOUT the 'www.' prefix,
# (http://www.yoursite.com/... will be redirected to http://yoursite.com/...)
# uncomment and adapt the following two lines :

# RewriteCond %{HTTP_HOST} ^www\.yoursite\.com$ [NC]
# RewriteRule ^(.*)$ http://yoursite.com/$1 [L,R=301]

# You can change the RewriteBase if you are using pixie in
# a subdirectory or in a VirtualDocumentRoot and clean urls
# do not function correctly after you have turned them on :

RewriteBase $clean

# Rewrite rules to prevent common exploits - Start :
# Block out any script trying to base64_encode junk to send via URL
RewriteCond %{QUERY_STRING} base64_encode.*\(.*\) [OR]
# Block out any script that includes a <script> tag in URL
RewriteCond %{QUERY_STRING} (\<|%3C).*script.*(\>|%3E) [NC,OR]
# Block out any script trying to set a PHP GLOBALS variable via URL
RewriteCond %{QUERY_STRING} GLOBALS(=|\[|\%[0-9A-Z]{0,2}) [OR]
# Block out any script trying to modify a _REQUEST variable via URL
RewriteCond %{QUERY_STRING} _REQUEST(=|\[|\%[0-9A-Z]{0,2})
# Send all blocked request to homepage with 403 Forbidden error!
RewriteRule ^(.*)$ index.php [F,L]
# End - Rewrite rules to prevent common exploits

# Pixie's core mod rewrite rules - Start :
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*) index.php?%{QUERY_STRING} [L]
# End - Pixie's core mod rewrite rules

</IfModule>

# End - rewrite rules

# Protect files and directories
<FilesMatch \"\.(engine|inc|info|install|module|profile|test|po|sh|.*sql|theme|tpl(\.php)?|xtmpl|svn-base)$|^(code-style\.pl|Entries.*|Repository|Root|Tag|Template|all-wcprops|entries|format)$\">
Order allow,deny
</FilesMatch>

# Don't show directory listings for URLs which map to a directory.
Options -Indexes

# Make Pixie handle any 404 errors.
ErrorDocument 404 /index.php

# Deny access to extension xml files (Comment out to de-activate.) - Start :
<Files ~ \"\.xml$\">
Order allow,deny
Deny from all
Satisfy all
</Files>
# End - Deny access to extension xml files

# Deny access to htaccess and htpasswd files (Comment out to de-activate.) - Start :
<Files ~ \"\.ht$\">
order allow,deny
deny from all
Satisfy all
</Files>
# End - Deny access to extension htaccess and htpasswd files

# Extra features - Start :

# Requires mod_expires to be enabled. mod_expires rules - Start :
<IfModule mod_expires.c>
# Enable expirations
ExpiresActive On
# Cache all files for 1 week after access (A).
ExpiresDefault A604800
# Do not cache dynamically generated pages.
ExpiresByType text/html A1
</IfModule>
# End - mod_expires rules

# End - Extra features

# End - .htaccess rules";
	fwrite($fh, $data_1);
	fclose($fh);
	/* @chmod('../../.htaccess', 0644); */ /* Disabled due to possible bug */
}
if ((isset($pixie_db_patch)) && ($pixie_db_patch == 'yes')) {
	$fh = fopen('../config.php', 'w') or $error .= "Please check the permissions of the file admin/config.php and enable writing to it. Then please click <a href=\"./upgrade.php\">here</a> and try again.";
	$data_2 = "<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../');
	exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: Configuration settings
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
/* MySQL settings */
\$pixieconfig['db']           = '{$pixieconfig['db']}';
\$pixieconfig['user']         = '{$pixieconfig['user']}';
\$pixieconfig['pass']         = '{$pixieconfig['pass']}';
\$pixieconfig['host']         = '{$pixieconfig['host']}';
\$pixieconfig['table_prefix'] = '{$pixieconfig['table_prefix']}';
/* Timezone - (Server time zone) */
\$pixieconfig['server_timezone'] = '$pixie_server_timezone';
/* Foreign language database bug fix */
\$pixieconfig['site_charset'] = '$pixie_charset';
?>";
	fwrite($fh, $data_2);
	fclose($fh);
	@chmod('../config.php', 0640);
	/* Chmod config.php so that the database details don't get exposed by accident */
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

	<!-- 
	Pixie Powered (www.getpixie.co.uk)
	Licence: GNU General Public License v3
	Copyright (C) 2008 <?php
print date('Y');
?>, Scott Evans   

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

	<title>Pixie (www.getpixie.co.uk) - Upgrade-O-Matic :: Upgrade Utility</title>

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

	<?php
if ((isset($error)) && ($error)) {
	print "<p class=\"error\">$error</p>";
}
?>

	<div id="logo-holder"><img src="banner.gif" alt="Pixie logo" id="logo"></div>
	<div id="placeholder">

<?php
switch ($pixie_step) {
	case 1:
		$upgrades = 'upgrade.sql';
		/* Load external sql */
		$upgrade  = file($upgrades);
		foreach ($upgrade as $query) {
			safe_query($query);
		}
?>
		<h3>Complete!</h3>

		<p class="toptext">The <a href="http://www.getpixie.co.uk" alt="Get Pixie!" target="_blank">Pixie</a> Upgrade Utility has finished it's task.<br /><br />Please correct any errors listed above and read the warnings listed below to avoid problems.<br />Please also make sure that you delete the install directory and ensure that Pixie's files are not world writeable.<br /></p>
<p>You can return to your homepage by clicking <a href="../../" alt="Get Pixie!">here</a>.</p>
			<fieldset>
			<legend>Important upgrade information</legend>

<div class="form_item">Please ensure that you do the following to complete the upgrade process :<span class="form_help"><br /><?php
		if ((isset($error)) && ($error)) {
			print 'Please first correct the errors found before proceeding.';
		} else {
?><br />chmod the file .htaccess to 644<br />chmod the file admin/config.php to 640<br />Delete the directory admin/install<br /><br /><?php
		}
?></span></div><br /><br />

				<div class="safclear"></div>

			</fieldset>

<div class="divcentertext2"><br /><b>Thank you for installing Pixie!</b></div><br />
<?php
		break;
?>

<?php
	default:
?>

		<h3>Mmm... Upgrades!</h3>

		<p class="toptext">Welcome to the <a href="http://www.getpixie.co.uk" alt="Get Pixie!" target="_blank">Pixie</a> Upgrade Utility.<br />Please first review your options and then on click the OK button below to upgrade your Pixie powered site.<br /><br /><b>WARNING!</b><br />Please read the upgrade advisories found <a href="http://code.google.com/p/pixie-cms/wiki/Upgrading" alt="Pixie Wiki" target="_blank">here</a> first and ensure that you have backed up your database along with the files .htaccess and admin/config.php before proceeding.<br />Thank You.<br />
<?php
		echo "<br /><b>For your information :</b><br />Your server is running <a href=\"http://www.php.net/\" alt=\"PHP is a widely-used general-purpose scripting language that is especially suited for Web development and can be embedded into HTML.\" target=\"_blank\">PHP</a> " . phpversion() . "";
		$mysql_version = getSqlVersion();
		if ($mysql_version !== FALSE) {
			echo "<br />and <a href=\"http://www.mysql.com/\" alt=\"MySQL is the world's most popular open source database software, with over 100 million copies of its software downloaded or distributed throughout it's history.\" target=\"_blank\">MySQL</a> {$mysql_version}.<br />";
		}
?>
		</p>
		
		<form accept-charset="UTF-8" action="upgrade.php" method="post" id="form_db" class="form">
			<fieldset>
			<legend>Upgrade Options</legend>

<div class="form_item">Do you want to try to use the new .htaccess to improve security? (Highly recommended.)<span class="form_help"><div class="form_item"><input id="create-db" type="checkbox" name="new_htaccess" value="yes">New! .htaccess </input><span class="form_help"></span></div><br /><br /></span><br /><br /><br /><br /><br /><br />
<div class="form_item">Do you want to try to use the new database connection method and setup php 5 time support correctly? (Recommended.)<span class="form_help"><div class="form_item"><input id="create-db" type="checkbox" name="db_patch" value="yes">Bug Fix : Database patch </input><span class="form_help"></span></div><br /><br /></span><br /><br /><br /><br /><br /><br />
				<div class="form_row">
					<div class="form_label"><label for="server_timezone">Timezone </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="server_timezone" id="server_timezoneselect">
							<option selected="selected" value="<?php
		print $pixie_server_timezone;
?>"><?php
		print $pixie_server_timezone;
?></option>
							<?php
		foreach ($zonelist as $tzselect) {
			// Output all the timezones
			Echo "<option value=\"$tzselect\">$tzselect</option>";
		}
?>
						</select><span class="form_help">The time zone as set on your host server</span>
					</div>
				</div><br /><br /><br /><br /><br /><br />
<div class="form_item">You can proceed by clicking OK.</div><br /><br />

				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="1" />
					<input type="submit" name="next" class="form_submit" value="OK" />
				</div><br /><br /><br /><br />

<div id="switch"></div>
			<div class="extra"><p class="advanced-heading"><span class="small-heading">Optional Extra Settings</span></p><div class="divider"></div>
				<div class="form_row">
					<div class="form_item"><input id="create-db" type="checkbox" name="switch_charset" value="yes">Convert the database </input><span class="form_help">Do you want to try to convert your database to use character set utf8 and collate utf8_unicode_ci? (Only do this if you have backed up your database and your database is not UTF-8.)</span></div><br /><br />
				</div>
	</div>
				<div class="safclear"></div>

			</fieldset>
 		</form>

<?php
		break;
?>

<?php
}
?>
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
