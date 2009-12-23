<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: lib_pixie.                                               //
//*****************************************************************//

// ------------------------------------------------------------------
// set up pixie and let the magic begin
	function pixie() 
	{
		global $s, $m, $x, $p, $rel_path, $staticpage, $style, $site_url, $page_display_name, $page_type, $page_id, $syle, $clean_urls, $default_page; 

		$request = $_SERVER['REQUEST_URI'];

		if ($style) {
			$request = str_replace("?style=".$style, "", $request);
		}

		$site_url_last = $site_url{strlen($site_url)-1};
		if ($site_url_last != "/") {
			$site_url = $site_url."/";
		}

		if ($clean_urls == "yes") {
			// if the request contains a ? then this person is accessing with a dirty URL and is handled accordingly 
			if (strpos($request, "?s=") !== false) {
				$rel_path = "./";
			} else {
				//this is directory level of your installation. check autofind works!?!?
				$url = explode("/",$request);
				$count = count($url);
				$site_url_x = str_replace("http://", "", $site_url);
				$temp = explode("/", $site_url_x);
				$install = count($temp);

				$dir_level = $install - 2;
				if ($dir_level < 0) {
					$dir_level = 0;
				}
				
				$s = strtolower($url[$dir_level+1]);
				$m = strtolower($url[$dir_level+2]);
				$x = strtolower($url[$dir_level+3]);
				$p = strtolower($url[$dir_level+4]);

				switch($count) {
					case $dir_level+3: 
						$rel_path = "../";
					break;
					case $dir_level+4:
						$rel_path = "../../";
					break;
					case $dir_level+5:
						$rel_path = "../../../";
					break;
					case $dir_level+6:
						$rel_path = "../../../../";
					break;
					default:
						$rel_path = "./";
					break;
				}
			}
		} else {
			$rel_path = "./";
		}

		if (!$s) {
			$last = $default_page{strlen($default_page)-1};
			$default = explode("/",$default_page);
			$s = sterilise_txt($default['0']);
			$m = sterilise_txt($default['1']);
			$x = sterilise_txt($default['2']);
			$p = sterilise_txt($default['3']);
		}
		
		$s = public_check_404($s);
		
		if ($s == "404") {
			$m = "";
			$x = "";
			$p = "";
		}
		
		if ($m == "rss") {
			$rss = public_check_rss($s);
			if (!$rss) {
				$s = "404";
				$m = "";
				$x = "";
				$p = "";
			}
		}
		
		$page_type = check_type($s);
		if ($page_type == "dynamic") {
			$style = $page_type;
		} else if ($page_type == "static") {
			$style = $s;
			$m = "";
			$x = "";
			$p = "";
		} else if ($s == "404") {
			$style = "404";
		} else {
			$style = $s;
		}

		$s = str_replace("-", "BREAK", $s);
		$m = str_replace("-", "BREAK", $m);
		$x = str_replace("-", "BREAK", $x);
		$p = str_replace("-", "BREAK", $p);
		$s = preg_replace("/[^a-zA-Z0-9]/", "", $s);
		$m = preg_replace("/[^a-zA-Z0-9]/", "", $m);
		$x = preg_replace("/[^a-zA-Z0-9]/", "", $x);
		$p = preg_replace("/[^a-zA-Z0-9]/", "", $p);
		$s = str_replace("BREAK", "-", $s);
		$m = str_replace("BREAK", "-", $m);
		$x = str_replace("BREAK", "-", $x);
		$p = str_replace("BREAK", "-", $p);

		$page_id = get_page_id($s);
		$page_hits = safe_field('page_views','pixie_core',"page_name='$s'");
		$page_display_name = safe_field('page_display_name','pixie_core',"page_name='$s'");
		safe_update("pixie_core", "page_views  = $page_hits + 1", "page_name = '$s'");
	}
// ------------------------------------------------------------------
// Build the navigation dynamically or build it from specified array
	function build_navigation()
	{
		global $s, $site_url, $nested_nav, $lang;

		$check_pages = safe_rows("*","pixie_core", "public = 'yes' and in_navigation = 'yes' and page_name not in ('404','rss') order by page_order asc");
		$num = count($check_pages);
		$current_dir = current_dir();

		echo "<h3>".$lang['navigation']."</h3>\n\t\t\t\t<ul id=\"navigation_1\">\n";
		$i = 0;
		$first = true; // first link
		$last = false; // last link
		while ($i < $num) {
			$out = $check_pages[$i];
			$page_display_name = $out['page_display_name'];
			$page_name = $out['page_name'];
			$page_type = $out['page_type'];
			if($i == ($num - 1)) $last = true;
			if ($s == $page_name) {
				if ($page_type == "dynamic") {
					$includestr = "dynamic";
				} else {
					$includestr = $page_name;
				}
				if (($nested_nav == "yes") && (file_exists('admin/blocks/block_'.$includestr.'_nav.php'))) {
					echo "\t\t\t\t\t<li id=\"li_1_$page_name\"><a href=\"".createURL($page_name)."\" title=\"$page_display_name\" id=\"navigation_1_$page_name\" class=\"nav_current_1 replace\">$page_display_name<span></span></a>\n";
					include('admin/blocks/block_'.$includestr.'_nav.php');
				} else {
					echo "\t\t\t\t\t<li id=\"li_1_$page_name\" class=\"nav_current_li_1".($first ? " first" : "").($last ? " last" : "")."\"><a href=\"".createURL($page_name)."\" title=\"$page_display_name\" id=\"navigation_1_$page_name\" class=\"nav_current_1 replace\">$page_display_name<span></span></a></li>\n";
					$first = false;
				}
			} else {
				echo "\t\t\t\t\t<li id=\"li_1_$page_name\"".($first ? " class=\"first\"" : "").($last ? " class=\"last\"" : "")."><a href=\"".createURL($page_name)."\" title=\"$page_display_name\" id=\"navigation_1_$page_name\" class=\"replace\">$page_display_name<span></span></a></li>\n";
				$first = false;
			}
			$i++;
		}

		echo "\t\t\t\t</ul>\n";

	}
// ------------------------------------------------------------------
// Build and include the blocks for this page
	function build_blocks() {
		global $s;

		extract(safe_row("*", "pixie_core", "page_name = '$s'"));
		$blocks = explode(" ", $page_blocks);

		for ($count=0; $count < (count($blocks)); $count++) {
			$current = $blocks[$count];
			$current = str_replace(" ", "", $current);

			if (file_exists('admin/blocks/block_'.$current.'.php')) { 
				include('admin/blocks/block_'.$current.'.php');
				echo "\n";
			}
		}
	}
// ------------------------------------------------------------------
// Build a header bar for logged in users
	function build_head() {
		global $site_url, $date_format;
			
		if(isset($_COOKIE['pixie_login'])) {	
			list($username,$cookie_hash) = split(',',$_COOKIE['pixie_login']);
			$nonce = safe_field('nonce','pixie_users',"user_name='$username'");

			if (md5($username.$nonce) == $cookie_hash) {
				$privs = safe_field('privs','pixie_users',"user_name='$username'");	
				$realname = safe_field('realname','pixie_users',"user_name='$username'");
				$GLOBALS['pixie_user'] = $username;  
				$user_count = mysql_num_rows(safe_query("select * from ".PFX."pixie_log_users_online"));
				$user_count = $user_count - 1;

				echo "
	<div id=\"admin_header\">
		<h1>Hello ".firstword($realname)."</h1>
		<div id=\"admin_header_text\"><p>".safe_strftime($date_format, time()).". Currently your site has $user_count visitor(s) online.</p></div>
		<div id=\"admin_header_controls\"><p><a href=\"".$site_url."admin/\" title=\"Goto Pixie\">Pixie</a><a href=\"".$site_url."admin/?s=logout\" title=\"Logout of pixie\">Logout</a></p></div>
	</div>\n";
			}
		}
	}
// ------------------------------------------------------------------
// Build title for current page
	function build_title($ptitle='') {
		global $site_name, $page_display_name, $page_type, $s, $m, $x, $p;
		
		// will probably need support for child pages!
		
		if ($ptitle) {
			echo $ptitle;
		} else {		
			if ($page_type == "dynamic" && $m == "permalink") {
				$post_title = safe_field('title', 'pixie_dynamic_posts', "post_slug = '$x'"); 
				echo "$site_name - $page_display_name - $post_title";
			} else if ($m == "tag") {
				if ($p) {
					echo "$site_name - $page_display_name - Tag - ".simplify(squash_slug($x))." - Page $p";
				} else {
					echo "$site_name - $page_display_name - Tag - ".simplify(squash_slug($x));
				}
			} else if ($m == "page") {
				echo "$site_name - $page_display_name - ".simplify($m)." ".simplify($x);
			} else if ($m) {
				echo "$site_name - $page_display_name - ".simplify($m);
			} else {
				echo "$site_name - $page_display_name";
			}
		}
	}
?>