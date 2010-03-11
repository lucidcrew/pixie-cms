<?php
header('Content-type: text/css');  /* Declare the output of the file as CSS */
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Admin Style Import.                                      //
//*****************************************************************//

$refering = NULL;
$refering = parse_url( ($_SERVER['HTTP_REFERER']) );
if( ($refering['host'] == $_SERVER['HTTP_HOST']) ) {
if (defined('DIRECT_ACCESS')) { require_once '../../lib/lib_misc.php'; pixieExit(); exit(); }
define('DIRECT_ACCESS', 1);
require_once '../../lib/lib_misc.php';										/* perform basic sanity checks */
	bombShelter();   
	error_reporting(0);
	globalSec('admin_style.php', 1);
	/* Note : If you use this file, any global vars now have the prefix pixie, so what was $s is now $pixie_s */
	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');

	echo "
	@import url(style.css);
	@import url(navigation.css);
	";
	if (isset($pixie_s)) {
	$file = $pixie_s . '.css';
	    if (file_exists($file)) {
	    echo "@import url($file);";
	    }
	}
/* This file should be merged as an include or merged directly into another file instead of it being directly accessed like this. */
} else { header( 'Location: ../../../' ); exit(); } ?>