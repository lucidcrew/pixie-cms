<?php
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
error_reporting(0);			// turn off error reporting
if (!file_exists('config.php') || filesize('config.php') < 10) {		// check for config
if (file_exists('install/index.php')) { header( 'Location: install/' ); exit(); }					  		            // redirect to installer
if (!file_exists('install/index.php')) { require 'lib/lib_db.php'; db_down(); exit(); }
}
require 'lib/lib_misc.php';		//
	bombShelter();                  										// check URL size
	// Set $debug to yes to debug and see all the global vars coming into the file
	// To find error messages, search the page for php_errormsg if you turn this debug feature on
	$debug = 'no';

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	}

	$server_timezone = 'Europe/London';		/* We set this first incase of upgrade without timezone being set in config.php upgraders should manually set it. */

	$messageok  = NULL;	/* Prevents insecure undefined variable $messageok */
	$login_forgotten  = NULL;	/* Prevents insecure undefined variable $login_forgotten */
	$do  = NULL;	/* Prevents insecure undefined variable $do */

	globalSec('Admin index.php', 1);

	extract($_REQUEST);		// access to form vars if register globals is off // note : NOT setting a prefix yet, not looked at it yet
	require 'config.php';			// load configuration
	include 'lib/lib_db.php';		// load libraries order is important
	$prefs = get_prefs();		// prefs as an array
	extract($prefs);		// add prefs to globals
	include 'lib/lib_logs.php'; pagetime('init');		// runtime clock
	putenv('TZ=' . "$timezone");		// timezone fix (php5.1.0 or newer will set it's server timezone using function date_default_timezone_set!)
	if (strnatcmp(phpversion(),'5.1.0') >= 0) { date_default_timezone_set("$server_timezone"); }	/* New! Built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */
	include 'lang/' . $language . '.php';	// get the language file
	include 'lib/lib_date.php';		//
	include 'lib/lib_auth.php';		// check user is logged in
	include 'lib/lib_validate.php';		// 
	include 'lib/lib_core.php';		//
	include 'lib/lib_paginator.php';	//
	include 'lib/lib_upload.php';		//
	include 'lib/lib_rss.php';		//
	include 'lib/lib_tags.php';		//
	include 'lib/bad-behavior-pixie.php';   // no spam please
	include 'lib/lib_backup.php';	        //
	/* Error - lib_simplepie.php - Non-static method SimplePie_Misc::parse_date() should not be called statically - Waiting for devs to fix, it only happens with php5 */
	include 'lib/lib_simplepie.php';        // because pie should be simple
  	if (!file_exists( 'settings.php' ) || filesize( 'settings.php') < 10) {		// check for settings.php
	$gzip_admin = 'no';}		// ensure no unset variables if file is missing
  	if (file_exists( 'settings.php' ) || filesize( 'settings.php' ) < 10) {		// check for settings.php
	include 'settings.php';}

	$s = check_404($s);		// check section exists

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
	}

	if ($debug == 'yes') {
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The prefs array contains : ';
	htmlspecialchars(print_r($show_vars["prefs"]));
	echo '</pre></p>';
	}

	if ($do == 'rss' && $user) { adminrss($s, $user); } else {																//
?>
<?php if ($gzip_admin == 'yes') { if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) if (extension_loaded('zlib')) ob_start('ob_gzhandler'); else ob_start(); ?>
	<?php } /* Start gzip compression */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	
	<!-- title -->
	<title><?php build_admin_title();?></title>
	
	<!-- meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="cms, blog, simple, content, management, system, website, pixie, modular, php, css, themes, mysql, javascript, multilingual, open, source, small, site, maker, admin" />
	<meta name="description" content="Pixie is an open source web application that will help you quickly create and maintain your own website. Pixie is available at www.getpixie.co.uk." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="noindex,nofollow,noarchive" />
	<meta name="author" content="<?php print $site_author; ?>" />
	<meta name="copyright" content="<?php print $site_copyright; ?>" />
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date('Y');?>." /> 
		
	<!-- head javascript -->
	<?php /* Use jQuery from googleapis */ if ($jquery_google_apis_load == 'yes') { ?>
	<script type="text/javascript" src="<?php print $googleapis_jquery_load_location; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="jscript/jquery.js"></script>
	<?php } /* End Use jQuery from googleapis */ ?>

	<!-- css -->
	<link rel="stylesheet" href="admin/theme/style.php?s=<?php print $s; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="admin/theme/cskin.css" type="text/css" media="screen" />

	<?php
	// check for IE specific style files
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

	// check for handheld style file
	$csshandheld = 'admin/theme/handheld.css';
	if (file_exists($csshandheld)) {
	echo "\n\t<link href=\"" . $csshandheld . "\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>
	
	<!-- site icon -->
	<link rel="Shortcut Icon" type="image/x-icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon_pixie.jpg"/>

	<!-- rss feeds-->
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print str_replace('.',"",$lang['blog']); ?>" href="http://www.getpixe.co.uk/blog/rss/" />
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print $lang['latest_activity']; ?>" href="?s=myaccount&amp;do=rss&amp;user=<?php print safe_field('nonce','pixie_users',"user_name ='" . $GLOBALS['pixie_user'] . "'"); ?>" />

</head>
  <?php flush(); ?>
<body class="pixie <?php $s . " "; $date_array = getdate(); print 'y'.$date_array['year'] . " "; print 'm' . $date_array['mon'] . " "; print 'd' . $date_array['mday'] . " "; print 'h' . $date_array['hours'] . " "; print $s; ?>">
	<div id="message"></div>
	<div id="pixie">
		<div id="pixie_placeholder">
	
			<div id="pixie_header">
	
				<div id="tools">
					<ul id="tools_list">
						<li id="tool_skip"><a href="#pixie_body" title="<?php echo $lang['skip_to']; ?>"><?php echo $lang['skip_to']; ?></a></li>
						<?php if ($GLOBALS['pixie_user']){ ?><li id="tool_logout"><a href="?s=logout" title="<?php echo $lang['logout']; ?>"><?php echo $lang['logout']; ?></a></li><?php print "\n";} ?>
						<li id="tool_view"><a href="<?php print $site_url;?>" title="<?php echo $lang['view_site']; ?>"><?php echo $lang['view_site']; ?></a></li>
					</ul>	
				</div>
	
				<h1 id="pixie_title" title="Pixie"><span><a href="index.php" rel="home">Pixie</a></span></h1>
				<h2 id="pixie_strapline" title="<?php print $lang['tag_line'] . ' v' . $GLOBALS['version'];?>"><span><?php print $lang['tag_line'] . ' v' . $GLOBALS['version'];?></span></h2>
				
				<div id="nav_1">
					<?php print "\n"; if ($s != 'login') { ?>
					<ul id="nav_level_1">
						<?php if ($GLOBALS['pixie_user_privs'] >= 2){ ?><li><a href="?s=settings" title="<?php print $lang['nav1_settings'];?>"<?php if ($s == 'settings') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_settings'];?></a><?php print "\n";} ?>
						<?php if ($s != '404' && $s == 'settings'){ include('admin/modules/nav_' . $s . '.php'); } else if ($s != 'login') { echo "</li>\n"; } ?>
						<?php if ($GLOBALS['pixie_user_privs'] >= 1){ ?><li><a href="?s=publish" title="<?php print $lang['nav1_publish'];?>"<?php if ($s == 'publish') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_publish'];?></a><?php print "\n";} ?>
						<?php if ($s != "404" && $s == "publish"){ include('admin/modules/nav_'.$s.'.php'); } else if ($s != "login") { echo "</li>\n"; } ?>
						<?php if ($GLOBALS['pixie_user']){ ?><li><a href="?s=myaccount" title="<?php print $lang['nav1_home'];?>"<?php if  ($s == 'myaccount') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_home'];?></a><?php print "\n";} ?>
						<?php if ($s != '404' && $s == 'myaccount'){ include('admin/modules/nav_' . $s . '.php'); } else if ($s != 'login') { echo "</li>\n"; } ?>
					</ul>
					<?php } print "\n"; ?>
				</div>
	
			</div>
	
			<div id="pixie_body">
						
	   			<?php if ($s != '404'){ include('admin/modules/mod_' . $s . '.php'); } else { include('modules/static.php'); }?>
	
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

    <!-- JavaScript includes are placed after the content at the very bottom of the page, just before the closing body tag. -->
      <!-- This ensures that all content is loaded before manipulation of the DOM occurs. It also fixes a bug in opera where opera tries to load the carousel too early. -->
	<!-- javascript -->
	<script type="text/javascript" src="jscript/tags.js"></script>
	<script type="text/javascript" src="jscript/interface.js"></script>
	<script type="text/javascript" src="jscript/slider.js"></script>
	<script type="text/javascript" src="jscript/ajaxfileupload.js"></script>
	<script type="text/javascript" src="jscript/thickbox.js"></script>
	<?php /* Add tinymce */ if ($tinymce_load !== 'no') { ?>
	<script type="text/javascript" src="jscript/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="jscript/tiny_mce/tiny_mce_setup.js.php?theme=<?php print $site_theme; ?>&amp;s=<?php print $x; ?>&amp;m=<?php print $m;?>"></script>
	<?php } /* End add tinymce */ ?>

	<script type="text/javascript" src="jscript/pixie.js.php?s=<?php print $s; ?>"></script>

<?php
		global $message;
		if (($message) || ($messageok)) {
			echo "
	<script type=\"text/javascript\">
		jQuery(function(){";
 			if ($message) {
 				if($GLOBALS['system_message'] != $message) {
 					echo "\n\t\t\tjQuery.post(\"admin/modules/ajax_message.php\",{ message: \"$message\" }, function(data){ jQuery(data).appendTo(\"div#message\"); jQuery(\"#message\").hide(); jQuery(\"#message\").fadeIn(\"slow\"); jQuery(\"#message\").css({ padding: \"5px\" }); jQuery(\"#message\").addClass(\"errormess\"); });";
 				} else {
 					echo "\n\t\t\tjQuery.post(\"admin/modules/ajax_message.php\",{ message: \"$message\", back: \"no\" }, function(data){ jQuery(data).appendTo(\"div#message\"); jQuery(\"#message\").hide(); jQuery(\"#message\").fadeIn(\"slow\"); jQuery(\"#message\").css({ padding: \"5px\" }); jQuery(\"#message\").addClass(\"okmess\"); });";
 				}
 	 		} else if ($messageok) {
 				safe_update('pixie_settings', "value = now()", "name = 'dbupdatetime'");
 				echo "\n\t\t\tjQuery.post(\"admin/modules/ajax_message.php\",{ messageok: \"$messageok\" }, function(data){ jQuery(data).appendTo(\"div#message\"); jQuery(\"#message\").hide(); jQuery(\"#message\").fadeIn(\"slow\"); jQuery(\"#message\").css({ padding: \"5px\" }); jQuery(\"#message\").addClass(\"okmess\"); });";
 			}
		echo "
		}) 
	</script>\n";
		}
?>
	<!-- bad behavior -->
	<?php bb2_insert_head(); ?>
	<!-- If javascript is disabled show more of the carousel -->
	<noscript><style type="text/css">.jcarousel-skin-tango{max-height: 100%;}</style></noscript>
	<?php if ($debug == 'yes') {
	/* Show the defined global vars */ print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
	phpinfo();
	} ?>
</body>
</html>
<!-- page generated in: <?php pagetime('print');?> -->
	<?php if ($gzip_admin == 'yes') { ?>
	<?php if (extension_loaded('zlib')) ob_end_flush(); ?>
	<?php } /* End gzip compression */ ?>
<?php
	}
?>