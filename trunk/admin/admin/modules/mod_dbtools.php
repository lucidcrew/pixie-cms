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
 * Title: Database tools
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
//(would like cron (or similar) & email).   
if ($GLOBALS['pixie_user'] && $GLOBALS['pixie_user_privs'] >= 2) {
	if ($do == "backup") {
		$backup_obj               = new MySQL_Backup();
		$backup_obj->server       = $pixieconfig['host'];
		$backup_obj->username     = $pixieconfig['user'];
		$backup_obj->password     = $pixieconfig['pass'];
		$backup_obj->database     = $pixieconfig['db'];
		$backup_obj->tables       = array();
		$backup_obj->drop_tables  = true;
		$backup_obj->struct_only  = false;
		$backup_obj->comments     = true;
		$backup_obj->backup_dir   = '../files/sqlbackups/';
		$backup_obj->fname_format = 'd_m_Y-H-i-s';
		$filename                 = date("d_m_Y-H-i-s") . ".sql.gz";
		$task                     = MSB_SAVE;
		$use_gzip                 = true;
		if (!$backup_obj->Execute($task, '', $use_gzip)) {
			$message = $backup_obj->error;
		} else {
			$messageok = $lang['backup_ok'];
			logme($lang['backup_ok'], "no", "save");
			safe_update("pixie_settings", "last_backup = '$filename'", "settings_id = '1'");
			$prefs = get_prefs();
			extract($prefs);
		}
	}
	if (isset($del)) {
		if (file_exists("../files/sqlbackups/" . $del)) {
			$current = safe_field('last_backup', 'pixie_settings', "settings_id='1'");
			if ($current != $del) {
				$delk = file_delete("../files/sqlbackups/" . $del);
			} else {
				$unable = "yes";
			}
		}
		if ($delk) {
			$messageok = $lang['backup_delete_ok'] . " $del.";
			logme($lang['backup_delete_ok'] . " $del.", "no", "save");
		} else {
			if ($unable) {
				$message = $lang['backup_delete_no'];
			} else {
				$message = $lang['backup_delete_error'];
			}
		}
	}
?>
<div id="blocks">
					<div id="admin_block_backup" class="admin_block">
						<h3><?php
	echo $lang['create_backup'];
?></h3>
						<form action="?s=settings&amp;x=dbtools" method="post" id="backup_save">
							<fieldset>
							<legend><?php
	echo $lang['nav2_backup'];
?></legend>
								<div class="form_row_button">
									<input type="submit" name="backup_submit" id="backup_submit" value="<?php
	echo $lang['button_backup'];
?>" />
									<input type="hidden" name="do" value="backup" />
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<div id="pixie_content">
					<h2><?php
	echo $lang['database_backup'];
?></h2>
					<p><?php
	echo $lang['database_info'];
?></p>
					
					<div id="backup">
						<h3><?php
	echo $lang['database_backups'];
?></h3>
			
<?php
	$dir = "../files/sqlbackups/";
	if (is_dir($dir)) {
		$fd = @opendir($dir);
		if ($fd) {
			while (($part = @readdir($fd)) == true) {
				if ($part != "." && $part != "..") {
					if ($part != "index.php") {
						if ($part == $last_backup) {
							echo "\t\t\t\t\t\t<div class=\"abackup backuplatest\"><img src=\"admin/theme/images/icons/file_sql.png\" alt=\"SQL " . $lang['nav2_backup'] . "\" class=\"aicon\" /><span class=\"backup_fname\">" . str_replace(".sql.gz", "", $part) . "</span><a href=\"" . $site_url . "files/sqlbackups/$part\" title=\"" . $lang['download'] . ": $part\" class=\"backup_download\">" . $lang['download'] . "</a></div>\n";
						} else {
							echo "\t\t\t\t\t\t<div class=\"abackup\"><img src=\"admin/theme/images/icons/file_sql.png\" alt=\"SQL " . $lang['nav2_backup'] . "\" class=\"aicon\" /><span class=\"backup_fname\">" . str_replace(".sql.gz", "", $part) . "</span><a href=\"" . $site_url . "files/sqlbackups/$part\" title=\"" . $lang['download'] . ": $part\" class=\"backup_download\">" . $lang['download'] . "</a> <a href=\"?s=$s&amp;x=$x&amp;del=$part\" title=\"" . $lang['delete'] . ": $part\" onclick=\"return confirm('" . $lang['delete_file'] . " ($part)')\" class=\"backup_delete\">" . $lang['delete'] . "</a></div>\n";
						}
					}
				}
			}
		}
	}
?>
					</div>
				</div>
<?php
}
?>