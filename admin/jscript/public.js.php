<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Public JavaScript                                        //
//*****************************************************************//

$refering = NULL;
$refering = parse_url( ($_SERVER['HTTP_REFERER']) );
if( ($refering['host'] == $_SERVER['HTTP_HOST']) ) {
if (defined('DIRECT_ACCESS')) { require_once '../lib/lib_misc.php'; pixieExit(); exit(); }
define('DIRECT_ACCESS', 1);
require_once '../lib/lib_misc.php';										/* perform basic sanity checks */
	bombShelter();                  									/* check URL size */
	error_reporting(0);

	/* Note : If you use this file, any global vars now have the prefix pixie, so what was $s is now $pixie_s */

	globalSec('public.js.php', 1);
	/* extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie'); */ /* Disabled by default for security */

} else { header( 'Location: ../../' ); exit(); } ?>