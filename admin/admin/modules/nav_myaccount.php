<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Nav_Myaccount.                                           //
//*****************************************************************//

if (isset($GLOBALS['pixie_user']) && (isset($s))) { ?>
<ul id="sub_nav_level_1">
				  		<li><a href="?s=<?php print $s; ?>" title="<?php print $lang['nav2_home'];?>"<?php if (($s == 'myaccount') && ($x != 'myprofile')) { if ($x !== 'logs') { echo " class=\"sub_nav_current_1\""; } }?>><?php print $lang['nav2_home'];?></a></li>
						<li><a href="?s=<?php print $s; ?>&amp;x=myprofile" title="<?php print $lang['nav2_profile'];?>"<?php if ((!isset($do)) && (!$do) && ($x == 'myprofile')) { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_profile'];?></a></li>
						<li><a href="?s=<?php print $s; ?>&amp;x=myprofile&amp;do=security" title="<?php print $lang['nav2_security'];?>"<?php if ($do == 'security') { echo " class=\"sub_nav_current_1\""; }?>><?php print $lang['nav2_security'];?></a></li>
						</ul>
					</li>
<?php } ?>