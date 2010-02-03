<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Site Settings.                                           //
//*****************************************************************//

if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {

		if ($settings_edit) {
			$table_name = 'pixie_settings';
			$ok = safe_update('pixie_settings',  
								"rich_text_editor = '$rte', 
								logs_expire = '$logs', 
								system_message = '$sysmess',
								timezone = '$time_zone',
								date_format = '$dateformat',
								language = '$langu',
								dst = '$dstime'",
								"settings_id ='1'");

			if (!$ok) {
			  $message = $lang['error_save_settings'];
			} else {
				safe_optimize("$table_name");
				safe_repair("$table_name");
			  $messageok = $lang['ok_save_settings'];
			}
		}

		$prefs = get_prefs();
		extract($prefs);
		echo "<h2>Pixie " . $lang['nav2_settings'] . "</h2>";		
		echo "\n\n\t\t\t\t<div id=\"pixie_settings\">
 					<form action=\"?s=$s&amp;x=$x\" method=\"post\" id=\"form_settings\" class=\"form\">	
 						<fieldset>	
 						<legend>" . $lang['form_legend_pixie_settings'] . "</legend>
 							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"langu\">" . $lang['form_pixie_language'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_language'] . "</span></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"langu\" id=\"langu\">";
								// list all languages here
								if ($language == 'cz') { echo "<option selected=\"selected\" value=\"cz\">Čeština</option>"; } else { echo "<option value=\"cz\">Čeština</option>"; } /* Czech */
								if ($language == 'de') { echo "<option selected=\"selected\" value=\"de\">Deutsch</option>"; } else { echo "<option value=\"de\">Deutsch</option>"; } /* German */
								if ($language == 'dutch-nl') { echo "<option selected=\"selected\" value=\"dutch-nl\">Nederlandse</option>"; } else { echo "<option value=\"dutch-nl\">Nederlandse</option>"; } /* Dutch */
								if ($language == 'en-gb') { echo "<option selected=\"selected\" value=\"en-gb\">English (GB)</option>"; } else { echo "<option value=\"en-gb\">English (GB)</option>"; } /* English (GB) */
								if ($language == 'es-cl') { echo "<option selected=\"selected\" value=\"es-cl\">Espanyol (català)</option>"; } else { echo "<option value=\"es-cl\">Espanyol (català)</option>"; } /* Spanish (Catalan) */
								if ($language == 'es-es') { echo "<option selected=\"selected\" value=\"es-es\">Español</option>"; } else { echo "<option value=\"es-es\">Español</option>"; } /* Spanish */
								if ($language == 'es-gl') { echo "<option selected=\"selected\" value=\"es-gl\">Español (Galego)</option>"; } else { echo "<option value=\"es-gl\">Español (Galego)</option>"; } /* Spanish (Galician) */
								if ($language == 'fi-fi') { echo "<option selected=\"selected\" value=\"fi-fi\">Suomen</option>"; } else { echo "<option value=\"fi-fi\">Suomen</option>"; } /* Finnish */
								if ($language == 'fr') { echo "<option selected=\"selected\" value=\"fr\">Français</option>"; } else { echo "<option value=\"fr\">Français</option>"; } /* French */
								if ($language == 'it') { echo "<option selected=\"selected\" value=\"it\">Italiano</option>"; } else { echo "<option value=\"it\">Italiano</option>"; } /* Italian */
								if ($language == 'lv-lv') { echo "<option selected=\"selected\" value=\"lv-lv\">Latviešu</option>"; } else { echo "<option value=\"lv-lv\">Latviešu</option>"; } /* Latvian */
								if ($language == 'pl') { echo "<option selected=\"selected\" value=\"pl\">Polskie</option>"; } else { echo "<option value=\"pl\">Polskie</option>"; } /* Polish */
								if ($language == 'pt') { echo "<option selected=\"selected\" value=\"pt\">Português</option>"; } else { echo "<option value=\"pt\">Português</option>"; } /* Portuguese */
								if ($language == 'ru') { echo "<option selected=\"selected\" value=\"ru\">Русский</option>"; } else { echo "<option value=\"ru\">Русский</option>"; } /* Russian */
								if ($language == 'se-sv') { echo "<option selected=\"selected\" value=\"se-sv\">Svenska</option>"; } else { echo "<option value=\"se-sv\">Svenska</option>"; } /* Swedish */
						echo "</select></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"timezone\">" . $lang['form_pixie_timezone'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_timezone'] . "</span></div>
									<div class=\"form_item_drop\">
								<select class=\"form_select\" name=\"time_zone\" id=\"timezone\">\n";

									$tz = array(-12, -11, -10, -9.5, -9, -8.5, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0, +1, +2, +3, +3.5, +4, +4.5, +5, +5.5, +6, +6.5, +7, +8, +9, +9.5, +10, +10.5, +11, +11.5, +12, +13, +14,);
									$vals = array();

									foreach ($tz as $z)
									{
										$sign = ($z >= 0 ? '+' : '');
										$label = sprintf('GMT %s%02d:%02d', $sign, $z, abs($z - (int)$z) * 60);
										$vals[sprintf('%s%d', $sign, $z * 3600)] = $label;
										$value = "$sign".($z * 3600);
										if ($timezone == $value) {
											print "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$value\">$label</option>\n";
										} else {
											print "\t\t\t\t\t\t\t\t\t<option value=\"$value\">$label</option>\n";
										}
									}
															
				echo "\t\t\t\t\t\t\t\t</select>
									</div>
								</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"dst\">" . $lang['form_pixie_dst'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_dst'] . "</span></div>
								<div class=\"form_item_radio\">";
								echo "Yes<input type=\"radio\"" . ($dst == 'yes' ? " checked=\"checked\"" : "") . " name=\"dstime\" class=\"form_radio\" value=\"yes\" />";
								echo "No<input type=\"radio\"" . ($dst == 'no' ? " checked=\"checked\"" : "") . " name=\"dstime\" class=\"form_radio\" value=\"no\" />";
						echo "</div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"dateformat\">" . $lang['form_pixie_date'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_date'] . "</span></div>
								<div class=\"form_item_drop\">
								<select class=\"form_select\" name=\"dateformat\" id=\"dateformat\">\n";

									$dayname = '%A';
									$dayshort = '%a';
									$daynum = is_numeric(strftime('%e')) ? '%e' : '%d';
									$daynumlead = '%d';
									$daynumord = is_numeric(substr(trim(strftime('%Oe')), 0, 1)) ? '%Oe' : $daynum;
									$monthname = '%B';
									$monthshort = '%b';
									$monthnum = '%m';
									$year = '%Y';
									$yearshort = '%y';
									$time24 = '%H:%M';
									$time12 = strftime('%p') ? '%I:%M %p' : $time24;
									$date = strftime('%x') ? '%x' : '%Y-%m-%d';
							
									$formats = array(
										"$monthshort $daynumord, $time12",
										"$daynum.$monthnum.$yearshort",
										"$daynumord $monthname, $time12",
										"$yearshort.$monthnum.$daynumlead, $time12",
										"$dayshort $monthshort $daynumord, $time12",
										"$dayname $monthname $daynumord, $year",
										"$dayname $monthname $daynumord, $year @ $time24",
										"$monthshort $daynumord",
										"$daynumord $monthname $yearshort",
										"$daynumord $monthnum $year - $time24",
										"$daynumord $monthname $year",
										"$daynumord $monthname $year, $time24",
										"$daynumord. $monthname $year",
										"$daynumord. $monthname $year, $time24",
										"$year-$monthnum-$daynumlead",
										"$year-$daynumlead-$monthnum",
										"$date $time12",
										"$date",
										"$time24",
										"$time12",
										"$year-$monthnum-$daynumlead $time24",
									);
							
									$ts = time()+tz_offset();
									$vals = array();
							
									foreach ($formats as $f)
									{
										if ($d = safe_strftime($f, $ts))
										{
											$vals[$f] = $d;
											if ($f == $date_format) {
												print "\t\t\t\t\t\t\t\t\t<option selected=\"selected\" value=\"$f\">$d</option>\n";
											} else {
												print "\t\t\t\t\t\t\t\t\t<option value=\"$f\">$d</option>\n";
											}
										}
									}

								
							echo "\t\t\t\t\t\t\t\t</select>
								</div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"rte\">" . $lang['form_pixie_rte'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_rte'] . "</span></div>
								<div class=\"form_item_radio\">";
								echo "On<input type=\"radio\"" . ($rich_text_editor == 1 ? " checked=\"checked\"" : "") . " name=\"rte\" class=\"form_radio\" value=\"1\" />";
								echo "Off<input type=\"radio\"" . ($rich_text_editor == 0 ? " checked=\"checked\"" : "") . " name=\"rte\" class=\"form_radio\" value=\"0\" />";
							echo "	</div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"logs\">" . $lang['form_pixie_logs'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_logs'] . "</span></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"logs\" id=\"logs\">";
								if ($logs_expire == 5) { echo "<option selected=\"selected\" value=\"5\">5</option>"; } else { echo "<option value=\"5\">5</option>"; }
								if ($logs_expire == 10) { echo "<option selected=\"selected\" value=\"10\">10</option>"; } else { echo "<option value=\"10\">10</option>"; }
								if ($logs_expire == 15) { echo "<option selected=\"selected\" value=\"15\">15</option>"; } else { echo "<option value=\"15\">15</option>"; }
								if ($logs_expire == 30) { echo "<option selected=\"selected\" value=\"30\">30</option>"; } else { echo "<option value=\"30\">30</option>"; }
							echo "	</select></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"sysmess\">" . $lang['form_pixie_sysmess'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label><span class=\"form_help\">" . $lang['form_help_pixie_sysmess'] . "</span></div>
								<div class=\"form_item_textarea\"><textarea name=\"sysmess\" cols=\"50\" class=\"form_item_textarea_no_ckeditor\" rows=\"3\" id=\"sysmess\">$system_message</textarea></div>
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