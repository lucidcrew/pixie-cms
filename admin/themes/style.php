<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Style Import.                                            //
//*****************************************************************//

	// Here we check to make sure that the GET/POST/COOKIE and SESSION variables have not been poisioned
	// by an intruder before they are extracted

	if (isset($_REQUEST['_GET'])) { exit('Pixie Admin - index.php - An attempt to modify get data was made.'); }
	if (isset($_REQUEST['_POST'])) { exit('Pixie Admin - index.php - An attempt to modify post data was made.'); }
	if (isset($_REQUEST['_COOKIE'])) { exit('Pixie Admin - index.php - An attempt to modify cookie data was made.'); }
	if (isset($_REQUEST['_SESSION'])) { exit('Pixie Admin - index.php - An attempt to modify session data was made.'); }

	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');

	// declare the output of the file as CSS
	header('Content-type: text/css');

	echo"
	@import url($pixie_theme/core.css);
	@import url($pixie_theme/layout.css);
	@import url($pixie_theme/navigation.css);
	";

	$file = $pixie_theme."/".$pixie_s.".css";

	if (file_exists($file)) {
	echo "@import url($file);";
				}
?>