<?php
header('Content-Type: text/html; charset=utf-8');
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Ajax page order system.                                  //
//*****************************************************************//

if (defined('DIRECT_ACCESS')) { require_once '../../lib/lib_misc.php'; pixieExit(); exit(); }
define('DIRECT_ACCESS', 1);
require_once '../../lib/lib_misc.php';										/* perform basic sanity checks */
bombShelter();                  										/* check URL size */

error_reporting(0);

if ($_POST['pages']) {

	include_once '../../config.php';
	include_once '../../lib/lib_db.php';
	include_once '../../lib/lib_auth.php';

	$count = count($_POST['pages']);

	if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 2) {
		$i = 0;
		while ($i < $count){
			$page_name = $_POST['pages'][$i];
			safe_update('pixie_core', "page_order  = $i + 1", "page_name = '$page_name'");
		$i++;
		}
	}
}
/* This file should be merged as an include or merged directly into another file instead of it being directly accessed like this. */
?>