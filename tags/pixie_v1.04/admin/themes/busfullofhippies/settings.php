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
 * @author John Oxton
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
// what is the name of your theme?
$theme_name                 = 'Bus Full Of Hippies';
// Who created the theme?
$theme_creator              = 'John Oxton';
// What website would your like your theme to link to?
$theme_link                 = 'http://busfullofhippies.johnoxton.co.uk';
// Would you like your theme to have nested navigation? (yes or no).
$nested_nav                 = 'no';
// Would you like to load the Jquery javascript library? (yes or no) - (default: yes).
$jquery                     = 'no';
// Would you like to load the JQuery javascript library from google apis, it may speed up your site? (yes or no) - (default: no).
// http://code.google.com/apis/ajaxlibs/documentation/#AjaxLibraries
$theme_g_apis_jquery        = 'no';
// The version of jQuery to load from google apis
$theme_g_apis_jquery_loc    = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js';
// Would you like to load the swfobject javascript library from google apis, it may speed up your site? (yes or no) - (default: no).
// http://code.google.com/apis/ajaxlibs/documentation/#AjaxLibraries
$theme_swfobject_g_apis     = 'no';
// The version of swfobject to load from google apis
$theme_swfobject_g_apis_loc = 'http://ajax.googleapis.com/ajax/libs/swfobject/2/swfobject.js';
// Would you like the content to appear first in the HTML? (yes or no) - (default: no).
// if set to yes the content will be loaded then the blocks afterwards.
// if set to no the blocks will load first then the content.
$contentfirst               = 'no';
// Speed up the theme using php's gzip compression? (yes or no) - (default: no).
$gzip_theme_output          = 'no';
// more settings may appear in the future, please let us know if you have
// any suggestions as to how we could bring slightly more customisation 
// to site themes.
?>