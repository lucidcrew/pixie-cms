<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Admin Style Import.                                      //
//*****************************************************************//
header('Content-type: text/css');  /* declare the output of the file as CSS */
if (defined('DIRECT_ACCESS')) { require_once '../../lib/lib_misc.php'; nukeProofSuit(); exit(); }
define('DIRECT_ACCESS', 1);
require_once '../../lib/lib_misc.php';										/* perform basic sanity checks */
	bombShelter();   

	// Note : If you use this file, any global vars now have the prefix pixie, so what was $s is now $pixie_s
	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');

	echo"
	@import url(style.css);
	@import url(navigation.css);
	";
	$file = $pixie_s. '.css';
	if (file_exists($file)) {
	echo "@import url($file);";
	}	
?>