<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
		header( 'Location: ../../../' );
		exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: Nav_Settings
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 * @todo Tag release for Pixie 1.04
 *
 */

if ( isset( $GLOBALS['pixie_user'] ) && $GLOBALS['pixie_user_privs'] >= 2 ) {
		if ( ( !$m ) && ( !$x ) ) {
				$x = 'pages';
		}
		
		if ( isset( $s ) ) {
?>
<ul id="sub_nav_level_1">
						<li><a href="?s=<?php
				print $s;
?>&amp;x=pages" title="<?php
				print $lang['nav2_pages'] . " " . $lang['nav2_settings'];
?>"<?php
				if ( $x == 'pages' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_pages'];
?></a></li>
						<li><a href="?s=<?php
				print $s;
?>&amp;x=site" title="<?php
				print $lang['nav2_site'] . " " . $lang['nav2_settings'];
?>"<?php
				if ( $x == 'site' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_site'];
?></a></li>
						<li><a href="?s=<?php
				print $s;
?>&amp;x=pixie" title="Pixie <?php
				print $lang['nav2_settings'];
?>"<?php
				if ( $x == 'pixie' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>>Pixie</a></li>
						<!--<li><a href="?s=<?php
				print $s;
?>&amp;m=blocks" title="<?php
				print $lang['nav2_blocks'];
?>"<?php
				if ( $m == "blocks" ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_blocks'];
?></a></li>-->
						<li><a href="?s=<?php
				print $s;
?>&amp;x=theme" title="<?php
				print $lang['nav2_theme'] . " " . $lang['nav2_settings'];
?>"<?php
				if ( $x == 'theme' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_theme'];
?></a></li>
						<li><a href="?s=<?php
				print $s;
?>&amp;x=users" title="<?php
				print $lang['nav2_users'];
?>"<?php
				if ( $x == 'users' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_users'];
?></a></li>
						<li><a href="?s=<?php
				print $s;
?>&amp;x=dbtools" title="<?php
				print $lang['nav2_backup'];
?>"<?php
				if ( $x == 'dbtools' ) {
						echo " class=\"sub_nav_current_1\"";
				}
?>><?php
				print $lang['nav2_backup'];
?></a></li>
					</ul>
<?php
		}
?></li>
<?php
}
/* Again, what is this trailing li tag above for? Please explain or remove */
?>