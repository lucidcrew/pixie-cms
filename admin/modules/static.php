<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Static Page Module.                                      //
//*****************************************************************//

switch ($do) {
	
  // Module Admin
	case 'admin' :

		if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 1) {
			$type = 'static';
			$table_name = 'pixie_core';
			$edit_id = 'page_id';

			if ((!isset($edit)) or (!$edit)) {
				$edit = safe_field('page_id', 'pixie_core', "page_name='$x'");
			}

			admin_carousel($x);		
			admin_head();	
			admin_edit($table_name, $edit_id, $edit, $edit_exclude = array('page_id', 'page_type', 'page_name', 'page_description', 'page_display_name', 'page_blocks', 'admin', 'page_views', 'public', 'publish', 'hidden', 'searchable', 'page_order', 'last_modified', 'page_parent', 'in_navigation', 'privs'));

		}
	break;

	// Show Module
	default :

	if ((!isset($s)) && (!$s)) { $s = 404; }
    
		if ((isset($s)) && ($s)) {
			extract(safe_row('*', 'pixie_core', "page_name='$s'"));
			echo "<div id=\"$s\">\n\t\t\t\t\t\t<h3>$page_display_name</h3>\n";
			if(isset($_COOKIE['pixie_login'])) {
				list($username, $cookie_hash) = explode(',', $_COOKIE['pixie_login']);
				$nonce = safe_field('nonce', 'pixie_users', "user_name='$username'");
				if (md5($username . $nonce) == $cookie_hash) {
					$privs = safe_field('privs', 'pixie_users', "user_name='$username'");		
					if ($privs >= 1) {
						echo "\t\t\t\t\t\t<ul class=\"page_edit\">\n\t\t\t\t\t\t\t<li class=\"post_edit\"><a href=\"" . $site_url . "admin/?s=publish&amp;m=static&amp;x=$s&amp;edit=$page_id\" title=\"" . $lang['edit_page'] . "\">" . $lang['edit_page'] . "</a></li>\n\t\t\t\t\t\t</ul>\n";
					}
				}
			}
			eval('?>' . $page_content . '<?php ');
			echo "\n\t\t\t\t\t</div>\n";
		} 
}

?>