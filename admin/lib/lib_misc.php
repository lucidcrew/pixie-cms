<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_misc.                                                //
//*****************************************************************//
// -- PLEASE DO NOT PUT ANY MORE DATABASE FUNCTIONS IN THIS FILE! ---
// ------ Functions that use the database go in lib_db.php ----------
//
// THE EXISTING FUNCTIONS IN THIS FILE THAT USE THE DATABASE SHOULD
// BE MIGRATED TO lib_db.php.
//
// ------------------------------------------------------------------

/*	Set up debugging	*/
	if (defined('PIXIE_DEBUG')) { pixieExit(); exit(); }
	define('PIXIE_DEBUG', 'no'); /* Set debug to yes to debug and see all the global vars coming into the file */

	function pixieExit()                                          
	{
header('Status: 503 Service Unavailable');  /* 503 status might discourage search engines from indexing or caching the error message */
$pixie_exit = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
		\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
	<title>Pixie (www.getpixie.co.uk) - Security Warning</title>
	<style type=\"text/css\">
		body
			{
			font-family: Arial, 'Lucida Grande', Verdana, Sans-Serif;
			color: #333;
			}
		
		a, a:visited
			{
			text-decoration: none;
			color: #0497d3;
			}

		a:hover
			{
			color: #191919;
			text-decoration: none;
			}
			
		.helper
			{
			position: relative;
			top: 60px;
			border: 5px solid #e1e1e1;
			clear: left;
			padding: 15px 30px;
			margin: 0 auto;
			background-color: #F0F0F0;
			width: 500px;
			line-height: 15pt;
			}
	</style>
</head>
<body>
	<div class=\"helper\">
		<h3>Security Warning</h3>
		<p><a href=\"http://www.getpixie.co.uk\" alt=\"Get Pixie!\">Pixie</a> has blocked your request to this site due to security concerns. The site administrator has been notified of your details. Please try to visit this site again later if you have recieved this message in error.</p>
	</div>
</body>
</html>";
	exit($pixie_exit);

	}
//
//	WE SHOULD NOT BE OFFERING A POTENTIAL ATTACKER A GET OUT OF A DEAD END LINK SO THAT THEY CAN TRY AGAIN! ---------------
//	<p><a href=\"http://www.getpixie.co.uk\" alt=\"Get Pixie!\">Pixie</a> has blocked your request to this site due to security concerns. The site administrator has been notified of your details. <a href=\"$site_url\" title=\"$site_name\">Click here to be redirected to the $site_name homepage</a>.</p>
//	THAT CODE FROM ABOVE HAS BEEEN REMOVED! Remove this comment block if you agree. ---------------
//	lib_db is now not a requirement to init this required included page. ---------------
//	The result of an attacker should never interface with our database and just instead be dealt with by being silently dropped. -----
//
// ------------------------------------------------------------------
// Generate a new password
	function generate_password($length=10)
	{
		$pass = "";
		$chars = '023456789bcdfghjkmnpqrstvwxyz'; 
		$i = 0; 
		while ($i < $length) {
			$char = substr($chars, mt_rand(0, strlen($chars)-1), 1);
			if (!strstr($pass, $char)) {
				$pass .= $char;
				$i++;
			}
		}
		return $pass;
	}
// ------------------------------------------------------------------
// Get the first word in a _ seperated string
	function first_word($theString)
	{
   $stringParts = explode('_', $theString);
   return $stringParts[0];
	}
// ------------------------------------------------------------------
// Get the last word in a _ seperated string
	function last_word($theString)
	{
   $stringParts = explode('_', $theString);
   return array_pop($stringParts);
	}
// ------------------------------------------------------------------
// Get the first word in a string
	function firstword($theString)
	{
   $stringParts = explode(" ", $theString);
   return $stringParts[0];
	}
// ------------------------------------------------------------------
// Get the last word in a string
	function lastword($theString)
	{
   $stringParts = explode(" ", $theString);
   return array_pop($stringParts);
	}
// ------------------------------------------------------------------
// Get a var from $_SERVER global array, or create it
	function serverSet($thing)                                        
	{
		return (isset($_SERVER[$thing])) ? $_SERVER[$thing] : '';
	}
// ------------------------------------------------------------------
// protection from those who'd bomb the site by GET
	function bombShelter()                                          
	{
		$in = serverset('REQUEST_URI');
		$ip = $_SERVER['REMOTE_ADDR'];
		// logme is just going to flood the logs if under repeated mass attack and bring the mysql server down to a crawl if it's a botnet attack.
		// Without logging the attacker's ip address, just logging that there was an attack is pointless and just worries users without providing them a way to action something.
		// if (strlen($in) > 260) logme("BombShelter: possible attack, bomb via GET.","yes","error");
		if (strlen($in) > 260) { 
		// See the comment directly below function pixieExit as to why these two aren't needed
		// We don't want an attacker fed anything if they want to try to break the site.
		// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'"); // Depreciating this
		// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'"); // Depreciating this
		pixieExit();
		}

	// return true;		// Dunno.

	}
// ------------------------------------------------------------------
function globalSec($page_location, $sec_check)
{
	// Here we check to make sure that the super global $_REQUEST array's variables have not been poisioned
	// by an intruder before they are extracted
	// I'm not going to log this, I think doing that is a mistake and ignorance is also bliss...
	// We can maybe turn these isset checks into an array and loop it

	// We don't need to do this for the prefs too because it is trusted data coming from the database.
	if ($sec_check == 1) {

	if (isset($_REQUEST['_GET'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify get data was made.',"yes","error");
	pixieExit(); }

	if (isset($_REQUEST['_POST'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify get post data was made.',"yes","error");
	pixieExit(); }

	if (isset($_REQUEST['_COOKIE'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify cookie data was made.',"yes","error");
	pixieExit();	}

	if (isset($_REQUEST['_SESSION'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify session data was made.',"yes","error");
	pixieExit();	}

	if (isset($_REQUEST['GLOBALS'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify globals data was made.',"yes","error");
	pixieExit();	}

	if (isset($_REQUEST['_FILES'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify file data was made.',"yes","error");
	pixieExit();	}

	if (isset($_REQUEST['_REQUEST'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify request data was made.',"yes","error");
	pixieExit();	}

	if (isset($_REQUEST['_SERVER'])) { 
	// $site_name = safe_field('site_name','pixie_settings',"settings_id='1'");
	// $site_url = safe_field('site_url','pixie_settings',"settings_id='1'");
	// logme('Pixie Site Security - ' . "$page_location" . ' - An attempt to modify server data was made.',"yes","error");
	pixieExit();	}
	}

	// return true;		// Dunno.

}
// ------------------------------------------------------------------
	function doSlash($in)
	{ 
		if(phpversion() >= '4.3.0') {
			return doArray($in, 'mysql_real_escape_string');
		} else {
			return doArray($in, 'mysql_escape_string');
		}
	}
// ------------------------------------------------------------------
	function doArray($in, $function)
	{
		return is_array($in) ? array_map($function, $in) : $function($in); 
	}
//-------------------------------------------------------------------
// function to simply string in item_name format
	function simplify($string) 
	{
		$out = str_replace('_', " ", $string);
		$strlen = strlen($out); 
		$max = 150;   // find somwhere better for this?
		if ($strlen > $max) {
			$out = substr($out, 0, $max) . '...'; 
		}
	 	return ucfirst($out);
  }	
//-------------------------------------------------------------------
// function chop length of string
	function chopme($string, $length) 
	{
		$strlen = strlen($string); 
		$max = $length;
		if ($strlen > $max) {
			$string = substr($string, 0, $max) . '...'; 
		}
	 	return $string;
  }
//-------------------------------------------------------------------
// function for checking if its 404 time
	function check_404($section)
	{
		$check = file_exists('admin/modules/mod_' . $section . '.php');

		if ($check) {
			return $section;
		} else {
			$section = '404';
			return $section;
		}
	}	
//-------------------------------------------------------------------
// function for checking if its 404 time from public hit
	function public_check_404($section)
	{
		$section = str_replace('<x>', "", $section);
		if ($section == 'rss') {
			$check = safe_row('*', 'pixie_core', "page_name = '$section' AND public = 'yes' limit 0,1");
		} else {
			$check = safe_row('*', 'pixie_core', "page_name = '$section' AND public = 'yes' AND page_type != 'plugin' limit 0,1");
		}
		
		if ($check) {
			return $section;
		} else {
			$section = '404';
			return $section;
		}
	}
//-------------------------------------------------------------------
// function for checking what type of page we are dealing with
	function check_type($section)
	{ 
		extract(safe_row('*', 'pixie_core', "page_name = '$section' AND public = 'yes' limit 0,1"));
		
		if ($page_type) {
			return $page_type;
		} else {
			return 'Unable to find type of page in pixie_core. Has the page been deleted?';
		}
 	} 
//-------------------------------------------------------------------
// function for deleting a file
	function file_delete($file)
	{ 
 		//chmod($file, 0777); 
  	if(unlink($file)) { 
 	  	return true; 
  	} else { 
  	  return false; 
  	} 
	} 
//-------------------------------------------------------------------
// function to return current directory
	function current_dir()
	{
		$path = dirname($_SERVER['PHP_SELF']);
		$position = strrpos($path,'/') + 1;
		return substr($path, $position);
	}
//-------------------------------------------------------------------
// function to return current page id
	function get_page_id($section)
	{
		$page_id = safe_field('page_id', 'pixie_core', "page_name = '$section' AND public = 'yes' limit 0,1");
		if ($page_id) {
			return $page_id;
		}
	}
//-------------------------------------------------------------------
// function to return a slug from post name
	function make_slug($title)
	{
	 $slug = str_replace(" ", "BREAK", $title);
	 $slug = preg_replace("/[^a-zA-Z0-9]/", "", $slug);
	 $slug = str_replace("BREAK", "-", $slug);
	 $slug = str_replace("--", "-", $slug);
	 $slug = str_replace("---", "-", $slug);
	 $slug = str_replace("----", "-", $slug);
	 $slug = str_replace("-----", "-", $slug);
	 //return strtolower($slug);
	 return ($slug);
	}
//-------------------------------------------------------------------
// function to correctly form tags
	function make_tag($tags)
	{
	if (isset($tags)) {
	 $tags = explode(" ", $tags);
	 for ($count = 0; $count < (count($tags)); $count++) {
	   $current = $tags[$count];
	   if ($current != "") {
		 	$current = preg_replace("/[^a-zA-Z0-9]/", "", $current);
		 	$all_tag .= $current . " ";	
	   }
		 $i++;
	 }
	 
	 return rtrim($all_tag);
	}

	}
//-------------------------------------------------------------------
// function to revert slug / used for tags only
	function squash_slug($title)
	{
	 $slug = str_replace('-', " ", $title);
	 return strtolower($slug);
	}
//-------------------------------------------------------------------
// function to check if a page is installed and public
	function public_page_exists($page_name)
	{
		$rs = safe_row('*', 'pixie_core', "page_name = '$page_name' AND public = 'yes' limit 0,1");
		
		if ($rs) {
			return true;
		} else {
			return false;
		}
	}
//-------------------------------------------------------------------
// function to check if a number is odd or even
	function is_even($number){
  	$result = $number % 2;
   	if($result == 0) {
     return true;
    } else {
     return false;
    }
  }
//-------------------------------------------------------------------
// allow PHP/HTML to be written into textarea
	function textarea_encode($html_code)
	{
	    $from = array('<', '>');
	    $to = array('#&50', '#&52');
	    $html_code = str_replace($from, $to, $html_code);
	    return $html_code;
	}
//-------------------------------------------------------------------
// output title of current section for admin area
	function build_admin_title()
	{
		global $version, $lang, $s, $m, $x, $do;

		//myaccount
		if ((isset($s)) && ($s == 'myaccount')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_home']; }
		if ((isset($s)) && ($s == 'myaccount') && ($x == 'myprofile')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_profile']; }
		if ((isset($s)) && ($s == 'myaccount') && ($x == 'myprofile') && ($do == 'security')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_security']; }
		
		//publish - needs expanding!
		if ((isset($s)) && ($s == 'publish')) { $title = $lang['nav1_publish']; }
		if ((isset($s)) && ($s == 'publish') && ($x == 'filemanager')) { $title = $lang['nav1_publish'] . ' - ' . $lang['nav2_files']; }

		//settings - needs expanding!
		if ((isset($s)) && ($s == 'settings')) { $title = $lang['nav1_settings']; }
		if ((isset($s)) && ($s == 'settings') && ($m == 'theme')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_theme']; }
		if ((isset($s)) && ($s == 'settings') && ($m == 'users')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_users']; }
		if ((isset($s)) && ($s == 'settings') && ($x == 'dbtools')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_backup']; }

		echo 'Pixie v' . $version . ' : ' . $title;
	}
//-------------------------------------------------------------------
// create a clean or ugly url based on the Pixie setting
	function createURL($s, $m = '', $x = '', $p = '') 
	{
		global $site_url, $clean_urls;

		if ($clean_urls == 'yes') {
			$return = $site_url . $s . '/' . $m . '/' . $x . '/' . $p;
			$return = str_replace('//', "", $return);
			$return = str_replace('///', "", $return);
			$return = str_replace('////', "", $return);
			$return = str_replace('http:', 'http://', $return);
			$last = $return{strlen($return)-1};
  		if ($last != '/') {
  			$return = $return . '/';
  		}
			return $return;
		} else {
			$return = $site_url . '?s=' . $s . '&m=' . $m . '&x=' . $x . '&p=' . $p;
			$return = str_replace('&m=&x=&p=', "", $return);
			$return = str_replace('&x=&p=', "", $return);
			if (!$p) {
				$return = str_replace('&p=', "", $return);
			}
			return htmlentities($return);

		}
	}
//-------------------------------------------------------------------
// reset the page order
	function page_order_reset() 
	{
		$pages = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'yes' order by page_order asc");
		$num = count($pages);
		
  	$i = 0;
		while ($i < $num){
  			$out = $pages[$i];
  			$page_id = $out['page_id'];
  			safe_update('pixie_core', "page_order  = $i + 1", "page_id = '$page_id'");
  		$i++;
		}
	}
//-------------------------------------------------------------------
// create list of blocks with form adder
	function form_blocks() 
	{
		global $s, $m, $x, $site_url, $lang;

		$dir = './blocks';
  	if (is_dir($dir)) {
  		$fd = @opendir($dir);
    	if($fd) {
      	while (($part = @readdir($fd)) == true) {
        	if ($part != '.' && $part != '..') {
        	if ($part != 'index.php' && preg_match('/^block_.*\.php$/', $part)) {
        		$part = str_replace('block_', "", $part);
        		$part = str_replace('.php', "", $part);
          		$cloud .= "\t\t\t\t\t\t\t\t\t<a href=\"#\" title=\"Add block: $part\">$part</a>\n";
      		}
      		}
		}
    	}
  	}
		$cloud  = substr($cloud , 0, (strlen($cloud)-1)) . "";
		echo "\t\t\t\t\t\t\t\t<div class=\"form_block_suggestions\" id=\"form_block_list\">";
		echo "<span class=\"form_block_suggestions_text\">" . $lang['form_help_current_blocks'] . "</span>\n $cloud\n";
		echo "\t\t\t\t\t\t\t\t</div>\n"; 
	}
//-------------------------------------------------------------------
// protect email from spam bots
	function encode_email($emailaddy, $mailto = 0) 
	{

	$emailNOSPAMaddy = '';
	srand ((float) microtime() * 1000000);

	for ($i = 0; $i < strlen($emailaddy); $i = $i + 1) {

		$j = floor(rand(0, 1 + $mailto));
		if ($j == 0) {
		 	$emailNOSPAMaddy .= '&#' . ord(substr($emailaddy, $i, 1)) . ';';
		} elseif ($j == 1) {
			$emailNOSPAMaddy .= substr($emailaddy, $i, 1);
		} elseif ($j == 2) {
		 	$emailNOSPAMaddy .= '%' . zeroise(dechex(ord(substr($emailaddy, $i, 1))), 2);
		}
	}

	$emailNOSPAMaddy = str_replace('@', '&#64;', $emailNOSPAMaddy);
	return $emailNOSPAMaddy;
	
	}
//-------------------------------------------------------------------
// get extended entry info (<!--more-->)
	function get_extended($post) {
		//Match the new style more links
		if ( preg_match('/<!--more(.*?)?-->/', $post, $matches) ) {
			list($main, $extended) = explode($matches[0], $post, 2);
		} else {
			$main = $post;
			$extended = '';
		}
	
		// Strip leading and trailing whitespace
		$main = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $main);
		$extended = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $extended);
	
		return array('main' => $main, 'extended' => $extended);
	}
//-------------------------------------------------------------------
// steralise user input, security against XSS etc
	function sterilise($val, $is_sql = false) {

	   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	   // this prevents some character re-spacing such as <java\0script>
	   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	   
	   // straight replacements, the user should never need these since they're normal characters
	   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
	   $search = 'abcdefghijklmnopqrstuvwxyz';
	   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   $search .= '1234567890!@#$%^&*()';
	   $search .= '~`";:?+/={}[]-_|\'\\';
	   for ($i = 0; $i < strlen($search); $i++) {
		  // ;? matches the ;, which is optional
		  // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
	   
		  // &#x0040 @ search for the hex values
		  $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
		  // &#00064 @ 0{0,7} matches '0' zero to seven times
		  $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
	   }
	   
	   // now the only remaining whitespace attacks are \t, \n, and \r
	   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	   $ra = array_merge($ra1, $ra2);
	   
	   $found = true; // keep replacing as long as the previous round replaced something
	   while ($found == true) {
		  $val_before = $val;
		  for ($i = 0; $i < sizeof($ra); $i++) {
			 $pattern = '/';
			 for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
				   $pattern .= '(';
				   $pattern .= '(&#[xX]0{0,8}([9ab]);)';
				   $pattern .= '|';
				   $pattern .= '|(&#0{0,8}([9|10|13]);)';
				   $pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			 }
			 $pattern .= '/i';
			 $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
			 $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			 if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			 }
		  }
	   }
   
		if ($is_sql) {
			$val = mysql_real_escape_string ($val);

		}
 
		return $val;
	}
?>