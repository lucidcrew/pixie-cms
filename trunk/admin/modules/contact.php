<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: Contact                                                  //
//*****************************************************************//

switch ($do) {

	// General information:
	case 'info' :
		$m_name = 'Contact';
		$m_description = 'A simple contact form for your website with hCard/vCard Microformats.';
		$m_author = 'Scott Evans';
		$m_url = 'http://www.toggle.uk.com';
		$m_version = '1.2';
		$m_type = 'module';
		$m_publish = 'no';
		$m_in_navigation = 'yes';

	break;

	// Install
	case 'install' :
		$execute = "CREATE TABLE IF NOT EXISTS `pixie_module_contact` (`contact_id` mediumint(1) NOT NULL auto_increment,PRIMARY KEY  (`contact_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";
		$execute1 = "CREATE TABLE IF NOT EXISTS `pixie_module_contact_settings` (`contact_id` mediumint(1) NOT NULL auto_increment,`show_profile_information` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',`show_vcard_link` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',PRIMARY KEY  (`contact_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";
		$execute2 = "INSERT INTO `pixie_module_contact_settings` (`contact_id`, `show_profile_information`, `show_vcard_link`) VALUES (1, 'no', 'no');";
	break;

	// The administration of the module (add, edit, delete)
	case 'admin' :
		
		// nothing to see here

	break;

	// Pre
	case 'pre' :

		$site_title = safe_field('site_name', 'pixie_settings', "settings_id = '1'");
		$ptitle = $site_title . ' - Contact';
		$pinfo = 'Contact ' . $site_title;
		
		
		// if the form is submitted
		if (isset($contact_sub)) {
		
			// lets check to see if the refferal is from the current site
			if ( strpos($_SERVER['HTTP_REFERER'], $site_url) != FALSE ) { die(); }
			
			// lets check to see if our bot catcher has been filled in
			if ($iam) { die(); }
			
			if ( isset($uemail) ) {

				$domain = explode('@', $uemail);
				if (preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $uemail) && checkdnsrr($domain[1])) {
					if (isset($subject)) {
						if ($message) {
							$message = sterilise($message);
							$subject = sterilise($subject);
							$uemail = sterilise($uemail);
							$to = safe_field('email', 'pixie_users', "user_id = '$contact' limit 0,1");
							$eol="\r\n";
							$headers .= "From: $uemail <$uemail>" . $eol;
							$headers .= "Reply-To: $uemail <$uemail>" . $eol;
							$headers .= "Return-Path: $uemail <$uemail>" . $eol;
						} else {
							$error = 'Please enter a message.';
						}
					} else {
						$error = 'Please provide a subject.';
					}
				} else {
					$error = 'Please provide a valid email adress.';
				}
			} else {
				$error = 'Please provide your email address.';
			}
			
			if (isset($error)) {
				unset($contact_sub);
			}

			if (!isset($error)) {

			    $form_secret = $_POST['form_secret'];
			    if (isset($_SESSION['FORM_SECRET'])) {
				    if (strcasecmp($form_secret, $_SESSION['FORM_SECRET']) === 0) { /* Check that the checksum we created on form submission is the same the posted FORM_SECRET */
				    mail($to, $subject, $message, $headers); /* Send the mail */
				    $log_message = "$uemail sent a message to $to using the contact form.";
				    logme($log_message, 'no', 'site'); /* Log the action */
				    unset($_SESSION['FORM_SECRET']); /* Unset the checksum */
				    } else { /* Invalid secret key */ }
				    } else { /* Secret key missing */ }
			    }

			}

	break;

	// Head
	case 'head' :

	break;

	// Show Module
	default :

		$secret = sha1(uniqid( rand(), TRUE) ); /* Create a sha1 checksum to help verify that we are only sending the mail once */
		$_SESSION['FORM_SECRET'] = $secret; /* FORM_SECRET in $_SESSION['FORM_SECRET'] must be unique if you reuse this technique in other forms like the comments form for example */

		$sets = safe_row('*', 'pixie_module_contact_settings', "contact_id='1'"); /* Get the settings for this page */
		extract($sets); /* Extract them */

		echo '<h3>Contact</h3>';

		if (isset($show_profile_information)) {
		    if ($show_profile_information == 'yes') {
			$rs = safe_rows_start('*', 'pixie_users', '1 order by privs desc');
			while ($a = nextRow($rs)) {
			extract($a);
			echo "
					<div class=\"vcard\">
						<a class=\"url fn\" href=\"$website\"><span class=\"given-name\">"; if (isset($realname)) { echo firstword($realname); } echo "</span><span class=\"family-name\"> "; if (isset($realname)) { echo lastword($realname); } echo "</span></a>
						<div class=\"org hide\">$occupation</div>
						<div class=\"adr\">
							<span class=\"street-address\">$street</span> 
							<span class=\"locality\">$town</span>
							<span class=\"region\">$county</span> 
							<span class=\"country-name\">$country</span>
							<span class=\"postal-code\">$post_code</span>
						</div>
						<span class=\"tel\">$telephone</span>";
						if ($show_vcard_link == 'yes') {
						    if (isset($s)) {
							echo "<p class=\"extras\"><span class=\"down_vcard\"><a href=\"http://technorati.com/contacts/" . createURL($s) . "\">Download my vCard</a></span></p>";
						    }
						}
						echo "
					</div>";
			}
		    }
		 }
		 
		 if (isset($error)) {
		 	print "<p class=\"error\">$error</p>";
		 }
	
		 if (!isset($contact_sub)) {
		 if (!isset($uemail)) { $uemail = NULL; }
		 echo "
					<form accept-charset=\"UTF-8\" action=\""; if (isset($s)) { echo createURL($s); } echo "\" method=\"post\" id=\"contactform\" class=\"form\">
						<fieldset>
						<legend>Email $site_title</legend>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"uemail\">Enter your email <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"uemail\" maxlength=\"80\" id=\"uemail\" value=\"$uemail\" /></div>
							</div>
							<div class=\"form_row\" id=\"contact_list\">
								<div class=\"form_label\"><label for=\"contact\">Select Contact <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"contact\" id=\"contact\">";
								$rs = safe_rows_start('*', 'pixie_users', '1 order by privs desc');
								while ($a = nextRow($rs)) {
									extract($a);
									if((strlen($occupation) > 0) && (isset($realname))) {
										echo "<option value=\"$user_id\">$realname ($occupation)</option>";
									}
									else {
										echo "<option value=\"$user_id\">$realname</option>";
									}
								}

								if (!isset($subject)) { $subject = NULL; }

								echo "	
								</select></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"subject\">Subject <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"subject\" value=\"$subject\" size=\"30\" maxlength=\"80\" id=\"subject\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"messagey\">Message <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item\"><textarea name=\"message\" cols=\"35\" class=\"form_text_area\" rows=\"8\" id=\"messagey\">$message</textarea></div>
							</div>
							<div class=\"form_row_submit\">
								<input type=\"hidden\" name=\"form_secret\" id=\"form_secret\" value=\"$_SESSION[FORM_SECRET]\" />
								<input type=\"hidden\" name=\"iam\" value=\"\" />
								<input type=\"submit\" name=\"contact_sub\" class=\"form_submit\" id=\"contact_submit\" value=\"Submit\" />
							</div>
						</fieldset>
					</form>";
		} else {
			echo "<p class=\"notice emailsent\">Thank you for your email.</p>";
		}

	break;
}

?>