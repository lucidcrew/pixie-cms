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
 * Title: Publish
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
if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 1) {
	if (($m) and (!$x)) {
		extract(safe_row('*', 'pixie_core', "page_type = '$m' and publish = 'yes' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_views desc limit 0,1"));
		$x = $page_name;
		if ($m == 'module') {
			if (file_exists("../admin/modules/$x.php")) {
				$do = 'admin';
				include("../admin/modules/$x.php");
			} else {
				$message = "Page $m has been removed (check if module has been removed from modules folder).";
			}
		} else {
			if (file_exists("../admin/modules/$m.php")) {
				$do = 'admin';
				include("../admin/modules/$m.php");
			} else {
				$message = "Page $m has been removed (check if module has been removed from modules folder).";
			}
		}
	} else if (($m) and ($x)) {
		if ($m == 'module') {
			if (file_exists("../admin/modules/$x.php")) {
				$do = 'admin';
				include("../admin/modules/$x.php");
			} else {
				$message = "Page $x has been removed (check if module has been removed from modules folder).";
			}
		} else {
			if (file_exists("../admin/modules/$m.php")) {
				$do = 'admin';
				include("../admin/modules/$m.php");
			} else {
				$message = "Page $x has been removed (check if module has been removed from modules folder).";
			}
		}
	} else {
		if (file_exists("admin/modules/mod_$x.php")) {
			$do = 'admin';
			include("admin/modules/mod_$x.php");
		} else {
			$message = "Admin module $x has been removed from the admin modules folder.";
		}
	}
}
?>