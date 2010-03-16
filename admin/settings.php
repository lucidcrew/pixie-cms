<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
		header( 'Location: ../' );
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
 * Title: Pixie admin template settings
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

/* Speed up the admin interface using php's gzip compression? (yes or no) - (May not work with Internet Explorer, please test, default: no). */
$gzip_admin = 'no';

/* Would you like to load the JQuery javascript library from google apis, it may speed up your site? (yes or no) - (default: no). */
/* http://code.google.com/apis/ajaxlibs/documentation/#AjaxLibraries */
$g_apis_jquery = 'no';

/* The version of jQuery to load from google apis */
$g_apis_jquery_loc = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js';

/* more settings may appear in the future, please let us know if you have */
/* any suggestions as to how we could bring slightly more customisation */
/* to Pixie's admin interface. */
?>