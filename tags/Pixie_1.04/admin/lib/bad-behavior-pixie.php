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
 * Title: Bad Behavior - detects and blocks unwanted Web accesses
 *
 * Bad Behavior
 * Copyright (C) 2005-2010 Michael Hampton
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
define('BB2_CWD', dirname(__FILE__));
// Settings you can adjust for Bad Behavior.
// Most of these are unused in non-database mode.
$bb2_settings_defaults = array(
	'log_table' => "{$pixieconfig['table_prefix']}pixie_bad_behavior",
	'display_stats' => TRUE,
	'strict' => FALSE,
	'verbose' => FALSE,
	'logging' => TRUE,
	'httpbl_key' => '',
	'httpbl_threat' => 25,
	'httpbl_maxage' => 30
);
// Return current time in the format preferred by your database.
function bb2_db_date() {
	return gmdate('Y-m-d H:i:s'); // Example is MySQL format
}
// Return affected rows from most recent query.
function bb2_db_affected_rows($result) {
	return mysql_affected_rows($result);
}
// Escape a string for database usage
function bb2_db_escape($string) {
	return mysql_real_escape_string($string);
}
// Our log table structure
function bb2_table_structure($name) {
	// It's not paranoia if they really are out to get you.
	$name_escaped = bb2_db_escape($name);
	return "CREATE TABLE IF NOT EXISTS `$name_escaped` (
			`id` INT(11) NOT NULL auto_increment,
			`ip` TEXT NOT NULL,
			`date` DATETIME NOT NULL default '0000-00-00 00:00:00',
			`request_method` TEXT NOT NULL,
			`request_uri` TEXT NOT NULL,
			`server_protocol` TEXT NOT NULL,
			`http_headers` TEXT NOT NULL,
			`user_agent` TEXT NOT NULL,
			`request_entity` TEXT NOT NULL,
			`key` TEXT NOT NULL,
			INDEX (`ip`(15)),
			INDEX (`user_agent`(10)),
			PRIMARY KEY (`id`) );"; // TODO: INDEX might need tuning
}
// Return the number of rows in a particular query.
function bb2_db_num_rows($result) {
	if ($result !== FALSE)
		return count($result);
	return 0;
}
// Run a query and return the results, if any.
// Should return FALSE if an error occurred.
// Bad Behavior will use the return value here in other callbacks.
function bb2_db_query($query) {
	$ok = safe_query($query);
	if ($ok) {
		return $ok;
	} else {
		return FALSE;
	}
}
// Return all rows in a particular query.
// Should contain an array of all rows generated by calling mysql_fetch_assoc()
// or equivalent and appending the result of each call to an array.
function bb2_db_rows($result) {
	return safe_rows($result);
}
// Return emergency contact email address.
function bb2_email() {
	$email = safe_field('email', 'pixie_users', 'privs = 3');
	return $email; // You need to change this.
}
// retrieve settings from database
// Settings are hard-coded for non-database use
function bb2_read_settings() {
	global $bb2_settings_defaults;
	return $bb2_settings_defaults;
}
// write settings to database
function bb2_write_settings($settings) {
	return FALSE;
}
// installation
function bb2_install() {
	$settings = bb2_read_settings();
	$ok       = safe_query(bb2_table_structure($settings['log_table']));
	if ($ok) {
		safe_query("UPDATE `" . PFX . "pixie_settings` SET `bb2_installed`='yes'");
	}
}
// Screener
// Insert this into the <head> section of your HTML through a template call
// or whatever is appropriate. This is optional we'll fall back to cookies
// if you don't use it.
function bb2_insert_head() {
	global $bb2_javascript;
	echo $bb2_javascript;
}
// Display stats? This is optional.
function bb2_insert_stats($force = FALSE) {
	$settings = bb2_read_settings();
	if ($force or $settings['display_stats']) {
		$blocked = safe_rows('*', $settings['log_table'], "`key` NOT LIKE '00000000'");
		$number  = count($blocked);
		if ($blocked !== FALSE) {
			echo sprintf('<p><a href="http://www.bad-behavior.ioerror.us/">%1$s</a> %2$s <strong>%3$s</strong> %4$s</p>', ('Bad Behavior'), ('has blocked'), $number, ('access attempts in the last 7 days.'));
		}
	}
}
// Return the top-level relative path of wherever we are (for cookies)
// You should provide in $url the top-level URL for your site.
function bb2_relative_path() {
	//$site_url = safe_field("site_url", "pixie_settings", "settings_id = '1'");
	//$url = parse_url($site_url);
	//return $url['path'];
	return '/';
}
// Calls inward to Bad Behavior itself.
require_once(BB2_CWD . '/bad-behavior/version.inc.php');
require_once(BB2_CWD . '/bad-behavior/core.inc.php');
if ($bb2_installed == 'no') {
	bb2_install();
}
bb2_start(bb2_read_settings());
?>