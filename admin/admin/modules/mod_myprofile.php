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
 * Title: My Profile
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

/* Add user images? */

if ( isset( $GLOBALS['pixie_user'] ) ) {
		$scream = array();
		
		if ( ( isset( $profile_edit ) ) && ( $profile_edit ) ) {
				$table_name = 'pixie_users';
				$check      = new Validator();
				
				if ( ( !isset( $realname ) ) or ( $realname == "" ) ) {
						$error .= $lang['profile_name_error'] . ' ';
						$scream[] = 'realname';
				}
				
				if ( ( !isset( $email ) ) or ( !$check->validateEmail( $email, $lang['profile_email_error'] . ' ' ) ) ) {
						$scream[] = 'email';
				}
				
				if ( $website ) {
						if ( ( !preg_match( '/localhost/', $website ) ) && ( !preg_match( '/127.0.0./', $website ) ) ) {
								if ( !$check->validateURL( $website, $lang['profile_web_error'] . ' ' ) ) {
										$scream[] = 'website';
								}
								
						}
						
				}
				
				if ( $link_1 ) {
						if ( !$check->validateURL( $link_1, $lang['profile_web_error'] . ' ' ) ) {
								$scream[] = 'link_1';
						}
				}
				
				if ( $link_2 ) {
						if ( !$check->validateURL( $link_2, $lang['profile_web_error'] . ' ' ) ) {
								$scream[] = 'link_2';
						}
				}
				
				if ( $link_3 ) {
						if ( !$check->validateURL( $link_3, $lang['profile_web_error'] . ' ' ) ) {
								$scream[] = 'link_3';
						}
				}
				
				if ( $check->foundErrors() ) {
						$error .= $check->listErrors( 'x' );
				}
				
				if ( !isset( $error ) ) {
						// clean the input
						$realname   = sterilise( $realname, TRUE );
						$email      = sterilise( $email, TRUE );
						$biography  = mysql_real_escape_string( $biography );
						$link_1     = sterilise( $link_1, TRUE );
						$link_2     = sterilise( $link_2, TRUE );
						$link_3     = sterilise( $link_3, TRUE );
						$occupation = sterilise( $occupation, TRUE );
						$website    = sterilise( $website, TRUE );
						$street     = sterilise( $street, TRUE );
						$town       = sterilise( $town, TRUE );
						$street     = sterilise( $street, TRUE );
						$town       = sterilise( $town, TRUE );
						$county     = sterilise( $county, TRUE );
						$country    = sterilise( $country, TRUE );
						$post_code  = sterilise( $post_code, TRUE );
						$telephone  = sterilise( $telephone, TRUE );
						$user_id    = sterilise( $user_id, TRUE );
						
						$sql = "realname = '$realname', email = '$email', biography = '$biography', link_1 = '$link_1', link_2 = '$link_2', 
					link_3 = '$link_3', occupation = '$occupation', website = '$website', street = '$street', town = '$town', 
					county = '$county', country = '$country', post_code = '$post_code', telephone = '$telephone'";
						
						$ok = safe_update( 'pixie_users', "$sql", "user_id = '$user_id'" );
						
						if ( !$ok ) {
								if ( isset( $table_name ) ) {
										safe_optimize( "$table_name" );
										safe_repair( "$table_name" );
								}
								$message = $lang['unknown_error'];
						} else {
								$messageok = $lang['profile_ok'];
						}
						
				} else {
						$err     = explode( '|', $error );
						$message = $err[0];
				}
		}
		
		if ( ( isset( $profile_pass ) ) && ( $profile_pass ) ) {
				sleep( 3 );
				
				/* $new_password = addslashes($new_password); */
				/* Unfortunately, you can become permenatly logged out if you use a " in a password */
				/* $confirm_password = addslashes($confirm_password); */
				/* If we do this first, then we need to do stripslashes() when it comes out, potentially breaking compatibility with upgraders */
				
				$r = safe_field( 'user_name', 'pixie_users', "user_name = '$user_name'and 
			pass = password(lower('" . doSlash( $current_pass ) . "')) and privs >= 0" );
				
				if ( !$r ) {
						$error .= $lang['profile_password_invalid'] . ' ';
						$scream[] = 'current';
				}
				if ( !$new_password ) {
						$error .= $lang['profile_password_missing'] . ' ';
						$scream[] = 'new';
				}
				if ( !$confirm_password ) {
						$error .= $lang['profile_password_missing'] . ' ';
						$scream[] = 'confirm';
				}
				if ( strlen( $new_password ) < 6 ) {
						$error .= $lang['profile_password_invalid_length'] . ' ';
						$scream[] = 'new';
						$scream[] = 'confirm';
				}
				if ( $new_password != $confirm_password ) {
						$error .= $lang['profile_password_match_error'] . ' ';
						$scream[] = 'new';
						$scream[] = 'confirm';
				}
				
				if ( !isset( $error ) ) {
						$rs = safe_update( 'pixie_users', "pass = password(lower('$new_password'))", "user_name='$user_name'" );
						
						if ( !$rs ) {
								$message = $lang['profile_password_error'];
						} else {
								$email   = safe_field( 'email', 'pixie_users', "user_name='$user_name'" );
								$subject = $lang['email_changepassword_subject'];
								if ( !isset( $subject ) ) {
										$subject = NULL;
								}
								$emessage = $lang['email_newpassword_message'] . $new_password;
								$user     = safe_field( 'user_name', 'pixie_users', "email='$email'" );
								mail( $email, $subject, $emessage );
								$messageok = $lang['profile_password_ok'];
						}
				} else {
						$err     = explode( '|', $error );
						$message = $err[0];
				}
		}
		
		$uname = safe_field( 'user_name', 'pixie_users', "user_name='" . $GLOBALS['pixie_user'] . "'" );
		$rname = safe_field( 'realname', 'pixie_users', "user_name='" . $GLOBALS['pixie_user'] . "'" );
		
		print '<h2>' . $rname . ' (';
		if ( isset( $uname ) ) {
				print $uname;
		}
		print ')   </h2>';
		
		switch ( $do ) {
				
				case 'security':
						
						if ( in_array( 'current', $scream ) ) {
								$current_style = 'form_highlight';
						}
						if ( in_array( 'new', $scream ) ) {
								$new_style = 'form_highlight';
						}
						if ( in_array( 'confirm', $scream ) ) {
								$confirm_style = 'form_highlight';
						}
						
						echo "\n\n\t\t\t\t<div id=\"myprofile_edit\">
 					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x&amp;do=security\" method=\"post\" id=\"form_myprofile\" class=\"form\">
 						<fieldset>
 						<legend>Change your password</legend>		
		 					<div class=\"form_row ";
						if ( isset( $current_style ) ) {
								echo $current_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"current_pass\">" . $lang['form_current_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"current_pass\" value=\"\" size=\"40\" maxlength=\"80\" id=\"current_pass\" /></div>
							</div>			
							<div class=\"form_row ";
						if ( isset( $new_style ) ) {
								echo $new_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"new_password\">" . $lang['form_new_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"new_password\" value=\"\" size=\"40\" maxlength=\"80\" id=\"new_password\" /></div>
							</div>
							<div class=\"form_row ";
						if ( isset( $confirm_style ) ) {
								echo $confirm_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"confirm_password\">" . $lang['form_confirm_password'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"password\" class=\"form_text\" name=\"confirm_password\" value=\"\" size=\"40\" maxlength=\"80\" id=\"confirm_password\" /></div>
							</div>
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"profile_pass\" class=\"form_submit\" value=\"" . $lang['form_button_update'] . "\" />
								<input type=\"hidden\" name=\"user_name\" value=\"" . $GLOBALS['pixie_user'] . "\" maxlength=\"64\" />
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
 					</form>
 				</div>";
						
						break;
				
				default:
						$uname = $GLOBALS['pixie_user'];
						if ( isset( $uname ) ) {
								$rs = safe_row( '*', 'pixie_users', "user_name = '$uname' limit 0,1" );
						}
						
						if ( $rs && !isset( $error ) ) {
								extract( $rs );
								$logunix = returnUnixtimestamp( $last_access );
								$date    = date( 'l dS M y @ H:i', $logunix );
						}
						
						if ( in_array( 'realname', $scream ) ) {
								$realname_style = 'form_highlight';
						}
						if ( in_array( 'email', $scream ) ) {
								$email_style = 'form_highlight';
						}
						if ( in_array( 'website', $scream ) ) {
								$website_style = 'form_highlight';
						}
						if ( in_array( 'link_1', $scream ) ) {
								$link_1_style = 'form_highlight';
						}
						if ( in_array( 'link_2', $scream ) ) {
								$link_2_style = 'form_highlight';
						}
						if ( in_array( 'link_3', $scream ) ) {
								$link_3_style = 'form_highlight';
						}
						
						
						echo "\n\n\t\t\t\t<div id=\"myprofile_edit\">
 					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x\" method=\"post\" id=\"form_myprofile\" class=\"form\">
 						<fieldset>
 						<legend>Edit your profile</legend>		
							<div class=\"form_row ";
						if ( isset( $realname_style ) ) {
								echo $realname_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"realname\">" . $lang['form_name'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"realname\"";
						if ( isset( $realname ) ) {
								echo " value=\"$realname\"";
						}
						echo " size=\"40\" maxlength=\"80\" id=\"realname\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"telephone\">" . $lang['form_telephone'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"telephone\" value=\"$telephone\" size=\"40\" maxlength=\"80\" id=\"telephone\" /></div>
							</div>
							<div class=\"form_row ";
						if ( isset( $email_style ) ) {
								echo $email_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"email\">" . $lang['form_email'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"email\" value=\"$email\" size=\"40\" maxlength=\"80\" id=\"email\" /></div>
							</div>
							<div class=\"form_row ";
						if ( isset( $website_style ) ) {
								echo $website_style;
						}
						echo "\">
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
								<div class=\"form_label\"><label for=\"town\">" . $lang['form_address_county'] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
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
						
						if ( $GLOBALS['rich_text_editor'] == 1 ) {
								echo "\n\t\t\t\t\t\t\t\t<div class=\"form_item_textarea_ckeditor\">\n\t\t\t\t\t\t\t\t\t\t<textarea name=\"biography\" id=\"biography\" cols=\"50\" class=\"ck-textarea\" rows=\"10\">$biography</textarea>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n";
						} else {
								echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea\">\n\t\t\t\t\t\t\t\t<textarea name=\"biography\" class=\"form_item_textarea_no_ckeditor\">$biography</textarea>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n"; // id=\"$Nams[$j]\"
						}
						
						echo "		<div class=\"form_row ";
						if ( isset( $link_1_style ) ) {
								echo $link_1_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"link_1\">";
						if ( isset( $lang['form_fl1'] ) ) {
								echo $lang['form_fl1'];
						}
						echo " <span class=\"form_optional\">" . $lang['form_optional'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_1\" value=\"$link_1\" size=\"40\" maxlength=\"80\" id=\"link_1\" /></div>
							</div>
							<div class=\"form_row ";
						if ( isset( $link_2_style ) ) {
								echo $link_2_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"link_2\">";
						if ( isset( $lang['form_fl2'] ) ) {
								echo $lang['form_fl2'];
						}
						echo " </label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_2\" value=\"$link_2\" size=\"40\" maxlength=\"80\" id=\"link_2\" /></div>
							</div>
							<div class=\"form_row ";
						if ( isset( $link_3_style ) ) {
								echo $link_3_style;
						}
						echo "\">
								<div class=\"form_label\"><label for=\"link_3\">";
						if ( isset( $lang['form_fl3'] ) ) {
								echo $lang['form_fl3'];
						}
						echo " </label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"link_3\" value=\"$link_3\" size=\"40\" maxlength=\"80\" id=\"link_3\" /></div>
							</div>";
						echo "		<div class=\"form_row_button\" id=\"form_button\">
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