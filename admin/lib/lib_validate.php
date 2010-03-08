<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_validate.                                            //
//*****************************************************************//

// Author: Unknown
// Web:  	 forum.weborum.com/index.php?showtopic=2507
// Desc: 	 A class for validating common data from forms

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
	$result = preg_match($pattern, $themail);

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
    	$result = preg_match($pattern, $url);

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