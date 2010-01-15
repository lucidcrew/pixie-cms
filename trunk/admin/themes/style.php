<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Style Import.                                            //
//*****************************************************************//

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