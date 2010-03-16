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
 * Title: AJAX File Upload
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
		require_once '../../config.php';
		include_once '../../lib/lib_db.php';
		include_once '../../lib/lib_auth.php';
		include_once '../../lib/lib_date.php';
		include_once '../../lib/lib_validate.php';
		include_once '../../lib/lib_upload.php';
		include_once '../../lib/lib_rss.php';
		include_once '../../lib/lib_tags.php';
		include_once '../../lib/lib_logs.php';
		
		if ( isset( $GLOBALS['pixie_user'] ) && $GLOBALS['pixie_user_privs'] >= 1 ) {
				globalSec( 'ajax_fileupload.php', 1 );
				
				extract( $_REQUEST ); // access to form vars if register globals is off // note : NOT setting a prefix yet, not looked at it yet
				$prefs = get_prefs();
				extract( $prefs );
				include_once '../../lang/' . $language . '.php';
				
				// rebuild new form field
				if ( $form ) {
						if ( first_word( $form ) == 'image' ) {
								db_dropdown( 'pixie_files', "", $form, "file_type = 'Image' order by file_id desc" );
								if ( !$ie ) {
										echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $form . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower( $lang['upload'] ) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n";
								}
						} else if ( first_word( $form ) == 'document' ) {
								db_dropdown( 'pixie_files', "", $form, "file_type = 'Other' order by file_id desc" );
								if ( !$ie ) {
										echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $form . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower( $lang['upload'] ) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n";
								}
						} else if ( first_word( $form ) == 'video' ) {
								db_dropdown( 'pixie_files', "", $form, "file_type = 'Video' order by file_id desc" );
								if ( !$ie ) {
										echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $form . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower( $lang['upload'] ) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n";
								}
						} else if ( first_word( $form ) == 'audio' ) {
								db_dropdown( 'pixie_files', "", $form, "file_type = 'Audio' order by file_id desc" );
								if ( !$ie ) {
										echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $form . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower( $lang['upload'] ) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n";
								}
						} else {
								db_dropdown( 'pixie_files', "", $form, "file_id >= '0' order by file_id desc" );
								if ( !$ie ) {
										echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $form . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower( $lang['upload'] ) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n";
								}
						}
						
						die();
				}
				
				$max_size = 1024 * 100;
				
				$multi_upload = new muli_files;
				
				$file_name = $_FILES['upload']['name'][0];
				$file_ext  = substr( strrchr( $file_name, '.' ), 1 );
				$file_ext  = strtolower( $file_ext );
				
				if ( ( $file_ext == 'jpg' ) or ( $file_ext == 'gif' ) or ( $file_ext == 'png' ) ) {
						$dir       = '../../../files/images/';
						$file_type = 'Image';
				} else if ( ( $file_ext == 'mov' ) or ( $file_ext == 'flv' ) or ( $file_ext == 'avi' ) or ( $file_ext == 'm4v' ) or ( $file_ext == 'mp4' ) or ( $file_ext == 'mkv' ) or ( $file_ext == 'ogv' ) ) {
						$dir       = '../../../files/video/';
						$file_type = 'Video';
				} else if ( ( $file_ext == 'mp3' ) or ( $file_ext == 'flac' ) or ( $file_ext == 'ogg' ) or ( $file_ext == 'wav' ) or ( $file_ext == 'pls' ) or ( $file_ext == 'm4a' ) or ( $file_ext == 'xspf' ) ) {
						$dir       = '../../../files/audio/';
						$file_type = 'Audio';
				} else {
						$dir       = '../../../files/other/';
						$file_type = 'Other';
				}
				
				$file_tags = str_replace( '_', " ", $field );
				
				$multi_upload->upload_dir        = $dir;
				$multi_upload->message[]         = $multi_upload->extra_text( 4 );
				$multi_upload->do_filename_check = 'y';
				$multi_upload->tmp_names_array   = $_FILES['upload']['tmp_name'];
				$multi_upload->names_array       = $_FILES['upload']['name'];
				$multi_upload->error_array       = $_FILES['upload']['error'];
				$multi_upload->replace           = ( isset( $_POST['replace'] ) ) ? $_POST['replace'] : 'n';
				$multi_upload->extensions        = array(
						 '.png',
						'.jpg',
						'.gif',
						'.zip',
						'.mp3',
						'.pdf',
						'.exe',
						'.rar',
						'.swf',
						'.vcf',
						'.css',
						'.dmg',
						'.php',
						'.doc',
						'.xls',
						'.xml',
						'.eps',
						'.rtf',
						'.iso',
						'.psd',
						'.txt',
						'.ppt',
						'.mov',
						'.flv',
						'.avi',
						'.m4v',
						'.mp4',
						'.gz',
						'.bz2',
						'.tar',
						'.7z',
						'.svg',
						'.svgz',
						'.lzma',
						'.sig',
						'.sign',
						'.js',
						'.rb',
						'.ttf',
						'.html',
						'.phtml',
						'.flac',
						'.ogg',
						'.wav',
						'.mkv',
						'.pls',
						'.m4a',
						'.xspf',
						'.ogv' 
				);
				$multi_upload->upload_multi_files();
				
				if ( lastword( $multi_upload->show_error_string() ) == 'uploaded.' ) {
						$sql = "file_name = '$file_name', file_extension = '$file_ext', file_type = '$file_type', tags = '$file_tags'";
						$ok  = safe_insert( 'pixie_files', $sql );
						
						if ( !$ok ) {
								$message = $lang['file_upload_error'];
						} else {
								$messageok = $multi_upload->show_error_string();
								logme( $messageok, 'no', 'folder' );
								safe_optimize( 'pixie_files' );
								safe_repair( 'pixie_files' );
						}
				} else {
						$message = $multi_upload->show_error_string();
				}
				
				
				print $message;
				
		}
		/* This file should be merged as an include or merged directly into another file instead of it being directly accessed like this. */
} else {
		header( 'Location: ../../../' );
		exit();
}
?>