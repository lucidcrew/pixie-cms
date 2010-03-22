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
 * Title: lib_logs
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
//------------------------------------------------------------------
// Two functions to calculate page render times
function getmicrotime() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float) $usec + (float) $sec);
}
function pagetime($type) {
	static $orig_time;
	if ($type == 'init') {
		$orig_time = getmicrotime();
	}
	if ($type == 'print') {
		printf('%2.4f', getmicrotime() - $orig_time);
	}
}
//------------------------------------------------------------------
// referral function for tracking site referrals 
function referral() {
	global $lang;
	global $timezone;
	$url    = $GLOBALS['site_url'];
	$domain = trim(str_replace('www.', "", $url));
	if (isset($_SERVER['HTTP_REFERER'])) {
		$referral = $_SERVER['HTTP_REFERER'];
	} else {
		$referral = $lang['unknown_referrer'];
	}
	if (isset($GLOBALS['pixie_user'])) {
		$uname = $GLOBALS['pixie_user'];
	} else {
		$uname = 'Visitor';
	}
	$ip    = $_SERVER['REMOTE_ADDR'];
	$uname = sterilise_txt($uname, TRUE);
	if (!preg_match('/^[0-9\.]+$/', $ip)) {
		$ip       = sterilise($ip, TRUE);
		$referral = sterilise($referral, TRUE);
	}
	if (($referral) and (!strstr($referral, $domain))) {
		safe_insert('pixie_log', "user_id = '$uname',  
									 user_ip = '$ip', 
								 	 log_time = utc_timestamp(),
								 	 log_type = 'referral',
								 	 log_icon = 'referral',
								 	 log_message = '$referral'");
	}
}
//------------------------------------------------------------------
// log function for writing information to log database
function logme($message, $imp, $icon) {
	global $timezone;
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($GLOBALS['pixie_user'])) {
		$uname = $GLOBALS['pixie_user'];
	} else {
		$uname = 'Visitor';
	}
	if (!$icon) {
		$icon = 'site';
	}
	safe_insert('pixie_log', "user_id = '$uname',  
								 user_ip = '$ip', 
							 	 log_time = utc_timestamp(),
							 	 log_type = 'system',
							 	 log_message = '$message',
							 	 log_icon = '$icon',
							 	 log_important = '$imp'");
}
//------------------------------------------------------------------
// log function for keeping tract of who is online
function users_online() {
	$sessiontime = 3; //minutes
	safe_delete('pixie_log_users_online', "unix_timestamp() - last_visit >= $sessiontime * 60");
	$ip     = $_SERVER['REMOTE_ADDR'];
	$query  = 'SELECT last_visit FROM ' . PFX . "pixie_log_users_online WHERE visitor = '$ip'";
	$online = safe_query($query);
	if (mysql_num_rows($online) == 0) {
		$sql = "visitor = '$ip', last_visit = unix_timestamp()";
		safe_insert('pixie_log_users_online', $sql);
	} else {
		safe_update('pixie_log_users_online', 'last_visit = unix_timestamp()', "visitor = '$ip'");
	}
}
?>