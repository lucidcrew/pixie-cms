<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_logs.                                                //
//*****************************************************************//

//------------------------------------------------------------------
// Two functions to calculate page render times
	function getmicrotime()
	{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
	} 

	function pagetime($type)
	{
		static $orig_time;

		if($type=="init") {
			$orig_time=getmicrotime();
		}

		if($type=="print") {
			printf("%2.4f",getmicrotime()-$orig_time);
		}
	}
//------------------------------------------------------------------
// referral function for tracking site referrals 
	function referral() 
	{
		global $lang;
		$url = $GLOBALS['site_url'];
		$domain = trim(str_replace("www.","",$url));
		if (isset($_SERVER['HTTP_REFERER'])) { 
			$referral  = $_SERVER['HTTP_REFERER'];
		} else {
			$referral = $land['unknown_referrer'];
		}
		if ($GLOBALS['pixie_user']) {
			$uname = $GLOBALS['pixie_user'];
		} else {
			$uname = "Visitor";
		}
		$ip = $_SERVER['REMOTE_ADDR'];

		$uname = sterilise($uname, true);
		$ip = sterilise($ip, true);
		$referral = sterilise($referral, true); 

		if (($referral) and (!strstr($referral, $domain))) {
			safe_insert("pixie_log", 
									"user_id = '$uname',  
									 user_ip = '$ip', 
								 	 log_time = now(),
								 	 log_type = 'referral',
								 	 log_icon = 'referral',
								 	 log_message = '$referral'");
		}
	}
//------------------------------------------------------------------
// log function for writing information to log database
	function logme($message,$imp,$icon) 
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if ($GLOBALS['pixie_user']) {
			$uname = $GLOBALS['pixie_user'];
		} else {
			$uname = "Visitor";
		}
		if(!$icon) {
			$icon = "site";
		}
		safe_insert("pixie_log", 
								"user_id = '$uname',  
								 user_ip = '$ip', 
							 	 log_time = now(),
							 	 log_type = 'system',
							 	 log_message = '$message',
							 	 log_icon = '$icon',
							 	 log_important = '$imp'");
	}
//------------------------------------------------------------------
// log function for keeping tract of who is online
	function users_online() 
	{	
		$sessiontime = 3;  //minutes
		safe_delete("pixie_log_users_online", "unix_timestamp() - last_visit >= $sessiontime * 60");

		$ip = $_SERVER['REMOTE_ADDR'];
		$query = "SELECT last_visit FROM ".PFX."pixie_log_users_online WHERE visitor = '$ip'";
		$online = safe_query($query);

		if (mysql_num_rows($online) == "0") {
			$sql = "visitor = '$ip', last_visit = unix_timestamp()";
			safe_insert("pixie_log_users_online", $sql);
		} else {
			safe_update("pixie_log_users_online", "last_visit = unix_timestamp()", "visitor = '$ip'");
		}	
	}
?>