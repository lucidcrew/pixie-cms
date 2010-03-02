<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Login.                                                   //
//*****************************************************************//

if (isset($login_forgotten)) {
	
	sleep(3);

	if (!isset($username)) { $username = NULL; }

	$username = sterilise($username, TRUE);
	
	$r1 = safe_field('email', 'pixie_users', "email='$username'");	
	$r2 = safe_field('user_name', 'pixie_users', "user_name='$username'");

	if ($r1 or $r2) {
		if ($r1) {
			$rs = $r1;
		} else {
			$rs = safe_field('email', 'pixie_users', "user_name='$username'");
		}

		if ($rs) {
			$password = generate_password(8);
			$nonce = md5( uniqid( rand(), TRUE ) );
			$sql = "pass = password(lower('$password')), nonce = '$nonce'";
			$ok = safe_update('pixie_users', "$sql", "email = '$rs'");
			
			if ((isset($rs)) && ($ok)) {
				$email = $rs;
				$subject = $lang['email_newpassword_subject'];
				if (!isset($subject)) { $subject = NULL; }
				$emessage = $lang['email_newpassword_message'] . $password;
				$user = safe_field('realname','pixie_users', "email='$email'");
				$headers = "From: postmaster@{$_SERVER['HTTP_HOST']}" . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
				mail($email, $subject, $emessage, $headers);
				$messageok = $lang['forgotten_ok'];
				logme($lang['forgotten_log_ok'] . $user . ' (' . $email . ').', 'yes', 'user'); 
				$m = 'ok';
			} else {
				$message = $lang['unknown_error'];
			}
				
		}
		
	} else {
		$message = $lang['forgotten_missing'];
		logme($lang['forgotten_log_error'], 'yes', 'error'); 
	}

}


if ($m == 'forgotten') {
?>
				<div id="login">
					<form accept-charset="UTF-8" action="?s=login&amp;m=forgotten" method="post" id="form_forgotten" class="form">
						<fieldset>
							<legend>Forgotten your password?</legend>
							<p><?php print $lang['form_help_forgotten']; ?></p>		
							<div class="form_row">
								<div class="form_label"><label for="username"><?php print $lang['form_usernameoremail']; ?></label></div>
								<div class="form_item"><input type="text" class="form_text" tabindex="1" name="username" id="username" size="30" /></div>
							</div>
							<div class="form_row_button" id="form_button">
								<input type="submit" name="login_forgotten" tabindex="2" value="<?php print $lang['form_resetpassword']; ?>" class="form_submit" />
							</div>
							<div class="safclear"></div>
						</fieldset>
					</form>
					<ul>
						<li class="return"><a href="<?php print $site_url;?>" title="<?php echo $lang['view_site']; ?>"><?php  print $lang['form_returnto']; print str_replace('http://', "", $site_url);?></a></li>
					</ul>	
				</div>
<?php
} else {
?>

				<div id="login">
					<form accept-charset="UTF-8" action="index.php" method="post" id="form_login" class="form">
						<fieldset>
							<legend><?php print $lang['form_login']; ?></legend>		
							<div class="form_row">
								<div class="form_label"><label for="username"><?php print $lang['form_username']; ?></label></div>
								<div class="form_item"><input type="text" class="form_text" tabindex="1" name="username" id="username" size="30" /></div>
							</div>
							<div class="form_row">
								<div class="form_label"><label for="password"><?php print $lang['form_password']; ?></label></div>
								<div class="form_item"><input type="password" class="form_text" tabindex="2" name="password" id="password" size="30" /></div>
							</div>
							<div class="form_row">
								<div class="form_label_small"><label for="remember"><?php print $lang['form_rememberme']; ?></label></div>
								<div class="form_item_check"><input type="checkbox" tabindex="3" class="form_check" name="remember" value="checked" id="remember" /></div>
							</div>
							<div class="form_row_button" id="form_button">
								<input type="submit" name="login_submit" tabindex="4" value="<?php print $lang['form_login']; ?>" class="form_submit" />
							</div>
							<div class="safclear"></div>
						</fieldset>
					</form>
					<ul>
						<li class="forgotten"><a href="?s=login&amp;m=forgotten"><?php print $lang['form_forgotten']; ?></a></li>
						<li class="return"><a href="<?php print $site_url;?>" title="<?php echo $lang['view_site']; ?>"><?php  print $lang['form_returnto']; print str_replace('http://', "", $site_url);?></a></li>
					</ul>	
				</div>
<?php
}
?>