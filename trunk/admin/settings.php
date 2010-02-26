<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Pixie admin template settings                                   //
//*****************************************************************//

// Speed up the admin interface using php's gzip compression? (yes or no) - (May not work with Internet Explorer, please test, default: no).
$gzip_admin = 'no';

// Would you like to load the JQuery javascript library from google apis, it may speed up your site? (yes or no) - (default: no).
// http://code.google.com/apis/ajaxlibs/documentation/#AjaxLibraries
$jquery_google_apis_load = 'no';
// The version of jQuery to load from google apis
$googleapis_jquery_load_location = 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js';

// more settings may appear in the future, please let us know if you have
// any suggestions as to how we could bring slightly more customisation 
// to Pixie's admin interface.
?>