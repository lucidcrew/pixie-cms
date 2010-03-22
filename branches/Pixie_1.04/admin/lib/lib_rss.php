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
 * Title: lib_rss
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
// ------------------------------------------------------------------
// finds all dynamic pages with rss enabled and outputs list
function build_rss() {
	global $site_url, $site_name;
	if (public_page_exists('rss')) {
		$i   = 0;
		/* Prevents insecure undefined variable $i */
		$rs  = safe_rows_start('*', 'pixie_module_rss', "1 order by feed_display_name desc");
		$num = count($rs);
		if ($rs) {
			while ($a = nextRow($rs)) {
				extract($a);
				echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"$feed_display_name\" href=\"$url\" />\n\t";
				$i++;
			}
		}
	} else {
		$rs  = safe_rows('*', 'pixie_dynamic_settings', "rss = 'yes'");
		$num = count($rs);
		if ($rs) {
			$i = 0;
			while ($i < $num) {
				$out     = $rs[$i];
				$page_id = $out['page_id'];
				$rs1     = safe_row('*', 'pixie_core', "page_id = '$page_id' limit 0,1");
				extract($rs1);
				echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"$site_name - $page_display_name\" href=\"$site_url$page_name/rss/\" />\n\t";
				$i++;
			}
		}
	}
}
// ------------------------------------------------------------------
// Build an RSS output of the current dynamic page
function rss($page_name, $page_display_name, $page_id) {
	global $site_name, $site_url, $s, $lang, $clean_urls;
	header("Content-type: text/xml");
	echo ("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:dc="http://purl.org/dc/elements/1.1/">

		<channel>
			<title><?php
	echo "$site_name - $page_display_name (" . $lang['rss_feed'] . ")";
?></title>
			<description><?php
	echo "$site_name - $page_display_name";
?></description>
			<link><?php
	if ($clean_urls == 'yes') {
		echo createURL($page_name);
	} else {
		echo createURL($page_name . '?referrer=rss');
	}
?></link>
			<generator>Pixie installed  @ <?php
	echo "$site_url";
?></generator>
			<language>en</language>
			<image>
				<url><?php
	echo "$site_url";
?>files/images/rss_feed_icon.gif</url>
				<link><?php
	if ($clean_urls == 'yes') {
		echo createURL($page_name);
	} else {
		echo createURL($page_name . '?referrer=rss');
	}
?></link>
				<title><?php
	echo "$site_name - $page_display_name (" . $lang['rss_feed'] . ")";
?></title>
			</image>

			<atom:link href="<?php
	print createURL($page_name, 'rss');
?>" rel="self" type="application/rss+xml" />
<?php
	extract(safe_row('*', 'pixie_dynamic_settings', "page_id='$page_id' limit 0,1"));
	if ($rss) {
		$max   = $posts_per_page;
		$data  = safe_rows('*', 'pixie_dynamic_posts', "public = 'yes' and page_id = '$page_id' and posted < utc_timestamp() order by posted desc");
		$total = count($data);
		if ($total) {
			if ($total < $max) {
				$max = $total;
			}
			$i = 0;
			while ($i < $max) {
				$out      = $data[$i];
				$title    = $out['title'];
				$content  = $out['content'];
				$posted   = $out['posted'];
				$author   = $out['author'];
				$tags     = $out['tags'];
				$timeunix = returnUnixtimestamp($posted);
				$date     = safe_strftime('%a, %d %b %Y %H:%M:%S %z', $timeunix);
				$slug     = $out['post_slug'];
				if ($clean_urls == 'yes') {
					$urllink = createURL($page_name, 'permalink', $slug);
				} else {
					$urllink = createURL($page_name, 'permalink', $slug . '&referrer=rss');
				}
				echo "
		<item>
			<title>$title</title>
			<link>$urllink</link>
			<comments>" . createURL($page_name, 'permalink', $slug . '#comments') . "</comments>
			<pubDate>$date</pubDate>
			<dc:creator>$author</dc:creator>\n\t\t\t";
				if ((isset($tags)) && ($tags)) {
					$tag_list        = "";
					$all_tags        = strip_tags($tags);
					$tags_array_temp = explode(" ", $all_tags);
					$total_tag       = count($tags_array_temp);
					$j               = 0;
					while ($j < $total_tag) {
						if ($tags_array_temp[$j] != "") {
							echo '<category>' . str_replace(" ", "", $tags_array_temp[$j]) . '</category>';
						}
						$j++;
					}
					for ($count = 0; $count < (count($tags_array_temp)); $count++) {
						$current = $tags_array_temp[$count];
						$first   = $current{strlen($current) - strlen($current)};
						if ($first == " ") {
							$current = substr($current, 1, strlen($current) - 1);
						}
						$ncurrent = make_slug($current);
						if (isset($s)) {
							$tag_list .= "<a href=\"" . createURL($s, 'tag', $ncurrent) . "\" title=\"View all posts in " . $current . "\">" . $current . "</a>, ";
						}
					}
					$tag_list = substr($tag_list, 0, (strlen($tag_list) - 2)) . "";
				}
				echo "
			<guid isPermaLink=\"true\">$urllink</guid>
			<description><![CDATA[\n";
				$post = get_extended($content);
				echo "\t\t\t" . $post['main'] . "\n";
				if ($post['extended']) {
					echo "\t\t\t" . $post['extended'] . "\n";
				}
				if ($tag_list) {
					echo "\t\t\t<p>Tagged: $tag_list</p>\n";
				}
				echo "\t\t\t]]></description>
			<wfw:commentRss>http://transformr.co.uk/hatom/" . createURL($page_name, 'permalink', $slug) . "</wfw:commentRss>
		</item>";
				$i++;
			}
		}
	}
	echo "\n\t</channel>\n</rss>";
}
// ------------------------------------------------------------------
// check if the current page has rss
function public_check_rss($page_name) {
	extract(safe_row('*', 'pixie_core', "page_name='$page_name' limit 0,1"));
	extract(safe_row('*', 'pixie_dynamic_settings', "page_id='$page_id' limit 0,1"));
	if ($rss == 'yes') {
		return TRUE;
	} else {
		return FALSE;
	}
}
// ------------------------------------------------------------------
// build admin RSS feed
function adminrss($s, $user) {
	global $site_name, $site_url, $s, $lang, $date_format;
	if (safe_field('nonce', 'pixie_users', "nonce='$user'")) {
		header('Content-type: text/xml'); // Note : header should ALWAYS go at the top of a document. See php header(); in the php manual.
		echo ("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
	
<rss version="2.0" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/">

		<channel>
			<title><?php
		echo "$site_name - " . $lang['latest_activity'] . ' (' . $lang['rss_feed'] . ')';
?></title>
			<description><?php
		echo "$site_name - " . $lang['latest_activity'] . "";
?></description>
			<link><?php
		echo "$site_url/admin/?s=myaccount&amp;do=rss&amp;user=$user&amp;referrer=rss";
?></link>
			<generator>Pixie installed @ http://<?php
		echo "$site_url";
?></generator>
			<language>en</language>
			<image>
				<url><?php
		echo "$site_url";
?>files/images/rss_feed_icon.gif</url>
				<link><?php
		echo $site_url . "admin/?s=myaccount&amp;do=rss&amp;user=$user&amp;referrer=rss";
?></link>
				<title><?php
		echo "$site_name";
?></title>
			</image>
<?php
		$max   = 60;
		$data  = safe_rows('*', 'pixie_log', "log_type = 'system' order by log_time desc");
		$total = count($data);
		if ($total) {
			if ($total < $max) {
				$max = $total;
			}
		}
		$i = 0;
		while ($i < $max) {
			$out     = $data[$i];
			$title   = $out['log_message'];
			$link    = $site_url;
			$author  = $out['user_id'];
			$time    = $out['log_time'];
			$logunix = returnUnixtimestamp($time);
			$time    = safe_strftime('%a, %d %b %Y %H:%M:%S %z', $logunix);
			$site    = str_replace('http://', "", $site_url);
			echo "  		
		<item>
			<title>($site_name) - $author: $title</title>
			<link>$link?referrer=rss</link>
			<author>$author</author>
			<pubdate>$time</pubdate>
		</item>";
			$i++;
		}
		echo "\n\t</channel>\n</rss>";
	} else {
		// the user has attempted to access the RSS feed with an invalid nonce
		logme($lang['rss_access_attempt'], 'yes', 'error');
		echo $lang['rss_access_attempt'];
	}
}
?>