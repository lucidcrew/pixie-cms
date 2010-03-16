<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
	header( 'Location: ../../' );
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
 * Title: RSS Plugin
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

switch ( $do ) {
	
	// general information
	case 'info':
		
		$m_name        = 'RSS Plugin';
		$m_description = 'Allows you to have control over the RSS feeds that are available to your visitors.';
		$m_author      = 'Scott Evans';
		$m_url         = 'http://www.toggle.uk.com/';
		$m_version     = 1.1;
		$m_type        = 'plugin';
		$m_publish     = 'yes';
		
		break;
	
	// install
	case 'install':
		// create any required tables
		$execute  = "CREATE TABLE IF NOT EXISTS `pixie_module_rss` (`rss_id` tinyint(2) NOT NULL auto_increment,`feed_display_name` varchar(80) collate utf8_unicode_ci NOT NULL default '',`url` varchar(80) collate utf8_unicode_ci NOT NULL default '',PRIMARY KEY  (`rss_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;";
		$execute1 = "CREATE TABLE IF NOT EXISTS `pixie_module_rss_settings` (`rss_id` mediumint(1) NOT NULL auto_increment,PRIMARY KEY  (`rss_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";
		break;
	
	// pre (to be run before page load)
	case 'pre':
		
		break;
	
	// head (to be run in the head)
	case 'head':
		
		break;
	
	// admin of module
	case 'admin':
		
		$module_name  = 'rss';
		$table_name   = 'pixie_module_rss';
		$order_by     = 'feed_display_name';
		$asc_desc     = 'asc';
		$view_exclude = array(
			 'rss_id' 
		);
		$edit_exclude = array(
			 'rss_id' 
		);
		$tags         = 'no';
		
		admin_module( $module_name, $table_name, $order_by, $asc_desc, $view_exclude, $edit_exclude, 15, $tags );
		
		break;
	
	// show module
	default:
		if ( isset( $s ) ) {
			extract( safe_row( '*', 'pixie_core', "page_name = '$s'" ) );
		}
		echo "<div ";
		if ( isset( $s ) ) {
			echo "id=\"$s\"";
		}
		echo ">
	  	\t\t\t<h3>$page_display_name</h3>
	  				<h4>Whats all this then?</h4>
	  				<p>RSS or Really Simple Syndication, is a way of reading new content from websites. It allows you to keep informed of the latest developments
	  				without the need to constantly revisit a site. Most sites now offer this feature, to find out more have a read of the 
	  				<a href=\"http://en.wikipedia.org/wiki/RSS_(protocol)\" title=\"RSS @ Wikipedia\">Wikipedia entry</a> on RSS.</p>
	  				<h4>RSS Tools</h4>
	  				<p>Clicking on a feed should open it in your default feed reader. If you do not have a reader I recommend using <a href=\"http://www.google.com/reader/\" title=\"Google Reader\">
	  				Google's online</a> reader to get started. Once you get used to the idea try a software based solution. 
	  				For Apple users I recommend using <a href=\"http://newsfirerss.com/\" title=\"Newsfire RSS reader\">Newsfire</a>, or the built in RSS reader in <a href=\"http://www.apple.com/macosx/features/safari/\" title=\"Safari RSS reader\">Safari</a>. 
	  				Windows users try <a href=\"http://www.blogbridge.com\" title=\"BlogBridge RSS reader\">BlogBridge</a>, or <a href=\"http://www.rssowl.org/\" title=\"RSSOwl RSS reader\">RSSOwl</a>.</p>\n";
		
		$rs  = safe_rows( '*', 'pixie_dynamic_settings', "rss = 'yes'" );
		$num = count( $rs );
		if ( $rs ) {
			$i = 0;
			echo "\t\t\t\t\t<h4>Local Feeds</h4>
						<ul id=\"local_feeds\">\n";
			if ( public_page_exists( 'rss' ) ) {
				$rs  = safe_rows_start( '*', 'pixie_module_rss', '1 order by feed_display_name desc' );
				$num = count( $rs );
				if ( $rs ) {
					while ( $a = nextRow( $rs ) ) {
						extract( $a );
						echo "\t\t\t\t\t\t<li><a href=\"$url\" title=\"$feed_display_name\" />$feed_display_name</a></li>\n";
						$i++;
					}
				}
			} else {
				while ( $i < $num ) {
					$out     = $rs[$i];
					$page_id = $out['page_id'];
					$rs1     = safe_row( '*', 'pixie_core', "page_id = '$page_id' limit 0,1" );
					extract( $rs1 );
					echo "\t\t\t\t\t\t<li><a href=\"" . createURL( $page_name, 'rss' ) . "\" title=\"$site_name - $page_display_name\" />$page_display_name</a></li>\n";
					$i++;
				}
			}
			echo "<li style=\"display:none;\"></li>"; // Prevent invalid markup if the list is empty
			echo "\t\t\t\t\t</ul>\n";
		}
		echo "\t\t\t\t</div>\n";
		break;
}

?>