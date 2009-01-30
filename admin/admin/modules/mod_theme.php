<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Theme Settings.                                          //
//*****************************************************************//

if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {
	
	if ($do) {
		if (file_exists("themes/".$do)) {
			$ok = safe_update("pixie_settings",  
												 "site_theme = '$do'",
												 "settings_id ='1'");
		}
		if ($ok) {
			$messageok = $lang['theme_ok'];
		} else {
			$message = $lang['theme_error'];
		}
	}

	$prefs = get_prefs();
	extract($prefs);
	echo "<h2>".$lang['nav2_theme']."</h2>\n\t\t\t\t<p>".$lang['theme_info']."</p>";
	echo "\n\n\t\t\t\t<div id=\"themes\">\n\t\t\t\t\t<h3>".$lang['theme_pick']."</h3>\n";
	
	$dir="themes/";
  	if (is_dir($dir)) {
  		$fd = @opendir($dir);
    	if($fd) {
      	while (($part = @readdir($fd)) == true) {
        	if ($part != "." && $part != "..") {
         		$newdir = $dir.$part;   
         		if (is_dir($newdir)) {
					include "themes/$part/settings.php";
          		if ($part == $site_theme) {
          			echo "\t\t\t\t\t<div class=\"atheme currenttheme\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\"><img src=\"themes/$part/thumb.jpg\" alt=\"".$lang['nav2_theme'].": $theme_name\" class=\"ticon\"/></a><span class=\"tname\">$theme_name</span><span class=\"tcreator\">".$lang['by']." <a href=\"$theme_link\">$theme_creator</a></span><span class=\"tselect\">Current theme</span></div>\n"; 
          		} else { 
          			echo "\t\t\t\t\t<div class=\"atheme\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\"><img src=\"themes/$part/thumb.jpg\" alt=\"".$lang['nav2_theme'].": $theme_name\" class=\"ticon\"/></a><span class=\"tname\">$theme_name</span><span class=\"tcreator\">".$lang['by']." <a href=\"$theme_link\">$theme_creator</a></span><span class=\"tselect\"><a href=\"?s=$s&amp;x=$x&amp;do=$part\" title=\"".$lang['theme_apply']."\">".$lang['theme_apply']."</a></span></div>\n"; 
          		}	
        		}
      		}
    		}
  		}
  	}
		echo "\t\t\t\t</div>";
}
?>