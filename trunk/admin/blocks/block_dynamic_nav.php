<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../');
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
 * Title: Dynamic Sub Navigation Block
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
global $s, $m, $x, $site_url, $lang;
if ($nested_nav == 'yes') {
?>
					<ul id="sub_navigation_1">
						<li><a href="<?php
	echo createURL($page_name, 'archives');
?>" title="<?php
	print $page_display_name . ': ' . $lang['archives'];
?>"<?php
	if ($m == 'archives') {
		print " class=\"sub_nav_current_1 replace\"";
	} else {
		print " class=\"replace\"";
	}
?>><?php
	print $lang['archives'];
?><span></span></a></li>
						<li><a href="<?php
	echo createURL($page_name, 'popular');
?>" title="<?php
	print $page_display_name . ': ' . $lang['popular_posts'];
?>"<?php
	if ($m == 'popular') {
		print " class=\"sub_nav_current_1 replace\"";
	} else {
		print " class=\"replace\"";
	}
?>><?php
	print $lang['popular_posts'];
?><span></span></a></li>
						<li><a href="<?php
	echo createURL($page_name, 'tags');
?>" title="<?php
	print $page_display_name . ': ' . $lang['tags'];
?>"<?php
	if ($m == 'tags') {
		print " class=\"sub_nav_current_1 replace\"";
	} else {
		print " class=\"replace\"";
	}
?>><?php
	print $lang['tags'];
?><span></span></a></li>
					</ul>
					</li>
<?php
} else {
	echo "\t\t\t\t\t<div id=\"block_dynamic_nav\" class=\"block\">\n\t\t\t\t\t\t<div class=\"block_header\">\n\t\t\t\t\t\t\t<h4>Sub Navigation</h4>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_body\">\n";
?>
							<ul id="sub_navigation_1">
								<li><a href="<?php
	echo createURL($page_name, 'archives');
	;
?>" title="<?php
	print $page_display_name . ': ' . $lang['archives'];
?>"<?php
	if ($m == 'archives') {
		print " class=\"sub_nav_current_1\"";
	}
?>><?php
	print $lang['archives'];
?></a></li>
								<li><a href="<?php
	echo createURL($page_name, 'popular');
?>" title="<?php
	print $page_display_name . ': ' . $lang['popular_posts'];
?>"<?php
	if ($m == 'popular') {
		print " class=\"sub_nav_current_1\"";
	}
?>><?php
	print $lang['popular_posts'];
?></a></li>
								<li><a href="<?php
	echo createURL($page_name, 'tags');
?>" title="<?php
	print $page_display_name . ': ' . $lang['tags'];
?>"<?php
	if ($m == 'tags') {
		print " class=\"sub_nav_current_1\"";
	}
?>><?php
	print $lang['tags'];
?></a></li>
							</ul>
<?php
	echo "\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_footer\"></div>\n\t\t\t\t\t</div>\n";
}
?>