<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_auth.                                                //
//*****************************************************************//

	if ((isset($login_submit)) && ($login_submit)) {

	if (!isset($username)) { $username = NULL; }
	if (!isset($password)) { $password = NULL; }
	if (!isset($remember)) { $remember = NULL; }

		$log_in = auth_login($username, $password, $remember); 

		if (!$log_in) { 
			$s = 'myaccount';
			logme($lang['ok_login'], 'no', 'user'); 
		} else { 
			$s = 'login'; $message = $log_in;
			logme($lang['failed_login'], 'yes', 'error'); 
		}
			
	} else if ((isset($s)) && ($s == 'logout')) {

		setcookie('pixie_login', ' ', time()-3600,'/'); $s = 'login';
	
	} else { 
	
	  $log_in = auth_check();

		if (isset($GLOBALS['pixie_user'])) {

			if ($GLOBALS['pixie_user']) { 

				if ((!isset($s)) && (!$s)) { $s = 'myaccount'; }

			} else { 

			/*if ($s == 'help') { 
				$s = 'help';
			} else {*/
				$s = 'login';
			/*}*/

			$message = $log_in; 
			}
		}
	}

// -------------------------------------------------------------
	function auth_login($username, $password, $remember){
		
		global $lang;
		
		$username = sterilise_txt($username, TRUE);
		$password = sterilise_txt($password, TRUE);
		$remember = sterilise_txt($remember, TRUE);
	
		$howmany = count(safe_rows('*', 'pixie_log', "log_message = '" . $lang['failed_login'] . "' and user_ip = '" . $_SERVER["REMOTE_ADDR"] . "' and log_time < utc_timestamp() and log_time > DATE_ADD(utc_timestamp(), INTERVAL -1 DAY)"));
		
		sleep(1);																																    // should halt dictionary attacks
		
		// no more logins than 3 in 24 hours
		if ($howmany > 3) {
			$message = $lang['login_exceeded'];
			logme($lang['logins_exceeded'], 'yes', 'error'); 
			return $message;
		} else {
		if (isset($username) && isset($password)) {
			$r = safe_field('user_name', 'pixie_users', "user_name = '$username'and 
			pass = password(lower('" . doSlash($password) . "')) and privs >= 0");

			if ($r) {
				$user_hits = safe_field('user_hits', 'pixie_users', "user_name='$username'");
				safe_update('pixie_users', 'last_access = utc_timestamp()', "user_name = '$username'");
				safe_update('pixie_users', "user_hits  = $user_hits + 1", "user_name = '$username'");

        $nonce = safe_field('nonce', 'pixie_users', "user_name='$username'");
        
			  if ((isset($remember)) && ($remember)) {	                                                     // persistent cookie required
					setcookie('pixie_login', $username . ',' . md5($username . $nonce), time()+3600*24*365, '/'); 
				} else {                                                               // session-only cookie required
					setcookie('pixie_login', $username . ',' . md5($username . $nonce), 0, '/');    			        
				}

        $privs = safe_field('privs', 'pixie_users', "user_name='$username'");			 // login is good, create user
	      $realname = safe_field('realname', 'pixie_users', "user_name='$username'");
	      $nonce = safe_field('nonce', 'pixie_users', "user_name='$username'");
	      if (isset($realname)) { $GLOBALS['pixie_real_name'] = $realname; }

        if (isset($privs)) { $GLOBALS['pixie_user_privs'] = $privs; }
				$GLOBALS['pixie_user'] = $username;
				$GLOBALS['nonce'] = $nonce;
				return '';                                     	
    	} else {																																 // login failed
    		$GLOBALS['pixie_user'] = '';
    		$message = $lang['login_incorrect'];
				return $message;
		  }
		  
		} else {
			$GLOBALS['pixie_user'] = '';
    		$message = $lang['login_missing'];
			return $message;
		}
		}
	}
// -------------------------------------------------------------
	function auth_check() {

		global $lang;
		
		if(isset($_COOKIE['pixie_login'])) {	
			list($username, $cookie_hash) = explode(',', $_COOKIE['pixie_login']);
			$nonce = safe_field('nonce', 'pixie_users', "user_name='$username'");

			if (md5($username . $nonce) == $cookie_hash) {														 // check nonce
				$privs = safe_field('privs', 'pixie_users', "user_name='$username'");			 // login is good, create user
	      $realname = safe_field('realname', 'pixie_users', "user_name='$username'");
	      if (isset($realname)) { $GLOBALS['pixie_real_name'] = $realname; }

        if (isset($privs)) { $GLOBALS['pixie_user_privs'] = $privs; }
				$GLOBALS['pixie_user'] = $username;
				return '';	
			} else {                                                                 // something's wrong
				$GLOBALS['pixie_user'] = '';
				setcookie('pixie_login', '', time()-3600);
				$message = $lang['bad_cookie'];
				return $message;
			}
    } else {
    	$GLOBALS['pixie_user'] = '';
			setcookie('pixie_login', '', time()-3600);
    }
	}
?>