<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../../');
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
 * Title: My Account
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
if (isset($GLOBALS['pixie_user'])) {
	if ((isset($s)) && ($s == 'myaccount') && ($x != 'myprofile')) {
		$uname = $GLOBALS['pixie_user'];
		$rs    = safe_row('*', 'pixie_users', "user_name = '$uname' limit 0,1");
		if ($rs) {
			// clear logs past $log_expire days
			safe_delete('pixie_log', '`log_time` < date_sub(utc_timestamp(),interval ' . $GLOBALS['logs_expire'] . ' day)');
			safe_delete('pixie_bad_behavior', '`date` < date_sub(utc_timestamp(),interval ' . $GLOBALS['logs_expire'] . ' day)');
			safe_optimize('pixie_log');
			safe_repair('pixie_log');
			safe_optimize('pixie_bad_behavior');
			safe_repair('pixie_bad_behavior');
			// users online	
			$user_count = mysql_num_rows(safe_query('select * from ' . $pixieconfig['table_prefix'] . 'pixie_log_users_online'));
			if ($user_count > 0) {
				$user_count = $user_count - 1;
			}
			// number of visitors
			$visitors  = count(safe_rows('distinct user_ip', 'pixie_log', "user_id = 'Visitor' and log_type = 'referral'"));
			// count bad behaviors
			$badbcount = mysql_num_rows(safe_query('select * from ' . $pixieconfig['table_prefix'] . 'pixie_bad_behavior'));
			// count page_views
			$pageviews = mysql_num_rows(safe_query('select * from ' . $pixieconfig['table_prefix'] . "pixie_log where user_id = 'Visitor' and log_type = 'referral'"));
			// last login time
			$logintime = safe_field('last_access', 'pixie_users', "user_name = '" . $GLOBALS['pixie_user'] . "' limit 0,1");
			$logunix   = returnUnixtimestamp($logintime);
			$logindate = safe_strftime($date_format, $logunix);
			echo "<div id=\"blocks\">
						<div class=\"admin_block\" id=\"admin_block_stats\">
							<h3>" . $lang['statistics'] . ' - ' . safe_strftime($date_format, time()) . "</h3>
							<p>" . $lang['your_site_has'] . " <b>$user_count</b> " . $lang['visitors_online'] . "</p>
							<p class=\"pstats\">" . $lang['in_the_last'] . " $logs_expire " . $lang['days'] . " :</p>
							<ul>
								<li><b>$visitors</b> " . $lang['site_visitors'] . "</li>
								<li><b>$pageviews</b> " . $lang['page_views'] . "</li>
								<li><b>$badbcount</b> <a href=\"http://www.bad-behavior.ioerror.us/\" title=\"Spam protection by Bad Behavior\" target=\"_blank\">" . $lang['spam_attacks'] . "</a>.</li>
							</ul>
							<p class=\"plogin\">" . $lang['last_login_on'] . "<br/>$logindate.</p>
						</div>\n";
			echo "\t\t\t\t\t<div class=\"admin_block\" id=\"admin_block_links\">";
			echo "\t\t\t\t\t\n\t\t\t\t\t\t<h3 class=\"qlinks\">" . $lang['quick'] . " " . $lang['links'] . "</h3>\n\t\t\t\t\t\t<ul>\n";
			if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 1) {
				extract(safe_row('*', 'pixie_core', "page_type = 'dynamic' order by page_views desc limit 0,1"));
				if ($page_type == 'dynamic') {
					echo "\t\t\t\t\t\t\t<li><a href=\"" . $site_url . "admin/?s=publish&amp;m=dynamic&amp;x=$page_name&amp;go=new\" title=\"" . $lang['new_entry'] . "$page_display_name " . $lang['entry'] . "\" >" . $lang['new_entry'] . "$page_display_name " . $lang['entry'] . "</a></li>\n";
				}
				extract(safe_row('*', 'pixie_core', "page_type = 'static' order by page_views desc limit 0,1"));
				if ($page_type == 'static') {
					echo "\t\t\t\t\t\t\t<li><a href=\"" . $site_url . "admin/?s=publish&amp;m=static&amp;x=$page_name&amp;edit=$page_id\" title=\"" . $lang['edit'] . "$page_display_name " . $lang['page'] . "\" >" . $lang['edit'] . "$page_display_name " . $lang['page'] . "</a></li>\n";
				}
				extract(safe_row('*', 'pixie_core', "page_type = 'module' order by page_id desc limit 0,1"));
				if (($page_type == 'module') && ($page_name != 'contact')) {
					echo "\t\t\t\t\t\t\t<li><a href=\"" . $site_url . "admin/?s=publish&amp;m=module&amp;x=$page_name&amp;go=new\" title=\"" . $lang['new_entry'] . "$page_display_name " . $lang['entry'] . "\" >" . $lang['new_entry'] . "$page_display_name " . $lang['entry'] . "</a></li>\n";
				}
			}
			echo "\t\t\t\t\t\t\t<li class=\"linkspixie\"><a href=\"http://www.getpixie.co.uk/blog/\" title=\"Pixie " . $lang['blog'] . "\" target=\"_blank\">Pixie " . $lang['blog'] . "</a></li>\n";
			echo "\t\t\t\t\t\t\t<li><a href=\"http://www.getpixie.co.uk/forums/\" title=\"Pixie " . $lang['forums'] . "\" target=\"_blank\">Pixie " . $lang['forums'] . "</a></li>\n";
			echo "\t\t\t\t\t\t\t<li><a href=\"http://www.getpixie.co.uk/downloads/\" title=\"Pixie " . $lang['downloads'] . "\" target=\"_blank\">Pixie " . $lang['downloads'] . "</a></li>\n\t\t\t\t\t\t</ul>\n";
		}
		echo "\t\t\t\t\t</div>\n";
		extract($rs);
		echo "\t\t\t\t\t<div class=\"admin_block\" id=\"admin_block_my_links\">";
		echo "\n\t\t\t\t\t\t<h3 class=\"plinks\">" . firstword($GLOBALS['pixie_real_name']) . "'s " . $lang['links'] . "</h3>\n\t\t\t\t\t\t<ul>\n";
		echo "\t\t\t\t\t\t\t<li><a href=\"$link_1\" title=\"Visit $link_1\" target=\"_blank\">" . str_replace('http://', "", $link_1) . "</a></li>\n";
		echo "\t\t\t\t\t\t\t<li><a href=\"$link_2\" title=\"Visit $link_2\" target=\"_blank\">" . str_replace('http://', "", $link_2) . "</a></li>\n";
		echo "\t\t\t\t\t\t\t<li><a href=\"$link_3\" title=\"Visit $link_3\" target=\"_blank\">" . str_replace('http://', "", $link_3) . "</a></li>\n";
		echo "\t\t\t\t\t\t</ul>\n";
		echo "\t\t\t\t\t</div>\n";
		echo "\t\t\t\t</div>";
	}
	if ($m) {
		/* Was : */
		/* $m = ereg_replace('[^A-Za-z0-9]', "", $m); */
		/* But ereg_replace() is depreciated. */
		$m = preg_replace('[^A-Za-z0-9]', "", $m);
		include("../admin/modules/$m.php");
	} else if ($x) {
		/* Was : */
		/* $x = ereg_replace('[^A-Za-z0-9]', "", $x); */
		/* But ereg_replace() is depreciated. */
		$x = preg_replace('[^A-Za-z0-9]', "", $x);
		include("mod_$x.php");
	} else {
		if (isset($do) && $do == 'referral') {
			echo "
				<div id=\"pixie_content\">
					<ul id=\"log_tools\">
						<li id=\"log_switch_latest\"><a href=\"?s=myaccount\" title=\"" . $lang['switch_to'] . " " . $lang['latest_activity'] . "\">" . $lang['switch_to'] . " " . $lang['latest_activity'] . "</a></li>
					</ul>
					<h2>" . $lang['latest_referrals'] . "</h2>
					<div id=\"logs_table\">
						<table class=\"tbl\" summary=\"" . $lang['latest_referrals'] . ' @ ' . str_replace('http://', "", $site_url) . "\">
						<thead>

							<tr>
								<th class=\"tbl_heading\" id=\"icon\"></th>
								<th class=\"tbl_heading\" id=\"when\">" . $lang['when'] . "</th>
								<th class=\"tbl_heading\" id=\"who\">" . $lang['who'] . "</th>
								<th class=\"tbl_heading\" id=\"from\">" . $lang['from'] . "</th>
							</tr>

						</thead>
						<tbody>
					";
		} else {
			echo "
				<div id=\"pixie_content\">
					<ul id=\"log_tools\">
						<li id=\"log_switch_referral\"><a href=\"?s=myaccount&amp;do=referral\" title=\"" . $lang['switch_to'] . " " . $lang['latest_referrals'] . "\">" . $lang['switch_to'] . " " . $lang['latest_referrals'] . "</a></li>
						<li id=\"log_rss\"><a href=\"?s=myaccount&amp;do=rss&amp;user=" . $GLOBALS['nonce'] . "\" title=\"" . $lang['feed_subscribe'] . "\">" . $lang['feed_subscribe'] . "</a></li>
					</ul>
					<h2>" . $lang['latest_activity'] . "</h2>
					<div id=\"logs_table\">
						<table class=\"tbl\" summary=\"" . $lang['latest_activity'] . " @ " . str_replace('http://', "", $site_url) . "\">
						<thead>

							<tr>
								<th class=\"tbl_heading\" id=\"icon\"></th>
								<th class=\"tbl_heading\" id=\"when\">" . $lang['when'] . "</th>
								<th class=\"tbl_heading\" id=\"who\">" . $lang['who'] . "</th>
								<th class=\"tbl_heading\" id=\"what\">" . $lang['what'] . "</th>
							</tr>

						</thead>
						<tbody>
					";
		}
		safe_delete('pixie_log', "`log_time` < date_sub(utc_timestamp(),interval " . $GLOBALS['logs_expire'] . ' day)');
		safe_optimize('pixie_log');
		safe_repair('pixie_log');
		if (isset($do) && $do == 'referral') {
			$rs = safe_rows_start('*, unix_timestamp(log_time) as stamp', 'pixie_log', "log_type = 'referral' AND log_time < utc_timestamp() order by log_time desc limit 30");
		} else {
			$rs = safe_rows_start('*, unix_timestamp(log_time) as stamp', 'pixie_log', "log_type = 'system' AND log_time < utc_timestamp() order by log_time desc limit 30");
		}
		if ($rs) {
			$counter = 0;
			while ($a = nextRow($rs)) {
				$counter++;
				extract($a);
				$logunix = returnUnixtimestamp($log_time);
				$time    = safe_strftime($date_format, $logunix);
				if ($log_important == 'yes') {
					$trclass = 'logimportant';
				} else {
					$trclass = 'normal';
				}
				if (is_even($counter)) {
					$trclass .= ' even';
				} else {
					$trclass .= ' odd';
				}
				if ($counter >= 20) {
					$trclass .= ' fade' . (30 - $counter);
				}
				if (isset($do) && $do == 'referral') {
					$log_url = htmlentities($log_message);
					$from    = "<a href=\"$log_url\" title=\"Visit: $log_url\">" . chopme(str_replace('http://', "", $log_url), 70) . "</a>";
					echo "
								<tr class=\"$trclass\">
									<td class=\"tbl_row\" headers=\"icon\"><img src=\"admin/theme/images/icons/$log_icon.png\" alt=\"$log_icon icon\" /></td>
									<td class=\"tbl_row\" headers=\"when\">$time</td>
									<td class=\"tbl_row\" headers=\"who\"><a href=\"http://network-tools.com/default.asp?prog=lookup&amp;host=$user_ip\" title=\"Lookup IP: $user_ip\" target=\"_blank\">$user_ip</a> </td>
									<td class=\"tbl_row\" headers=\"from\">$from</a></td>
								</tr>";
				} else {
					echo "
								<tr class=\"$trclass\">
									<td class=\"tbl_row\" headers=\"icon\"><img src=\"admin/theme/images/icons/$log_icon.png\" alt=\"$log_icon icon\" /></td>
									<td class=\"tbl_row\" headers=\"when\">$time</td>
									<td class=\"tbl_row\" headers=\"who\"><a href=\"http://network-tools.com/default.asp?prog=lookup&amp;host=$user_ip\" title=\"Lookup IP: $user_ip\" target=\"_blank\">$user_id</a> </td>
									<td class=\"tbl_row\" headers=\"what\">$log_message</td>
								</tr>";
				}
			}
		}
		echo "
						</tbody>
						</table>
					</div>
				</div>";
		if ($system_message) {
			$message = $system_message;
		}
	}
}
?>