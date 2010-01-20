<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Installer.                                               //
//*****************************************************************//
require '../lib/lib_misc.php';     										  		// loaded for security
	bombShelter();                  											  		// che
	$debug = 'no';	// Set this to yes to debug and see all the global vars coming into the file
			// To find error messages, search the page for php_errormsg if you turn this debug feature on

	error_reporting(0);	// Turns off error reporting

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
	}

	// Variables that need to be defined

	$pixie_version = '1.04';		// You can define the version number for Pixie releases here
	$pixie_user = 'Pixie Installer';		// The name on the first log
	$pixie_server_timezone = 'Europe/London';		// Hosted server timezone
	$pixie_step = '0';
	$pixie_dropolddata = 'No';
	$pixie_reinstall = 'No';

	$pixie_prefix = NULL; // Prevent undefined variables. If undefined - Initialise them!
	$pixie_database = NULL;
	$pixie_password = NULL;
	$pixie_username = NULL;
	$pixie_host = NULL;
	$pixie_sitename = NULL;
	$pixie_email = NULL;
	$pixie_name = NULL;
	$error = NULL;
	$error1 = NULL;
	$step = NULL;
	$urlstart = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$urlstart = str_replace("admin/install/index.php","",$urlstart);
	$pixie_url = $urlstart;
	$pixie_user_privs = 'NULL'; // This defines an undefined constant or index? I think it needs unset or something...

	// Experimental features need switches, put those switches here

	// Google translate the installer. Needs method to remember language across pages
	// The translator only displays if your browser does not have language en set
	$google_translate = 'No';	// We can use google translate to translate the interface if set to Yes //	http://translate.google.com/translate_tools	// Needs page language setting on each page to auto translate the interface, todo..

	// This prevents the default php server timezone error message when the phpdate function is called
	// php uses this setting in scripts to get the correct server time. Not user local time.
	// It must be set to not bog php down with errors.

    if (strnatcmp(phpversion(),'5.1.0') >= 0) 
    { 
        	date_default_timezone_set("$pixie_server_timezone");	# equal or newer 
    }

	globalSec('Main index.php', 1);

	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie'); // access to form vars if register globals is off

	switch($pixie_step) {
		
		// step 2
		// create the config file, chmod the correct directories and install basic db stucture 
		case '2':

			if ($pixie_prefix == 'pixie_') { $pixie_prefix = 'pixie__'; }		// Prevent pixie_ being used as the prefix, causes bug

			if ($pixie_dropolddata == 'Yes') {
			if ($pixie_reinstall == 'Yes') {
			$pixie_step = '1';
			$error = 'Please choose either fresh start or re-install. You cannot select both.';
			break;
			      }
			}

			if ($pixie_reinstall == 'Yes') {
			include '../config.php';           		// load configuration
			$pixie_database  =  $pixieconfig['db'];
			$pixie_username  =  $pixieconfig['user'];
			$pixie_password  =  $pixieconfig['pass'];
			$pixie_host  =  $pixieconfig['host'];
			$pixie_prefix  =  $pixieconfig['table_prefix'];
			$pixie_server_timezone  =  $pixieconfig['server_timezone'];
			}

			$conn = mysql_connect($pixie_host, $pixie_username, $pixie_password);
			
			if (!$conn) {
				if ($pixie_dropolddata == 'Yes') { $pixie_step = '1'; 	$error = 'Pixie could not connect to your database, check your details below.'; break; }
				$error = 'Pixie could not connect to your database, check your details below.';

			} else {
				$checkdb = mysql_select_db($pixie_database);
				if (!$checkdb) {

				if ($_REQUEST['database'] == NULL) { $have_you_even_provided_a_database_name = '<br />Please provide the correct name of your database.'; } else { $have_you_even_provided_a_database_name = "<br />Make sure you have created a database with the name <b><u>$pixie_database</u></b>"; }
					$error = "Pixie could not connect to your database! $have_you_even_provided_a_database_name";

				} else {
					
					if ($pixie_dropolddata == 'Yes') { chmod('../config.php', 0777); $do_the_drop = 'Yes'; } // chmod doesn't work here but it might for you!
					if ($pixie_reinstall == 'Yes') { chmod('../config.php', 0777); $do_the_drop = 'Yes'; } // chmod doesn't work here but it might for you!

							  if ($do_the_drop == 'Yes') {
					    /* This could be a function. It drops all tables from a database */
					    /* Do not add this to lib_db because it is a security risk! */
							  /* query all tables */
							  $sql = "SHOW TABLES FROM $pixie_database";
							  if($result = mysql_query($sql)){
							  /* add table name to array */
							  while($row = mysql_fetch_row($result)){
							  $found_tables[]=$row[0];
							}
						      }
						else{
			$pixie_step = '1';
			$error = 'Error, could not the list tables. MySQL Error: ' . mysql_error();
			break;
					    }
							  /* loop through and drop each table */
							  foreach($found_tables as $table_name){
							  $sql = "DROP TABLE $pixie_database.$table_name";
							  if($result = mysql_query($sql)){
							  // We could echo a sucess message here if we wanted
							}
						  else{
			$pixie_step = '1';
			$error = 'Error deleting $table_name. MySQL Error: ' . mysql_error() . "";
			break;
					      }
					    }

											     }

					// write data to config file
					if (is_writable('../config.php')) {
						$fh = fopen('../config.php', 'w');
						$data = 
						"<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Configuration settings.                                  //
//*****************************************************************//

// MySQL settings //
\$pixieconfig['db'] = '$pixie_database';
\$pixieconfig['user'] = '$pixie_username';
\$pixieconfig['pass'] = '$pixie_password';
\$pixieconfig['host'] = '$pixie_host';
\$pixieconfig['table_prefix'] = '$pixie_prefix';

// Timezone //
// This timezone setting is the server time zone //
// and not your local time zone. //
\$pixieconfig['server_timezone'] = '$pixie_server_timezone';
?>";
						fwrite($fh, $data);
						fclose($fh);
						
						// chmod config.php so that the database details don't get exposed by accident
						chmod('../config.php', 0640);

						// load in the required libraries
						
						include '../config.php';
						include '../lib/lib_db.php';
						
						// install the base layer sql
						
						// pixie_bad_behaviour table
						$sql = "						
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_bad_behavior` (
							`id` int(11) NOT NULL auto_increment,
							`ip` text collate utf8_unicode_ci NOT NULL,
							`date` datetime NOT NULL default '0000-00-00 00:00:00',
							`request_method` text collate utf8_unicode_ci NOT NULL,
							`request_uri` text collate utf8_unicode_ci NOT NULL,
							`server_protocol` text collate utf8_unicode_ci NOT NULL,
							`http_headers` text collate utf8_unicode_ci NOT NULL,
							`user_agent` text collate utf8_unicode_ci NOT NULL,
							`request_entity` text collate utf8_unicode_ci NOT NULL,
							`key` text collate utf8_unicode_ci NOT NULL,
							PRIMARY KEY  (`id`),
							KEY `ip` (`ip`(15)),
							KEY `user_agent` (`user_agent`(10))
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
						";
						
						$ok = safe_query($sql);
						
						// pixie_core table
						$sql1 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_core` (
							`page_id` smallint(11) NOT NULL auto_increment,
							`page_type` set('dynamic','static','module','plugin') collate utf8_unicode_ci NOT NULL default '',
							`page_name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
							`page_display_name` varchar(40) collate utf8_unicode_ci NOT NULL default '',
							`page_description` longtext collate utf8_unicode_ci NOT NULL,
							`page_blocks` varchar(200) collate utf8_unicode_ci default NULL,
							`page_content` longtext collate utf8_unicode_ci,
							`page_views` int(12) default '0',
							`page_parent` varchar(40) collate utf8_unicode_ci default NULL,
							`privs` tinyint(2) NOT NULL default '2',
							`publish` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
							`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
							`in_navigation` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
							`page_order` int(3) default '0',
							`searchable` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
							`last_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
							PRIMARY KEY  (`page_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=3 ;
						";
						
						$ok = safe_query($sql1);
						
						// pixie_core data for 404 and comments plugin
						$sql2 = "
							INSERT INTO `".$pixie_prefix."pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`, `page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`, `public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES
							(1, 'static', '404', 'Error 404', 'Page not found.', '', '<p>The page you are looking for cannot be found.</p>', 11, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-01-01 00:00:11'),
							(2, 'plugin', 'comments', 'Comments', 'This plugin enables commenting on dynamic pages.', '', '', 1, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-01-01 00:00:11');	
						";
						
						$ok = safe_query($sql2);
						
						// pixie_dynamic_posts table
						$sql3 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_dynamic_posts` (
					  		`post_id` int(11) NOT NULL auto_increment,
					  		`page_id` int(11) NOT NULL default '0',
					  		`posted` timestamp NOT NULL default '0000-00-00 00:00:00',
					  		`title` varchar(235) collate utf8_unicode_ci NOT NULL default '',
					  		`content` longtext collate utf8_unicode_ci NOT NULL,
					  		`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',
					  		`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
					  		`comments` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
					  		`author` varchar(64) collate utf8_unicode_ci NOT NULL default '',
					  		`last_modified` timestamp NULL default CURRENT_TIMESTAMP,
					  		`post_views` int(12) default NULL,
					  		`post_slug` varchar(255) collate utf8_unicode_ci NOT NULL default '',
					  		PRIMARY KEY  (`post_id`),
					  		UNIQUE KEY `id` (`post_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
						";
						
						$ok = safe_query($sql3);
						
						// pixie_dynamic_settings table
						$sql4 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_dynamic_settings` (
						  	`settings_id` int(11) NOT NULL auto_increment,
						  	`page_id` int(11) NOT NULL default '0',
						  	`posts_per_page` int(2) NOT NULL default '0',
						  	`rss` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
						  	PRIMARY KEY  (`settings_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;			
						";
						
						$ok = safe_query($sql4);
						
						// pixie_files table
						$sql5 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_files` (
						  	`file_id` smallint(6) NOT NULL auto_increment,
						  	`file_name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`file_extension` varchar(5) collate utf8_unicode_ci NOT NULL default '',
						  	`file_type` set('Video','Image','Audio','Other') collate utf8_unicode_ci NOT NULL default '',
						  	`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',
						  	PRIMARY KEY  (`file_id`),
						  	UNIQUE KEY `id` (`file_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=5 ;
						";
			
						$ok = safe_query($sql5);
						
						// insert the default files supplied with pixie
						$sql6 = "
							INSERT INTO `".$pixie_prefix."pixie_files` (`file_id`, `file_name`, `file_extension`, `file_type`, `tags`) VALUES
							(1, 'rss_feed_icon.gif', 'gif', 'Image', 'rss feed icon'),
							(2, 'no_grav.jpg', 'jpg', 'Image', 'gravitar icon'),
							(3, 'apple_touch_icon.jpg', 'jpg', 'Image', 'icon apple touch'),
							(4, 'apple_touch_icon_pixie.jpg', 'jpg', 'Image', 'icon apple touch pixie');
						";
						
						$ok = safe_query($sql6);
						
						// pixie_log table
						$sql7 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_log` (
						  	`log_id` int(6) NOT NULL auto_increment,
						  	`user_id` varchar(40) collate utf8_unicode_ci NOT NULL default '',
						  	`user_ip` varchar(15) collate utf8_unicode_ci NOT NULL default '',
						  	`log_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
						  	`log_type` set('referral','system') collate utf8_unicode_ci NOT NULL default '',
						  	`log_message` varchar(250) collate utf8_unicode_ci NOT NULL default '',
						  	`log_icon` varchar(20) collate utf8_unicode_ci NOT NULL default '',
						  	`log_important` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
						  	PRIMARY KEY  (`log_id`),
						  	UNIQUE KEY `id` (`log_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;						
						";
						
						$ok = safe_query($sql7);
						
						// pixie_log_users_online table
						$sql8 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_log_users_online` (
						  	`visitor_id` int(11) NOT NULL auto_increment,
						  	`visitor` varchar(15) collate utf8_unicode_ci NOT NULL default '',
						  	`last_visit` int(14) NOT NULL default '0',
						  	PRIMARY KEY  (`visitor_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
						";

						$ok = safe_query($sql8);
						
						// pixie_module_comments table
						$sql9 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_module_comments` (
						  	`comments_id` int(5) NOT NULL auto_increment,
						  	`post_id` int(5) NOT NULL default '0',
						  	`posted` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
						  	`name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`email` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`url` varchar(80) collate utf8_unicode_ci default NULL,
						  	`comment` longtext collate utf8_unicode_ci NOT NULL,
						  	`admin_user` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',
						  	PRIMARY KEY  (`comments_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;						
						";
						
						$ok = safe_query($sql9);
						
						// pixie_settings table
						$sql10 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_settings` (
						  	`settings_id` smallint(6) NOT NULL auto_increment,
						  	`site_name` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`site_keywords` longtext collate utf8_unicode_ci NOT NULL,
						  	`site_url` varchar(255) collate utf8_unicode_ci NOT NULL default '',
						  	`site_theme` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`site_copyright` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`site_author` varchar(80) collate utf8_unicode_ci NOT NULL default '',
						  	`default_page` varchar(40) collate utf8_unicode_ci NOT NULL default '',
						  	`clean_urls` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
						  	`version` varchar(5) collate utf8_unicode_ci NOT NULL default '',
						  	`language` varchar(6) collate utf8_unicode_ci NOT NULL default '',
						  	`timezone` varchar(6) collate utf8_unicode_ci NOT NULL default '',
						  	`dst` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',
						  	`date_format` varchar(30) collate utf8_unicode_ci NOT NULL default '',
						  	`logs_expire` varchar(3) collate utf8_unicode_ci NOT NULL default '',
						  	`rich_text_editor` tinyint(1) NOT NULL default '0',
						  	`system_message` tinytext collate utf8_unicode_ci NOT NULL,
						  	`last_backup` varchar(120) collate utf8_unicode_ci NOT NULL default '',
						  	`bb2_installed` SET('yes','no') collate utf8_unicode_ci NOT NULL DEFAULT 'no',
						  	PRIMARY KEY  (`settings_id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;						
						";
						
						$ok = safe_query($sql10);
						
						// pixie_users table
						$sql11 = "
						CREATE TABLE IF NOT EXISTS `".$pixie_prefix."pixie_users` (
						  	`user_id` int(4) NOT NULL auto_increment,
						  	`user_name` varchar(64) collate utf8_unicode_ci NOT NULL default '',
						  	`realname` varchar(64) collate utf8_unicode_ci NOT NULL default '',
						  	`street` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`town` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`county` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`country` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`post_code` varchar(20) collate utf8_unicode_ci NOT NULL default '',
						  	`telephone` varchar(30) collate utf8_unicode_ci NOT NULL default '',
						  	`email` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`website` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`biography` mediumtext collate utf8_unicode_ci NOT NULL,
						  	`occupation` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`link_1` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`link_2` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`link_3` varchar(100) collate utf8_unicode_ci NOT NULL default '',
						  	`privs` tinyint(2) NOT NULL default '1',
						  	`pass` varchar(128) collate utf8_unicode_ci NOT NULL default '',
						  	`nonce` varchar(64) collate utf8_unicode_ci NOT NULL default '',
						  	`user_hits` int(7) NOT NULL default '0',
						  	`last_access` timestamp NOT NULL default CURRENT_TIMESTAMP,
						  	PRIMARY KEY  (`user_id`),
						  	UNIQUE KEY `name` (`user_name`)
						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=1 ;						
						";

						$ok = safe_query($sql11);
						
						// place dummy settings into settings table
						$sql12 = "
							INSERT INTO `".$pixie_prefix."pixie_settings` (`settings_id`, `site_name`, `site_keywords`, `site_url`, `site_theme`, `site_copyright`, `site_author`, `default_page`, `clean_urls`, `version`, `language`, `timezone`, `dst`, `date_format`, `logs_expire`, `rich_text_editor`, `system_message`, `last_backup`) VALUES
							(1, '-', '-', '-', '-', '', '', '-', 'no', '-', '-', '-', 'yes', '-', '-', 1, '', '');
						";
						
						$ok = safe_query($sql12);	

						$already_there_test = "
							SELECT settings_id FROM ".$pixie_prefix."pixie_settings;
						";

						$ok = safe_query($already_there_test);

						if (!$ok) {
							  $error = 'Core database schema could not be created.';
							  }
						
					} else {

					if (filesize('../config.php') < 5) {	// check for config
					$error = "Pixie is unable to write to your config.php file, you may need to manually change the file using a text editor and FTP or change the permissions of the file.<br/> <a href=\"http://code.google.com/p/pixie-cms/w/list\" title=\"Pixie Wiki\">View the help files for more information</a>.";
					}
						
					}
					
				} 
			}

		if ($pixie_dropolddata == 'Yes') {
		$pixie_step = '2';
		} else {

			if (!$error) {
				$pixie_step = '2';
			} else {
				$pixie_step = '1';
			}
		}
		
		break;
		
		case '3':	
		
			include '../config.php';           		// load configuration
			include '../lib/lib_db.php';       		// load libraries order is important
			include '../lang/'.$pixie_langu.'.php';       // get the language file
			include '../lib/lib_date.php';			//
			include '../lib/lib_validate.php'; 		// 
			include '../lib/lib_core.php';          //
			include '../lib/lib_backup.php';	    //

			$pixie_sitename = addslashes($pixie_sitename);	// Helps prevents a bug where a ' in a string like : dave's site, errors out the admin interface
			$pixie_sitename = htmlentities($pixie_sitename);	// Helps prevents a bug where a ' in a string like : dave's site, errors out the admin interface

			$check = new Validator ();
			if (!$pixie_sitename) { $error .= $lang['site_name_error']." |"; $scream[] = 'name'; }
			if (!$pixie_url) { $error .= $lang['site_url_error']." |"; $scream[] = 'url'; }
			// we turn off url validation so localhost is accepted
			//if (!$check->validateURL($url, $lang['site_url_error']." |")) { $scream[] = "url"; }
			if ($check->foundErrors()) { $error .= $check->listErrors("x"); }

			$table_name = 'pixie_settings';
			$site_url_last = $pixie_url{strlen($pixie_url)-1};
			
  			$err = explode("|",$error);
  			$error = $err[0];
  			
  			if (!$error) {
  			  	if ($site_url_last != "/") {
  					$pixie_url = $pixie_url."/";
  				}
  				
  				// site defaults
  				// save settings to the database
				$ok = safe_update(
					"pixie_settings", 
					"site_name = '$pixie_sitename', 
					 site_url = '$pixie_url',
					 site_theme = 'itheme',
					 version = '$pixie_version',
					 language = '$pixie_langu',
					 dst = 'no',
					 timezone = '+0',
					 date_format = '%Oe %B %Y, %H:%M',
					 logs_expire = '30',
					 rich_text_editor = '1',
					 system_message = 'Welcome to Pixie...(you can clear this message in your Pixie settings).', 
					 site_keywords = 'pixie, demo, getpixie, small, simple, site, maker, www.getpixie.co.uk, cms, content, management, system, easy, interface, design, microformats, web, standards, themes, css, xhtml, scott, evans, toggle, php, mysql, pisky', 
					 default_page = 'none',
					 clean_urls = 'no'",
					 "settings_id ='1'"
				);
				
				// create .htaccess for clean URLs
				$fh = fopen('../../.htaccess', 'w');
				$clean = str_replace("/admin/install/index.php","",$_SERVER["REQUEST_URI"]);
				if (!$clean) {
					$clean = "/";
				}
				$data = 
"#
# 	Apache-PHP-Pixie .htaccess
#

#	Pixie Powered (www.getpixie.co.uk)
#	Licence: GNU General Public License v3                   		 
#	Copyright (C) Scott Evans   

#	This program is free software: you can redistribute it and/or modify
#	it under the terms of the GNU General Public License as published by
#	the Free Software Foundation, either version 3 of the License, or
#	(at your option) any later version.

#	This program is distributed in the hope that it will be useful,
#	but WITHOUT ANY WARRANTY; without even the implied warranty of
#	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
#	GNU General Public License for more details.

#	You should have received a copy of the GNU General Public License
#	along with this program. If not, see http://www.gnu.org/licenses/   

#	www.getpixie.co.uk                          

# 	This file was automatically created for you by the Pixie Installer.

# Set the default handler.
DirectoryIndex index.php

# Start the rewrite rules
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

  # Modify the RewriteBase if you are using pixie in a subdirectory or in a
  # VirtualDocumentRoot and the rewrite rules are not working properly.
  # For example if your site is at http://yoursite.com/pixie uncomment and
  # modify the following line:
    RewriteBase $clean

# Protect files and directories from prying eyes.
<FilesMatch \"\.(engine|inc|info|install|module|profile|test|po|sh|.*sql|theme|tpl(\.php)?|xtmpl|svn-base)$|^(code-style\.pl|Entries.*|Repository|Root|Tag|Template|all-wcprops|entries|format)$\">
  Order allow,deny
</FilesMatch>

# Don't show directory listings for URLs which map to a directory.
Options -Indexes

# Make Pixie handle any 404 errors.
ErrorDocument 404 /index.php

# Force simple error message for requests for non-existent favicon.ico.
<Files favicon.ico>
  # There is no end quote below, for compatibility with Apache 1.3.
  ErrorDocument 404 \"The requested file favicon.ico was not found.
</Files>

########## Begin - Rewrite rules to block out some common exploits
## If you experience problems on your site block out the operations listed below
## This attempts to block the most common type of exploit `attempts.`

## Deny access to extension xml files (comment out to de-activate)
<Files ~ \"\.xml$\">
Order allow,deny
Deny from all
Satisfy all
</Files>
## End of deny access to extension xml files

## Deny access to htaccess and htpasswd files (comment out to de-activate)
<Files ~ \"\.ht$\">
order allow,deny
deny from all
Satisfy all
</Files>
## End of deny access to extension htaccess and htpasswd files files

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
#
########## End - Rewrite rules to block out some common exploits

# Start Pixie's core mod rewrite rules
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*) index.php?%{QUERY_STRING} [L]
# End Pixie's core mod rewrite rules

# End the rewrite rules
</IfModule>

# Extra features

# Requires mod_expires to be enabled.
<IfModule mod_expires.c>
  # Enable expirations.
  ExpiresActive On

  # Cache all files for 2 weeks after access (A).
  ExpiresDefault A1209600

  # Do not cache dynamically generated pages.
  ExpiresByType text/html A1
</IfModule>";
				fwrite($fh, $data);
				fclose($fh);
				chmod('../../.htaccess', 0640); // Try to chmod the .htaccess file
  			}
  			
  			// load external sql
  			$file = $pixie_type.'_db.sql';
  			$file_content = file($file);
   			foreach($file_content as $sql_line){
   				// adjust for table prefix
   				$sql_line = str_replace('pixie_', $pixieconfig['table_prefix'].'pixie_', $sql_line);
      			safe_query($sql_line);
			}
			  			
  			// chmod the files folder
  			chmod('../../files/', 0777);
			chmod('../../files/audio/', 0777);
			chmod('../../files/cache/', 0777);
			chmod('../../files/images/', 0777);
			chmod('../../files/other/', 0777);
			chmod('../../files/sqlbackups/', 0777);

			if (!$error) {
				$pixie_step = '3';
			} else {
				$pixie_step = '2';
			}
		
		break;
		
		// step 4 - finish 
		case '4':
		
			include '../config.php';           		// load configuration
			include '../lib/lib_db.php';       		// load libraries order is important
			
			$prefs = get_prefs();           		// prefs as an array
			extract($prefs);                		// add prefs to globals
			include '../lang/'.$language.'.php';      	 // get the language file
			include '../lib/lib_date.php';			//
			include '../lib/lib_validate.php'; 		// 
			include '../lib/lib_core.php';          	//
			include '../lib/lib_backup.php';	    	//
			include '../lib/lib_logs.php';          	//

	if ($debug == 'yes') {
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The prefs array contains : ';
	htmlspecialchars(print_r($show_vars["prefs"]));
	echo '</pre></p>';
	}

			$check = new Validator ();
			$check_result_number = 0;
			// Boy, this needed cleaning up...

			if ($pixie_name == "") { $error1 .= $lang['user_realname_missing']." |"; $scream[] = 'realname';
			if ($check->foundErrors()) { $error1 .= $check->listErrors("x"); }
			$err = explode("|",$error1);
			$error = $err[0];
						}

			if (!$error) {	
			$check_result_number = $check_result_number + 1;
					}

			$pixie_username = str_replace(" ", "", preg_replace('/\s\s+/', ' ', trim($pixie_username))); // This ensures no spaces in the username

			if ($pixie_username == "") { $error1 .= $lang['user_name_missing']." |"; $scream[] = 'uname';
			if ($check->foundErrors()) { $error1 .= $check->listErrors("x"); }
			$err = explode("|",$error1);
			$error = $err[0];
						}

			if (!$error) {
			$check_result_number = $check_result_number + 1;
					}

			if (!$check->validateEmail($pixie_email,$lang['user_email_error']." |")) { $scream[] = 'email';
			if ($pixie_email == "") { $error1 .= $lang['user_email_error']." |"; $scream[] = 'email';
			if ($check->foundErrors()) { $error1 .= $check->listErrors("x"); }
			$err = explode("|",$error1);
			$error = $err[0];
												  }

						}

			if (!$error) {
			$check_result_number = $check_result_number + 1;
					}

			if ($pixie_password == "") { $error1 .= $lang['user_password_missing']." |"; $scream[] = 'realname';
			if ($check->foundErrors()) { $error1 .= $check->listErrors("x"); }
			$err = explode("|",$error1);
			$error = $err[0];
						}

			if (!$error) {
			$check_result_number = $check_result_number + 1;
					}


			// We have four results to check, so if they were all done, do this :
			if ($check_result_number == 4) {

			$sql = "realname = '$pixie_name'"; 
			safe_insert('pixie_users', $sql);
			safe_update('pixie_settings', "site_author = '$pixie_name', site_copyright = '$pixie_name'", "settings_id ='1'");	
			$sql = "user_name = '$pixie_username'"; 
			safe_update('pixie_users', $sql, "user_id ='1'");
			$sql = "email = '$pixie_email'"; 
			safe_update('pixie_users', $sql, "user_id ='1'");
			$nonce = md5( uniqid( rand(), true ) ); // Could we use sha1 instead? sha1( uniqid( rand(), true ) );	// http://www.php.net/manual/en/function.sha1.php
			$sql = "pass = password(lower('$pixie_password')), nonce = '$nonce', privs = '3', link_1 = 'http://www.toggle.uk.com', link_2 = 'http://www.getpixie.co.uk', link_3 = 'http://www.iwouldlikeawebsite.com', website='$site_url', `biography`=''"; 
			safe_update('pixie_users', $sql, "user_id ='1'");

			// upgrade sql
			$file = 'upgrade.sql';
			$file_content = file($file);
			foreach($file_content as $sql_line){
				// adjust prefix
				$sql_line = str_replace('pixie_', $pixieconfig['table_prefix'].'pixie_', $sql_line);
				safe_query($sql_line);
							    }

			$newmessage = 'No';
			// log the install
			if ($pixie_dropolddata == 'Yes') { logme('Mmmm... Minty... Pixie was installed a freshhh... remember to delete the install directory on your server.','yes','error'); $newmessage = 'Yes'; }
			if ($pixie_reinstall == 'Yes') { logme('Pixie was re-installed... you should manually delete the directory named install, which is located inside the admin directory.','yes','error'); $newmessage = 'Yes'; }
			if ($newmessage == 'No') { 
			logme('Pixie was installed... remember to delete the install directory on your server.','yes','error');
			}

	if (strnatcmp(phpversion(),'5.1.0') >= 0) { 
	logme('Welcome to Pixie ' . $pixie_version . ' running on PHP ' . phpversion() . ' be sure to visit <a href ="http://www.getpixie.co.uk/">www.getpixie.co.uk</a> to check for updates.','no','site');
						  } else { 
        logme('WARNING! Your current PHP version : ' . phpversion() . ' is not the current stable version of php. Please consult your server Administrator about upgrading php for security reasons.','yes','error');
	if (strnatcmp(phpversion(),'5.0.0') >= 0) { 
	logme('WARNING! Your current PHP version : ' . phpversion() . ' is depreciated and unsupported. Please consult your server Administrator about upgrading php for security reasons.','yes','error');
						  }
						  }

				// needs to be added to language file
				$emessage = "	
Hi ".$pixie_name.",
Congratulations! Pixie is now installed. Here are your login details:

Username: ".$pixie_username."
Password: ".$pixie_password."

You can visit: ".$pixie_url." to view your site
or ".$pixie_url."admin to login.

Thank You for installing Pixie.
We hope you enjoy it!

www.getpixie.co.uk
";

				$subject = "Hi ".$pixie_name.", Pixie was successfully installed.";
				mail($pixie_email, $subject, $emessage);
						  }

			if (!$error) {
				$pixie_step = '4';
			} else {
				$pixie_step = '3';
			}
		break;
		
		default:

		if ($debug == 'yes') { if ($pixie_step == '0') { $pixie_step = '1'; } }

		if ($pixie_step !== '1') {	// Always return back to the installer if requested
			if (filesize('../config.php') > 30) {		   // check for config
			header( 'Location: ../../admin/' ); exit();}   // redirect to pixie if its found
			}

    if (strnatcmp(phpversion(),'5.1.0') >= 0) 
    { 
        	date_default_timezone_set("$pixie_server_timezone");	# equal or newer 
    } 
    else 
    { 
        $error = 'WARNING! Your current PHP version: ' . phpversion() . ' is not the current stable version of php. Please consult your server Administrator about upgrading php for security reasons.';	# not sufficiant 
    if (strnatcmp(phpversion(),'5.0.0') >= 0) 
    { 
	$error = 'WARNING! Your current PHP version: ' . phpversion() . ' is depreciated and unsupported. Please consult your server Administrator about upgrading php for security reasons.';
    }

    }

		break;
	
	}
	
	if (!$pixie_step) {
		$pixie_step = '1';
	}
?>
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
	
	<title>Pixie (www.getpixie.co.uk) - Installer</title>
	
	<!-- meta tags -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="toggle, binary, html, xhtml, css, php, xml, mysql, flash, actionscript, action, script, web standards, accessibility, scott, evans, scott evans, sunk, media, www.getpixie.co.uk, scripts, news, portfolio, shop, blog, web, design, print, identity, logo, designer, fonts, typography, england, uk, london, united kingdom, staines, middlesex, computers, mac, apple, osx, os x, windows, linux, itx, mini, pc, gadgets, itunes, mp3, technology, www.toggle.uk.com" />
	<meta name="description" content="http://www.toggle.uk.com/ - web and print design portfolio for scott evans (uk)." />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="7 days" />
	<meta name="author" content="Scott Evans" />
  	<meta name="copyright" content="Scott Evans" />

	<!-- CSS -->
	<link rel="stylesheet" href="../admin/theme/style.php" type="text/css" media="screen"  />
<style type="text/css">
body,html {
height:auto;
background:#191919;
}

#bg-wrap {
background:#191919 url(background.jpg) 7px 0 no-repeat;
width:790px;
min-height:670px;
padding-top:100px;
display:none;
margin:0 auto;
}

#placeholder {
border:5px solid #e1e1e1;
clear:left;
background-color:#fff;
width:400px;
line-height:15pt;
min-height:480px;
margin:0 auto;
padding:15px 30px 20px;
}

p {
font-size:.8em;
padding:15px 0;
}

legend {
color:#109bd4;
}

.form_text {
width:320px;
}

.form_item_drop select {
width:335px;
padding:2px;
}

label {
float:left;
}

.form_help {
float:left;
font-size:.7em;
padding-left:5px;
padding-right:5px;
position:relative;
top:2px;
width:60%;
text-align:left;
}

.form_item_drop {
clear:both;
}

.help {
color:#898989;
margin:0;
padding:0;
}

.error,.notice,.success {
border:2px solid #ddd;
width:436px;
margin:0 auto;
padding:15px;
}

.error {
background:#FBE3E4;
color:#D12F19;
border-color:#FBC2C4;
}

.notice {
background:#FFF6BF;
color:#817134;
border-color:#FFD324;
}

.success {
background:#E6EFC2;
color:#529214;
border-color:#C6D880;
}

.showvars {
background-color:#000;
color:#0B9BD4;
}

.divcentertext {
font-size:.9em;
text-align:center;
}

.divcentertext2 {
font-size:.8em;
text-align:center;
}

#pixieicon {
border:5px solid #e1e1e1;
}

input,select {
margin-top:.4em;
}

.form_submit, .form_submit_b {
background-color:transparent;
background-image:url(button.png);
background-position:center bottom;
background-repeat:no-repeat;
border:0;
color:#fff;
height:30px;
width:70px;
}

.form_submit:hover, .form_submit_b:hover {
background-position:center top;
color:#fff;
}

.extra {
border:1px solid #E4E4E4;
margin-top:42px;
padding-left:24px;
padding-right:24px;
padding-bottom:48px;
display:none;
}

.small-heading {
font-size:14px;
color:#109BD4;
}

.divider {
border-top:1px solid #E4E4E4;
padding-bottom:18px;
width:252px;
margin-left:12px;
}

#switch {
text-align:right;
}

.switch-span {
margin-top:12px;
}

.extra .form_help {
width:100%;
clear:both;
padding-bottom:12px;
}

.extra select {
padding:2px;
}

.extra input {
width:285px;
}

.extra select {
width:295px;
}

.center,.advanced-heading {
text-align:center;
}

.form_submit_b {
font-size: 4px;
display: none;
}

#restart {
height: 20px;
width: 100%;
padding-bottom: 20px;
}

#logo-holder {
width: 470px;
height: 50px;
display:block;
margin:0 auto;
background-color:transparent;
background-image:url(banner.gif);
background-position:center top;
background-repeat:no-repeat;
border:0;
z-index: 100;
}

#logo {
width:470px;
height: 50px;
}

#google_translate_element {
text-align: center;
padding-top: 2em;
}

</style>

	<!-- site icons-->
	<link rel="Shortcut Icon" type="image/x-icon" href="../favicon.ico" />
	<link rel="apple-touch-icon" href="../../files/images/apple_touch_icon.jpg"/>
	
</head>

<body>
	<div id="bg-wrap">
	<div id="bg">
	<?php
	if ($error) {
		print "<p class=\"error\">$error</p>";
	}
	?>
	<div id="logo-holder"><img src="banner.gif" alt="Pixie logo" id="logo"></div>
	<div id="placeholder">
		<?php
		if ($pixie_step == '4') {
		?>
		<h3>Finished...</h3>	
		<?php
		} else {
		?>
		<h3>Installer (step <?php print $pixie_step; ?> of 3)</h3>
		<?php
		}		 
		switch($pixie_step) {
			case '4':
				global $site_url;
		?>
		<div class="center"><br /><b>Congratulations!</b></div><br />
		<div class="center"><img id="pixieicon" src="<?php print $site_url . 'files/images/apple_touch_icon.jpg'; ?>" alt="Pixie Logo jpg" /></div>
		<div class="divcentertext2"><br />Your new <b>Pixie</b> web site is now setup and ready to use.</div>
		<p>If you would like to add any <b>themes</b> or <b>modules</b>, be sure to visit the <a href="http://www.getpixie.co.uk" title="Pixie">Pixie website</a> to browse the collection. Please remember to delete the install directory within Pixie to secure your site.</p>
		<div class="divcentertext2">What would you like to do <b>next</b>?
		<br /><br /><a href="<?php print $site_url; ?>" title="Visit the homepage">Visit your new homepage</a> or<br />
		<a href="<?php print $site_url . 'admin/'; ?>" title="Login to Pixie">Login and start adding content</a> to your site...<br /></div>
		<p>If you need <b>help</b> with Pixie, you can join the <a href="http://groups.google.com/group/pixie-cms" title="Pixie Forums">Pixie Forums</a> and start a discussion. <b>Everyone</b> is welcome.<br />
		<br />If you would like to help <b>develop</b> Pixie, you can visit Pixie's <a href="http://code.google.com/p/pixie-cms/" title="Help develop Pixie">Google code project page</a> to get started.</p>
		<div class="divcentertext2"><br /><b>Thank you for installing Pixie!</b></div><br />
		<?php if ($debug == 'yes') { ?>
		<div class="center" id="restart"><form action="index.php" method="post" id="restart-form" class="form"><input type="hidden" name="step" value="1" /><input type="submit" name="next" class="form_submit_b" value="Re-Install" /></form></div>
		<?php } ?>
		<?php
			break;
			case '3':
		?>
		
		<p class="toptext">Nearly finished!<br />Last step is to create the "Super User" account for Pixie:</p>
	
		<form action="index.php" method="post" id="form_user" class="form">
			<fieldset>
			<legend>Super User information</legend>
				<div class="form_row">
					<div class="form_label"><label for="name">Your Name <span class="form_required">*</span></label><span class="form_help">Your real name</span></div>
					<div class="form_item"><input type="text" class="form_text" name="name" value="<?php print $pixie_name ?>" size="40" maxlength="80" id="name" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="username">Username <span class="form_required">*</span></label><span class="form_help">A login username</span></div>
					<div class="form_item"><input type="text" class="form_text" name="username" value="<?php print $pixie_username ?>" size="40" maxlength="80" id="username" /></div>
				</div>
	
				<div class="form_row">
					<div class="form_label"><label for="email">Email <span class="form_required">*</span></label><span class="form_help">Your email address</span></div>
					<div class="form_item"><input type="text" class="form_text" name="email" value="<?php print $pixie_email ?>" size="40" maxlength="80" id="email" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="password">Password <span class="form_required">*</span></label><span class="form_help">A strong password</span></div>
					<div class="form_item"><input type="password" class="form_text" name="password" value="<?php print $pixie_password ?>" size="40" maxlength="80" id="password" /></div>
				</div>
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="4" />
					<input type="submit" name="next" class="form_submit" value="Finish" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
		</form>
	
		<?php
			break;
			
			case "2":
			
			$url1 = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			$url1 = str_replace('admin/install/index.php',"",$url1);
		?>
		<p class="toptext">Now Pixie needs some details about your site (you will have access to more settings once Pixie is installed):</p>
		
		<form action="index.php" method="post" id="form_site" class="form">
			<fieldset>
			<legend>Site information</legend>
				<div class="form_row">
					<div class="form_label"><label for="langu">Language <span class="form_required">*</span></label><span class="form_help">Please select a language</span></div>
					<div class="form_item_drop">
						<select class="form_select" name="langu" id="langu">
							<option selected="selected" value="en-gb">English</option>
							<option value="fi-fi">Suomen</option>		<!--	Finnish		-->
							<option value="fr">Fran&ccedil;ais</option>	<!--	French		-->
							<option value="it">Italiano</option>		<!--	Italian		-->
							<option value="pl">Polska</option>		<!--	Polish		-->
							<option value="pt">Portugu&ecirc;s</option>	<!--	Portuguese	-->
							<option value="es-cl">Espa&ntilde;ol</option>	<!--	Spanish		-->
							<option value="se-sv">Svenska</option>		<!--	Swedish		-->
						</select>
					</div>
				</div>		
				<div class="form_row ">
					<div class="form_label"><label for="url">Site url <span class="form_required">*</span></label><span class="form_help">The full URL to your Pixie site</span></div>
					<div class="form_item"><input type="text" class="form_text" name="url" value="<?php if ($pixie_url) { print $pixie_url; } else { print $url1; }?>" size="40" maxlength="80" id="url" /></div>
				</div>
				<div class="form_row ">
					<div class="form_label"><label for="site_name">Site Name <span class="form_required">*</span></label><span class="form_help">What's it called?</span></div>
					<div class="form_item"><input type="text" class="form_text" name="sitename" value="<?php if ($pixie_sitename) { print $pixie_sitename; } else { print 'My Pixie Site'; } ?>" size="40" maxlength="80" id="site_name" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="type">Site type <span class="form_required">*</span></label><span class="form_help">What type of site are you after?</span></div>
					<div class="form_item_drop">
						<select class="form_select" name="type" id="type">
							<option value="0">An empty one... I will start afresh.</option>
							<option selected="selected" value="1">Just a blog please (recommended).</option>
							<option value="2">Install everything... I want to try it all!</option>
						</select>
					</div>
				</div>
				<p class="help">Please note you can completely edit your choice once Pixie is installed, the site types are to save your time when setting up different websites.<br /><br />As Pixie matures so will the list of possibilites.<br /><a href="http://code.google.com/p/pixie-cms/" title="Pixie on Google code">Help us develop</a> Pixie!</p> 
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="3" />
					<input type="submit" name="next" class="form_submit" value="Next &raquo;" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
		</form>
		
		<?php
			break;
			
			default:

		?>

<?php

// List of timezones to use to set pixie's timezone with

$zonelist = array('Pacific/Midway',
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
		'Pacific/Tongatapu');

		// Add more here if you want to...

		// Sort by area/city name.
		sort( $zonelist );

?>

		<p class="toptext">Welcome to the <a href="http://www.getpixie.co.uk" alt="Get Pixie!">Pixie</a> installer, just a few steps to go until you have your own Pixie powered website. Firstly we need your database details :</p>
		
		<form action="index.php" method="post" id="form_db" class="form">
			<fieldset>
			<legend>Database information</legend>		
				<div class="form_row ">
					<div class="form_label"><label for="host">Host <span class="form_required">*</span></label><span class="form_help">Usually ok as "localhost"</span></div>
					<div class="form_item"><input type="text" class="form_text" name="host" value="<?php if ($pixie_host) { print $pixie_host; } else { print 'localhost'; }?>" size="40" maxlength="80" id="host" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="username">Database Username <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="username" value="<?php print $pixie_username; ?>" size="40" maxlength="80" id="username" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="password">Database Password <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="password" class="form_text" name="password" value="<?php print $pixie_password; ?>" size="40" maxlength="80" id="password" /></div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="database">Database Name <span class="form_required">*</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="database" value="<?php print $pixie_database; ?>" size="40" maxlength="80" id="database" /></div>
				</div>
		<div id="switch"></div>
			<div class="extra"><p class="advanced-heading"><span class="small-heading">Optional Extra Settings</span></p><div class="divider"></div>
				<div class="form_row">
					<div class="form_label"><label for="server_timezone">Timezone </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="server_timezone" id="server_timezoneselect">
							<option selected="selected" value="<?php print $pixie_server_timezone; ?>"><?php print $pixie_server_timezone; ?></option>
							<?php foreach($zonelist as $tzselect){
							// Output all the timezones
							Echo "<option value=\"$tzselect\">$tzselect</option>";
							} ?>
						</select><span class="form_help">The time zone as set on the host server</span>
					</div>
				</div>			
				<div class="form_row">
					<div class="form_label"><label for="prefix">Database Table Prefix <span class="form_optional">(optional)</span></label></div>
					<div class="form_item"><input type="text" class="form_text" name="prefix" value="<?php print $pixie_prefix; ?>" size="40" maxlength="80" id="prefix" /><span class="form_help">Example : pixie_</span></div>
				</div>

		<?php if ($debug == 'yes') { ?>

				<div class="form_row">
					<div class="form_label"><label for="dropolddata">Fresh start </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="dropolddata" id="dropolddataselect">
							<option selected="selected" value="<?php print $pixie_dropolddata; ?>"><?php print $pixie_dropolddata; ?></option>
							<option value="Yes">Yes</option>
						</select><span class="form_help">Remove the existing data and configuration?</span>
					</div>
				</div>
				<div class="form_row">
					<div class="form_label"><label for="reinstall">Re-install </label></div>
					<div class="form_item_drop">
						<select class="form_select" name="reinstall" id="reinstallselect">
							<option selected="selected" value="<?php print $pixie_reinstall; ?>"><?php print $pixie_reinstall; ?></option>
							<option value="Yes">Yes</option>
						</select><span class="form_help">Remove the data but recycle the configuration?</span>
					</div>
				</div>

				     <?php } ?>

			</div>
				<div class="form_row_button" id="form_button">
					<input type="hidden" name="step" value="2" />
					<input type="submit" name="next" class="form_submit" value="Next &raquo;" />
				</div>
				<div class="safclear"></div>
			</fieldset>	
 		</form>
 		<?php
 			break;
 		}
 		?>
			<?php if ($google_translate == 'Yes') { // The translate element only shows up if the visiting browser is not set to lang en ?>
			      <!-- Google Translate Element -->
			      <div id="google_translate_element" style="display:none"></div>
			<?php } // If display:none is removed from the above line, the translator will always show ?>
	      </div>
	</div>
  </div>

	<?php if ($debug == 'yes') {
	/* Show the defined global vars */ print '<pre class="showvars">' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
	phpinfo();
	} ?>

	<!-- If javascript is disabled -->
	<noscript><style type="text/css">#bg-wrap{display:block;}.extra{display:block;}</style></noscript>
	<!-- javascript -->
	<script type="text/javascript" src="../jscript/jquery.js"></script>
	<script type="text/javascript">
    var $j = jQuery.noConflict();

    // Pixie external links jquery functions
    // If you click on a link in the the installer, you won't have to click back afterwards now :)

    $j(function() { 
    $j('a').filter(function() {
    //Compare the anchor tag's host name with location's host name
    return this.hostname && this.hostname !== location.hostname;
    });

    //Set the _target attribute to blank
    $j('a').filter(function() {
    //Compare the anchor tag's host name with location's host name
    return this.hostname && this.hostname !== location.hostname;
    }).attr('target', '_blank').attr('title', 'Opens in a new window');

    return false; 
    });

    $j(function() { 
$j.fn.wait = function(time, type) {
        time = time || 5000;
        type = type || "fx";
        return this.queue(type, function() {
            var self = this;
            setTimeout(function() {
                $j(self).dequeue();
            }, time);
        });
    return false; 
    };

$j('#bg-wrap').fadeIn('slow');

$j(document).ready(function(){
$j(function(form) {
function loadPage() {
$j('.extra').append("<p class=\"return-switch-span\">Click here to <a class=\"return-switch-link\" href=\"javascript:void(0);\">hide these settings</a></p>");
$j('#switch').prepend("<p class=\"switch-span\">Click here for <a class=\"switch-link\" href=\"javascript:void(0);\">extra settings</a></p>");
      $j('.switch-link').click(function (event) { 
      event.preventDefault();
$j('.extra').fadeIn('slow');
$j('html, body').animate({ scrollTop: 500 }, 0);
$j('.switch-span').fadeOut(0);
      });
$j('.return-switch-link').click(function (event) { 
      event.preventDefault();
$j('.extra').fadeOut('slow');
$j('.switch-span').fadeIn('slow');
      });
    $j('.error').show().wait().slideDown('slow').slideUp(function() { 
$j('#placeholder p.toptext').prepend("<div class=\"error-text\">Please click here to see the <a class=\"error-show\" href=\"javascript:void(0);\">error message</a> again.<br/><br/></div>");
$j('.error-text').fadeOut(450).fadeIn(450);
      $j('.error-show').click(function (event) { 
      event.preventDefault();
$j('.error').slideDown();
$j('.error-text').fadeOut(1000).replaceWith("<div class=\"error-text\">Please correct the error and then try again.<br/><br/></div>").fadeIn(2500);
      });
      });
    return true; 
    };
	loadPage();

<?php if ($debug == 'yes') { ?>

$j('#restart').hover(
      function () {
        $j('.form_submit_b').fadeIn('slow');
      }, 
      function () {
        $j('.form_submit_b').fadeOut('slow');
      }
    );

		      <?php } ?>

});

});

   });
	</script>
<?php if ($google_translate == 'Yes') { ?>
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en'
  }, 'google_translate_element');
}
</script><script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php } ?>
</body>
</html>
