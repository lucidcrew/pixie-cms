<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../');
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
 * Title: Events Module
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
switch ($do) {
	// General information:
	// The general information is used to show infromation about the module within Pixie. 
	// Simply enter details of your module here:
	case 'info':
		// The name of your module
		$m_name          = 'Events';
		// A description of your module
		$m_description   = 'Events module with support for hCalendar microformat, archives and Google calendar links.';
		// Who is the module author?
		$m_author        = 'Scott Evans';
		// What is the URL of your homepage
		$m_url           = 'http://www.toggle.uk.com';
		// What version is this?
		$m_version       = '1.1';
		// Can be set to module or plugin.
		$m_type          = 'module';
		// Is this a module that needs publishing to?
		$m_publish       = 'yes';
		// Put this module in the navigation by default?
		$m_in_navigation = 'yes';
		break;
	// Install
	// This section contains the SQL needed to create your modules tables
	case 'install':
		// Create any required tables
		$execute  = "CREATE TABLE IF NOT EXISTS `pixie_module_events` (`events_id` int(5) NOT NULL auto_increment,`date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,`title` varchar(100) collate utf8_unicode_ci NOT NULL default '',`description` longtext collate utf8_unicode_ci,`location` varchar(120) collate utf8_unicode_ci default NULL,`url` varchar(140) collate utf8_unicode_ci default NULL,`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',PRIMARY KEY  (`events_id`),UNIQUE KEY `id` (`events_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;";
		$execute1 = "CREATE TABLE IF NOT EXISTS `pixie_module_events_settings` (`events_id` mediumint(1) NOT NULL auto_increment,`google_calendar_links` set('yes','no') collate utf8_unicode_ci NOT NULL default '',`number_of_events` varchar(3) collate utf8_unicode_ci NOT NULL default '10',PRIMARY KEY  (`events_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;";
		$execute2 = "INSERT INTO `pixie_module_events_settings` (`events_id`, `google_calendar_links`, `number_of_events`) VALUES (1, 'yes', '10');";
		// you can execute upto 5 sql queries ($execute - $execute4) 
		break;
	// The administration of the module (add, edit, delete)
	// This is where Pixie really saves you time, these few lines of code will create the entire admin interface
	case 'admin':
		// The name of your module
		$module_name    = 'Events';
		// The name of the table
		$table_name     = 'pixie_module_events';
		// The field to order by in table view
		$order_by       = 'date';
		// Ascending (asc) or decending (desc)
		$asc_desc       = 'desc';
		// Fields you want to exclude in your table view
		$view_exclude   = array(
			'events_id',
			'description',
			'cost',
			'location',
			'public',
			'url'
		);
		// Fields you do not want people to be able to edit
		$edit_exclude   = array(
			'events_id'
		);
		// The number of items per page in the table view
		$items_per_page = 15;
		// Does this module support tags (yes or no)
		$tags           = 'no';
		admin_module($module_name, $table_name, $order_by, $asc_desc, $view_exclude, $edit_exclude, $items_per_page, $tags);
		break;
	// Pre
	// Any code to be run before HTML output, any redirects or header changes must occur here
	case 'pre':
		// get the details of this page from pixie_core
		if (isset($s)) {
			extract(safe_row('*', 'pixie_core', "page_name='$s'"));
		}
		// get the settings of the page from its settings table
		extract(safe_row('*', 'pixie_module_events_settings', "events_id='1'"));
		switch ($m) {
			case 'archives';
				global $timezone;
				$site_title = safe_field('site_name', 'pixie_settings', "settings_id = '1'");
				$ptitle     = $site_title . ' - ' . $page_display_name . ' - Archives';
				$rs         = safe_rows_start('*', 'pixie_module_events', "events_id >= '0'  and date < now() and public = 'yes' order by date desc");
				break;
			default:
				global $timezone;
				$site_title = safe_field('site_name', 'pixie_settings', "settings_id = '1'");
				$ptitle     = $site_title . ' - ' . $page_display_name;
				$rs         = safe_rows_start('*', 'pixie_module_events', "events_id >= '0'  and date > now() and public = 'yes' order by date asc limit $number_of_events");
				break;
		}
		break;
	// Head
	// This will output code into the end of the head section of the HTML, this allows you to load in external CSS, JavaScript etc
	case 'head':
		// you could place some css for layout here... altenatively place a file called events.css in your theme folder and Pixie will load it with this page automatically. 
?>
<!-- styles for events module -->
	<style type="text/css">
	.dtstart
		{
		font-weight:bold;
		}
	</style>
	<?php
		break;
	// Show Module
	// This is where your module will output into the content div on the page
	default:
		if (isset($s)) {
			echo "<div id=\"$s\">\n\t\t\t\t\t\t<h3>$page_display_name</h3>\n";
			if ($rs) {
				while ($a = nextRow($rs)) {
					extract($a);
					$logunix     = returnUnixtimestamp($date);
					$dateis      = safe_strftime($date_format, $logunix);
					$microformat = safe_strftime('%Y-%m-%dT%T%z', $logunix);
					$googtime    = safe_strftime('%Y%m%dT%H%M%SZ', $logunix);
					echo "
						<div class=\"vevent\">
							<h4 class=\"summary\" title=\"";
					if (isset($title)) {
						echo $title;
					}
					echo "\">";
					if (isset($title)) {
						echo $title;
					}
					echo "</h4>
							<ul class=\"vdetails\"><p>
								<li class=\"vtime\">Date: <abbr class=\"dtstart\" title=\"$microformat\">$dateis</abbr></li>\n";
					if ($location) {
						echo "\t\t\t\t\t\t\t\t<li class=\"vlocation\">Venue: <span class=\"location\">$location</span></li>\n";
					}
					if ($url) {
						echo "\t\t\t\t\t\t\t\t<li class=\"vlink\">Link: <a class=\"url\" href=\"$url\">$url</a></li>\n";
					}
					if ($google_calendar_links == 'yes') {
						$url_desc = substr($description, 0, 24);
						/* Limit the description to 24 characters in length, so that a huge url is not sent. */
						echo "\t\t\t\t\t\t\t\t<li class=\"vgoogle\"><a href=\"http://www.google.com/calendar/event?action=TEMPLATE&amp;text=";
						if (isset($title)) {
							echo (urlencode($title));
						}
						echo "&amp;dates=$googtime/$googtime&amp;details=" . urlencode(strip_tags($url_desc)) . "&amp;location=" . urlencode($location) . "&amp;trp=false&amp;sprop=$site_url&amp;sprop=name:$site_title\"  target=\"_blank\">Add to Google calendar</a></li>\n";
					}
					echo "	
							</p></ul>
							<div class=\"event_body\"><p>";
					print "\t\t\t\t\t\t\t\t" . str_replace('<p>', "<p class=\"description\">", $description);
					echo " 
							</p></div>
						</div>\n";
				}
				if (!isset($title)) {
					echo "<p class=\"error\">No events found</p>";
				}
				if ($m == 'archives') {
					if (isset($s)) {
						echo "\t\t\t\t\t\t<a class=\"view_more_link\" href=\"" . createURL($s) . "\">View upcoming events...</a>\n";
						/* Needs lannguage */
					}
				} else {
					if (isset($s)) {
						echo "\t\t\t\t\t\t<a class=\"view_more_link\" href=\"" . createURL($s, 'archives') . "\">View the archives...</a>\n";
						/* Needs lannguage */
					}
				}
			}
			echo "\t\t\t\t\t</div>";
		}
		break;
}
?>