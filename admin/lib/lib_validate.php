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
	/* Was : */ /* $result = ereg ('^[A-Za-z0-9\ ]+$', $theinput ); */ /* But ereg is now depreciated. */
        $result = preg_match('^[A-Za-z0-9\ ]+$', $theinput );
        if ($result){
            return TRUE;
        }else{
            $this->errors[] = $description;
            return FALSE;
        }
    }

    // Validate text only, no spaces allowed
    function validateTextOnlyNoSpaces($theinput, $description = '') {
	/* Was : */ /* $result = ereg ('^[A-Za-z0-9]+$', $theinput ); */ /* But ereg is now depreciated. */
        $result = preg_match('^[A-Za-z0-9]+$', $theinput );
        if ($result){
            return TRUE;
        }else{
            $this->errors[] = $description;
            return FALSE;
        }
    }
        
    // Validate email address
    function validateEmail($themail, $description = '') {
	/* Was : */ /* ereg ('^[^@ ]+@[^@ ]+\.[^@ \.]+$', $themail ); */ /* But ereg is now depreciated. */
        $result = preg_match('^[^@ ]+@[^@ ]+\.[^@ \.]+$', $themail );
        if ($result){
            return TRUE;
        }else{
            $this->errors[] = $description;
            return FALSE;
        }
            
    }

    // Validate a web address
    function validateURL($url, $description = '') {
    	$result = preg_match ('/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i', $url);
    	if ($result) {
    		return TRUE;
    	} else {
    		$this->errors[] = $description;
    		return FALSE;
    	}
    }
    
    // Validate numbers only
    function validateNumber($theinput, $description = ''){
        if (is_numeric($theinput)) {
            return TRUE; // The value is numeric, return TRUE
        }else{
            $this->errors[] = $description; // Value not numeric! Add error description to list of errors
            return FALSE; // Return FALSE
        }
    }
    
    // Check whether any errors have been found (i.e. validation has returned FALSE)
    // since the object was created
    function foundErrors() {
        if (count($this->errors) > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // Return a string containing a list of errors found,
    // Seperated by a given deliminator
	  function listErrors($delim = ' '){
        return implode($delim, $this->errors);
    }
    
    // Manually add something to the list of errors
    function addError($description){
        $this->errors[] = $description;
    }    
        
}

?>