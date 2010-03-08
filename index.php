<?php
header('Content-Type: text/html; charset=UTF-8');
//***********************************************************************//
// Pixie: The Small, Simple, Site Maker.                                 //
// ----------------------------------------------------------------------//
// Licence: GNU General Public License v3                   	         //
// Copyright (C) 2008, Scott Evans                                       //
//                                                                       //
// This program is free software: you can redistribute it and/or modify  //
// it under the terms of the GNU General Public License as published by  //
// the Free Software Foundation, either version 3 of the License, or     //
// (at your option) any later version.                                   //
//                                                                       //
// This program is distributed in the hope that it will be useful,       //
// but WITHOUT ANY WARRANTY; without even the implied warranty of        //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          //
// GNU General Public License for more details.                          //
//                                                                       //
// You should have received a copy of the GNU General Public License     //
// along with this program. If not, see http://www.gnu.org/licenses/     //                      
// ----------------------------------------------------------------------//
// Title: Index			                                         //
//***********************************************************************//
if ( (defined('DIRECT_ACCESS')) or (defined('PIXIE_DEBUG')) ) { require_once 'admin/lib/lib_misc.php'; pixieExit(); exit(); }	/* Prevent any kind of predefinition of DIRECT_ACCESS or PIXIE_DEBUG */
define('DIRECT_ACCESS', 1);													/* Knock once for yes */
if (!file_exists('admin/config.php') or filesize('admin/config.php') < 10) {							/* check for config */
if (file_exists('admin/install/index.php')) { header( 'Location: admin/install/' ); exit(); }					/* redirect to installer */
if (!file_exists('admin/install/index.php')) { require_once 'admin/lib/lib_db.php'; db_down(); exit(); }			/* redirect to an error page if down */
}
ini_set('default_charset', 'utf-8');												/* set default php charset */
require_once 'admin/lib/lib_misc.php';												/* perform basic sanity checks */
bombShelter();                  												/* check URL size */
if (PIXIE_DEBUG == 'yes') { error_reporting(-1); } else { error_reporting(0); }							/* set error reporting up if debug is enabled */

	globalSec('Main index.php', 1);												/* prevent superglobal poisoning before extraction */
	extract($_REQUEST);													/* access to form vars if register globals is off */ /* note : NOT setting a prefix yet, not looked at it yet */
	require_once 'admin/config.php';           										/* load configuration */
	include_once 'admin/lib/lib_db.php';       										/* import the database function library */
	$prefs = get_prefs();           											/* turn the prefs into an array */
	extract($prefs);													/* add prefs to globals using php's extract function */
	define('TZ', "$timezone");												/* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
	if (strnatcmp(phpversion(),'5.1.0') >= 0) {
	if (isset($server_timezone)) { } else { $server_timezone = 'Europe/London'; }
	date_default_timezone_set("$server_timezone"); }									/* New! Built in php function. Tell php what the server timezone is so that we can use php 5's rewritten time and date functions with the correct time and without error messages */
	include_once 'admin/lib/lib_logs.php'; pagetime('init');								/* start the runtime clock */
	include_once 'admin/lib/lib_validate.php';										/* import the validate library */
	include_once 'admin/lib/lib_date.php';											/* import the date library */
	include_once 'admin/lib/lib_paginator.php';										/* import the paginator library */
	include_once 'admin/lib/lib_pixie.php';											/* import the pixie library */
	include_once 'admin/lib/lib_rss.php';											/* import the rss library */
	include_once 'admin/lib/lib_tags.php';											/* import the tags library */
	include_once 'admin/lib/bad-behavior-pixie.php';									/* no spam please */
	if (strnatcmp(phpversion(),'5.0.0') >= 0) { include_once 'admin/lib/lib_simplepie_php5.php'; } else {			/* Load the php5 version of simplepie if you are running php5 */
	include_once 'admin/lib/lib_simplepie.php'; }										/* because pie should be simple */
	users_online();														/* current site visitors */
	pixie();														/* let the magic begin */
	referral();														/* referral */
	include_once "admin/lang/{$language}.php";										/* get the language file */
	include_once "admin/themes/{$site_theme}/settings.php";									/* load the current themes settings */
	if ((isset($s)) && ($s == 404)) { header('HTTP/1.0 404 Not Found'); }							/* send correct header for 404 pages */
	if ($m == 'rss') { if (isset($s)) { rss($s, $page_display_name, $page_id); }						/* rss */
	} else { if (isset($s)) { $page_description = safe_field('page_description', 'pixie_core', "page_name='$s'"); }		/* load this page's description */
	if ($page_type == 'module') {
	    if (isset($s)) {
		if (file_exists("admin/modules/{$s}_functions.php")) {
		include ("admin/modules/{$s}_functions.php");
		}
		$do = 'pre';  
		include ("admin/modules/{$s}.php");										/* load the module in pre mode */
	    }
	}
	if ((isset($s)) && ($s == 'contact')) { if (session_id() != 'contact') {
	session_id('contact'); session_cache_limiter('nocache'); session_start(); } }						/* Retrieve the value of the hidden field in the contact module */
	if (file_exists("admin/themes/{$site_theme}/theme.php")) {
	include_once ("admin/themes/{$site_theme}/theme.php"); }								/* New! Your custom theme file must be named theme.php instead of index.php */ /* Theme Override Super Feature */
	else { 
?>
<?php if ( (isset($gzip_theme_output)) && ($gzip_theme_output == 'yes') && (!substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) && (!@extension_loaded('zlib')) && (!@ob_start("ob_gzhandler")) ) /* Start gzip compression */ { if ( !@ob_start() ) { $gzip_theme_output = 'no'; } } else { $gzip_theme_output = 'no'; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>

	<!--
	Pixie Powered (www.getpixie.co.uk)
	Licence: GNU General Public License v3
	Copyright (C) <?php print date('Y');?>, Scott Evans

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
	<meta name="keywords" content="<?php print $site_keywords; ?>" />
	<meta name="description" content="<?php if (isset($pinfo)) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?>" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="<?php print $site_author; ?>" />
	<meta name="copyright" content="<?php print $site_copyright; ?>" />
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date('Y');?>." />

	<!-- title -->
	<title><?php if ( (isset($ptitle)) && ($ptitle) ) { echo $ptitle; } else { build_title(); } ?></title>

	<?php if (!isset($theme_g_apis_jquery)) { $theme_g_apis_jquery = 'no'; } if (!isset($theme_g_apis_jquery_loc)) { $theme_g_apis_jquery_loc = NULL; } if (!isset($theme_swfobject_g_apis)) { $theme_swfobject_g_apis = 'no'; } if (!isset($theme_swfobject_g_apis_loc)) { $theme_swfobject_g_apis_loc = NULL; } ?>
	<?php /* Chain stuff to load by condition, either yes or no */ if ($theme_g_apis_jquery == 'yes') { $jquery = 'yes'; } ?>

	<!-- javascript -->
	<?php if ($jquery == 'yes') { ?>
	<?php /* Use jQuery from googleapis */ if ($theme_g_apis_jquery == 'yes') { ?>
	<script type="text/javascript" src="<?php print $theme_g_apis_jquery_loc; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/jquery.js"></script>
	<?php } /* End Use jQuery from googleapis */ ?>
	<?php /* Use swfobject from googleapis */ if ($theme_swfobject_g_apis == 'yes') { ?>
	<script type="text/javascript" src="<?php print $theme_swfobject_g_apis_loc; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/swfobject.js"></script>
	<?php } /* End Use swfobject from googleapis */ ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/public.js.php<?php if (isset($s)) { print "?s={$s}"; } ?>"></script>
	<?php } /* End jquery = yes */ ?>
	<!-- bad behavior -->
	<?php bb2_insert_head(); ?>

	<!-- css -->
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/style.php?theme=<?php print $site_theme; ?>&amp;s=<?php print $style; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/print.css" type="text/css" media="print" />
	<?php

	/* check for IE specific style files */
	$cssie = "{$rel_path}admin/themes/{$site_theme}/ie.css"; $cssie6 = "{$rel_path}admin/themes/{$site_theme}/ie6.css"; $cssie7 = "{$rel_path}admin/themes/{$site_theme}/ie7.css";

	if (file_exists($cssie)) {
	echo "\n\t<!--[if IE]><link href=\"{$cssie}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists($cssie6)) {
	echo "\n\t<!--[if IE 6]><link href=\"{$cssie6}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists($cssie7)) {
	echo "\n\t<!--[if IE 7]><link href=\"{$cssie7}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}

	/* check for handheld style file */
	$csshandheld = "{$rel_path}admin/themes/{$site_theme}/handheld.css";
	if (file_exists($csshandheld)) {
	echo "\n\t<link href=\"{$csshandheld}\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>

	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon.jpg"/>

	<!-- rss feeds-->
	<?php build_rss(); ?>
	<?php $do = 'head'; if ( ($page_type == 'module') && (isset($s)) ) { include ("admin/modules/{$s}.php"); } ?>

</head>

<?php if ($gzip_theme_output == 'yes') { @ob_flush(); } flush(); /* Send the head so that the browser has something to do whilst it waits */ ?>

<body id="pixie" class="pixie <?php $date_array = getdate(); print "y{$date_array['year']}"; print " m{$date_array['mon']}"; print " d{$date_array['mday']}"; print " h{$date_array['hours']}"; if ( (isset($s)) && ($s) ) { print " s_{$s}"; } if ($m) { print " m_{$m}"; } if ($x) { print " x_{$x}"; } if ($p) { print " p_{$p}"; } ?>">

	<?php build_head(); ?>

	<div id="wrap" class="hfeed">

		<!-- use for extra style as required -->
		<div id="extradiv_a"><span></span></div>
		<div id="extradiv_b"><span></span></div>

		<div id="placeholder">

			<!-- use for extra style as required -->
			<div id="extradiv_1"><span></span></div>
			<div id="extradiv_2"><span></span></div>

			<div id="header">

				<div id="tools">
					<ul id="tools_list">
						<li id="tool_skip_navigation"><a href="#navigation" title="<?php print $lang['skip_to_nav'];?>"><?php print $lang['skip_to_nav'];?></a></li>
						<li id="tool_skip_content"><a href="#content" title="<?php print $lang['skip_to_content'];?>"><?php print $lang['skip_to_content'];?></a></li>
					</ul>
				</div>

				<h1 id="site_title" title="<?php print $site_name; ?>"><a href="<?php print $site_url; ?>" rel="home" class="replace"><?php print $site_name; ?><span></span></a></h1>
				<h2 id="site_strapline" title="<?php if (isset($pinfo)) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?>" class="replace"><?php if (isset($pinfo)) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?><span></span></h2>

			</div>

			<div id="navigation"><?php build_navigation(); ?></div>

			<div id="pixie_body">

				<?php if ($contentfirst == 'no') { echo "\n"; ?>
				<div id="content_blocks"><?php build_blocks(); ?></div>
				<?php } echo "\n"; ?>

				<div id="content"><?php $do = 'default'; if ($page_type == 'static') { include ('admin/modules/static.php'); } else if ($page_type == 'dynamic') { include ('admin/modules/dynamic.php'); } else { if (isset($s)) { include ("admin/modules/{$s}.php"); } } ?></div>

				<?php if ($contentfirst == 'yes') { echo "\n"; ?>
				<div id="content_blocks"><?php build_blocks(); ?></div>
				<?php } echo "\n"; ?>

			</div>

			<!-- use for extra style as required -->
			<div id="extradiv_3"><span></span></div>
			<div id="extradiv_4"><span></span></div>

		</div>

		<div id="footer">
			<div id="credits">
				<ul id="credits_list">

					<?php if ( public_page_exists('rss') ) {

						  echo "<li id=\"cred_rss\"><a href=\"" . createURL('rss') . "\" title=\"Subscribe\">Subscribe</a></li>\n";

					      } else {

						echo "\n";

					      } ?>

					<li id="cred_pixie"><a href="http://www.getpixie.co.uk" title="Get Pixie">Pixie Powered</a></li>
					<li id="cred_theme"><?php print $lang['theme']; print " : {$theme_name}"; ?> by <a href="<?php print $theme_link; ?>" title="<?php print "{$theme_name} by {$theme_creator}"; ?>"><?php print $theme_creator; ?></a></li>
				</ul>
			</div>
		</div>

		<!-- use for extra style as required -->
		<div id="extradiv_c"><span></span></div>
		<div id="extradiv_d"><span></span></div>

	</div>
</body>
</html>
	<!-- page generated in: <?php pagetime('print'); ?> -->
	<?php if ($gzip_theme_output == 'yes') { @ob_end_flush(); } ?><?php } ?>

<?php } 
?>