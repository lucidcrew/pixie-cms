<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Public JavaScript                                        //
//*****************************************************************//

	// Note : If you use this file, any global vars now have the prefix pixie, so what was $s is now $pixie_s

	// Set $debug to yes to debug and see all the global vars coming into the file
	// To find error messages, search the page for php_errormsg if you turn this debug feature on

	$debug = 'no';

	if ($debug == 'yes') {
	error_reporting(E_ALL & ~E_DEPRECATED);
	$show_vars = get_defined_vars();
	echo '<p><pre class="showvars">The _REQUEST array contains : ';
	htmlspecialchars(print_r($show_vars["_REQUEST"]));
	echo '</pre></p>';
	}

	header('Content-Type: text/javascript');

	// Here we check to make sure that the GET/POST/COOKIE and SESSION variables have not been poisioned
	// by an intruder before they are extracted

	if (isset($_REQUEST['_GET'])) { exit('Pixie Admin - index.php - An attempt to modify get data was made.'); }
	if (isset($_REQUEST['_POST'])) { exit('Pixie Admin - index.php - An attempt to modify post data was made.'); }
	if (isset($_REQUEST['_COOKIE'])) { exit('Pixie Admin - index.php - An attempt to modify cookie data was made.'); }
	if (isset($_REQUEST['_SESSION'])) { exit('Pixie Admin - index.php - An attempt to modify session data was made.'); }

	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');
?>