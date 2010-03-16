<?php
header( 'Content-Type: text/html; charset=utf-8' );
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
 * Title: Ajax message system
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

$refering = NULL;
$refering = parse_url( ( $_SERVER['HTTP_REFERER'] ) );
if ( ( $refering['host'] == $_SERVER['HTTP_HOST'] ) ) {
		if ( defined( 'DIRECT_ACCESS' ) ) {
				require_once '../../lib/lib_misc.php';
				pixieExit();
				exit();
		}
		define( 'DIRECT_ACCESS', 1 );
		require_once '../../lib/lib_misc.php';
		/* perform basic sanity checks */
		bombShelter();
		/* check URL size */
		error_reporting( 0 );
		
		if ( $_POST['message'] ) {
				print $message;
				echo "
				<span class=\"message_text_error\">";
				
				if ( $_POST['back'] != 'no' ) {
						echo "<img src=\"admin/theme/images/icons/error.png\" />";
				}
				echo $_POST['message'] . '</span>';
				if ( $_POST['back'] != "no" ) {
						echo "<span class=\"message_back\"> (<a href=\"javascript:history.go(-1);\" title=\"Back (Will reload any submitted form data)\">go back &raquo;</a>)</span>";
				}
		} else if ( $_POST['messageok'] ) {
				echo "
				<span class=\"message_text_ok\"><img src=\"admin/theme/images/icons/tick.png\" /> " . $_POST['messageok'] . "</span>
	";
		}
		/* This file should be merged as an include or merged directly into another file instead of it being directly accessed like this. */
} else {
		header( 'Location: ../../../' );
		exit();
}
?>