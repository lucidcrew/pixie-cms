<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Settings                                                 //
//*****************************************************************//

/* Was : */ /* $x = ereg_replace('[^A-Za-z0-9]', "", $x); */ /* but ereg_replace() is depreciated. */
$x = preg_replace('[^A-Za-z0-9]', "", $x);
if (!isset($username)) { $username = NULL; }

if(isset($_COOKIE['pixie_login'])) {
	list($username, $cookie_hash) = explode(',', $_COOKIE['pixie_login']);
	$nonce = safe_field('nonce', 'pixie_users', "user_name='$username'");
	if (md5($username . $nonce) == $cookie_hash) {
		$privs = safe_field('privs', 'pixie_users', "user_name='$username'");		
		if ($privs >= 2) {
			if (file_exists("admin/modules/mod_$x.php")) {
				include("admin/modules/mod_$x.php");
			} else {
				$message = "Admin module $x has been removed from the admin modules folder.";
			}
		}
	}
}
?>