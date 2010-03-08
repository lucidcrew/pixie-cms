<?php
header('Content-Type: text/html; charset=UTF-8');
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
 * Title: Index
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 * @todo Tag release for Pixie 1.04
 *
 */
    /* Prevent any kind of predefinition of DIRECT_ACCESS or PIXIE_DEBUG */
    if ( (defined('DIRECT_ACCESS')) or (defined('PIXIE_DEBUG')) ) {
	require_once 'admin/lib/lib_misc.php';
	pixieExit();
	exit();
    }
    /* 1 for yes */
    define('DIRECT_ACCESS', 1);
    /* Check for config */
    if ( (!file_exists('admin/config.php')) or (filesize('admin/config.php') < 10) ) {
	/* redirect to installer */
	if (file_exists('admin/install/index.php')) {
	    header( 'Location: admin/install/' );
	    exit();
	}
	/* Redirect to an error page if down */
	if (!file_exists('admin/install/index.php')) {
	    require_once 'admin/lib/lib_db.php';
	    db_down();
	    exit();
	}
    }
    /* Set default php charset */
    ini_set('default_charset', 'utf-8');
    /* Perform basic sanity checks */
    require_once 'admin/lib/lib_misc.php';
    /* Check URL size */
    bombShelter();
    /* Set error reporting up if debug is enabled */
    if (PIXIE_DEBUG == 'yes') {
	error_reporting(-1);

    } else {

	error_reporting(0);
    }
    /* Prevent superglobal poisoning before extraction */
    globalSec('Main index.php', 1);
    /* Access to form vars if register globals is off */ /* note : NOT setting a prefix yet, not looked at it yet */
    extract($_REQUEST);
    /* Load configuration */
    require_once 'admin/config.php';
    /* Import the database function library */
    include_once 'admin/lib/lib_db.php';
    /* Turn the prefs into an array */
    $prefs = get_prefs();
    /* Add prefs to globals using php's extract function */
    extract($prefs);
    /* Timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
    define('TZ', "$timezone");
	if (strnatcmp(phpversion(),'5.1.0') >= 0) {
	    if (isset($server_timezone)) {

	    } else {

	    $server_timezone = 'Europe/London';
	    }
	    /* New! Built in php function. Tell php what the server timezone is so that we can use php 5's rewritten time and date functions with the correct time and without error messages */
	    date_default_timezone_set("$server_timezone");
	}
    include_once 'admin/lib/lib_logs.php';
    /* Start the runtime clock */
    pagetime('init');
    /* Import the validate library */
    include_once 'admin/lib/lib_validate.php';
    /* Import the date library */
    include_once 'admin/lib/lib_date.php';
    /* Import the paginator library */
    include_once 'admin/lib/lib_paginator.php';
    /* Import the pixie library */
    include_once 'admin/lib/lib_pixie.php';
    /* Import the rss library */
    include_once 'admin/lib/lib_rss.php';
    /* Import the tags library */
    include_once 'admin/lib/lib_tags.php';
    /* No spam please */
    include_once 'admin/lib/bad-behavior-pixie.php';
	/* Because pie should be simple */
	if (strnatcmp(phpversion(),'5.0.0') >= 0) {
	    /* Load the php5 version of simplepie if you are running php5 */
	    include_once 'admin/lib/lib_simplepie_php5.php';

	} else {

	    include_once 'admin/lib/lib_simplepie.php';
	}
    /* Current site visitors */
    users_online();
    /* Let the magic begin */
    pixie();
    /* Referral */
    referral();
    /* Get the language file */
    include_once "admin/lang/{$language}.php";
    /* Load the current themes settings */
    include_once "admin/themes/{$site_theme}/settings.php";
    if ((isset($s)) && ($s == 404)) {
	/* Send correct header for 404 pages */
	header('HTTP/1.0 404 Not Found');
    }
    if ($m == 'rss') {
	if (isset($s)) {
	    /* RSS */
	    rss($s, $page_display_name, $page_id);
	}

    } else {

	if (isset($s)) {
	    /* Load this page's description */
	    $page_description = safe_field('page_description', 'pixie_core', "page_name='$s'");
	}
	if ($page_type == 'module') {
	    if (isset($s)) {
		if (file_exists("admin/modules/{$s}_functions.php")) {
		    include ("admin/modules/{$s}_functions.php");
		}
		/* Load the module in pre mode */
		$do = 'pre';  
		include ("admin/modules/{$s}.php");
	    }
	}
	if ((isset($s)) && ($s == 'contact')) {
	    if (session_id() != 'contact') {
		/* Retrieve the value of the hidden field in the contact module */
		session_id('contact');
		session_cache_limiter('nocache');
		session_start();
	    }
	}
	    /* Theme Override Super Feature */
	if (file_exists("admin/themes/{$site_theme}/theme.php")) {
	    /* New! Your custom theme file must be named theme.php instead of index.php */
	    include_once ("admin/themes/{$site_theme}/theme.php");

	} else {
	    /* By default use the regular Pixie template */
	    if ( (isset($gzip_theme_output)) && ($gzip_theme_output == 'yes') && (!substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) && (!@extension_loaded('zlib')) && (!@ob_start("ob_gzhandler")) ) /* Start gzip compression */ {
		if ( !@ob_start() ) {
		    $gzip_theme_output = 'no';
		}

	    } else {

		$gzip_theme_output = 'no';
	    }

?>
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

	<!-- Meta tags -->
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="keywords" content="<?php print $site_keywords; ?>" />
	<meta name="description" content="<?php if (isset($pinfo)) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?>" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="<?php print $site_author; ?>" />
	<meta name="copyright" content="<?php print $site_copyright; ?>" />
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date('Y');?>." />

	<!-- Title -->
	<title><?php if ( (isset($ptitle)) && ($ptitle) ) { echo $ptitle; } else { build_title(); } ?></title>

	<?php if (!isset($theme_g_apis_jquery)) { $theme_g_apis_jquery = 'no'; } if (!isset($theme_g_apis_jquery_loc)) { $theme_g_apis_jquery_loc = NULL; } if (!isset($theme_swfobject_g_apis)) { $theme_swfobject_g_apis = 'no'; } if (!isset($theme_swfobject_g_apis_loc)) { $theme_swfobject_g_apis_loc = NULL; } ?>
	<?php /* Chain stuff to load by condition, either yes or no */ if ($theme_g_apis_jquery == 'yes') { $jquery = 'yes'; } ?>

	<!-- Javascript -->
	<?php if ($jquery == 'yes') { ?>
	<?php if ($theme_g_apis_jquery == 'yes') { /* Use jQuery from googleapis */ ?>
	<script type="text/javascript" src="<?php print $theme_g_apis_jquery_loc; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/jquery.js"></script>
	<?php } /* End Use jQuery from googleapis */ ?>
	<?php if ($theme_swfobject_g_apis == 'yes') { /* Use swfobject from googleapis */ ?>
	<script type="text/javascript" src="<?php print $theme_swfobject_g_apis_loc; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/swfobject.js"></script>
	<?php } /* End Use swfobject from googleapis */ ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/public.js.php<?php if (isset($s)) { print "?s={$s}"; } ?>"></script>
	<?php } /* End jquery = yes */ ?>
	<!-- Bad Behavior -->
	<?php bb2_insert_head(); ?>

	<!-- CSS -->
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/style.php?theme=<?php print $site_theme; ?>&amp;s=<?php print $style; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/print.css" type="text/css" media="print" />
	<?php

	/* Check for IE specific style files */
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

	/* Check for handheld style file */
	$csshandheld = "{$rel_path}admin/themes/{$site_theme}/handheld.css";
	if (file_exists($csshandheld)) {
	    echo "\n\t<link href=\"{$csshandheld}\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>

	<!-- Site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon.jpg"/>

	<!-- RSS feeds-->
	<?php build_rss(); ?>
	<?php $do = 'head'; if ( ($page_type == 'module') && (isset($s)) ) { include ("admin/modules/{$s}.php"); } ?>

</head>

<?php if ($gzip_theme_output == 'yes') { @ob_flush(); } flush(); /* Send the head so that the browser has something to do whilst it waits */ ?>

<body id="pixie" class="pixie <?php $date_array = getdate(); print "y{$date_array['year']}"; print " m{$date_array['mon']}"; print " d{$date_array['mday']}"; print " h{$date_array['hours']}"; if ( (isset($s)) && ($s) ) { print " s_{$s}"; } if ($m) { print " m_{$m}"; } if ($x) { print " x_{$x}"; } if ($p) { print " p_{$p}"; } ?>">

	<?php build_head(); ?>

	<div id="wrap" class="hfeed">

		<!-- Use for extra style as required -->
		<div id="extradiv_a"><span></span></div>
		<div id="extradiv_b"><span></span></div>

		<div id="placeholder">

			<!-- Use for extra style as required -->
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

			<!-- Use for extra style as required -->
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
					<!-- The attribution at the bottom of every page -->
					<li id="cred_pixie"><a href="http://www.getpixie.co.uk" title="Get Pixie">Pixie Powered</a></li>
					<li id="cred_theme"><?php print $lang['theme']; print " : {$theme_name}"; ?> by <a href="<?php print $theme_link; ?>" title="<?php print "{$theme_name} by {$theme_creator}"; ?>"><?php print $theme_creator; ?></a></li>
				</ul>
			</div>
		</div>

		<!-- Use for extra style as required -->
		<div id="extradiv_c"><span></span></div>
		<div id="extradiv_d"><span></span></div>

	</div>
</body>
</html>
	<!-- Page generated in : <?php pagetime('print'); ?> -->
	<?php if ($gzip_theme_output == 'yes') { @ob_end_flush(); } ?><?php } ?>

<?php } 
?>