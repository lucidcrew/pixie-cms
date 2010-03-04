<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
//								   //
// Title: lib_misc.                                                //
//								   //
//*****************************************************************//
// ------------------------------------------------------------------
/* Set up debugging */
// ------------------------------------------------------------------
    if (defined('PIXIE_DEBUG')) { pixieExit(); exit(); }
    define('PIXIE_DEBUG', 'yes'); /* Set debug to yes to debug and see all the global vars coming into the file */
// ------------------------------------------------------------------
/* An exit on error function */
// ------------------------------------------------------------------
function pixieExit() {
header('Status: 503 Service Unavailable');  /* 503 status might discourage search engines from indexing or caching the error message */

		return <<<eod
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
<title>Pixie (www.getpixie.co.uk) - Security Warning</title>
<style type=\"text/css\">
body{font-family:Arial,'Lucida Grande',Verdana,Sans-Serif;color: #333;}
a, a:visited{text-decoration: none;color: #0497d3;}
a:hover{color: #191919;text-decoration: none;}
.helper{position: relative;top: 60px;border: 5px solid #e1e1e1;clear: left;padding: 15px 30px;margin: 0 auto;background-color: #F0F0F0;width: 500px;line-height: 15pt;}
</style>
</head>
<body>
<div class=\"helper\"><h3>Security Warning</h3>
<p><a href=\"http://www.getpixie.co.uk\" alt=\"Get Pixie!\">Pixie</a> has blocked your request to this site due to security concerns. The site administrator has been notified of your details. Please try to visit this site again later if you have recieved this message in error.</p>
</div>
</body>
</html>
eod;

}
// ------------------------------------------------------------------
/* Generate a new password */
// ------------------------------------------------------------------
function generate_password($length = 10) {

    $pass = "";
    $chars = '023456789bcdfghjkmnpqrstvwxyz'; 
    $i = 0; 

	while ($i < $length) {

	    $char = substr($chars, mt_rand(0, strlen($chars) - 1), 1);

		if (!strstr($pass, $char)) {
		    $pass .= $char;
		    $i++;
		}
	}

	return $pass;

}
// ------------------------------------------------------------------
/* Get the first word in a _ seperated string */
// ------------------------------------------------------------------
function first_word($theString) {

    $stringParts = explode('_', $theString);

    return $stringParts[0];

}
// ------------------------------------------------------------------
/* Get the last word in a _ seperated string */
// ------------------------------------------------------------------
function last_word($theString) {

    $stringParts = explode('_', $theString);

    return array_pop($stringParts);

}
// ------------------------------------------------------------------
/* Get the first word in a string */
// ------------------------------------------------------------------
function firstword($theString) {

    $stringParts = explode(" ", $theString);

    return $stringParts[0];

}
// ------------------------------------------------------------------
/* Get the last word in a string */
// ------------------------------------------------------------------
function lastword($theString) {

    $stringParts = explode(" ", $theString);

    return array_pop($stringParts);

}
// ------------------------------------------------------------------
/* Get a var from $_SERVER global array, or create it */
// ------------------------------------------------------------------
function serverSet($thing) {

    return (isset($_SERVER[$thing])) ? $_SERVER[$thing] : '';

}
// ------------------------------------------------------------------
/* Protection against those who'd bomb the site by GET */
// ------------------------------------------------------------------
function bombShelter() {

    $in = serverset('REQUEST_URI');
    $ip = $_SERVER['REMOTE_ADDR'];

	if (strlen($in) > 260) { pixieExit(); }

}
// ------------------------------------------------------------------
/* Prevents the super global $_REQUEST array's variables from poisioning */
// ------------------------------------------------------------------
function globalSec($page_location, $sec_check) {

    global $clean_urls; /* .htaccess already has a rule for this, we don't need to do it twice */

	if ( ($clean_urls != 'yes') && ($sec_check === 1) ) {

	    if ( isset($_REQUEST['_GET']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_POST']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_COOKIE']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_SESSION']) ) { pixieExit(); }
	    if ( isset($_REQUEST['GLOBALS']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_FILES']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_REQUEST']) ) { pixieExit(); }
	    if ( isset($_REQUEST['_SERVER']) ) { pixieExit(); }
	}

}
// ------------------------------------------------------------------
/* A workaround for old versions of php */
// ------------------------------------------------------------------
function doSlash($in) {
 
    if(phpversion() >= '4.3.0') {

	return doArray($in, 'mysql_real_escape_string');

    } else {

	return doArray($in, 'mysql_escape_string');

    }

}
// ------------------------------------------------------------------
/* An array function */
// ------------------------------------------------------------------
function doArray($in, $function) {

    return is_array($in) ? array_map($function, $in) : $function($in);

}
//-------------------------------------------------------------------
/* A function to simply string in item_name format */
// ------------------------------------------------------------------
function simplify($string) {

    $out = str_replace('_', " ", $string);
    $strlen = strlen($out); 
    $max = 150;   // find somwhere better for this?

	if ($strlen > $max) { $out = substr($out, 0, $max) . '...'; }

	return ucfirst($out);

}
//-------------------------------------------------------------------
/* A function chop length of string */
// ------------------------------------------------------------------
function chopme($string, $length) {

    $strlen = strlen($string); 
    $max = $length;

	if ($strlen > $max) { $string = substr($string, 0, $max) . '...'; }

	return $string;

}
//-------------------------------------------------------------------
/* A function for checking if its 404 time */
//-------------------------------------------------------------------
function check_404($section) {

    $check = file_exists("admin/modules/mod_{$section}.php");

	if ($check) {

	    return $section;

	} else {

	    $section = '404';

	    return $section;

	}

}
//-------------------------------------------------------------------
/* A Function for checking if its 404 time from public hit */
//-------------------------------------------------------------------
function public_check_404($section) {

    $section = str_replace('<x>', "", $section);

	if ($section === 'rss') {

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
/* A function for checking what type of page we are dealing with */
//-------------------------------------------------------------------
function check_type($section) {

    extract(safe_row('*', 'pixie_core', "page_name = '$section' AND public = 'yes' limit 0,1"));

	if ($page_type) {

	    return $page_type;

	} else {

	    return 'Unable to find type of page in pixie_core. Has the page been deleted?';

	}

}
//-------------------------------------------------------------------
/* A function for deleting a file */
//-------------------------------------------------------------------
function file_delete($file) { 

    if(unlink($file)) {

	return TRUE;

    } else {

	return FALSE;

    }

}
//-------------------------------------------------------------------
/* A function to return current directory */
//-------------------------------------------------------------------
function current_dir() {

    $path = dirname($_SERVER['PHP_SELF']);
    $position = strrpos($path,'/') + 1;

    return substr($path, $position);

}
//-------------------------------------------------------------------
/* A function to return current page id */
//-------------------------------------------------------------------
function get_page_id($section) {

    $page_id = safe_field('page_id', 'pixie_core', "page_name = '$section' AND public = 'yes' limit 0,1");

	if ($page_id) {

	    return $page_id;

	}

}
//-------------------------------------------------------------------
/* function to create a safe string from special characters like those found in non-English languages */
//-------------------------------------------------------------------
function safe_string($string) {

    $from = explode(',', '&lt;,&gt;,&#039;,&amp;,&quot;,À,Á,Â,Ã,Ä,&Auml;,Å,Ā,Ą,Ă,Æ,Ç,Ć,Č,Ĉ,Ċ,Ď,Đ,Ð,È,É,Ê,Ë,Ē,Ę,Ě,Ĕ,Ė,Ĝ,Ğ,Ġ,Ģ,Ĥ,Ħ,Ì,Í,Î,Ï,Ī,Ĩ,Ĭ,Į,İ,Ĳ,Ĵ,Ķ,Ł,Ľ,Ĺ,Ļ,Ŀ,Ñ,Ń,Ň,Ņ,Ŋ,Ò,Ó,Ô,Õ,Ö,&Ouml;,Ø,Ō,Ő,Ŏ,Œ,Ŕ,Ř,Ŗ,Ś,Š,Ş,Ŝ,Ș,Ť,Ţ,Ŧ,Ț,Ù,Ú,Û,Ü,Ū,&Uuml;,Ů,Ű,Ŭ,Ũ,Ų,Ŵ,Ý,Ŷ,Ÿ,Ź,Ž,Ż,Þ,Þ,à,á,â,ã,ä,&auml;,å,ā,ą,ă,æ,ç,ć,č,ĉ,ċ,ď,đ,ð,è,é,ê,ë,ē,ę,ě,ĕ,ė,ƒ,ĝ,ğ,ġ,ģ,ĥ,ħ,ì,í,î,ï,ī,ĩ,ĭ,į,ı,ĳ,ĵ,ķ,ĸ,ł,ľ,ĺ,ļ,ŀ,ñ,ń,ň,ņ,ŉ,ŋ,ò,ó,ô,õ,ö,&ouml;,ø,ō,ő,ŏ,œ,ŕ,ř,ŗ,š,ù,ú,û,ü,ū,&uuml;,ů,ű,ŭ,ũ,ų,ŵ,ý,ÿ,ŷ,ž,ż,ź,þ,ß,ſ,А,Б,В,Г,Д,Е,Ё,Ж,З,И,Й,К,Л,М,Н,О,П,Р,С,Т,У,Ф,Х,Ц,Ч,Ш,Щ,Ъ,Ы,Э,Ю,Я,а,б,в,г,д,е,ё,ж,з,и,й,к,л,м,н,о,п,р,с,т,у,ф,х,ц,ч,ш,щ,ъ,ы,э,ю,я');
    $to = explode(',', ',,,,,A,A,A,A,Ae,A,A,A,A,A,Ae,C,C,C,C,C,D,D,D,E,E,E,E,E,E,E,E,E,G,G,G,G,H,H,I,I,I,I,I,I,I,I,I,IJ,J,K,K,K,K,K,K,N,N,N,N,N,O,O,O,O,Oe,Oe,O,O,O,O,OE,R,R,R,S,S,S,S,S,T,T,T,T,U,U,U,Ue,U,Ue,U,U,U,U,U,W,Y,Y,Y,Z,Z,Z,T,T,a,a,a,a,ae,ae,a,a,a,a,ae,c,c,c,c,c,d,d,d,e,e,e,e,e,e,e,e,e,f,g,g,g,g,h,h,i,i,i,i,i,i,i,i,i,ij,j,k,k,l,l,l,l,l,n,n,n,n,n,n,o,o,o,o,oe,oe,o,o,o,o,oe,r,r,r,s,u,u,u,ue,u,ue,u,u,u,u,u,w,y,y,y,z,z,z,t,ss,ss,A,B,V,G,D,E,YO,ZH,Z,I,Y,K,L,M,N,O,P,R,S,T,U,F,H,C,CH,SH,SCH,Y,Y,E,YU,YA,a,b,v,g,d,e,yo,zh,z,i,y,k,l,m,n,o,p,r,s,t,u,f,h,c,ch,sh,sch,y,y,e,yu,ya');
    $string = urldecode(str_replace($from, $to, $string));
    $string = preg_replace('/[^a-zA-Z0-9 ]/', "", $string);

    return ($string);

}
//-------------------------------------------------------------------
/* function to return a slug from post name */
//-------------------------------------------------------------------
function make_slug($slug) {

    $slug = safe_string($slug);
    $slug = str_replace(' ', '-', $slug);
    $dash = array('--', '---', '----', '-----');
    $slug = strtolower(str_replace($dash, '-', $slug));

    return ($slug);

}
//-------------------------------------------------------------------
/* A function to correctly form tags */
//-------------------------------------------------------------------
function make_tag($tags) {

    if (isset($tags)) {

	$tags = explode(" ", $tags);

	for ($count = 0; $count < (count($tags)); $count++) {

	    $current = $tags[$count];

		if ($current != "") {

		    $current = safe_string($current);

			if ( (isset($all_tag)) ) { } else { $all_tag = NULL; }

		    $all_tag .= $current . " ";
		}
	}

	return rtrim($all_tag);

    }

}
//-------------------------------------------------------------------
/* A function to revert slug / used for tags only */
//-------------------------------------------------------------------
function squash_slug($title) {

    $slug = str_replace('-', " ", $title);

    return strtolower($slug);

}
//-------------------------------------------------------------------
/* A function to check if a page is installed and public */
//-------------------------------------------------------------------
function public_page_exists($page_name) {

    $rs = safe_row('*', 'pixie_core', "page_name = '$page_name' AND public = 'yes' limit 0,1");

	if ($rs) {

	return TRUE;

	} else {

	    return FALSE;

	}

}
//-------------------------------------------------------------------
/* A function to check if a number is odd or even */
//-------------------------------------------------------------------
function is_even($number) {

    $result = $number % 2;

	if($result == 0) {

	    return TRUE;

	} else {

	    return FALSE;

	}

}
//-------------------------------------------------------------------
/* Allow PHP/HTML to be written into textarea */
//-------------------------------------------------------------------
function textarea_encode($html_code) {

    $from = array('<', '>');
    $to = array('#&50', '#&52');
    $html_code = str_replace($from, $to, $html_code);

    return $html_code;

}
//-------------------------------------------------------------------
/* Output title of current section for admin area */
//-------------------------------------------------------------------
function build_admin_title() {

    global $version, $lang, $s, $m, $x, $do;
	/* myaccount */
	if ((isset($s)) && ($s == 'myaccount')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_home']; }
	if ((isset($s)) && ($s == 'myaccount') && ($x == 'myprofile')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_profile']; }
	if ((isset($s)) && ($s == 'myaccount') && ($x == 'myprofile') && ($do == 'security')) { $title = $lang['nav1_home'] . ' - ' . $lang['nav2_security']; }
	/* publish - (needs expanding!) */
	if ((isset($s)) && ($s == 'publish')) { $title = $lang['nav1_publish']; }
	if ((isset($s)) && ($s == 'publish') && ($x == 'filemanager')) { $title = $lang['nav1_publish'] . ' - ' . $lang['nav2_files']; }
	/* settings - needs expanding! */
	if ((isset($s)) && ($s == 'settings')) { $title = $lang['nav1_settings']; }
	if ((isset($s)) && ($s == 'settings') && ($m == 'theme')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_theme']; }
	if ((isset($s)) && ($s == 'settings') && ($m == 'users')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_users']; }
	if ((isset($s)) && ($s == 'settings') && ($x == 'dbtools')) { $title = $lang['nav1_settings'] . ' - ' . $lang['nav2_backup']; }
	if ( (isset($version)) && (isset($title)) ) { echo "Pixie v{$version} : {$title}"; }
	else {  echo "Pixie v{$version}"; }

}
//-------------------------------------------------------------------
/*  Create a clean or ugly url based on the Pixie setting */
//-------------------------------------------------------------------
function createURL($s, $m = '', $x = '', $p = '') {

    global $site_url, $clean_urls;

	if ($clean_urls === 'yes') {

	    $return = "{$site_url}{$s}/{$m}/{$x}/{$p}";
	    $slash = array('//', '///', '////');
	    $return = str_replace($slash, "", $return);
	    $return = str_replace('http:', 'http://', $return);
	    $last = $return { strlen($return) - 1 };

		if ($last != '/') { $return = "{$return}/"; }

	    return $return;

	} else {

	    $return = "{$site_url}?s={$s}&m={$m}&x={$x}&p={$p}";
	    $return = str_replace('&m=&x=&p=', "", $return);
	    $return = str_replace('&x=&p=', "", $return);

		if (!$p) { $return = str_replace('&p=', "", $return); }
	    $return = htmlspecialchars($return, ENT_QUOTES, 'UTF-8');

	    return $return;

	}

}
//-------------------------------------------------------------------
/* Reset the page order */
//-------------------------------------------------------------------
function page_order_reset() {

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
/* Create list of blocks with form adder */
//-------------------------------------------------------------------
function form_blocks() {

    global $s, $m, $x, $site_url, $lang;
    $dir = './blocks';

	if ( (is_dir($dir)) ) {

	    $fd = @opendir($dir);

		if($fd) {

		    while ( ($part = @readdir($fd) ) == TRUE) {

			if ( ($part != '.') && ($part != '..') ) {

			    if ( ($part != 'index.php') && (preg_match('/^block_.*\.php$/', $part)) ) {

				$part = str_replace('block_', "", $part);
				$part = str_replace('.php', "", $part);

				    if ( isset($cloud) ) { } else { $cloud = NULL; }

				$cloud .= "\t\t\t\t\t\t\t\t\t<a href=\"#\" title=\"Add block: $part\">$part</a>\n";
			    }
			}
		    }
		}
	}

	if ( (isset($cloud)) && ($cloud) ) {

	    $cloud  = substr($cloud , 0, (strlen($cloud) - 1)) . "";
	    echo "\t\t\t\t\t\t\t\t<div class=\"form_block_suggestions\" id=\"form_block_list\">";
	    echo "<span class=\"form_block_suggestions_text\">" . $lang['form_help_current_blocks'] . "</span>\n $cloud\n";
	    echo "\t\t\t\t\t\t\t\t</div>\n";
	}

}
//-------------------------------------------------------------------
/* Protect email from spam bots */
//-------------------------------------------------------------------
function encode_email($emailaddy, $mailto = 0) {

    $emailNOSPAMaddy = '';
    srand ( (float) microtime() * 1000000 );

	for ($i = 0; $i < strlen($emailaddy); $i = $i + 1) {

	    $j = floor(rand(0, 1 + $mailto));

		if ($j == 0) {

		    $emailNOSPAMaddy .= '&#' . ord(substr($emailaddy, $i, 1)) . ';';

		} elseif ($j === 1) {

		    $emailNOSPAMaddy .= substr($emailaddy, $i, 1);

		} elseif ($j === 2) {

		    $emailNOSPAMaddy .= '%' . zeroise(dechex(ord(substr($emailaddy, $i, 1))), 2);
		}
	}

	$emailNOSPAMaddy = str_replace('@', '&#64;', $emailNOSPAMaddy);

	return $emailNOSPAMaddy;

}
//-------------------------------------------------------------------
/* Get extended entry info (<!--more-->) */
//-------------------------------------------------------------------
function get_extended($post) { /* Match the more links */

    if ( preg_match('/<!--more(.*?)?-->/', $post, $matches) ) {

	list($main, $extended) = explode($matches[0], $post, 2);

    } else {

	$main = $post;
	$extended = '';
    }

    /* Strip leading and trailing whitespace */

    $main = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $main);
    $extended = preg_replace('/^[\s]*(.*)[\s]*$/', '\\1', $extended);

    return array('main' => $main, 'extended' => $extended);

}
//-------------------------------------------------------------------
/* Don't call sterilise unless necessary */
//-------------------------------------------------------------------
function sterilise_txt($txt, $is_sql = FALSE) {

    if (!preg_match('/^[a-zA-ZÀÁÂÃÄÅĀĄĂÆÇĆČĈĊĎĐÐÈÉÊËĒĘĚĔĖĜĞĠĢĤĦÌÍÎÏĪĨĬĮİĲĴĶŁĽĹĻĿÑŃŇŅŊÒÓÔÕÖØŌŐŎŒŔŘŖŚŠŞŜȘŤŢŦȚÙÚÛÜŪŮŰŬŨŲŴÝŶŸŹŽŻÞÞàáâãäåāąăæçćčĉċďđðèéêëēęěĕėƒĝğġģĥħìíîïīĩĭįıĳĵķĸłľĺļŀñńňņŉŋòóôõöøōőŏœŕřŗšùúûüūůűŭũųŵýÿŷžżźþßſАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыэюя0-9\_]+$/', $txt))

	return sterilise($txt, $is_sql);

	return $txt;

}
//-------------------------------------------------------------------
/* Steralise user input, security against XSS etc */
//-------------------------------------------------------------------
function sterilise($val, $is_sql = FALSE) {

    /* 	Remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	this prevents some character re-spacing such as <java\0script>
	note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs	 */

    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	   
    /* 	Straight replacements, the user should never need these since they're normal characters
	this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29> 	*/

    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    $search = 'ÀÁÂÃÄÅĀĄĂÆÇĆČĈĊĎĐÐÈÉÊËĒĘĚĔĖĜĞĠĢĤĦÌÍÎÏĪĨĬĮİĲĴĶŁĽĹĻĿÑŃŇŅŊÒÓÔÕÖØŌŐŎŒŔŘŖŚŠŞŜȘŤŢŦȚÙÚÛÜŪŮŰŬŨŲŴÝŶŸŹŽŻÞÞàáâãäåāąăæçćčĉċďđðèéêëēęěĕėƒĝğġģĥħìíîïīĩĭįıĳĵķĸłľĺļŀñńňņŉŋòóôõöøōőŏœŕřŗšùúûüūůűŭũųŵýÿŷžżźþßſАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыэюя';

	for ($i = 0; $i < strlen($search); $i++) {

	    /* 	;? matches the ;, which is optional
		0{0,7} matches any padded zeros, which are optional and go up to 8 chars
	   
		&#x0040 @ search for the hex values 	*/

	    $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); /* With a ; */

	    /* &#00064 @ 0{0,7} matches '0' zero to seven times */

	    $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); /* With a ; */
	}

	/* now the only remaining whitespace attacks are \t, \n, and \r */

	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);
	$found = TRUE; /* keep replacing as long as the previous round replaced something */

	    while ($found === TRUE) {

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
			    $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2);/* Add in <> to nerf the tag */
			    $val = preg_replace($pattern, $replacement, $val); /* Filter out the hex tags */

				if ($val_before == $val) {

				    /* No replacements were made, so exit the loop */

				    $found = FALSE;
				}
		    }
	    }

		if ($is_sql) {

		    $val = mysql_real_escape_string($val);
		}

		return $val;

}
?>