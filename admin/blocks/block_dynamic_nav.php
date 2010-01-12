<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Dynamic Sub Navigation.                                  //
//*****************************************************************//

global $s, $m, $x, $site_url, $lang;

if ($nested_nav == "yes") {
?>
					<ul id="sub_navigation_1">
						<li><a href="<?php echo createURL($page_name, "archives"); ?>" title="<?php print $page_display_name.": ".$lang['archives'];?>"<?php if ($m == "archives") { print " class=\"sub_nav_current_1 replace\"";} else { print " class=\"replace\""; } ?>><?php print $lang['archives']; ?><span></span></a></li>
						<li><a href="<?php echo createURL($page_name, "popular"); ?>" title="<?php print $page_display_name.": ".$lang['popular_posts']; ?>"<?php if ($m == "popular") { print " class=\"sub_nav_current_1 replace\"";} else { print " class=\"replace\""; } ?>><?php print $lang['popular_posts']; ?><span></span></a></li>
						<li><a href="<?php echo createURL($page_name, "tags"); ?>" title="<?php print $page_display_name.": ".$lang['tags'];?>"<?php if ($m == "tags") { print " class=\"sub_nav_current_1 replace\"";} else { print " class=\"replace\""; } ?>><?php print $lang['tags']; ?><span></span></a></li>
					</ul>
					</li>
<?php
} else {
	echo "\t\t\t\t\t<div id=\"block_dynamic_nav\" class=\"block\">\n\t\t\t\t\t\t<div class=\"block_header\">\n\t\t\t\t\t\t\t<h4>Sub Navigation</h4>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_body\">\n";
?>
							<ul id="sub_navigation_1">
								<li><a href="<?php echo createURL($page_name, "archives");; ?>" title="<?php print $page_display_name.": ".$lang['archives'];?>"<?php if ($m == "archives") { print " class=\"sub_nav_current_1\"";}?>><?php print $lang['archives']; ?></a></li>
								<li><a href="<?php echo createURL($page_name, "popular"); ?>" title="<?php print $page_display_name.": ".$lang['popular_posts'];?>"<?php if ($m == "popular") { print " class=\"sub_nav_current_1\"";}?>><?php print $lang['popular_posts']; ?></a></li>
								<li><a href="<?php echo createURL($page_name, "tags"); ?>" title="<?php print $page_display_name.": ".$lang['tags']; ?>"<?php if ($m == "tags") { print " class=\"sub_nav_current_1\"";}?>><?php print $lang['tags']; ?></a></li>
							</ul>
<?php				
	echo "\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_footer\"></div>\n\t\t\t\t\t</div>\n";
}

?>