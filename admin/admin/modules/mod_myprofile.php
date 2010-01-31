<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: My Profile.                                              //
//*****************************************************************//

//add user images?

if ($GLOBALS['pixie_user']) {
	
		$scream = array();

		if ($profile_edit) {
				
				$table_name = 'pixie_users';
				$check = new Validator ();

				if ($realname == "") { $error .= $lang['profile_name_error'] . ' '; $scream[] = 'realname'; }

				if (!$check->validateEmail($email, $lang['profile_email_error'] . ' ')) { $scream[] = 'email'; }
				
				if ($website) {

				if (preg_match('/localhost/i', $website)) {	/* This prevents an error if you are developing locally */
				} else {
				if (preg_match('/127.0.0./', $website)) {	/* This prevents an error if you are developing locally */
				} else {
				if (!$check->validateURL($website, $lang['profile_web_error'] . ' ')) { $scream[] = 'website'; }
				}
				}

				}

				if ($link_1) {
					if (!$check->validateURL($link_1, $lang['profile_web_error'] . ' ')) { $scream[] = 'link_1'; }
				}

				if ($link_2) {
					if (!$check->validateURL($link_2, $lang['profile_web_error'] . ' ')) { $scream[] = 'link_2'; }
				}

				if ($link_3) {
					if (!$check->validateURL($link_3, $lang['profile_web_error'] . ' ')) { $scream[] = 'link_3';	}			
				}
				
				if ($check->foundErrors()) { $error .= $check->listErrors('x'); }

				if (!$error) {
				
					// clean the input
					$realname = sterilise($realname, true);
					$email = sterilise($email, true);
					$biography = mysql_real_escape_string($biography);
					$link_1 = sterilise($link_1, true);
					$link_2 = sterilise($link_2, true);
					$link_3 = sterilise($link_3, true);
					$occupation = sterilise($occupation, true);
					$website = sterilise($website, true);
					$street = sterilise($street, true);
					$town = sterilise($town, true);
					$street = sterilise($street, true);
					$town = sterilise($town, true);
					$county = sterilise($county, true);
					$country = sterilise($country, true);
					$post_code = sterilise($post_code, true);
					$telephone = sterilise($telephone, true);
					$user_id = sterilise($user_id, true);

					$sql = "realname = '$realname', email = '$email', biography = '$biography', link_1 = '$link_1', link_2 = '$link_2', 
					link_3 = '$link_3', occupation = '$occupation', website = '$website', street = '$street', town = '$town', 
					county = '$county', country = '$country', post_code = '$post_code', telephone = '$telephone'";
						
					$ok = safe_update('pixie_users', "$sql", "user_id = '$user_id'");

					if (!$ok) {
						safe_optimize("$table_name");
						safe_repair("$table_name");
				  	$message = $lang['unknown_error']; 
				  } else {
				  	$messageok = $lang['profile_ok'];
				  }

				} else {
					$err = explode('|',$error);
					$message = $err[0];
				}
		}

		if ($profile_pass) {

			sleep(3);

			$r = safe_field('user_name', 'pixie_users', "user_name = '$user_name'and 
			pass = password(lower('" . doSlash($current_pass) . "')) and privs >= 0");
			
			if (!$r) { $error .= $lang['profile_password_invalid'] . ' '; $scream[] = 'current'; }
			if (!$new_password) { $error .= $lang['profile_password_missing'] . ' '; $scream[] = 'new'; }
			if (!$confirm_password) { $error .= $lang['profile_password_missing'] . ' '; $scream[] = 'confirm'; } 
			if (strlen($new_password) < 6) { $error .= $lang['profile_password_invalid_length'] . ' '; $scream[] = 'new'; $scream[] = 'confirm'; } 
			if ($new_password != $confirm_password) { $error .= $lang['profile_password_match_error'] . ' '; $scream[] = 'new'; $scream[] = 'confirm'; }

			if (!$error) {
				$rs = safe_update('pixie_users', "pass = password(lower('$new_password'))","user_name='$user_name'");

				if (!$rs) {
				  	$message = $lang['profile_password_error'];
				  } else {
				  	$email = safe_field('email','pixie_users',"user_name='$user_name'");
						$subject = $lang['email_changepassword_subject'];				
						$emessage = $lang['email_newpassword_message'].$new_password;
						$user = safe_field('user_name','pixie_users',"email='$email'");
						mail($email, $subject, $emessage);
				  	$messageok = $lang['profile_password_ok'];
				  }
			} else {
				$err = explode('|',$error);
				$message = $err[0];
			}
		}

		$uname = safe_field('user_name', 'pixie_users', "user_name='" . $GLOBALS['pixie_user'] . "'");
		$rname = safe_field('realname', 'pixie_users', "user_name='" . $GLOBALS['pixie_user'] . "'");

		print '<h2>' . $rname . ' (' . $uname . ')   </h2>';

switch ($do) {

case 'security' :

		if (in_array('current', $scream)) { $current_style = 'form_highlight'; }
		if (in_array('new', $scream)) { $new_style = 'form_highlight'; }
		if (in_array('confirm', $scream)) { $confirm_style = 'form_highlight'; }

		echo "\n\n\t\t\t\t<div id=\"myprofile_edit\">
 					<form action=\"?s=$s&amp;x=$x&amp;do=security\" method=\"post\" id=\"form_myprofile\" class=\"form\">
 						<fieldset>
 						<legend>Change your password</legend>		
		 					<div class=\"form_row $current_style\">
								<div class=\"form_label\"><label for=\"current_pass\">" . $lang['form_current_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"current_pass\" value=\"\" size=\"40\" maxlength=\"80\" id=\"current_pass\" /></div>
							</div>			
							<div class=\"form_row $new_style\">
								<div class=\"form_label\"><label for=\"new_password\">" . $lang['form_new_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"new_password\" value=\"\" size=\"40\" maxlength=\"80\" id=\"new_password\" /></div>
							</div>
							<div class=\"form_row $confirm_style\">
								<div class=\"form_label\"><label for=\"confirm_password\">" . $lang['form_confirm_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"confirm_password\" value=\"\" size=\"40\" maxlength=\"80\" id=\"confirm_password\" /></div>
							</div>
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"profile_pass\" class=\"form_submit\" value=\"".$lang['form_button_update']."\" />
								<input type=\"hidden\" name=\"user_name\" value=\"" . $GLOBALS['pixie_user'] . "\" maxlength=\"64\" />
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
 					</form>
 				</div>";

break;

default:
		$uname = $GLOBALS['pixie_user'];
		$rs = safe_row('*', 'pixie_users', "user_name = '$uname' limit 0,1");

 		if ($rs && !$error) {
 			extract($rs);
 			$logunix = returnUnixtimestamp($last_access);
			$date = date('l dS M y @ H:i', $logunix);
 		}

		if (in_array('realname', $scream)) { $realname_style = 'form_highlight'; }
		if (in_array('email', $scream)) { $email_style = 'form_highlight'; }
		if (in_array('website', $scream)) { $website_style = 'form_highlight'; }
		if (in_array('link_1', $scream)) { $link_1_style = 'form_highlight'; }
		if (in_array('link_2', $scream)) { $link_2_style = 'form_highlight'; }
		if (in_array('link_3', $scream)) { $link_3_style = 'form_highlight'; }


		echo "\n\n\t\t\t\t<div id=\"myprofile_edit\">
 					<form action=\"?s=$s&amp;x=$x\" method=\"post\" id=\"form_myprofile\" class=\"form\">
 						<fieldset>
 						<legend>Edit your profile</legend>		
							<div class=\"form_row $realname_style\">
								<div class=\"form_label\"><label for=\"realname\">" . $lang['form_name'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"realname\" value=\"$realname\" size=\"40\" maxlength=\"80\" id=\"realname\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"telephone\">" . $lang['form_telephone'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"telephone\" value=\"$telephone\" size=\"40\" maxlength=\"80\" id=\"telephone\" /></div>
							</div>
							<div class=\"form_row $email_style\">
								<div class=\"form_label\"><label for=\"email\">" . $lang['form_email'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"email\" value=\"$email\" size=\"40\" maxlength=\"80\" id=\"email\" /></div>
							</div>
							<div class=\"form_row $website_style\">
								<div class=\"form_label\"><label for=\"website\">" . $lang['form_website'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label><span class=\"form_help\">" . $lang['form_help_site_url'] . "</span></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"website\" value=\"$website\" size=\"40\" maxlength=\"80\" id=\"website\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"occupation\">" . $lang['form_occupation'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"occupation\" value=\"$occupation\" size=\"40\" maxlength=\"80\" id=\"occupation\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"street\">" . $lang['form_address_street'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"street\" value=\"$street\" size=\"40\" maxlength=\"80\" id=\"street\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"town\">" . $lang['form_address_town'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"town\" value=\"$town\" size=\"40\" maxlength=\"80\" id=\"town\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"town\">" . $lang['form_address_county'] . " <span class=\"form_optional\">".$lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"county\" value=\"$county\" size=\"40\" maxlength=\"80\" id=\"county\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"pcode\">" . $lang['form_address_pcode'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"post_code\" value=\"$post_code\" size=\"30\" maxlength=\"80\" id=\"pcode\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"country\">" . $lang['form_address_country'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" name=\"country\" class=\"form_text\" value=\"$country\" size=\"40\" maxlength=\"80\" id=\"country\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"biography\">" . $lang['form_address_biography'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>";

							if ($GLOBALS['rich_text_editor'] == 1) {
	   						echo "\n\t\t\t\t\t\t\t\t<div class=\"mceSwitch\" id=\"biography_mceSwitch\">\n\t\t\t\t\t\t\t\t\t<input type=\"button\" onclick=\"setTextareaToTinyMCE('biography');\" value=\"Editor\" class=\"mceEditorOn mceCurrent\" /><input type=\"button\" onclick=\"unsetTextareaToTinyMCE('biography');\" value=\"HTML\" class=\"mceEditorOff\" />\n\t\t\t\t\t\t\t\t\t<div class=\"form_item_textarea_mce\">\n\t\t\t\t\t\t\t\t\t\t<textarea name=\"biography\" id=\"biography\" cols=\"50\" class=\"mceEditor\" rows=\"10\">$biography</textarea>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   					} else {
	   						echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea\">\n\t\t\t\t\t\t\t\t<textarea name=\"biography\" class=\"form_item_textarea_nomce\">$biography</textarea>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n"; // id=\"$Nams[$j]\"
	   					}

	   				echo "							<div class=\"form_row $link_1_style\">
								<div class=\"form_label\"><label for=\"link_1\">" . $lang['form_fl1'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_1\" value=\"$link_1\" size=\"40\" maxlength=\"80\" id=\"link_1\" /></div>
							</div>
							<div class=\"form_row $link_2_style\">
								<div class=\"form_label\"><label for=\"link_2\">" . $lang['form_fl2'] . "</label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_2\" value=\"$link_2\" size=\"40\" maxlength=\"80\" id=\"link_2\" /></div>
							</div>
							<div class=\"form_row $link_3_style\">
								<div class=\"form_label\"><label for=\"link_3\">" . $lang['form_fl3'] . "</label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_3\" value=\"$link_3\" size=\"40\" maxlength=\"80\" id=\"link_3\" /></div>
							</div>
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"profile_edit\" class=\"form_submit\" value=\"" . $lang['form_button_update'] . "\" />
								<input type=\"hidden\" name=\"user_id\" value=\"$user_id\" maxlength=\"64\" />
							</div>
							<div class=\"safclear\"></div>
						</fieldset>	
 					</form>
 				</div>";
break;
}
}
?>