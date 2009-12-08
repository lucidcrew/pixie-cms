<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Admin Style Import.                                      //
//*****************************************************************//

extract($_REQUEST);
// declare the output of the file as CSS
header('Content-type: text/css');

echo"
@import url(style.css);
@import url(navigation.css);
";
$file = $s.".css";
if (file_exists($file)) {
	echo "@import url($file);";
}	
?>