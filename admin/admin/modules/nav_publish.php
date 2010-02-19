<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Nav_Publish.                                             //
//*****************************************************************//

if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 1) {

	if ((!$m) && (!$x)) {
		// try find the first page in the navigation
		$m = safe_field('page_type', 'pixie_core', "public = 'yes' and publish = 'yes' and in_navigation = 'yes' and page_order = '1' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_views desc");
		
		// if we do not have any pages in the navigation lets find any page
		if (!$m) {
			$m = safe_field('page_type', 'pixie_core', "public = 'yes' and publish = 'yes' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_views desc");
		}
	}

if (isset($s)) { ?>
<ul id="sub_nav_level_1">
						<li><a href="?s=<?php print $s; ?>" title="<?php print $lang['nav2_pages'];?>"<?php if ($x != 'filemanager') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_pages'];?></a></li>
						<li><a href="?s=<?php print $s; ?>&amp;x=filemanager" title="<?php print $lang['nav2_files'];?>"<?php if ($x == 'filemanager') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_files'];?></a></li>
					</ul>
<?php } ?></li>
<?php } /* Not to sure why there is a closing li tag after a ul tag above? Please explain or remove */ ?>