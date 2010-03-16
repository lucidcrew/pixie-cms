<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
	header( 'Location: ../../' );
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
 * Title: Static Page Module
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

switch ( $do ) {
	
	// Module Admin
	case 'admin':
		
		if ( isset( $GLOBALS['pixie_user'] ) && $GLOBALS['pixie_user_privs'] >= 1 ) {
			$type       = 'static';
			$table_name = 'pixie_core';
			$edit_id    = 'page_id';
			
			if ( ( !isset( $edit ) ) or ( !$edit ) ) {
				$edit = safe_field( 'page_id', 'pixie_core', "page_name='$x'" );
			}
			
			admin_carousel( $x );
			admin_head();
			admin_edit( $table_name, $edit_id, $edit, $edit_exclude = array(
				 'page_id',
				'page_type',
				'page_name',
				'page_description',
				'page_display_name',
				'page_blocks',
				'admin',
				'page_views',
				'public',
				'publish',
				'hidden',
				'searchable',
				'page_order',
				'last_modified',
				'page_parent',
				'in_navigation',
				'privs' 
			) );
			
		}
		break;
	
	// Show Module
	default:
		
		if ( ( !isset( $s ) ) && ( !$s ) ) {
			$s = 404;
		}
		
		if ( ( isset( $s ) ) && ( $s ) ) {
			extract( safe_row( '*', 'pixie_core', "page_name='$s'" ) );
			echo "<div id=\"$s\">\n\t\t\t\t\t\t<h3>$page_display_name</h3>\n";
			if ( isset( $_COOKIE['pixie_login'] ) ) {
				list( $username, $cookie_hash ) = explode( ',', $_COOKIE['pixie_login'] );
				$nonce = safe_field( 'nonce', 'pixie_users', "user_name='$username'" );
				if ( md5( $username . $nonce ) == $cookie_hash ) {
					$privs = safe_field( 'privs', 'pixie_users', "user_name='$username'" );
					if ( $privs >= 1 ) {
						echo "\t\t\t\t\t\t<ul class=\"page_edit\">\n\t\t\t\t\t\t\t<li class=\"post_edit\"><a href=\"" . $site_url . "admin/?s=publish&amp;m=static&amp;x=$s&amp;edit=$page_id\" title=\"" . $lang['edit_page'] . "\">" . $lang['edit_page'] . "</a></li>\n\t\t\t\t\t\t</ul>\n";
					}
				}
			}
			eval( '?>' . $page_content . '<?php ' );
			echo "\n\t\t\t\t\t</div>\n";
		}
}

?>