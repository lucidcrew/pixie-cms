<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	     //
// Title: TinyMCE Image List.                                      //
//*****************************************************************//
header('Content-Type: text/javascript');
error_reporting(0);																														// turn off error reporting

include_once '../../config.php';           																				
include_once '../../lib/lib_db.php';       																			
include_once '../../lib/lib_misc.php';     																		
include_once '../../lib/lib_auth.php';

$site_url = safe_field('site_url','pixie_settings',"settings_id='1'");

echo "var tinyMCEImageList = new Array("; 
$rs = safe_rows("*", "pixie_files", "file_type = 'Image' order by file_id desc limit 20");
	if ($rs) {
		$num = count($rs);
		$last = $num-1;
		$i = 0;
		while ($i < $num){
			$out = $rs[$i];
  		$file_name = $out['file_name'];
  		if ($i ==  $last) { 
				echo "[\"$file_name\", \"".$site_url."files/images/$file_name\"]";
  		} else {
  			echo "[\"$file_name\", \"".$site_url."files/images/$file_name\"],";
  		}
			$i++;
		}
	}
echo ");";
?>