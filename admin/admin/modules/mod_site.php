<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Site Settings.                                           //
//*****************************************************************//

if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 2) {
	
		$scream = array();

		if ((isset($settings_edit)) && ($settings_edit)) {
			
			$check = new Validator ();
			if (!$sitename) { $error .= $lang['site_name_error'] . ' '; $scream[] = 'name'; }
			if (!$url) { $error .= $lang['site_url_error'] . ' '; $scream[] = 'url'; }

				if ($url) {

				    if ( (!preg_match('/localhost/', $url)) && (!preg_match('/127.0.0./', $url)) ) {

					if (!$check->validateURL($url, $lang['site_url_error'] . ' ')) { $scream[] = 'url'; }

				    }

				}

			if ($check->foundErrors()) { $error .= $check->listErrors('x'); }

			$sitename = addslashes($sitename);	/* Helps prevents a bug where a ' in a string like : dave's site, errors out the admin interface */
			$sitename = htmlentities($sitename);	/* Same as above */

			$table_name = 'pixie_settings';
			$site_url_last = $url { strlen($url) - 1 };
			
  		if ($site_url_last != '/') {
  			$url = $url . '/';
  		}

  		$err = explode('|', $error);

  		if (!isset($error)) {
				$ok = safe_update('pixie_settings', 
									"site_name = '$sitename', 
									site_url = '$url', 
									site_keywords = '$keywords', 
									site_author = '$site_auth',
									site_copyright = '$site_cright',
									default_page = '$default',
									clean_urls = '$cleanurls'",
									"settings_id ='1'");
  		}

			if (!$ok) {
				$message = $err[0];
				if (!$message) {
			  	$message = $lang['error_save_settings'];
				}
				$site_name = $sitename;
				$site_url = $url;
				$site_keywords = $keywords;
				$site_author = $site_auth;
				$site_copyright = $site_cright;
				$default_page = $default;
			} else {
				if (isset($table_name)) { safe_optimize("$table_name"); safe_repair("$table_name"); }
				$messageok = $lang['ok_save_settings'];
				$prefs = get_prefs();
				extract($prefs);
			}
		} else {
			$prefs = get_prefs();
			extract($prefs);
		}

		if (in_array('name', $scream)) { $name_style = 'form_highlight'; }
		if (in_array('url', $scream)) { $url_style = 'form_highlight'; }
		
		echo "<h2>" . $lang['nav2_site'] . " " . $lang['nav2_settings'] . "</h2>";
		echo "\n\n\t\t\t\t<div id=\"site_settings\">
 					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x\" method=\"post\" id=\"form_settings\" class=\"form\">	
 						<fieldset>	
 						<legend>" . $lang['form_legend_site_settings'] . "</legend>
							<div class=\"form_row "; if (isset($name_style)) { echo $name_style; } echo "\">
								<div class=\"form_label\"><label for=\"site_name\">" . $lang['form_site_name'] . " <span class=\"form_required\">" . $lang['form_required']."</span></label><span class=\"form_help\">" . $lang['form_help_site_name'] . "</span></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"sitename\" value=\"$site_name\" size=\"40\" maxlength=\"80\" id=\"site_name\" /></div>
							</div>
							<div class=\"form_row "; if (isset($url_style)) { echo $url_style; } echo "\">
								<div class=\"form_label\"><label for=\"url\">" . $lang['form_site_url'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_site_url'] . "</span></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"url\" value=\"$site_url\" size=\"40\" maxlength=\"80\" id=\"url\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"default\">" . $lang['form_site_homepage'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_homepage'] . "</span></div>";

								$all = safe_rows('*', 'pixie_core', "public='yes'");
								$num = count($all);
							 	$i = 0;
							 	echo "\n\t\t\t\t\t\t\t\t<div class=\"form_item_drop\"><select class=\"form_select\" name=\"default\" id=\"default\">\n";
							 							
							 	while ($i < $num){
							 	$out = $all[$i];
  								$module_display_name = $out['page_display_name'];
  								$module_name = $out['page_name'];
  								$page_type = $out['page_type'];
								if (($module_name == 404) || ($module_name == 'navigation') || ($module_name == 'rss')) {
  									//	do nothing
  								} else if ($page_type == 'plugin') {
  									// do nothing again
  								} else {
							    	if ($default_page == $module_name . '/') {
								 			print "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$module_name/\">$module_display_name</option>\n";
								 		} else {
								 			print "\t\t\t\t\t\t\t\t\t<option value=\"$module_name/\">$module_display_name</option>\n";
								 		} 
  								}
							 	$i++;
							 	}
							echo "\t\t\t\t\t\t\t\t</select></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"keywords\">" . $lang['form_site_keywords'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label><span class=\"form_help\">" . $lang['form_help_site_keywords'] . "</span></div>
								<div class=\"form_item_textarea\"><textarea name=\"keywords\" cols=\"50\" class=\"form_item_textarea_no_ckeditor\" rows=\"3\" id=\"keywords\">$site_keywords</textarea></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"site_author\">" . $lang['form_site_author'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" name=\"site_auth\" class=\"form_text\" value=\"$site_author\" size=\"40\" maxlength=\"80\" id=\"site_author\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"site_copyright\">" . $lang['form_site_copyright'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" name=\"site_cright\" class=\"form_text\" value=\"$site_copyright\" size=\"40\" maxlength=\"80\" id=\"site_copyright\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"cleanurls\">" . $lang['form_site_curl'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_site_curl'] . "</span></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"cleanurls\" id=\"cleanurls\">";
								if ($clean_urls == 'yes') { echo "<option selected=\"selected\" value=\"yes\">Yes</option>"; } else { echo "<option value=\"yes\">Yes</option>"; }
								if ($clean_urls == 'no') { echo "<option selected=\"selected\" value=\"no\">No</option>"; } else { echo "<option value=\"no\">No</option>"; }
							echo "</select></div>
							</div>
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"settings_edit\" class=\"form_submit\" id=\"form_addedit_submit\" value=\"" . $lang['form_button_update'] . "\" />
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
	 				</form>
	 			</div>";
}
?>