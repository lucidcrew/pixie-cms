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
 * Title: Theme Settings
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
if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {
	if ((isset($do)) && ($do)) {
		if (file_exists("themes/{$do}")) {
			$ok = safe_update("pixie_settings", "site_theme = '$do'", "settings_id ='1'");
		}
		if ($ok) {
			$messageok = $lang['theme_ok'];
		} else {
			$message = $lang['theme_error'];
		}
	}
	$prefs = get_prefs();
	extract($prefs);
	echo "<h2>{$lang['nav2_theme']}</h2>\n\t\t\t\t<p>{$lang['theme_info']}</p>";
	echo "\n\n\t\t\t\t<div id=\"themes\">\n\t\t\t\t\t<h3>{$lang['theme_pick']}</h3>\n";
	$dir = 'themes/';
	if (is_dir($dir)) {
		$fd = @opendir($dir);
		if ($fd) {
			while (($part = @readdir($fd)) == true) {
				if ($part != "." && $part != "..") {
					$newdir = $dir.$part;   
					if (is_dir($newdir) && preg_match('/^[A-Za-z].*[A-Za-z]$/', $part)) {
						include "themes/$part/settings.php";
						if ($part == $site_theme) {
							echo "\t\t\t\t\t<div class=\"atheme currenttheme\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\"><img src=\"themes/$part/thumb.jpg\" alt=\"".$lang['nav2_theme'].": $theme_name\" class=\"ticon\"/></a><span class=\"tname\">$theme_name</span><span class=\"tcreator\">".$lang['by']." <a href=\"$theme_link\">$theme_creator</a></span><span class=\"tselect\">Current theme</span></div>\n"; 
						} else { 
							echo "\t\t\t\t\t<div class=\"atheme\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\"><img src=\"themes/$part/thumb.jpg\" alt=\"".$lang['nav2_theme'].": $theme_name\" class=\"ticon\"/></a><span class=\"tname\">$theme_name</span><span class=\"tcreator\">".$lang['by']." <a href=\"$theme_link\">$theme_creator</a></span><span class=\"tselect\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\">".$lang['theme_apply']."</a></span></div>\n"; 
						}
					}
				}
			}
		}
	}
	echo "\t\t\t\t</div>";
}
?>