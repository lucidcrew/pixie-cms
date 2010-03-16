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
 * Title: Comments Plugin
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
	// general information
	case 'info':
		
		$m_name        = 'Comments';
		$m_description = 'This plugin will allow visitors to leave a comment on any post in a dynamic page.';
		$m_author      = 'Scott Evans';
		$m_url         = 'http://www.toggle.uk.com';
		$m_version     = 1.1;
		$m_type        = 'plugin';
		$m_publish     = 'yes';
		
		break;
	
	// install
	
	// pre (to be run before page load)
	
	// admin of module
	case 'admin':
		
		$module_name  = 'comments';
		$table_name   = 'pixie_module_comments';
		$order_by     = 'posted';
		$asc_desc     = 'desc';
		$view_exclude = array(
			 'comments_id',
			'post_id',
			'page_id',
			'url',
			'admin_user' 
		);
		$edit_exclude = array(
			 'comments_id',
			'post_id' 
		);
		$view_number  = '20';
		$tags         = 'no';
		
		admin_module( $module_name, $table_name, $order_by, $asc_desc, $view_exclude, $edit_exclude, $view_number, $tags );
		
		break;
	
	// show module
	default:
		// I am not here to show anything, I am used as part of the dynamic pages page.
		break;
}

?>