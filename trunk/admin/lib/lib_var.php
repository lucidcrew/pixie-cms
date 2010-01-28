<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_misc.                                                //
//*****************************************************************//
// ------------------------------------------------------------------

/*	Set up debugging	*/
	if (defined('PIXIE_DEBUG')) { nukeProofSuit(); exit(); }
	define('PIXIE_DEBUG', 'no'); /* Set debug to yes to debug and see all the global vars coming into the file */

/*	Set up the old (Not new) Timezone method	*/
	if (defined('TZ')) { nukeProofSuit(); exit(); }
	define('TZ', "$timezone"); /* timezone fix (php 5.1.0 or newer will set it's server timezone using function date_default_timezone_set!) */

/*	Set undefined variables for pages	*/
	/* Main index */
	$ptitle = NULL;
	$pinfo = NULL;
	$delete = NULL;
	$username = NULL;
	/* contact/ */
	$subject = NULL;
	$contact_sub = NULL;
	$uemail = NULL;
	$error = NULL;
	$show_profile_information = NULL;
	/* events/ */
	$title = NULL;
	/*  For upgraders that don't have them defined in config.php */
	$server_timezone = 'Europe/London';
	/*  For upgraders that don't have them defined in settings.php */
	$gzip_theme_output = NULL;
	$theme_jquery_google_apis = NULL;
	$theme_jquery_google_apis_location = NULL;
	$theme_swfobject_google_apis = NULL;
	$theme_swfobject_google_apis_location = NULL;
	/* Admin index */
	$GLOBALS['pixie_user'] = NULL;
	$messageok  = NULL;
	$login_forgotten  = NULL;
	$do  = NULL;
// ------------------------------------------------------------------
/*	Debug code	*/


// ------------------------------------------------------------------
?>