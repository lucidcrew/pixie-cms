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
 * Title: Nav_Myaccount
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

if ( isset( $GLOBALS['pixie_user'] ) && ( isset( $s ) ) ) {
?>
<ul id="sub_nav_level_1">
				  		<li><a href="?s=<?php
		print $s;
?>" title="<?php
		print $lang['nav2_home'];
?>"<?php
		if ( ( $s == 'myaccount' ) && ( $x != 'myprofile' ) ) {
				if ( $x !== 'logs' ) {
						echo " class=\"sub_nav_current_1\"";
				}
		}
?>><?php
		print $lang['nav2_home'];
?></a></li>
						<li><a href="?s=<?php
		print $s;
?>&amp;x=myprofile" title="<?php
		print $lang['nav2_profile'];
?>"<?php
		if ( ( !isset( $do ) ) && ( !$do ) && ( $x == 'myprofile' ) ) {
				echo " class=\"sub_nav_current_1\"";
		}
?>><?php
		print $lang['nav2_profile'];
?></a></li>
						<li><a href="?s=<?php
		print $s;
?>&amp;x=myprofile&amp;do=security" title="<?php
		print $lang['nav2_security'];
?>"<?php
		if ( $do == 'security' ) {
				echo " class=\"sub_nav_current_1\"";
		}
?>><?php
		print $lang['nav2_security'];
?></a></li>
						</ul>
					</li>
<?php
}
?>