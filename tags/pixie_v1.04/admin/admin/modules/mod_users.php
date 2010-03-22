<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../../');
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
 * Title: Users
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
/* User photos would be nice! */
if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 2) {
	$scream = array();
	if ((isset($del)) && ($del)) {
		$cuser = $GLOBALS['pixie_user'];
		$rs    = safe_row('*', 'pixie_users', "user_id = '$del' limit 0,1");
		extract($rs);
		if ($privs != '3') {
			$delete = safe_delete('pixie_users', "user_id='$del'");
		}
		if ((isset($delete)) && (isset($realname))) {
			$emessage = $lang['email_account_close_message'];
			$subject  = $lang['email_account_close_subject'];
			if (!isset($subject)) {
				$subject = NULL;
			}
			if (isset($email)) {
				mail($email, $subject, $emessage);
			}
			$messageok = $lang['user'] . " " . $realname . " " . $lang['user_delete_ok'];
			logme($messageok, 'no', 'user');
			safe_optimize('pixie_users');
			safe_repair('pixie_users');
		} else {
			$message = $lang['user_delete_error'] . " " . $realname;
			logme($message, 'no', 'user');
		}
	}
	if ((isset($user_edit)) && ($user_edit)) {
		$table_name = 'pixie_users';
		$check      = new Validator();
		if ((!isset($uname)) or ($uname == "")) {
			$error .= $lang['user_name_missing'] . ' ';
			$scream[] = 'uname';
		}
		if (!isset($uname)) {
			$uname = str_replace(" ", "", preg_replace('/\s\s+/', ' ', trim($uname)));
		}
		if ((!isset($realname)) or ($realname == "")) {
			$error .= $lang['user_realname_missing'] . ' ';
			$scream[] = "realname";
		}
		if ((!isset($email)) or (!$check->validateEmail($email, $lang['user_email_error'] . ' '))) {
			$scream[] = 'email';
		}
		if ($check->foundErrors()) {
			$error .= $check->listErrors('x');
		}
		if (!isset($error)) {
			$sql = "user_name = '$uname', realname = '$realname', email = '$email', privs = '$privilege'";
			$ok  = safe_update('pixie_users', "$sql", "user_id = '$user_id'");
			if (!$ok) {
				$message = $lang['unknown_error'];
			} else {
				$messageok = $lang['user_update_ok'] . " " . $realname . '.';
				// needs to be added to language file
				$emessage  = "
Your account information has been changed @ $site_url. Your new information is:

username: $uname
email: $email

* your password has not been changed.

visit: " . $site_url . "admin to login.";
				$subject   = $lang['email_account_edit_subject'];
				if (!isset($subject)) {
					$subject = NULL;
				}
				mail($email, $subject, $emessage);
				logme($messageok, 'no', 'user');
			}
		} else {
			$edit = $user_id;
			if (isset($uname)) {
				$user_name = $uname;
			}
			$err     = explode("|", $error);
			$message = $err[0];
		}
	}
	if ((isset($user_new)) && ($user_new)) {
		$table_name = 'pixie_users';
		$check      = new Validator();
		if ((!isset($uname)) or ($uname == "")) {
			$error .= $lang['user_name_missing'] . ' ';
			$scream[] = 'uname';
		}
		if (isset($uname)) {
			$uname = str_replace(" ", "", preg_replace('/\s\s+/', ' ', trim($uname)));
		}
		if ((!isset($realname)) or ($realname == "")) {
			$error .= $lang['user_realname_missing'] . ' ';
			$scream[] = 'realname';
		}
		if ((!isset($email)) or (!$check->validateEmail($email, $lang['user_email_error'] . ' '))) {
			$scream[] = 'email';
		}
		if ($check->foundErrors()) {
			$error .= $check->listErrors('x');
		}
		if (!isset($error)) {
			$password = generate_password(6);
			$nonce    = md5(uniqid(rand(), TRUE));
			$sql      = "user_name = '$uname', realname = '$realname', email = '$email', pass = password(lower('$password')), nonce = '$nonce', privs = '$privilege', link_1 = 'http://www.toggle.uk.com', link_2 = 'http://www.getpixie.co.uk', link_3 = 'http://www.iwouldlikeawebsite.com', biography=''";
			if (isset($table_name)) {
				$ok = safe_insert($table_name, $sql);
			}
			if (!$ok) {
				$message = $lang['user_duplicate'];
				$do      = 'newuser';
			} else {
				// needs to be added to language file
				$emessage = "
			
You have been invited to help maintain the website $site_url. Your account information is:

username: $uname
password: $password

visit: " . $site_url . "admin to login.";
				$subject  = $lang['email_account_new_subject'];
				if (!isset($subject)) {
					$subject = NULL;
				}
				mail($email, $subject, $emessage);
				$messageok = "{$lang['user_new_ok']} {$realname}  :::  [ {$lang['form_username']} : {$uname} ]  :::  [ {$lang['form_password']} : {$password} ]";
				$logok = "{$lang['user_new_ok']} {$realname}";
				logme($logok, 'no', 'user');
			}
		} else {
			$do      = 'newuser';
			$err     = explode('|', $error);
			$message = $err[0];
		}
	}
	if ((isset($edit)) && ($edit)) {
		if ((!isset($user_edit)) or (!$user_edit)) {
			$rs = safe_row('*', 'pixie_users', "user_id = '$edit' limit 0,1");
			if ($rs) {
				extract($rs);
			}
		}
		if (($privs == 3) && ($GLOBALS['pixie_user_privs'] != 3)) {
			// editing of super user is not allowed unless you are super user
		} else {
			if (in_array('email', $scream)) {
				$email_style = 'form_highlight';
			}
			if (in_array('uname', $scream)) {
				$uname_style = 'form_highlight';
			}
			if (in_array('realname', $scream)) {
				$realname_style = 'form_highlight';
			}
			echo "<h2>" . $lang['edit_user'] . " ($user_name)</h2>";
			echo "\n\n\t\t\t\t<div id=\"users_newedit\">
 					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x\" method=\"post\" class=\"form\">
 						<fieldset>
 						<legend>" . $lang['form_legend_user_settings'] . "</legend>
		 					<div class=\"form_row ";
			if (isset($uname_style)) {
				echo $uname_style;
			}
			echo "\">
								<div class=\"form_label\"><label for=\"uname\">" . $lang['form_user_username'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span><span class=\"form_help\">" . $lang['form_help_user_username'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"uname\" value=\"$user_name\" size=\"50\" maxlength=\"80\" id=\"uname\" /></div>
							</div>			
							<div class=\"form_row ";
			if (isset($realname_style)) {
				echo $realname_style;
			}
			echo "\">
								<div class=\"form_label\"><label for=\"realname\">" . $lang['form_user_realname'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span><span class=\"form_help\">" . $lang['form_help_user_realname'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"realname\"";
			if (isset($realname)) {
				echo " value=\"$realname\"";
			}
			echo " size=\"50\" maxlength=\"80\" id=\"realname\" /></div>
							</div>
							<div class=\"form_row ";
			if (isset($email_style)) {
				echo $email_style;
			}
			echo "\">
								<div class=\"form_label\"><label for=\"email\">Email <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"email\"";
			if (isset($email)) {
				echo " value=\"$email\"";
			}
			echo " size=\"50\" maxlength=\"80\" id=\"email\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"privilege\">" . $lang['form_user_permissions'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span><span class=\"form_help\">" . $lang['form_help_user_permissions'] . "</span></label></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"privilege\" id=\"privilege\">";
			if ($privs == 3) {
				echo "<option selected=\"selected\" value=\"3\">Super User</option>";
			} else {
				if ($privs == 2) {
					echo "<option selected=\"selected\" value=\"2\">Administrator</option>";
				} else {
					echo "<option value=\"2\">Administrator</option>";
				}
				if ($privs == 1) {
					echo "<option selected=\"selected\" value=\"1\">Client</option>";
				} else {
					echo "<option value=\"1\">Client</option>";
				}
				if ($privs == 0) {
					echo "<option selected=\"selected\" value=\"0\">User</option>";
				} else {
					echo "<option value=\"0\">User</option>";
				}
			}
			echo "</select></div>
							</div>
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"user_edit\" class=\"form_submit\" value=\"" . $lang['form_button_update'] . "\" />
								<input type=\"hidden\" class=\"form_text\" name=\"user_id\" value=\"$user_id\" maxlength=\"64\" />
							</div>
							<div class=\"form_row_button\">
								<span class=\"form_button_cancel\"><a href=\"?s=$s&amp;x=$x\">" . $lang['form_button_cancel'] . "</a></span>
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
 					</form>
 				</div>\n";
		}
	} else if (isset($do) && $do == 'newuser') {
		if (in_array('email', $scream)) {
			$email_style = 'form_highlight';
		}
		if (in_array('uname', $scream)) {
			$uname_style = 'form_highlight';
		}
		if (in_array('realname', $scream)) {
			$realname_style = 'form_highlight';
		}
		echo '<h2>' . $lang['create_user'] . '</h2>
 				<p>' . $lang['create_user_info'] . '</p>';
		echo "\n\n\t\t\t<div id=\"users_newedit\">
 					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x\" method=\"post\" class=\"form\">
 						<fieldset>
 						<legend>" . $lang['form_legend_user_settings'] . "</legend>
		 					<div class=\"form_row ";
		if (isset($uname_style)) {
			echo $uname_style;
		}
		echo "\">
								<div class=\"form_label\"><label for=\"uname\">" . $lang['form_user_username'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span><span class=\"form_help\">" . $lang['form_help_user_username'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"uname\"";
		if (isset($uname)) {
			echo " value=\"$uname\"";
		}
		echo " size=\"50\" maxlength=\"80\" id=\"uname\"  /></div>
							</div>
							
							<div class=\"form_row ";
		if (isset($realname_style)) {
			echo $realname_style;
		}
		echo "\">
								<div class=\"form_label\"><label for=\"realname\">" . $lang['form_user_realname'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span><span class=\"form_help\">" . $lang['form_help_user_realname'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"realname\"";
		if (isset($realname)) {
			echo " value=\"$realname\"";
		}
		echo " size=\"50\" maxlength=\"80\" id=\"realname\" /></div>
							</div>
	
							<div class=\"form_row ";
		if (isset($email_style)) {
			echo $email_style;
		}
		echo "\">
								<div class=\"form_label\"><label for=\"email\">Email <span class=\"form_required\">" . $lang['form_required'] . "</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"email\"";
		if (isset($email)) {
			echo " value=\"$email\"";
		}
		echo " size=\"50\" maxlength=\"80\" id=\"email\" /></div>
							</div>

							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"user_new\" class=\"form_submit\" value=\"" . $lang['form_button_save'] . "\" />
							</div>
							<div class=\"form_row_button\">
								<span class=\"form_button_cancel\"><a href=\"?s=settings&amp;x=users\">" . $lang['form_button_cancel'] . "</a></span>
								<input type=\"hidden\" name=\"privilege\" value=\"" . $_POST['privs'] . "\" />
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
 					</form>
 				</div>\n";
	} else {
?>	
			<div id="blocks">
				<div id="admin_block_user" class="admin_block">
					<h3><?php
		print $lang['create_user'];
?></h3>
<?php
		echo "					<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=users\" method=\"post\">
 					<fieldset>
 						<legend>" . $lang['create_user'] . "</legend>
						<div class=\"form_row\">
							<div class=\"form_label\"><label for=\"privs\">" . $lang['form_user_permissions'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_user_permissions_block'] . "</span></div>
							<div class=\"form_item_drop\"><select class=\"form_select\" name=\"privs\" id=\"privs\">
								<option value=\"2\">Administrator</option>
								<option value=\"1\">Client</option>									
								<option value=\"0\">User</option>
							</select></div>
						</div>
						<div class=\"form_row_button\" id=\"form_button\">
							<input type=\"submit\" name=\"user\" class=\"form_submit\" value=\"" . $lang['form_button_create_user'] . "\" />
							<input type=\"hidden\" name=\"do\" value=\"newuser\" />
						</div>
					</fieldset>
 					</form>";
?>			
					</div>
					<div id="admin_block_help" class="admin_block">
						<h3><?php
		print $lang['help'];
?></h3>
						<p><?php
		print $lang['help_settings_user_type'];
?></p>
						<ul>
							<li><img src="admin/theme/images/icons/user_tie.png" alt="Administrator" /> <?php
		print $lang['help_settings_user_admin'];
?></li>
							<li><img src="admin/theme/images/icons/user.png" alt="Client" /> <?php
		print $lang['help_settings_user_client'];
?></li>
							<li><img src="admin/theme/images/icons/user.png" alt="User" /> <?php
		print $lang['help_settings_user_user'];
?></li>
						</ul>
					</div>
				</div>
<?php
		echo "				<div id=\"pixie_content\">\n";
		safe_optimize('pixie_users');
		safe_repair('pixie_users');
		echo "\t\t\t\t\t<h2>" . $lang['nav2_users'] . "</h2>\n\t\t\t\t\t<p>" . $lang['user_info'] . "</p>";
		$rs = safe_rows('*', 'pixie_users', 'privs >= 2 order by realname asc');
		if ($rs) {
			echo "\n\t\t\t\t\t<div id=\"user_admins\">
						<h3>Administrators</h3>\n";
			// last seen "commenting on: XXXXX & DATE"
			$num = count($rs);
			$i   = 0;
			while ($i < $num) {
				$out       = $rs[$i];
				$user_name = $out['user_name'];
				$realname  = $out['realname'];
				$email     = $out['email'];
				$privs     = $out['privs'];
				$userid    = $out['user_id'];
				if (($privs == 3) && (isset($email)) && (isset($realname))) {
					if ($GLOBALS['pixie_user'] == $user_name) {
						echo "\t\t\t\t\t\t<div class=\"auser superuser vcard\"><img src=\"admin/theme/images/icons/user_tie.png\" alt=\"User image\" class=\"aicon\" /><span class=\"uname fn\"><a href=\"mailto:$email\" class=\"email\" title=\"Email $realname\">$realname</a> ($user_name)</span><span class=\"uedit\"><a href=\"?s=$s&amp;x=$x&amp;edit=$userid\">" . $lang['edit'] . "</a></span></div>\n";
					} else {
						echo "\t\t\t\t\t\t<div class=\"auser superuser vcard\"><img src=\"admin/theme/images/icons/user_tie.png\" alt=\"User image\" class=\"aicon\" /><span class=\"uname fn\"><a href=\"mailto:$email\" class=\"email\" title=\"Email $realname\">$realname</a> ($user_name)</span><span class=\"suser\">Super User</span></div>\n";
					}
				} else {
					echo "\t\t\t\t\t\t<div class=\"auser vcard\"><img src=\"admin/theme/images/icons/user_tie.png\" alt=\"User image\" class=\"aicon\" /><span class=\"uname fn\"><a href=\"mailto:$email\" class=\"email\" title=\"Email $realname\">$realname</a> ($user_name)</span><span class=\"uedit\"><a href=\"?s=$s&amp;x=$x&amp;edit=$userid\">" . $lang['edit'] . "</a></span><span class=\"udelete\"><a href=\"?s=$s&amp;x=$x&amp;del=$userid\" onclick=\"return confirm('" . $lang['user_delete_confirm'] . " $realname?')\">" . $lang['delete'] . "</a></span></div>\n";
				}
				$i++;
			}
			echo "\t\t\t\t\t</div>\n";
		}
		$rs = safe_rows('*', 'pixie_users', 'privs = 1 order by realname asc');
		if ($rs) {
			echo "\t\t\t\t\t<div id=\"user_clients\">
						<h3>Clients</h3>\n";
			$num = count($rs);
			$i   = 0;
			while ($i < $num) {
				$out       = $rs[$i];
				$user_name = $out['user_name'];
				$realname  = $out['realname'];
				$email     = $out['email'];
				$privs     = $out['privs'];
				$userid    = $out['user_id'];
				if ((isset($email)) && (isset($realname))) {
					echo "\t\t\t\t\t\t<div class=\"auser vcard\"><img src=\"admin/theme/images/icons/user.png\" alt=\"User image\" class=\"aicon\" /><span class=\"uname fn\"><a href=\"mailto:$email\" class=\"email\" title=\"Email $realname\">$realname</a> ($user_name)</span><span class=\"uedit\"><a href=\"?s=$s&amp;x=$x&amp;edit=$userid\">" . $lang['edit'] . "</a></span><span class=\"udelete\"><a href=\"?s=$s&amp;x=$x&amp;del=$userid\" onclick=\"return confirm('" . $lang['user_delete_confirm'] . " $realname?')\">" . $lang['delete'] . "</a></span></div>\n";
				}
				$i++;
			}
			echo "\t\t\t\t\t</div>\n";
		}
		$rs = safe_rows('*', 'pixie_users', 'privs = 0 order by realname asc');
		if ($rs) {
			echo "\t\t\t\t\t<div id=\"user_users\">
						<h3>Users</h3>\n";
			$num = count($rs);
			$i   = 0;
			while ($i < $num) {
				$out       = $rs[$i];
				$user_name = $out['user_name'];
				$realname  = $out['realname'];
				$email     = $out['email'];
				$privs     = $out['privs'];
				$userid    = $out['user_id'];
				if ((isset($email)) && (isset($realname))) {
					echo "\t\t\t\t\t\t<div class=\"auser vcard\"><img src=\"admin/theme/images/icons/user.png\" alt=\"User image\" class=\"aicon\" /><span class=\"uname fn\"><a href=\"mailto:$email\" class=\"email\" title=\"Email $realname\">$realname</a> ($user_name)</span><span class=\"uedit\"><a href=\"?s=$s&amp;x=$x&amp;edit=$userid\">" . $lang['edit'] . "</a></span><span class=\"udelete\"><a href=\"?s=$s&amp;x=$x&amp;del=$userid\" onclick=\"return confirm('" . $lang['user_delete_confirm'] . " $realname?')\">" . $lang['delete'] . "</a></span></div>\n";
				}
				$i++;
			}
			echo "\t\t\t\t\t</div>\n";
		}
		echo "\n\t\t\t\t</div>";
	}
}
?>