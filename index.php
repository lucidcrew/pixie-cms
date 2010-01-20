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
// Title: Index			                                         //
//***********************************************************************//
error_reporting(0);	// Turns off error reporting
if (!file_exists('admin/config.php') || filesize('admin/config.php') < 10) {		// check for config
if (file_exists('admin/install/index.php')) { header( 'Location: admin/install/' ); exit(); }					  		            // redirect to installer
if (!file_exists('admin/install/index.php')) { require 'admin/lib/lib_db.php'; db_down(); exit(); }
}
require 'admin/lib/lib_misc.php';     										  		// loaded for security
	bombShelter();                  											  		// check URL size
	$debug = 'no';	// Set this to yes to debug and see all the global vars coming into the file
			// To find error messages, search the page for php_errormsg if you turn this debug feature on

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	}

	$ptitle = NULL;	/* Prevents insecure undefined variable $ptitle */
	$pinfo = NULL;	/* Prevents insecure undefined variable $pinfo */
	$delete = NULL;	/* Prevents insecure undefined variable $delete */
	$username = NULL;	/* Prevents insecure undefined variable $username */
	$server_timezone = 'Europe/London';		/* We set this first incase of upgrade without timezone being set in config.php upgraders should manually set it. */
	// These variables are here to prevent an undefined variable for upgraders that don't have them defined in settings.php - remove them if it seems paranoid...
	$gzip_theme_output = NULL;
	$theme_jquery_google_apis = NULL;
	$theme_jquery_google_apis_location = NULL;
	$theme_swfobject_google_apis = NULL;
	$theme_swfobject_google_apis_location = NULL;

	globalSec('Main index.php', 1);

	extract($_REQUEST);	// access to form vars if register globals is off // note : NOT setting a prefix yet, not looked at it yet
	require 'admin/config.php';           										  		// load configuration
	include 'admin/lib/lib_db.php';       										  		// load libraries order is important
	$prefs = get_prefs();           											  		// prefs as an array
	extract($prefs);
	include 'admin/lib/lib_logs.php'; pagetime('init');   						  		// runtime clock
	putenv('TZ=' . "$timezone"); 															// timezone fix
	if (strnatcmp(phpversion(),'5.1.0') >= 0) { date_default_timezone_set("$server_timezone"); }	/* New! Built in php function. Tell php what the server timezone is so that we can use php's rewritten time and date functions with the correct time and without error messages  */
	include 'admin/lib/lib_validate.php'; 										  		// 
	include 'admin/lib/lib_date.php';											  		//
	include 'admin/lib/lib_paginator.php';										  		//
	include 'admin/lib/lib_pixie.php';											  		//
	include 'admin/lib/lib_rss.php';											  		//
	include 'admin/lib/lib_tags.php';											  		//
	include 'admin/lib/bad-behavior-pixie.php';                                   		// no spam please
	/* Error - lib_simplepie.php - Non-static method SimplePie_Misc::parse_date() should not be called statically - Waiting for devs to fix, it only happens with php5 */
	include 'admin/lib/lib_simplepie.php';                                   			// because pie should be simple

	users_online();																  		// current site visitors
	pixie();																	  		// let the magic begin 
	referral(); 																 		// referral

	include 'admin/lang/' . $language . '.php';                                       		// get the language file
	include 'admin/themes/' . $site_theme . '/settings.php';                          		// load the current themes settings

	if ($s == '404') { header('HTTP/1.0 404 Not Found'); }						  		// send correct header for 404 pages
	if ($m == 'rss') { rss($s, $page_display_name, $page_id); } else {																	  		//
	$page_description = safe_field('page_description', 'pixie_core', "page_name='$s'");	// load this pages description
	
	if ($page_type == 'module') {
		if (file_exists('admin/modules/' . $s . '_functions.php')) { include ('admin/modules/' . $s . '_functions.php'); }
		$do = 'pre';  
		include ('admin/modules/' . $s . '.php');											// load the module in pre mode
				    }

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

	if (file_exists('admin/themes/' . $site_theme . '/index.php')) {
	include ('admin/themes/' . $site_theme . '/index.php'); }	/* Theme override */
	else { 
?>

<?php if ($gzip_theme_output == 'yes') {
      if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) if (extension_loaded('zlib')) ob_start('ob_gzhandler');
      else ob_start();			} /* Start gzip compression */ ?>
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
	
	<!-- title -->
	<title><?php build_title($ptitle); ?></title>
	
	<!-- meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="<?php print $site_keywords; ?>" />
	<meta name="description" content="<?php if ($pinfo) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?>" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="<?php print $site_author; ?>" />
	<meta name="copyright" content="<?php print $site_copyright; ?>" />
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date('Y');?>." /> 
	
	<!-- javascript -->
	<?php /* Chain stuff to load by condition, either yes or no */ if ($theme_swfobject_google_apis == 'yes') { $theme_jquery_google_apis = 'yes'; } if ($theme_jquery_google_apis == 'yes') { $theme_swfobject_google_apis = 'yes'; } if ($theme_jquery_google_apis == 'yes') { $jquery = 'yes'; } if ($theme_swfobject_google_apis == 'yes') { $jquery = 'yes'; } ?>
	<?php if ($jquery == 'yes') { ?>
	<?php /* Use jQuery from googleapis */ if ($theme_jquery_google_apis == 'yes') { ?>
	<script type="text/javascript" src="<?php print $theme_jquery_google_apis_location; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/jquery.js"></script>
	<?php } /* End Use jQuery from googleapis */ ?>
	<?php /* Use swfobject from googleapis */ if ($theme_swfobject_google_apis == 'yes') { ?>
	<script type="text/javascript" src="<?php print $theme_swfobject_google_apis_location; ?>"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/swfobject.js"></script>
	<?php } /* End Use swfobject from googleapis */ ?>
	<script type="text/javascript" src="<?php print $rel_path; ?>admin/jscript/public.js.php?s=<?php print $s; ?>"></script>
	<?php } /* End jquery = yes */ ?>

	<!-- bad behavior -->
	<?php bb2_insert_head(); ?>
	
	<!-- css -->
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/style.php?theme=<?php print $site_theme; ?>&amp;s=<?php print $style; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/print.css" type="text/css" media="print" />
	<?php
	// check for IE specific style files
	$cssie = "$rel_path . 'admin/themes/' . $site_theme . '/ie.css'";
	$cssie6 = "$rel_path . 'admin/themes/' . $site_theme . '/ie6.css'";
	$cssie7 = "$rel_path . 'admin/themes/' . $site_theme . '/ie7.css'";

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
	$csshandheld = "$rel_path . 'admin/themes/' . $site_theme . '/handheld.css'";
	if (file_exists($csshandheld)) {
	echo "\n\t<link href=\"" . $csshandheld . "\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>
	
	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="<?php print $rel_path; ?>admin/themes/<?php print $site_theme; ?>/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon.jpg"/>
		
	<!-- rss feeds-->
	<?php build_rss(); ?>
	
	<?php $do = 'head'; if ($page_type == 'module') { include('admin/modules/' . $s . '.php'); } ?>

</head>
  <?php flush(); ?>
<body id="pixie" class="pixie <?php $date_array = getdate(); print 'y' . $date_array['year'] . " "; print 'm' . $date_array['mon'] . " "; print 'd' . $date_array['mday'] . " "; print 'h' . $date_array['hours'] . " "; if ($s) { print 's_' . $s . " "; } if ($m) { print 'm_' . $m . " "; } if ($x) { print 'x_' . $x . " "; } if ($p) { print 'p_' . $p; } ?>">

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
				<h2 id="site_strapline" title="<?php if ($pinfo) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?>" class="replace"><?php if ($pinfo) { print strip_tags($pinfo); } else { print strip_tags($page_description); } ?><span></span></h2>
	
			</div>
	
			<div id="navigation">
				<?php build_navigation(); ?>
			</div>
	
			<div id="pixie_body">
				<?php if ($contentfirst == 'no') { echo "\n"; ?>
				<div id="content_blocks">
					<?php build_blocks(); ?>
				</div>
				<?php } echo "\n"; ?>
				<div id="content">
	
					<?php $do = 'default'; if ($page_type == 'static') { include('admin/modules/static.php'); } else if ($page_type == 'dynamic') { include('admin/modules/dynamic.php'); } else { include('admin/modules/' . $s . '.php'); } ?>
					
				</div>
				<?php if ($contentfirst == 'yes') { echo "\n"; ?>
				<div id="content_blocks">
					<?php build_blocks(); ?>
				</div>
				<?php } echo "\n"; ?>	
			</div>
	
			<!-- use for extra style as required -->
			<div id="extradiv_3"><span></span></div>
			<div id="extradiv_4"><span></span></div>
	
		</div>
		
		<div id="footer">
			<div id="credits">
				<ul id="credits_list">
					<?php 
					if (public_page_exists('rss')) {
						echo "<li id=\"cred_rss\"><a href=\"" . createURL('rss') . "\" title=\"Subscribe\">Subscribe</a></li>\n";
					} else {
						echo "\n";
					}
					?>
					<li id="cred_pixie"><a href="http://www.getpixie.co.uk" title="Get Pixie">Pixie Powered</a></li>
					<li id="cred_theme"><?php print $lang['theme']; print ' : ' . $theme_name;?> by <a href="<?php print $theme_link; ?>" title="<?php print $theme_name . ' by ' . $theme_creator;?>"><?php print $theme_creator;?></a></li>
				</ul>
			</div>
		</div>
		
		<!-- use for extra style as required -->
		<div id="extradiv_c"><span></span></div>
		<div id="extradiv_d"><span></span></div>

	</div>

  <?php if ($debug == 'yes') {
  /* Show the defined global vars */ print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
  phpinfo();
  } ?>

</body>
</html>
<!-- page generated in: <?php pagetime('print'); ?> -->
	<?php if ($gzip_theme_output == 'yes') { ?>
	<?php if (extension_loaded('zlib')) ob_end_flush(); ?>
	<?php } /* End gzip compression */ ?>
<?php 
	}
	} 
?>