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
// Title: Admin Index			                                 //
//***********************************************************************//
if (defined('DIRECT_ACCESS')) { require_once 'lib/lib_misc.php'; pixieExit(); exit(); }					/* Prevent any kind of predefinition of DIRECT_ACCESS */
if (defined('PIXIE_DEBUG')) { require_once 'lib/lib_misc.php'; pixieExit(); exit(); }					/* Prevent any kind of predefinition of PIXIE_DEBUG */
define('DIRECT_ACCESS', 1);												/* Knock once for yes */
if (!file_exists('config.php') || filesize('config.php') < 10) {							/* check for config */
if (file_exists('install/index.php')) { header( 'Location: install/' ); exit(); }					/* redirect to installer */
if (!file_exists('install/index.php')) { require_once 'lib/lib_db.php'; db_down(); exit(); }				/* redirect to an error page if down */
}
ini_set('default_charset', 'utf-8');											/* set default php charset */
require_once 'lib/lib_misc.php';											/* perform basic sanity checks */
bombShelter();														/* check URL size */
error_reporting(0);													/* turn off error reporting */
if (PIXIE_DEBUG == 'yes') { error_reporting(E_ALL & ~E_DEPRECATED); }							/* set error reporting up if debug is enabled */

	globalSec('Admin index.php', 1);										/* prevent superglobal poisoning before extraction */
	extract($_REQUEST);												/* access to form vars if register globals is off */ /* note : NOT setting a prefix yet, not looked at it yet */
	require_once 'config.php';											/* load configuration */
	include_once 'lib/lib_db.php';											/* import the database function library */
	$prefs = get_prefs();												/* turn the prefs into an array */
	extract($prefs);												/* add prefs to globals using php's extract function */
	if (strnatcmp(phpversion(),'5.1.0') >= 0) {
	if (!isset($server_timezone)) { $server_timezone = 'Europe/London'; }
	date_default_timezone_set("$server_timezone"); }								/* New! Built in php function. Tell php what the server timezone is so that we can use php 5's rewritten time and date functions to set the correct time without error messages */
	define('TZ', "$timezone");											/* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */
	include_once 'lib/lib_logs.php'; pagetime('init');								/* start the runtime clock */
	include_once 'lang/' . $language . '.php';									/* get the language file */
	include_once 'lib/lib_date.php';										/* import the date library */
	include_once 'lib/lib_auth.php';										/* check user is logged in */
	include_once 'lib/lib_validate.php';										/* import the validate library */
	include_once 'lib/lib_core.php';										/* import the core library */
	include_once 'lib/lib_paginator.php';										/* import the paginator library */
	include_once 'lib/lib_upload.php';										/* import the upload library */
	include_once 'lib/lib_rss.php';											/* import the rss library */
	include_once 'lib/lib_tags.php';										/* import the tags library */
	include_once 'lib/bad-behavior-pixie.php';									/* no spam please */
	include_once 'lib/lib_backup.php';										/* import the backup library */

	if (strnatcmp(phpversion(),'5.0.0') >= 0) {
	include_once 'lib/lib_simplepie_php5.php'; } else {								/* Load the php5 version of simplepie if you are running php5 */
	include_once 'lib/lib_simplepie.php'; }										/* because pie should be simple */
  	if (!file_exists( 'settings.php' ) || filesize( 'settings.php') < 10) {						/* check for settings.php */
	$gzip_admin = 'no'; }												/* ensure $gzip_admin not unset */
  	if (file_exists( 'settings.php' ) || filesize( 'settings.php' ) < 10) {						/* check for settings.php */
	include_once 'settings.php';}											/* load settings.php, if found */

	$s = check_404($s);												/* check section exists */

	if (PIXIE_DEBUG == 'yes') { $show_vars = get_defined_vars();							/* output important variables to screen if debug is enabled */
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
	echo '<p><pre class="showvars">The prefs array contains : ';
	htmlspecialchars(print_r($show_vars["prefs"]));
	echo '</pre></p>'; }

	if ((isset($s)) && (isset($do)) && ($do == 'rss') && ($user)) { adminrss($s, $user); } else {
?>
<?php if (!isset($gzip_admin)) { $gzip_admin = 'no'; } if ($gzip_admin == 'yes') { if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) if (extension_loaded('zlib')) ob_start('ob_gzhandler'); else ob_start(); ?>
	<?php } /* Start gzip compression */ ?>
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
	<meta name="keywords" content="cms, blog, simple, content, management, system, website, pixie, modular, php, css, themes, mysql, javascript, multilingual, open, source, small, site, maker, admin" />
	<meta name="description" content="Pixie is an open source web application that will help you quickly create and maintain your own website. Pixie is available at www.getpixie.co.uk." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="noindex,nofollow,noarchive" />
	<meta name="author" content="<?php print $site_author; ?>" />
	<meta name="copyright" content="<?php print $site_copyright; ?>" />
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date('Y');?>." /> 

	<!-- title -->
	<title><?php build_admin_title();?></title>

	<!-- head javascript -->
	<?php /* Use jQuery from googleapis */ if ($jquery_google_apis_load == 'yes') { ?>
	<script type="text/javascript" src="<?php print $googleapis_jquery_load_location; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="jscript/jquery.js"></script>
	<?php } /* End Use jQuery from googleapis */ ?>

	<!-- css -->
	<link rel="stylesheet" href="admin/theme/style.php?<?php if (isset($s)) { print 's=' . $s; } ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="admin/theme/cskin.css" type="text/css" media="screen" />

	<?php
	/* check for IE specific style files */
	$cssie = 'admin/theme/ie.css';
	$cssie6 = 'admin/theme/ie6.css';
	$cssie7 = 'admin/theme/ie7.css';

	if (file_exists($cssie)) {
	echo "\n\t<!--[if IE]><link href=\"" . $cssie . "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists($cssie6)) {
	echo "\n\t<!--[if IE 6]><link href=\"" . $cssie6 . "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists($cssie7)) {
	echo "\n\t<!--[if IE 7]><link href=\"" . $cssie7 . "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}

	/* check for handheld style file */
	$csshandheld = 'admin/theme/handheld.css';
	if (file_exists($csshandheld)) {
	echo "\n\t<link href=\"" . $csshandheld . "\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>
	
	<!-- site icon -->
	<link rel="Shortcut Icon" type="image/x-icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon_pixie.jpg"/>

	<!-- rss feeds-->
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print str_replace('.', "", $lang['blog']); ?>" href="http://www.getpixe.co.uk/blog/rss/" />
	<?php if (isset($GLOBALS['pixie_user'])) { ?>
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print $lang['latest_activity']; ?>" href="?s=myaccount&amp;do=rss&amp;user=<?php print safe_field('nonce', 'pixie_users',"user_name ='" . $GLOBALS['pixie_user'] . "'"); ?>" />
	<?php } ?>

</head>
    <?php ob_flush(); flush(); /* Send the head so that the browser has something to do whilst it waits */ ?>
<body class="pixie <?php if (isset($s)) { $s . " "; $date_array = getdate(); print 'y' . $date_array['year'] . " "; print 'm' . $date_array['mon'] . " "; print 'd' . $date_array['mday'] . " "; print 'h' . $date_array['hours'] . " "; print $s; } ?>">
	<div id="message"></div>
	<div id="pixie">
		<div id="pixie_placeholder">
	
			<div id="pixie_header">
	
				<div id="tools">
					<ul id="tools_list">
						<li id="tool_skip"><a href="#pixie_body" title="<?php echo $lang['skip_to']; ?>"><?php echo $lang['skip_to']; ?></a></li>
						<?php if (isset($s)) { if (isset($GLOBALS['pixie_user'])) { if ($s != 'login') { ?><li id="tool_logout"><a href="?s=logout" title="<?php echo $lang['logout']; ?>"><?php echo $lang['logout']; ?></a></li><?php } print "\n"; } } ?>
						<li id="tool_view"><a href="<?php print $site_url;?>" target="_blank" title="<?php echo $lang['view_site']; ?>"><?php echo $lang['view_site']; ?></a></li>
					</ul>	
				</div>
	
				<h1 id="pixie_title" title="Pixie"><span><a href="index.php" rel="home">Pixie</a></span></h1>
				<h2 id="pixie_strapline" title="<?php print $lang['tag_line'] . ' v' . $GLOBALS['version'];?>"><span><?php print $lang['tag_line'] . ' v' . $GLOBALS['version'];?></span></h2>
				
				<div id="nav_1">
					<?php print "\n"; if (isset($s)) { if ($s != 'login') { ?>
					<ul id="nav_level_1">
						<?php if ((isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 2)) { ?><li><a href="?s=settings" title="<?php print $lang['nav1_settings'];?>"<?php if ($s == 'settings') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_settings'];?></a><?php print "\n";} ?>
						<?php if ($s != '404' && $s == 'settings'){ include('admin/modules/nav_' . $s . '.php'); } else if ($s != 'login') { echo "</li>\n"; } ?>
						<?php if ((isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 1)) { ?><li><a href="?s=publish" title="<?php print $lang['nav1_publish'];?>"<?php if ($s == 'publish') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_publish'];?></a><?php print "\n";} ?>
						<?php if ($s != '404' && $s == 'publish') { include('admin/modules/nav_'. $s .'.php'); } else if ($s != 'login') { echo "</li>\n"; } ?>
						<?php if (isset($GLOBALS['pixie_user'])) { ?><li><a href="?s=myaccount" title="<?php print $lang['nav1_home'];?>"<?php if  ($s == 'myaccount') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_home'];?></a><?php print "\n";} ?>
						<?php if ($s != '404' && $s == 'myaccount'){ include('admin/modules/nav_' . $s . '.php'); } else if ($s != 'login') { echo "</li>\n"; } ?>
					</ul>
					<?php } } print "\n"; ?>
				</div>
	
			</div>
	
			<div id="pixie_body">
						
	   			<?php if ((isset($s)) && ($s != '404')) { include('admin/modules/mod_' . $s . '.php'); } else { include('modules/static.php'); }?>
	
			</div>
		</div>
		<div id="pixie_footer">
			<div id="credits">
				<ul id="credits_list">
					<li id="cred_pixie"><a href="http://www.getpixie.co.uk/" title="Get Pixie">Pixie Powered.</a></li>
					<li id="cred_licence"><?php print $lang['license']; ?> <a href="<?php print $site_url . 'license.txt';?>" title="<?php print $lang['license']; ?> GNU General Public License v3" rel="license">GNU General Public License v3</a>.</li>
					<li id="cred_site"><a href="<?php print $site_url;?>" title="<?php echo $lang['view_site']; ?>"><?php $site = strtolower(str_replace('http://', "", $site_url)); print $site; ?></a></li>
				</ul>
			</div>
		</div>

	</div>

	<!-- javascript -->
	<script type="text/javascript">    //<![CDATA[
	var $j = jQuery.noConflict();
    <?php if ((isset($s)) && ($s != 'login')) { ?>
	globalUrlVars = { pixieSiteUrl : '<?php print $site_url; ?>', pixieThemeDir : '<?php print $site_theme; ?>' };
    <?php /* End if not logged in */ } ?>
    <?php global $message; if (isset($message) || isset($messageok)) { ?>
	$j(function(){

	    function pixieErrorMessage() {
		$j.post('admin/modules/ajax_message.php', { message: '<?php print $message; ?>' }, function(data){ $j(data).appendTo('div#message'); $j('#message').hide(); $j('#message').fadeIn('slow'); $j('#message').css({ padding: '5px' }); $j('#message').addClass('errormess'); });
	    };  /* End function PixieErrorMessage */
	    function pixieOkMessage() {
		$j.post('admin/modules/ajax_message.php', { message: '<?php print $message; ?>', back: 'no' }, function(data){ $j(data).appendTo('div#message'); $j('#message').hide(); $j('#message').fadeIn('slow'); $j('#message').css({ padding: '5px' }); $j('#message').addClass('okmess'); });
	    };  /* End function PixieOkMessage */
	    function pixieLoginMessage() {
		$j.post('admin/modules/ajax_message.php', { messageok: '<?php if (isset($messageok)) { print $messageok; } ?>' }, function(data){ $j(data).appendTo('div#message'); $j('#message').hide(); $j('#message').fadeIn('slow'); $j('#message').css({ padding: '5px' }); $j('#message').addClass('okmess'); });
	    };  /* End function PixieLoginMessage */

	<?php if ($message) { if ($GLOBALS['system_message'] != $message) { ?>
	    pixieErrorMessage(); <?php } else { ?> pixieOkMessage(); <?php } ?>
	<?php } else if (isset($messageok)) { safe_update('pixie_settings', "value = utc_timestamp()", "name = 'dbupdatetime'"); ?> pixieLoginMessage();<?php } ?>

		});  /* End jQuery function */

    <?php } ?>				//]]></script>
	<?php if ((isset($s)) && ($s != 'login')) { ?><script type="text/javascript" src="jscript/tags.js"></script><?php } ?>
	<script type="text/javascript" src="jscript/interface.js"></script>
	<script type="text/javascript" src="jscript/slider.js"></script>
	<?php if ((isset($s)) && ($s != 'login')) { ?><?php if ($s == 'publish' || 'settings') { ?><script type="text/javascript" src="jscript/ajaxfileupload.js"></script><?php } ?><?php } ?>
	<?php if ((isset($s)) && ($s != 'login')) { ?><?php if ($s == 'publish' || 'settings') { ?><script type="text/javascript" src="jscript/thickbox.js"></script><?php } ?><?php } ?>
	<?php if ((isset($s)) && ($s != 'login')) { ?><?php if (($s == 'publish' || 'settings') || ($x == 'myprofile')) { ?><script type="text/javascript" src="jscript/ckeditor/ckeditor.js"></script><?php } ?><?php } ?>
	<script type="text/javascript" src="jscript/pixie.js.php?<?php if (isset($s)) { print 's=' . $s; } if (isset($x)) { print '&amp;x=' . $x; } if (isset($lang['ck_toggle_advanced'])) { print '&amp;advmode=' . $lang['ck_toggle_advanced']; } ?>"></script>
  <?php if (PIXIE_DEBUG == 'yes') { /* Show the defined global vars */ print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>'; phpinfo(); } ?>
	<!-- bad behavior -->
	<?php bb2_insert_head(); ?>
	<!-- If javascript is disabled show more of the carousel and display the ckeditor textareas -->
	<noscript><style type="text/css">.jcarousel-skin-tango{max-height:100%;}.ck-textarea{display:block;}</style></noscript>
</body>
</html>
<!-- page generated in: <?php pagetime('print');?> -->
	<?php if ($gzip_admin == 'yes') { ?>
	<?php if (extension_loaded('zlib')) ob_end_flush(); ?>
	<?php } /* End gzip compression */ ?>
<?php
	}
?>