<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: Nav_Settings.                                            //
//*****************************************************************//

if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {

	if ((!$m) && (!$x)) {
		$x = 'pages';
	}
	
?>
<ul id="sub_nav_level_1">
						<li><a href="?s=<?php print $s;?>&amp;x=pages" title="<?php print $lang['nav2_pages'] . " " . $lang['nav2_settings'];?>"<?php if ($x == 'pages') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_pages'];?></a></li>
						<li><a href="?s=<?php print $s;?>&amp;x=site" title="<?php print $lang['nav2_site'] . " " . $lang['nav2_settings'];?>"<?php if ($x == 'site') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_site'];?></a></li>
						<li><a href="?s=<?php print $s;?>&amp;x=pixie" title="Pixie <?php print $lang['nav2_settings'];?>"<?php if ($x == 'pixie') { echo " class=\"sub_nav_current_1\""; }?>>Pixie</a></li>
						<!--<li><a href="?s=<?php print $s;?>&amp;m=blocks" title="<?php print $lang['nav2_blocks'];?>"<?php if ($m == "blocks") { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_blocks'];?></a></li>-->
						<li><a href="?s=<?php print $s;?>&amp;x=theme" title="<?php print $lang['nav2_theme'] . " " . $lang['nav2_settings'];?>"<?php if ($x == 'theme') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_theme'];?></a></li>
						<li><a href="?s=<?php print $s;?>&amp;x=users" title="<?php print $lang['nav2_users'];?>"<?php if ($x == 'users') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_users'];?></a></li>
						<li><a href="?s=<?php print $s;?>&amp;x=dbtools" title="<?php print $lang['nav2_backup'];?>"<?php if ($x == 'dbtools') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_backup'];?></a></li>
					</ul>
					</li>
<?php
}
?>