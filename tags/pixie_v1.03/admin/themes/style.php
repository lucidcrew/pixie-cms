<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Style Import.                                            //
//*****************************************************************//

extract($_REQUEST);
// declare the output of the file as CSS
header('Content-type: text/css');

echo"
@import url($theme/core.css);
@import url($theme/layout.css);
@import url($theme/navigation.css);
";
$file = $theme."/".$s.".css";
if (file_exists($file)) {
	echo "@import url($file);";
}
?>