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
 * Title: lib_validate - A class for validating common data from forms
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @link http://forum.weborum.com/index.php?showtopic=2507
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
class Validator {
	var $errors; // A variable to store a list of error messages
	// Validate text only
	function validateTextOnly($theinput, $description = '') {
		$result = $theinput;
		$result = preg_replace('/[^a-zA-ZÀÁÂÃÄÅĀĄĂÆÇĆČĈĊĎĐÐÈÉÊËĒĘĚĔĖĜĞĠĢĤĦÌÍÎÏĪĨĬĮİĲĴĶŁĽĹĻĿÑŃŇŅŊÒÓÔÕÖØŌŐŎŒŔŘŖŚŠŞŜȘŤŢŦȚÙÚÛÜŪŮŰŬŨŲŴÝŶŸŹŽŻÞÞàáâãäåāąăæçćčĉċďđðèéêëēęěĕėƒĝğġģĥħìíîïīĩĭįıĳĵķĸłľĺļŀñńňņŉŋòóôõöøōőŏœŕřŗšùúûüūůűŭũųŵýÿŷžżźþßſАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыэюя0-9 ]/', "", $result);
		if ($result == $theinput) {
			return TRUE;
		} else {
			$this->errors[] = $description;
			return FALSE;
		}
	}
	// Validate text only, no spaces allowed
	function validateTextOnlyNoSpaces($theinput, $description = '') {
		$result = $theinput;
		$result = str_replace(' ', '', $result);
		$result = preg_replace('/[^a-zA-ZÀÁÂÃÄÅĀĄĂÆÇĆČĈĊĎĐÐÈÉÊËĒĘĚĔĖĜĞĠĢĤĦÌÍÎÏĪĨĬĮİĲĴĶŁĽĹĻĿÑŃŇŅŊÒÓÔÕÖØŌŐŎŒŔŘŖŚŠŞŜȘŤŢŦȚÙÚÛÜŪŮŰŬŨŲŴÝŶŸŹŽŻÞÞàáâãäåāąăæçćčĉċďđðèéêëēęěĕėƒĝğġģĥħìíîïīĩĭįıĳĵķĸłľĺļŀñńňņŉŋòóôõöøōőŏœŕřŗšùúûüūůűŭũųŵýÿŷžżźþßſАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыэюя0-9 ]/', "", $result);
		if ($result == $theinput) {
			return TRUE;
		} else {
			$this->errors[] = $description;
			return FALSE;
		}
	}
	// Validate email address
	function validateEmail($themail, $description = '') {
		$pattern = '/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/';
		$result  = preg_match($pattern, $themail);
		if ($result) {
			return TRUE;
		} else {
			$this->errors[] = $description;
			return FALSE;
		}
	}
	// Validate a web address
	function validateURL($url, $description = '') {
		$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
		$result  = preg_match($pattern, $url);
		if ($result) {
			return TRUE;
		} else {
			$this->errors[] = $description;
			return FALSE;
		}
	}
	// Validate numbers only
	function validateNumber($theinput, $description = '') {
		if (is_numeric($theinput)) {
			return TRUE; // The value is numeric, return TRUE
		} else {
			$this->errors[] = $description; // Value not numeric! Add error description to list of errors
			return FALSE; // Return FALSE
		}
	}
	// Check whether any errors have been found (i.e. validation has returned FALSE)
	// since the object was created
	function foundErrors() {
		if (count($this->errors) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	// Return a string containing a list of errors found,
	// Seperated by a given deliminator
	function listErrors($delim = ' ') {
		return implode($delim, $this->errors);
	}
	// Manually add something to the list of errors
	function addError($description) {
		$this->errors[] = $description;
	}
}
?>