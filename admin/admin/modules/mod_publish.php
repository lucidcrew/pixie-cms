<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: Publish.                                                 //
//*****************************************************************//

if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 1) {
	if (($m) and (!$x)) {
		extract(safe_row('*', 'pixie_core', "page_type = '$m' and publish = 'yes' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_views desc limit 0,1"));
		$x = $page_name;
		if ($m == 'module') {
			if (file_exists("../admin/modules/$x.php")) {
				$do = 'admin';	
				include("../admin/modules/$x.php");	
			} else {
				$message = "Page $m has been removed (check if module has been removed from modules folder).";
			}
		} else {
			if (file_exists("../admin/modules/$m.php")) {
				$do = 'admin';	
				include("../admin/modules/$m.php");	
			} else {
				$message = "Page $m has been removed (check if module has been removed from modules folder).";
			}
		}
	} else if (($m) and ($x)) {
		if ($m == 'module') {
			if (file_exists("../admin/modules/$x.php")) {
				$do = 'admin';	
				include("../admin/modules/$x.php");	
			} else {
				$message = "Page $x has been removed (check if module has been removed from modules folder).";
			}
		} else {
			if (file_exists("../admin/modules/$m.php")) {
				$do = 'admin';	
				include("../admin/modules/$m.php");	
			} else {
				$message = "Page $x has been removed (check if module has been removed from modules folder).";
			}
		}
	} else {
		if (file_exists("admin/modules/mod_$x.php")) {
			$do = 'admin';
			include("admin/modules/mod_$x.php");
		} else {
			$message = "Admin module $x has been removed from the admin modules folder.";
		}
	}
}
?>