<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
		header( 'Location: ../../../' );
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
 * Title: Settings
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

/* Was : */
/* $x = ereg_replace('[^A-Za-z0-9]', "", $x); */
/* but ereg_replace() is depreciated. */
$x = preg_replace( '[^A-Za-z0-9]', "", $x );
if ( !isset( $username ) ) {
		$username = NULL;
}

if ( isset( $_COOKIE['pixie_login'] ) ) {
		list( $username, $cookie_hash ) = explode( ',', $_COOKIE['pixie_login'] );
		$nonce = safe_field( 'nonce', 'pixie_users', "user_name='$username'" );
		if ( md5( $username . $nonce ) == $cookie_hash ) {
				$privs = safe_field( 'privs', 'pixie_users', "user_name='$username'" );
				if ( $privs >= 2 ) {
						if ( file_exists( "admin/modules/mod_$x.php" ) ) {
								include_once( "admin/modules/mod_$x.php" );
						} else {
								$message = "Admin module $x has been removed from the admin modules folder.";
						}
				}
		}
}

?>