<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: Contact                                                  //
//*****************************************************************//

switch ($do) {

	// General information:
	case "info":
		$m_name = "Contact";
		$m_description = "A simple contact form for your website with hCard/vCard Microformats.";
		$m_author = "Scott Evans";
		$m_url = "http://www.toggle.uk.com";
		$m_version = "1.1";
		$m_type = "module";
		$m_publish = "no";

	break;

	// Install
	case "install":
		$execute = "CREATE TABLE IF NOT EXISTS `pixie_module_contact_settings` (`contact_id` mediumint(1) NOT NULL auto_increment,`show_profile_information` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',`show_vcard_link` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',PRIMARY KEY  (`contact_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;";
		$execute1 = "INSERT INTO `pixie_module_contact_settings` (`contact_id`, `show_profile_information`, `show_vcard_link`) VALUES (1, 'yes', 'yes');";
	break;

	// The administration of the module (add, edit, delete)
	case "admin":
		
		// nothing to see here

	break;

	// Pre
	case "pre":
	
		$site_title = safe_field("site_name","pixie_settings","settings_id = '1'");
		$ptitle = $site_title." - Contact";
		$pinfo = "Contact ".$site_title;
		
		
		// if the form is submitted, send the email
		if ($contact_sub) {
		
			// lets check to see if the refferal is from the current site
			if (strpos($_SERVER['HTTP_REFERER'], $site_url) != false) { die(); }
			
			// lets check to see if our bot catcher has been filled in
			if ($iam) { die(); }
			
			if ($uemail) {
				if ($subject) {
					if ($message) {
						$message = sterilise($message);
						$subject = sterilise($subject);
						$uemail = sterilise($uemail);
						$to = safe_field('email','pixie_users',"user_id = '$contact' limit 0,1");
						$eol="\r\n";
						$headers .= "From: $uemail <$uemail>".$eol;
						$headers .= "Reply-To: $uemail <$uemail>".$eol;
						$headers .= "Return-Path: $uemail <$uemail>".$eol;
						mail($to, $subject, $message, $headers);
					} else {
						$error = "Please enter a message.";
					}
				} else {
					$error = "Please provide a subject.";
				}
			} else {
				$error = "Please provide your email address.";
			}
			
			if ($error) {
				unset($contact_sub);
			}
		}
		
	break;
	
	// Head
	case "head":

	break;

	// Show Module
	default:
		
		// get the settings for this page
		extract(safe_row("*", "pixie_module_contact_settings", "contact_id='1'"));

		echo "<h3>Contact</h3>";
			
		if ($show_profile_information == "yes") {
		$rs = safe_rows_start("*", "pixie_users", "1 order by privs desc");
		while ($a = nextRow($rs)) {
			extract($a);
			echo "
					<div class=\"vcard\">
						<a class=\"url fn\" href=\"$website\"><span class=\"given-name\">".firstword($realname)."</span><span class=\"family-name\"> ".lastword($realname)."</span></a>
						<div class=\"org hide\">$occupation</div>
						<div class=\"adr\">
							<span class=\"street-address\">$street</span> 
							<span class=\"locality\">$town</span>
							<span class=\"region\">$county</span> 
							<span class=\"country-name\">$country</span>
							<span class=\"postal-code\">$post_code</span>
						</div>
						<span class=\"tel\">$telephone</span>";
						if ($show_vcard_link == "yes") {
							echo "<p class=\"extras\"><span class=\"down_vcard\"><a href=\"http://technorati.com/contacts/".createURL($s)."\">Download my vCard</a></span></p>";
						}
						echo "
					</div>";
		 }
		 }
		 
		 if ($error) {
		 	print "<p class=\"error\">$error</p>";
		 }
	
		 if (!$contact_sub) {
		 echo "
					<form action=\"".createURL($s)."\" method=\"post\" id=\"contactform\" class=\"form\">
						<fieldset>
						<legend>Email $site_title</legend>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"uemail\">Enter your email <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" name=\"uemail\" maxlength=\"80\" id=\"uemail\" value=\"$uemail\" /></div>
							</div>
							<div class=\"form_row\" id=\"contact_list\">
								<div class=\"form_label\"><label for=\"contact\">Select Contact <span class=\"form_required\">*</span></label></div>
								<div class=\"form_item_drop\"><select class=\"form_select\" name=\"contact\" id=\"contact\">";
								$rs = safe_rows_start("*", "pixie_users", "1 order by privs desc");
								while ($a = nextRow($rs)) {
									extract($a);
									if(strlen($occupation) > 0) {
										echo "<option value=\"$user_id\">$realname ($occupation)</option>";
									}
									else {
										echo "<option value=\"$user_id\">$realname</option>";
									}
								}
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