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
 * Title: Tag Cloud block
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
if (isset($s)) {
	$id   = get_page_id($s);
	$type = check_type($s);
	global $lang;
	global $timezone;
	if ($type == 'dynamic') {
		$table = 'pixie_dynamic_posts';
	} else if ($type == 'module') {
		$table = "pixie_module_{$s}";
	}
	echo "\t\t\t\t\t<div id=\"block_tagcloud\" class=\"block\">\n\t\t\t\t\t\t<div class=\"block_header\">\n\t\t\t\t\t\t\t<h4>" . $lang['tags'] . "</h4>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_body\">\n";
	if ($type == 'dynamic') {
		public_tag_cloud($table, "page_id = {$id} and public = 'yes'");
	} else {
		$condition = "{$s}_id >= '0'";
		if (isset($table)) {
			public_tag_cloud($table, $condition);
		}
	}
	echo "\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_footer\"></div>\n\t\t\t\t\t</div>\n";
}
?>