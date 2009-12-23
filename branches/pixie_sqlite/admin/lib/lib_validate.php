<?php
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
    function validateTextOnly($theinput,$description = ''){
        $result = ereg ("^[A-Za-z0-9\ ]+$", $theinput );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
    }

    // Validate text only, no spaces allowed
    function validateTextOnlyNoSpaces($theinput,$description = ''){
        $result = ereg ("^[A-Za-z0-9]+$", $theinput );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
    }
        
    // Validate email address
    function validateEmail($themail,$description = ''){
        $result = ereg ("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $themail );
        if ($result){
            return true;
        }else{
            $this->errors[] = $description;
            return false;
        }
            
    }

    // Validate a web address
    function validateURL($url, $description = '') {
    	$result = preg_match ("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/i", $url);
    	if ($result) {
    		return true;
    	} else {
    		$this->errors[] = $description;
    		return false;
    	}
    }
    
    // Validate numbers only
    function validateNumber($theinput,$description = ''){
        if (is_numeric($theinput)) {
            return true; // The value is numeric, return true
        }else{
            $this->errors[] = $description; // Value not numeric! Add error description to list of errors
            return false; // Return false
        }
    }
    
    // Check whether any errors have been found (i.e. validation has returned false)
    // since the object was created
    function foundErrors() {
        if (count($this->errors) > 0){
            return true;
        }else{
            return false;
        }
    }

    // Return a string containing a list of errors found,
    // Seperated by a given deliminator
	  function listErrors($delim = ' '){
        return implode($delim,$this->errors);
    }
    
    // Manually add something to the list of errors
    function addError($description){
        $this->errors[] = $description;
    }    
        
}
?>