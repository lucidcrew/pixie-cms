<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: All Pages with settings.                                 //
//*****************************************************************//

if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {

	$table_name = 'pixie_core';

	if ($empty) {
		$rf = safe_row('*', 'pixie_core', "page_id = '$empty'");

		if ($rf) {
			extract ($rf);
	
			if ($page_type == 'dynamic') {
				safe_delete('pixie_dynamic_posts', "page_id = '$empty'");
				safe_optimize('pixie_dynamic_posts');
				safe_repair("$pixie_dynamic_posts");		
			} else if ($page_type == 'static') {
				safe_update('pixie_core', "page_content = ''", "page_id = '$empty'");
				safe_optimize('pixie_core');
				safe_repair("$pixie_core");	
			} else {
				$table = 'pixie_module_' . $page_name;
				if (table_exists($table)) {
					safe_query("TRUNCATE TABLE $table");
					safe_optimize($table);
					safe_repair($table);
				}
			}
			
			if ($page_type == 'plugin') {
				$word = $lang['settings_plugin'] . '.';
			} else {
				$word = $lang['page'];
			}

			$messageok = $lang['all_content_deleted'] . " " . $page_display_name . " $word";
			logme($lang['all_content_deleted'] . " " . $page_display_name . " $word", 'yes', 'site');

		}

	}

	if ($edit) {
		
		$rs = safe_row('*', 'pixie_core', "page_id = '$edit'");
		extract ($rs);

		echo "<div id=\"page_header\">
					<h2>$page_display_name</h2>
				</div>";

		if ($page_type == 'plugin') {
			$word = $lang['settings_plugin'];
		} else {
			$word = $lang['settings_page'];
		}
		echo "\n\t\t\t\t<ul id=\"page_tools\">
					<li><a href=\"?s=$s&amp;delete=$page_id\" onclick=\"return confirm('" . $lang['sure_delete_page'] . " " . $page_display_name . " $word?')\" title=\"" . $lang['delete'] . " " . $lang['settings_page'] . ": $page_display_name\" class=\"page_delete\">" . $lang['delete'] . " " . $page_display_name . " $word</a></li>
					<li><a href=\"?s=$s&amp;empty=$page_id\" onclick=\"return confirm('" . $lang['sure_empty_page'] . " " . $page_display_name . " $word?')\" title=\"" . $lang['empty'] . " " . $lang['settings_page'] . ": $page_display_name\" class=\"page_empty\">" . $lang['empty'] . " " . $page_display_name . " $word</a></li>
				</ul>";

					
		$type = $page_type;
		$edit_id = 'page_id';

		if ($page_type == 'static') {
			admin_edit($table_name, $edit_id, $edit, $edit_exclude=array('page_id', 'page_type', 'page_views', 'publish', 'admin', 'page_content', 'last_modified', 'page_parent', 'page_order'));
		} else if ($page_type == 'plugin') {
			echo "\n\t\t\t\t<div class=\"helper\">\n\t\t\t\t\t<h3>" . $lang['help'] . "</h3>\n\t\t\t\t\t<p>" . $lang['helper_plugin'] . "</p>\n\t\t\t\t</div>";
		} else {
			admin_edit($table_name, $edit_id, $edit, $edit_exclude=array('page_id', 'page_type', 'page_views', 'publish', 'page_content', 'last_modified', 'page_parent', 'page_order'));
		}

		if ($page_type == 'dynamic') {
			admin_edit('pixie_dynamic_settings', $edit_id, $edit, $edit_exclude=array('settings_id', 'page_id', 'admin', 'page_content'));
		}

		if (($page_type == 'module') or ($page_type == 'plugin')) {
			$module_name = safe_field('page_name', 'pixie_core', "page_id = '$edit'");
			$table = 'pixie_module_' . $module_name . '_settings';
			$id = $module_name . '_id';
			if (table_exists($table)) {
				admin_edit($table, $id, '1', $edit_exclude=array($id));
			}
		}
	
		
	} else if ($do == 'newpage') {
		if ($type == 'dynamic') {
			echo "<div id=\"page_header\">
				<h2>" . $lang['settings_page_new'] . " $type " . $lang['settings_page'] . "</h2>
			</div>";
			admin_new($table_name, $edit_exclude=array('page_id', 'page_type', 'page_views', 'publish', 'admin', 'page_content', 'last_modified', 'page_parent', 'page_order'));
		} else if ($type == 'static') {
			echo "<div id=\"page_header\">
				<h2>" . $lang['settings_page_new'] . " $type " . $lang['settings_page'] . "</h2>
			</div>";
			admin_new($table_name, $edit_exclude=array('page_id', 'page_type', 'page_views', 'publish', 'admin', 'page_content', 'last_modified', 'page_parent', 'page_order'));			
		} else {
			if ($install) {
				if (!$modplug) {
					$message = $lang['no_module_selected'];
				} else {
					// lets install
					$do = install;
					include('modules/' . $modplug . '.php');
					
					if ($execute) {
						$execute =  str_replace('pixie_', $pixieconfig['table_prefix'] . "pixie_", $execute);
						safe_query($execute);
					} 
					if ($execute1) {
						$execute1 =  str_replace('pixie_', $pixieconfig['table_prefix'] . "pixie_", $execute1);
						safe_query($execute1);
					}
					if ($execute2) {
						$execute2 =  str_replace('pixie_', $pixieconfig['table_prefix'] . "pixie_", $execute2);
						safe_query($execute2);
					} 
					if ($execute3) {
						$execute3 =  str_replace('pixie_', $pixieconfig['table_prefix'] . "pixie_", $execute3);
						safe_query($execute3);
					} 
					if ($execute4) {
						$execute4 =  str_replace('pixie_', $pixieconfig['table_prefix'] . "pixie_", $execute4);
						safe_query($execute4);
					}  
					$do = info;
					include('modules/' . $modplug . '.php');

					// make a safe reference in core, not public etc
					$sql = "page_type = '$m_type', page_name = '$modplug', page_display_name = '$m_name', page_description = '$m_description', privs = '2', publish = '$m_publish', public = 'yes', in_navigation = 'no', searchable = 'no'"; 
					$coreok = safe_insert('pixie_core', $sql);
					
					if ($coreok) {
						$messageok = $m_name." " . $lang['install_module_ok'];
						logme($messageok, 'no', 'site'); 				  	
					}
				}
			}
			echo "<div id=\"page_header\">
					<h2>" . $lang['install_module'] . "</h2>
				</div>
			
				<div id=\"admin_form\">
						
					<form action=\"?s=settings&amp;x=pages&amp;do=newpage&type=module\" method=\"post\" id=\"form_modplug\" class=\"form\">
						<fieldset>
							<legend>" . $lang['select_module'] . "</legend>\n";
							
							$dir = 'modules/';
							if (is_dir($dir)) {
								$fd = @opendir($dir);
								if($fd) {
								while (($part = @readdir($fd)) == true) {
									if ($part != '.' && $part != '..') {
									if ($part != 'index.php') {
									if (last_word($part) != 'functions.php') {	
										$pname = str_replace('.php', "", $part);
										$rs = safe_row('*', 'pixie_core', "page_name = '$pname' order by page_name asc");
										
										if (!$rs) {
											if (($pname == 'dynamic') || ($pname == 'static')) { 	
												// ignore these pages
											} else {
												$do = 'info';
												include "modules/$part";
												$mfound = true; 
												echo "\t\t\t\t\t\t\t<div class=\"amodule\"><input type=\"radio\" name=\"modplug\" value=\"$pname\"><h3><img src=\"admin/theme/images/icons/page_" . $m_type . ".png\" alt=\"$m_type\" /> $m_name</h3> $m_description <span class=\"m_credits\"><b>Author:</b> <a href=\"$m_url\" title=\"$m_author\">$m_author</a> <b>Version:</b> v$m_version</span></div>\n";
											} 
										}
									}	
									}		
									}
									}
								}
							}
							
							if (!$mfound) {
								echo "\t\t\t\t\t\t<p>" . $lang['all_installed'] . "</p>";
							}


							echo "
							<div class=\"form_row_button\" id=\"form_button\">
								<input type=\"submit\" name=\"install\" class=\"form_submit\" id=\"form_modplug_submit\" value=\"" . $lang['form_button_install'] . "\" />
							</div>
							<div class=\"form_row_button\">
								<span class=\"form_button_cancel\"><a href=\"?s=settings\" title=\"" . $lang['form_button_cancel'] . "\">" . $lang['form_button_cancel'] . "</a></span>
							</div>
							<div class=\"safclear\"></div>
						</fieldset>
					</form>
				</div>";

		}
				
	} else {
?>
<div id="blocks">
					<div id="admin_block_addpage" class="admin_block">
						<h3><?php print $lang['settings_page_new'] . " " . $lang['settings_page']; ?></h3>

						<form action="?s=settings&amp;x=pages" method="post" id="newpage">
							<fieldset>
							<legend><?php print $lang['settings_page_new'] . " " . $lang['settings_page']; ?></legend>
							<div class="form_row">
								<div class="form_label"><label for="type"><?php print $lang['page_type']; ?> <span class="form_required"><?php print $lang['form_required']; ?></span></label><span class="form_help"><?php print $lang['form_help_settings_page_type']; ?></span></div>
								<div class="form_item_drop"><select class="form_select" name="type" id="type">
									<option value="dynamic">Dynamic</option>
									<option value="static">Static</option>
									<option value="module">Module/Plugin</option>
								</select>
							</div>
							</div>
								<div class="form_row_button">
									<input type="submit" name="backup_submit" id="backup_submit" value="<?php print $lang['form_button_create_page']; ?>" />
									<input type="hidden" name="do" value="newpage" />
								</div>
							</fieldset>

						</form>
					</div>
					<div id="admin_block_help" class="admin_block">
							<h3><?php print $lang['help']; ?></h3>
							<p><?php print $lang['help_settings_page_type']; ?></p>
							<ul>
								<li><img src="admin/theme/images/icons/page_dynamic.png" alt="Dynamic" /> <b>Dynamic</b> - <?php print $lang['help_settings_page_dynamic']; ?></li>
								<li><img src="admin/theme/images/icons/page_static.png" alt="Static" /> <b>Static</b> - <?php print $lang['help_settings_page_static']; ?></li>
								<li><img src="admin/theme/images/icons/page_module.png" alt="Module" /> <b>Module/Plugin</b> - <?php print $lang['help_settings_page_module']; ?></li>
							</ul>
					</div>
				</div>

				<div id="pixie_content">
					<h2><?php print $lang['nav2_pages']; ?></h2>

					<?php
					$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'yes' order by page_order asc");
					if ($rs) {
					$found = true;	
					?>
<h3><?php print $lang['pages_in_navigation']; ?></h3>
					<p class="smallerp"><?php print $lang['pages_in_navigation_info']; ?></p>
					<?php

					echo "<ul id=\"pages\" class=\"pagelist innav\">\n";
					$num = count($rs);
					$i = 0;
					while ($i < $num){
		  			$out = $rs[$i];
		  			$page_display_name = $out['page_display_name'];
		  			$page_name = $out['page_name'];
		  			$page_type = $out['page_type'];
		  			$page_id = $out['page_id'];
		  			if ($page_name == str_replace('/',"", $default_page)) {
		  				$homestyle = 'phome';
		  			} else {
		  				$homestyle = $page_type;
		  			}

		  			echo "\t\t\t\t\t\t<li id=\"$page_name\" class=\"page $homestyle\"><span class=\"page_title\">$page_display_name</span><div class=\"page_tools\"><a href=\"?s=$s&amp;x=$x&amp;edit=$page_id\" class=\"page_settings\">" . $lang['nav2_settings'] . "</a><span class=\"page_handle\"><img src=\"admin/theme/images/icons/up.png\" alt=\"up\" /><img src=\"admin/theme/images/icons/down.png\" alt=\"down\" /></span></div></li>\n";

		  		$i++;
					}

					echo "\t\t\t\t\t</ul>\n";
					}

					
					$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'no' and page_name != '404' and page_type != 'plugin' order by page_name asc");
					if ($rs) {
					$found = true;	
					?>
					
					<h3><?php print $lang['pages_outside_navigation']; ?></h3>
					<p class="smallerp"><?php print $lang['pages_outside_navigation_info']; ?></p>
					<?php
					
					echo "<ul class=\"pagelist outnav\">\n";
					$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'no' and page_name != '404' and page_type != 'plugin' order by page_name asc");
					$num = count($rs);
					$i = 0;
					while ($i < $num){
		  			$out = $rs[$i];
		  			$page_display_name = $out['page_display_name'];
		  			$page_name = $out['page_name'];
		  			$page_type = $out['page_type'];
		  			$page_id = $out['page_id'];		
		  		  if ($page_name == str_replace('/',"", $default_page)) {
		  				$homestyle = 'phome';
		  			} else {
		  				$homestyle = $page_type;
		  			}			
		  			echo "\t\t\t\t\t\t<li id=\"$page_name\" class=\"page $homestyle\"><span class=\"page_title\">$page_display_name</span><div class=\"page_tools\"><a href=\"?s=$s&amp;x=$x&amp;edit=$page_id\" class=\"page_settings\">" . $lang['nav2_settings'] . "</a></div></li>\n";

		  		$i++;
					}

					echo "\t\t\t\t\t</ul>\n";
					}
					
					$rs = safe_rows('*', 'pixie_core', "page_type = 'plugin' order by page_name asc");
					if ($rs) {
					$found = true;	
					?>

					<h3><?php print $lang['plugins']; ?></h3>
					<p class="smallerp"><?php print $lang['plugins_info']; ?></p>
					<?php

					echo "<ul class=\"pagelist plugin\">\n";
					$num = count($rs);
					$i = 0;
					while ($i < $num){
		  			$out = $rs[$i];
		  			$page_display_name = $out['page_display_name'];
		  			$page_name = $out['page_name'];
		  			$page_type = $out['page_type'];
		  			$page_id = $out['page_id'];				  			

		  			echo "\t\t\t\t\t\t<li id=\"$page_name\" class=\"page\"><span class=\"page_title\">$page_display_name</span><div class=\"page_tools\"><a href=\"?s=$s&amp;x=$x&amp;edit=$page_id\" class=\"page_settings\">" . $lang['nav2_settings'] . "</a></div></li>\n";

		  		$i++;
					}

					echo "\t\t\t\t\t</ul>\n\n";
					}

					$rs = safe_rows('*', 'pixie_core', "public = 'no' and page_type != 'plugin' order by page_name asc");
					if ($rs) {
					$found = true;	
					?>
					<h3><?php print $lang['pages_disabled']; ?></h3>
					<p class="smallerp"><?php print $lang['pages_disabled_info']; ?></p>
					<?php

					echo "<ul class=\"pagelist disabled\">\n";
					$num = count($rs);
					$i = 0;
					while ($i < $num){
		  			$out = $rs[$i];
		  			$page_display_name = $out['page_display_name'];
		  			$page_name = $out['page_name'];
		  			$page_type = $out['page_type'];
		  			$page_id = $out['page_id'];				  	
		  					
		  			$homestyle = $page_type;

		  			echo "\t\t\t\t\t\t<li id=\"$page_name\" class=\"page $homestyle\"><span class=\"page_title\">$page_display_name</span><div class=\"page_tools\"><a href=\"?s=$s&amp;x=$x&amp;edit=$page_id\" class=\"page_settings\">" . $lang['nav2_settings']."</a></div></li>\n";

		  		$i++;
					}

					echo "\t\t\t\t\t</ul>\n";
					}
					
					if (!$found) {
						echo "\n\t\t\t\t<div class=\"helper\">\n\t\t\t\t\t<h3>" . $lang['help'] . "</h3>\n\t\t\t\t\t<p>" . $lang['helper_nopages'] . "</p>\n\t\t\t\t</div>";
					}
					?>
				</div>
<?php
	}
}
?>