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
// Title: Admin Index			                                         //
//***********************************************************************//

	error_reporting(0);														// turn off error reporting

	include "lib/lib_logs.php"; pagetime("init");   						// runtime clock

	extract($_REQUEST);                                                     // access to form vars if register globals is off

  	if (!file_exists( "config.php" ) || filesize( "config.php") < 10) {     // check for config
	header( "Location: install/" ); exit();} 								// redirect to installer
	
	include "config.php";           										// load cofiguration

	include "lib/lib_db.php";       										// load libraries order is important
	include "lib/lib_misc.php";     										//
	
	$prefs = get_prefs();           										// prefs as an array
	extract($prefs);                										// add prefs to globals
	putenv("TZ=$timezone");													// timezone fix

	include "lang/".$language.".php";                                       // get the language file
	
	include "lib/lib_date.php";												//
	include "lib/lib_auth.php";												// check user is logged in
	include "lib/lib_validate.php"; 										// 
	include "lib/lib_core.php";                                             //
	include "lib/lib_paginator.php";										//
	include "lib/lib_upload.php";											//
	include "lib/lib_rss.php";												//
	include "lib/lib_tags.php";												//
	include "lib/bad-behavior-pixie.php";                              		// no spam please
	include "lib/lib_backup.php";	                                        //
	include "lib/lib_simplepie.php";                                 		// because pie should be simple

	bombShelter();                  										// check URL size

	$s = check_404($s);                                                     // check section exists
	
	if ($do == "rss" && $user) {											// if this is a RSS page build feed
		adminrss($s, $user);												//
	} else {																//
	
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
	<meta name="generator" content="Pixie <?php print $version; ?> - Copyright (C) 2006 - <?php print date("Y");?>." /> 
		
	<!-- javascript -->
	<script type="text/javascript" src="jscript/jquery.js"></script>
	<script type="text/javascript" src="jscript/interface.js"></script>
	<script type="text/javascript" src="jscript/slider.js"></script>
	<script type="text/javascript" src="jscript/thickbox.js"></script>
	<script type="text/javascript" src="jscript/tablesorter.js"></script>
	<script type="text/javascript" src="jscript/pixie.js.php?s=<?php print $s; ?>"></script>
	<script type="text/javascript" src="jscript/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="jscript/tiny_mce/tiny_mce_setup.js.php?theme=<?php print $site_theme; ?>&amp;s=<?php print $x; ?>&amp;m=<?php print $m;?>"></script>
	<script type="text/javascript" src="jscript/tags.js"></script>
	<script type="text/javascript" src="jscript/ajaxfileupload.js"></script>
	
	<!-- bad behavior -->
	<?php bb2_insert_head(); ?>
	
	<!-- css -->
	<link rel="stylesheet" href="admin/theme/style.php?s=<?php print $s; ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="admin/theme/cskin.css" type="text/css" media="screen" />
	<?php
	// check for IE specific style files
	if (file_exists("admin/theme/ie.css")) {
		echo "\n\t<!--[if IE]><link href=\"admin/theme/ie.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists("admin/theme/ie6.css")) {
		echo "\n\t<!--[if IE 6]><link href=\"admin/theme/ie6.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}
	if (file_exists("admin/theme/ie7.css")) {
		echo "\n\t<!--[if IE 7]><link href=\"admin/theme/ie7.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n";
	}

	// check for handheld style file
	if (file_exists("admin/theme/handheld.css")) {
		echo "\n\t<link href=\"admin/theme/handheld.css\" type=\"text/css\" rel=\"stylesheet\" media=\"handheld\" />\n";
	}
	?>
	
	<!-- site icon -->
	<link rel="Shortcut Icon" type="image/x-icon" href="favicon.ico" />
	<link rel="apple-touch-icon" href="<?php print $site_url; ?>files/images/apple_touch_icon_pixie.jpg"/>

	<!-- rss feeds-->
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print str_replace(".","",$lang['blog']); ?>" href="http://www.getpixe.co.uk/blog/rss/" />
	<link rel="alternate" type="application/rss+xml" title="Pixie - <?php print $lang['latest_activity']; ?>" href="?s=myaccount&amp;do=rss&amp;user=<?php print safe_field('nonce','pixie_users',"user_name ='".$GLOBALS['pixie_user']."'"); ?>" />

</head>

<body class="pixie <?php $s." "; $date_array = getdate(); print "y".$date_array['year']." "; print "m".$date_array['mon']." "; print "d".$date_array['mday']." "; print "h".$date_array['hours']." "; print $s; ?>">
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
				<h2 id="pixie_strapline" title="<?php print $lang['tag_line']." v".$GLOBALS['version'];?>"><span><?php print $lang['tag_line']." v".$GLOBALS['version'];?></span></h2>
				
				<div id="nav_1">
					<?php print "\n"; if ($s != "login") { ?>
					<ul id="nav_level_1">
						<?php if ($GLOBALS['pixie_user_privs'] >= 2){ ?><li><a href="?s=settings" title="<?php print $lang['nav1_settings'];?>"<?php if ($s == 'settings') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_settings'];?></a><?php print "\n";} ?>
						<?php if ($s != "404" && $s == "settings"){ include('admin/modules/nav_'.$s.'.php'); } else if ($s != "login") { echo "</li>\n"; } ?>
						<?php if ($GLOBALS['pixie_user_privs'] >= 1){ ?><li><a href="?s=publish" title="<?php print $lang['nav1_publish'];?>"<?php if ($s == 'publish') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_publish'];?></a><?php print "\n";} ?>
						<?php if ($s != "404" && $s == "publish"){ include('admin/modules/nav_'.$s.'.php'); } else if ($s != "login") { echo "</li>\n"; } ?>
						<?php if ($GLOBALS['pixie_user']){ ?><li><a href="?s=myaccount" title="<?php print $lang['nav1_home'];?>"<?php if  ($s == 'myaccount') { print " class=\"nav_current_1\"";}?>><?php print $lang['nav1_home'];?></a><?php print "\n";} ?>
						<?php if ($s != "404" && $s == "myaccount"){ include('admin/modules/nav_'.$s.'.php'); } else if ($s != "login") { echo "</li>\n"; } ?>
					</ul>
					<?php } print "\n"; ?>
				</div>
	
			</div>
	
			<div id="pixie_body">
						
	   			<?php if ($s != "404"){ include('admin/modules/mod_'.$s.'.php'); } else { include('modules/static.php'); }?>
	
			</div>
		</div>
		<div id="pixie_footer">
			<div id="credits">
				<ul id="credits_list">
					<li id="cred_pixie"><a href="http://www.getpixie.co.uk/" title="Get Pixie">Pixie Powered.</a></li>
					<li id="cred_licence"><?php print $lang['license']; ?> <a href="<?php print $site_url."license.txt";?>" title="<?php print $lang['license']; ?> GNU General Public License v3" rel="license">GNU General Public License v3</a>.</li>
					<li id="cred_site"><a href="<?php print $site_url;?>" title="<?php echo $lang['view_site']; ?>"><?php $site = strtolower(str_replace("http://", "", $site_url)); print $site; ?></a></li>
				</ul>
			</div>
		</div>
	</div>	
<?php
		global $message;
		if (($message) || ($messageok)) {
			echo "
	<script type=\"text/javascript\">
		$(function(){";
 			if ($message) {
 				if($GLOBALS['system_message'] != $message) {
 					echo "\n\t\t\t$.post(\"admin/modules/ajax_message.php\",{ message: \"$message\" }, function(data){ $(data).appendTo(\"div#message\"); $(\"#message\").hide(); $(\"#message\").fadeIn(\"slow\"); $(\"#message\").css({ padding: \"5px\" }); $(\"#message\").addClass(\"errormess\"); });";
 				} else {
 					echo "\n\t\t\t$.post(\"admin/modules/ajax_message.php\",{ message: \"$message\", back: \"no\" }, function(data){ $(data).appendTo(\"div#message\"); $(\"#message\").hide(); $(\"#message\").fadeIn(\"slow\"); $(\"#message\").css({ padding: \"5px\" }); $(\"#message\").addClass(\"okmess\"); });";
 				}
 	 		} else if ($messageok) {
 				safe_update("pixie_settings", "value = now()", "name = 'dbupdatetime'");
 				echo "\n\t\t\t$.post(\"admin/modules/ajax_message.php\",{ messageok: \"$messageok\" }, function(data){ $(data).appendTo(\"div#message\"); $(\"#message\").hide(); $(\"#message\").fadeIn(\"slow\"); $(\"#message\").css({ padding: \"5px\" }); $(\"#message\").addClass(\"okmess\"); });";
 			}
		echo"
		}) 
	</script>\n";
		}
?>
</body>
</html>
<!-- page generated in: <?php pagetime("print");?> -->
<?php
	}
?>