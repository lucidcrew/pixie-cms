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
	if (defined('PIXIE_DEBUG')) { pixieExit(); exit(); }
	define('PIXIE_DEBUG', 'no'); /* Set debug to yes to debug and see all the global vars coming into the file */

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
	$messageok = NULL;
	$login_forgotten = NULL;
	$do = NULL;
	/*  Admin area */
	$pixie_s = NULL;
	$url_style = NULL;
	$submit_edit = NULL;
	$name_style = NULL;
	$submit_new = NULL;
	$settings_edit = NULL;
	$login_submit = NULL;
	$remember = NULL;
	$profile_pass = NULL;
	$profile_edit = NULL;
	$confirm_style = NULL;
	$new_style = NULL;
	$current_style = NULL;
	$s = NULL;
	$edit = NULL;
	$go = NULL;
	$ck = NULL;
	$ckimage = NULL;
	$tag = NULL;
	$tags = NULL;
	$ckfile = NULL;
	$submit_upload = NULL;
	$del = NULL;
	$empty = NULL;
	$user_new = NULL;
	$user_edit = NULL;
	$email_style = NULL;
	$realname_style = NULL;
	$uname_style = NULL;
	$email = NULL;
	$realname = NULL;
	$uname = NULL;
	$pixie_dynamic_posts = NULL;
	$table_name = NULL;
	$mfound = NULL;
	$install = NULL;


// ------------------------------------------------------------------
/*	Debug code	*/


// ------------------------------------------------------------------
?>