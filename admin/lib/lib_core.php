<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: lib_core.                                                //
//*****************************************************************//

// prepare for table prefix
if (!empty($pixieconfig['table_prefix'])) {
	define ('PFX', $pixieconfig['table_prefix']); } else { if (!defined('PFX')) { define ('PFX', ''); }
					  }

if (!function_exists('adjust_prefix')) {
	function adjust_prefix($table){
		if (stripos($table, PFX) === 0) return $table;
		else return PFX . $table;
	}
}

// ------------------------------------------------------------------
// class for displaying contents of a db table
class ShowTable {

	var $Res;
	var $exclude = array();
	var $table_name;
	var $view_number;
	var $lo;
	var $finalmax;
	var $whereami;
	var $a_array = array();
	var $edit;

	function ShowTable ($Res, $exclude, $table_name, $view_number, $lo, $finalmax, $whereami, $type, $s) {

		$this->Res = $Res;
		$this->exclude = $exclude;
		$this->table = $table_name;
		$this->limit = $view_number;
		$this->num = $lo;
		$this->finalmax = $finalmax;
		$this->whereami = $whereami;
		$this->page_type = $type;
		$this->s = $s;
	}

	function DrawBody () {

		global $date_format, $lang, $page_display_name;

		echo "\t<table class=\"tbl $this->table\" summary=\"" . $lang['results_from'] . " $this->table.\">
							<thead>
								<tr>";

	  	for ($j = 0; $j < mysql_num_fields($this->Res); $j++) {
	  		if (!in_array(mysql_field_name($this->Res, $j), $this->exclude))
			    if ( (isset($arlen)) && (isset($sum)) ) {
				$arlen[$j] = mysql_field_len($this->Res, $j); $sum += $arlen[$j];
			    }
		}

		for ($j = 0; $j < mysql_num_fields($this->Res); $j++) {
			if (!in_array(mysql_field_name($this->Res, $j), $this->exclude)) {
				$st3="class=\"tbl_heading\"";
				$fieldname = simplify(mysql_field_name($this->Res, $j));

				if ( (isset($lang['form_' . mysql_field_name($this->Res, $j)])) && ($lang['form_' . mysql_field_name($this->Res, $j)]) ) {

				    $fieldname = $lang['form_' . mysql_field_name($this->Res, $j)];
				}
				    echo "<th $st3 id=\"" . mysql_field_name($this->Res, $j) . "\">$fieldname</th>";
			}
		}

		echo "
									<th class=\"tbl_heading\" id=\"page_edit\"></th>
									<th class=\"tbl_heading\" id=\"page_delete\"></th>
								</tr>
							</thead>";


		if ($this->finalmax)
			$this->limit = $this->finalmax;

		echo "
							<tbody>";
		$counter = NULL;
		while ($counter < $this->limit) {
			$F = mysql_fetch_array($this->Res);
			if (is_even($counter))
				$trclass = 'odd';
			else
				$trclass = 'even';

			echo "
								<tr class=\"$trclass\">\n";

			for ($j = 0; $j < mysql_num_fields($this->Res); $j++) {
				if (!in_array(mysql_field_name($this->Res, $j), $this->exclude)) {
					if (mysql_field_type($this->Res, $j) == 'timestamp') {
						$logunix = returnUnixtimestamp($F[$j]);
						$date = safe_strftime($date_format, $logunix);
						echo "
									<td class=\"tbl_row\" headers=\"" . mysql_field_name($this->Res,$j) . "\">" . $date . "</td>";
					} else if (mysql_field_name($this->Res, $j) == 'url') {
						echo "
									<td class=\"tbl_row\" headers=\"" . mysql_field_name($this->Res,$j) . "\"><a href=\"" . $F[$j] . "\">" . $F[$j] . "</a></td>";
					} else if (mysql_field_name($this->Res, $j) == 'email') {
						echo "
									<td class=\"tbl_row\" headers=\"" . mysql_field_name($this->Res,$j) . "\"><a href=\"mailto:" . $F[$j] . "\">" . $F[$j] . "</a></td>";
					} else if ($F[$j] == "") {
						echo "
									<td class=\"tbl_row\" headers=\"" . mysql_field_name($this->Res,$j) . "\">No Content</td>";
					} else {
						echo "
									<td class=\"tbl_row\" headers=\"" . mysql_field_name($this->Res,$j) . "\">" . strip_tags($F[$j]) . "</td>";
					}
				}
			}

			echo "
									<td class=\"tbl_row tbl_edit\" headers=\"page_edit\"><a href=\"$this->whereami&amp;edit=$F[0]\" title=\"" . $lang['edit'] . "\">" . $lang['edit'] . "</a></td>
									<td class=\"tbl_row tbl_delete\" headers=\"page_delete\"><a href=\"$this->whereami&amp;delete=$F[0]\" onclick=\"return confirm('" . $lang['sure_delete_entry'] . " (#$F[0]) " . $lang['from_the'] . " $page_display_name " . $lang['settings_page'] . "?')\" title=\"" . $lang['delete'] . "\">".$lang['delete'] . "</a></td>
								</tr>";

			$counter++;
		}

		echo "
							</tbody>
						</table>\n";
	}
}

// ------------------------------------------------------------------
// class for add/edit new records in db table
	class ShowBlank {

		var $Nam;
	 	var $Typ;
	 	var $Res;
	 	var $Flg;
	 	var $Pkn;
		var $edit_exclude = array();
		var $table_name;

		function ShowBlank ($Nam, $Typ, $Len, $Flg, $Res, $Pkn, $edit_exclude, $table_name) {
			$this->Nam = $Nam;
			$this->Typ = $Typ;
			$this->Len = $Len;
			$this->Res = $Res;
			$this->Flg = $Flg;
			$this->Pkn = $Pkn;
			$this->exclude = $edit_exclude;
			$this->tablename = $table_name;
		}
		
		function ShowBody () {
	 		global $edit, $s, $m, $x, $page, $page_display_name, $lang, $type;

			// check $edit against $x - they need to represent the same page, if not redirect.
			$checkid = safe_field('page_id', 'pixie_core', "page_name='$x'");
			
			if ((isset($edit)) && ($edit) && ($m == 'static')) {
				if ($edit != $checkid) {
					echo "<div class=\"helper\"><h3>" . $lang['help'] . "</h3><p>" . $lang['unknown_edit_url'] . "</p></div>";
					$cancel = TRUE;
				}
			}

			if ( isset($cancel) ) { } else { $cancel_not_set = 1; }

			if ($cancel_not_set == 1) {
			
				$Nams = explode( '|', substr($this->Nam, 0, (strlen( $this->Nam ) - 1)) );
				$Type = explode( '|', substr($this->Typ, 0, (strlen( $this->Typ ) - 1)) );
				$Leng = explode( '|', substr($this->Len, 0, (strlen( $this->Len ) - 1)) );
				$Flag = explode( '|', substr($this->Flg, 0, (strlen( $this->Flg ) - 1)) );
				$Fild = explode( '|', substr($this->Res, 0, (strlen( $this->Res ) - 1)) );
		
				if (!$page) { $page = 1; }

				if ((isset($s)) && ($s == 'settings')) {
					if (strpos($this->tablename, 'module')) {
						$formtitle = $lang['advanced'] . " " . $lang['page_settings'];
					} else if (strpos($this->tablename, 'dynamic')) {
						$formtitle = $lang['advanced'] . " " . $lang['page_settings'];
					} else {
						$formtitle = $lang['page_settings'];
					}
				} else {
					if ((isset($edit)) && ($edit)) {
						if ($m == 'static') {
							$formtitle = $lang['edit'] . " $page_display_name " . $lang['settings_page'];
						} else {
							$formtitle = $lang['edit'] . " $page_display_name " . str_replace('.', "", $lang['entry']) . " (#$edit)";
						}
					} else {
						$formtitle = $lang['new_entry'] . " $page_display_name " . str_replace('.', "" ,$lang['entry']);
					}
				}

				if ((isset($s)) && ($s == 'settings')) {
					$post = "?s=$s&amp;x=$x";
				} else if (($m == 'static') && (isset($edit))) {
					$post = "?s=$s&amp;m=$m&amp;x=$x&amp;edit=$edit&amp;page=$page";
				} else {
					$post = "?s=$s&amp;m=$m&amp;x=$x&amp;page=$page";
				}
				echo "<form accept-charset=\"UTF-8\" action=\"$post\" method=\"post\" id=\"form_addedit\" class=\"form\">\n";
				echo "\t\t\t\t\t\t<fieldset>\n\t\t\t\t\t\t<legend>$formtitle</legend>\n";
				echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"table_name\" value=\"$this->tablename\" maxlength=\"80\" />\n";
		
				for ($j = 0; $j < count($Nams); $j++) {
					// clears out the form as some of the fields populate
					if ((!isset($edit)) or (!$edit)) { 
					$Fild[$j] = "";
				}

				// if comments are disabled then hide the field
				if (($Nams[$j] == 'comments' ) && (!public_page_exists('comments'))) {
					echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"no\" maxlength=\"" . $Leng[$j] . "\" />\n";
					$j++;
				}

				if (!in_array($Nams[$j], $this->exclude)) { //fields populated and output depending on type etc.
	
					//$searchfor = "_".first_word($Nams[$j]);
					
					if ($Leng[$j] < 40) {
						$ln = $Leng[$j];
					} else if ($Leng[$j] <= 400) {
						$ln = 50;
					}

					$nullf = explode(" ", $Flag[$j]);

	   				if ($nullf[0] == 'not_null') { // label required fields
	   					if ( (isset($lang['form_' . $Nams[$j]])) ) {
						if ( ($Nams[$j] != 'page_name')  or ($type == 'static') or (!isset($edit)) or (!$edit) ) {	/* Prevents the editing of page_name which does not work in modules and dynamic pages */
	   						$displayname = $lang['form_' . $Nams[$j]] . " <span class=\"form_required\">" . $lang['form_required'] . "</span>";
						} else {
	   						$displayname = " <span style=\"display:none\" class=\"form_required\">" . $lang['form_required'] . "</span>";
						}
	   					} else {
	   						$displayname = simplify($Nams[$j]) . " <span class=\"form_required\">" . $lang['form_required'] . "</span>";
	   					}
	   				} else {
	   					if ( (isset($lang['form_' . $Nams[$j]])) && ($lang['form_' . $Nams[$j]]) ) {
	   						$displayname = $lang['form_' . $Nams[$j]] . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span>";
	   					} else {
	   						$displayname = simplify($Nams[$j]) . " <span class=\"form_optional\">" . $lang['form_optional'] . "</span>";
	   					}
	   				}

	   				// check language file for any form help
	   				if ( (isset($lang['form_help_' . $Nams[$j]])) && ($lang['form_help_' . $Nams[$j]]) ) {

					    if ( ($Nams[$j] != 'page_name')  or ($type == 'static') or (!isset($edit)) or (!$edit) ) {	/* Prevents the editing of page_name which does not work in modules and dynamic pages */
	   					$form_help = "<span class=\"form_help\">" . $lang['form_help_' . $Nams[$j]] . "</span>";

					    } else {
	   					$form_help = "<span style=\"display:none\" class=\"form_help\">" . $lang['form_help_' . $Nams[$j]] . "</span>";
					    }

					} else {
	   					$form_help = "";
					}

					if ($GLOBALS['rich_text_editor'] == 1) {
	   					$containsphp = strlen(stristr(utf8_decode( ($Fild[$j]) ), '<?php')) > 0;

	   					if ($containsphp) {
	   						$form_help .= " <span class=\"alert\">" . $lang['form_php_warning'] . '</span>';
	   					}
	   				}
		  
	   			echo "\t\t\t\t\t\t\t<div class=\"form_row\">\n\t\t\t\t\t\t\t\t<div class=\"form_label\">
					<label for=\"$Nams[$j]\">" . $displayname . "</label>$form_help</div>\n";    //$Type[$j] $Leng[$j] $Flag[$j] for field info
	   				//echo "$Nams[$j] - $Type[$j] - $Leng[$j] - $Flag[$j]"; // see form field properties
					if ( ($Type[$j] == 'timestamp') && (!isset($edit)) && (!$edit) ) {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";

	   					if (isset($date)) { date_dropdown($date); } else { $date = NULL; date_dropdown($date); }

	   					echo "\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   				} else if (($Type[$j] == 'timestamp') && (isset($edit)) && ($edit)) {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";
		   				date_dropdown($Fild[$j]);
	   					echo "\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   				//} else if ($Type[$j] == "blob") {
	   				//	echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea\">\n\t\t\t\t\t\t\t\t<textarea name=\"$Nams[$j]\" class=\"form_item_textarea_no_ckeditor\">$Fild[$j]</textarea>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n"; 	   				
	   				} else if ($Type[$j] == 'longtext' or $Leng[$j] > 800 or $Type[$j] == 'blob') {
	   					if ($GLOBALS['rich_text_editor'] == 1) {
	   						if (!$containsphp) {
	   							echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea_ckeditor\">\n\t\t\t\t\t\t\t\t\t\t<textarea name=\"$Nams[$j]\" id=\"$Nams[$j]\" cols=\"50\" class=\"ck-textarea\" rows=\"10\">" . htmlentities($Fild[$j], ENT_QUOTES, 'UTF-8') . "</textarea>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n"; // id=\"$Nams[$j]\"
	   						} else {
	   							echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea\">\n\t\t\t\t\t\t\t\t<textarea name=\"$Nams[$j]\" class=\"form_item_textarea_no_ckeditor\">" . htmlspecialchars($Fild[$j], ENT_QUOTES, 'UTF-8') . "</textarea>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n"; // id=\"$Nams[$j]\"
	   						}
	   					} else {
	   						echo "\t\t\t\t\t\t\t\t<div class=\"form_item_textarea\">\n\t\t\t\t\t\t\t\t<textarea name=\"$Nams[$j]\" class=\"form_item_textarea_no_ckeditor\">" . htmlspecialchars($Fild[$j], ENT_QUOTES, 'UTF-8') . "</textarea>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n"; // id=\"$Nams[$j]\"
	   					}
	   				} else if ($Type[$j] == "set'yes','no'" or $Flag[$j] == 'not_null set') {
	   					if ($Fild[$j] == 'no') {
	   						echo "\t\t\t\t\t\t\t\t<div class=\"form_item_radio\">\n\t\t\t\t\t\t\t\tYes<input type=\"radio\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" class=\"form_radio\" value=\"yes\" />
	   						     	No<input checked=\"checked\" type=\"radio\" name=\"$Nams[$j]\" class=\"form_radio\" value=\"$Fild[$j]\" />\n\t\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t\t</div>\n";
	   					} else {
		   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_radio\">\n\t\t\t\t\t\t\t\tYes<input checked=\"checked\" type=\"radio\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" class=\"form_radio\" value=\"yes\" />
	   						     	No<input type=\"radio\" name=\"$Nams[$j]\" class=\"form_radio\" value=\"no\"/>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   					}
	   				} else if (first_word($Nams[$j]) == 'image') {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop image_preview\">\n";
	   					db_dropdown('pixie_files', $Fild[$j], $Nams[$j], "file_type = 'Image' order by file_id desc");
	   					echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $Nams[$j] . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower($lang['upload']) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
					} else if (first_word($Nams[$j]) == 'document') {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";
	   					db_dropdown('pixie_files', $Fild[$j], $Nams[$j], "file_type = 'Other' order by file_id desc");
	   					echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $Nams[$j] . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower($lang['upload']) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
					} else if (first_word($Nams[$j]) == 'video') {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";
	   					db_dropdown('pixie_files', $Fild[$j], $Nams[$j], "file_type = 'Video' order by file_id desc");
	   					echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $Nams[$j] . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower($lang['upload']) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
					} else if (first_word($Nams[$j]) == 'audio') {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";
	   					db_dropdown('pixie_files', $Fild[$j], $Nams[$j], "file_type = 'Audio' order by file_id desc");
	   					echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $Nams[$j] . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower($lang['upload']) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
					} else if (first_word($Nams[$j]) == 'file') {
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">\n";
	   					db_dropdown('pixie_files', $Fild[$j], $Nams[$j], "file_id >= '0' order by file_id desc");
	   					echo "\n\t\t\t\t\t\t\t\t<span class=\"more_upload\">or <a href=\"#\" onclick=\"upswitch('" . $Nams[$j] . "'); return false;\" title=\"" . $lang['upload'] . "\">" . strtolower($lang['upload']) . "...</a></span>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   				} else if ($Nams[$j] == 'tags') {
	   					$tableid = 0;
						$condition = $tableid . " >= '0'"; 
						form_tag($this->tablename, $condition);
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item\">\n\t\t\t\t\t\t\t\t<input type=\"text\" class=\"form_text\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" value=\"$Fild[$j]\" size=\""; if ( (isset($ln)) ) { echo $ln; } else { $ln = 25; echo $ln; } echo "\" maxlength=\"" . $Leng[$j] . "\" />\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	   				} else if ($Nams[$j] == 'page_blocks') {
	   					form_blocks();
	 	   				echo "\t\t\t\t\t\t\t\t<div class=\"form_item\">\n\t\t\t\t\t\t\t\t<input type=\"text\" class=\"form_text\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" value=\"$Fild[$j]\" size=\""; if ( (isset($ln)) ) { echo $ln; } else { $ln = 25; echo $ln; } echo "\" maxlength=\"" . $Leng[$j] . "\" />\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n";
	 	   			} else if ($Nams[$j] == 'privs') {
	 	   				if ($Fild[$j] == 2) {
	 	   					$adminclass = "selected=\"selected\""; $everyoneclass = NULL;
	 	   				} else {
	 	   					$everyoneclass = "selected=\"selected\""; $adminclass = NULL;
	 	   				}
	 	   				echo "\t\t\t\t\t\t\t\t<div class=\"form_item_drop\">
									<select class=\"form_select\" name=\"$Nams[$j]\" name=\"$Nams[$j]\">
										<option value=\"2\" $adminclass>Administrators only</option>
										<option value=\"1\" $everyoneclass>Administrators &amp; Clients</option>
									</select>
	   							</div>\n\t\t\t\t\t\t\t</div>\n";
	   				} else {
						if ( ($Nams[$j] != 'page_name')  or ($type == 'static') or (!isset($edit)) or (!$edit) ) {	/* Prevents the editing of page_name which does not work in modules and dynamic pages */
	   					echo "\t\t\t\t\t\t\t\t<div class=\"form_item\">\n\t\t\t\t\t\t\t\t<input type=\"text\" class=\"form_text\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" value=\"" . htmlspecialchars($Fild[$j], ENT_QUOTES, 'UTF-8') . "\" size=\""; if ( (isset($ln)) ) { echo $ln; } else { $ln = 25; echo $ln; } echo "\" maxlength=\"" . $Leng[$j] . "\" />\n\t\t\t\t\t\t\t\t</div>";
						} else {
	   					echo "\t\t\t\t\t\t\t\t<div style=\"display:none\" class=\"form_item\">\n\t\t\t\t\t\t\t\t<input style=\"display:none\" type=\"text\" class=\"form_text\" name=\"$Nams[$j]\" id=\"$Nams[$j]\" value=\"" . htmlspecialchars($Fild[$j], ENT_QUOTES, 'UTF-8') . "\" size=\""; if ( (isset($ln)) ) { echo $ln; } else { $ln = 25; echo $ln; } echo "\" maxlength=\"" . $Leng[$j] . "\" />\n\t\t\t\t\t\t\t\t</div>";
						}
	   					echo "\n\t\t\t\t\t\t\t</div>\n";
	   				} 

					//other field types still to come: File uploads...?
	   				
	 				//hidden fields populated
				} else {
					if ((($Nams[$j] == 'page_id') && (isset($s)) && ($s == 'publish') && ($m == 'dynamic'))) {
						$page_id = get_page_id($x);
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"$page_id\" maxlength=\"" . $Leng[$j] . "\" />\n";
					} else if (last_word($Nams[$j]) == 'id') {
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"$Fild[$j]\" maxlength=\"" . $Leng[$j] . "\" />\n";
					} else if (($Nams[$j] == 'author')) {
						if ((isset($edit)) && ($edit)) {
							$output = $Fild[$j];
						} else {
							if (!isset($GLOBALS['pixie_user'])) { $GLOBALS['pixie_user'] = NULL; }
							$output = $GLOBALS['pixie_user'];
						}
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"" . $output . "\" maxlength=\"" . $Leng[$j] . "\" />\n";
					} else if ($Type[$j] == "timestamp"){
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"" . returnSQLtimestamp(time()) . "\" maxlength=\"" . $Leng[$j] . "\" />\n";
					} else if ($Nams[$j] == 'page_type') {
						if ($type) {
							$output = $type;
						} else {
							if (isset($edit)) {
							$output =  safe_field('page_type', 'pixie_core', "page_id='$edit'");
							}
						}
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"" . $output . "\" maxlength=\"" . $Leng[$j] . "\" />\n";
					} else if (($Nams[$j] == 'publish' && !$edit)) {
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"yes\" maxlength=\"0\" />\n";
					} else if ($Nams[$j] == 'page_content') {
						// do nothing
					} else if ($Nams[$j] == 'admin') {
						// do nothing
							} else {
						echo "\t\t\t\t\t\t\t<input type=\"hidden\" class=\"form_text\" name=\"$Nams[$j]\" value=\"$Fild[$j]\" maxlength=\"" . $Leng[$j] . "\" />\n";
					}
				}
			}
	 		
			if ((isset($edit)) && ($edit)) {
				echo "\t\t\t\t\t\t\t<div class=\"form_row_button\">\n\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"submit_edit\" class=\"form_submit\" value=\"" . $lang['form_button_update'] . "\" />\n\t\t\t\t\t\t\t</div>\n";
			} else if ((isset($go)) && ($go == 'new')) {
				// do a save draft and save button button?? - when everything can be saved as a draft and is autosaved using AJAX
				} else {
			  echo "\t\t\t\t\t\t\t<div class=\"form_row_button\" id=\"form_button\">\n\t\t\t\t\t\t\t\t<input type=\"submit\" name=\"submit_new\" class=\"form_submit\" value=\"" . $lang['form_button_save'] . "\" />\n\t\t\t\t\t\t\t</div>\n";
			}
			if ($m != 'static') {
				echo "\t\t\t\t\t\t\t<div class=\"form_row_button\">\n\t\t\t\t\t\t\t\t<span class=\"form_button_cancel\"><a href=\"?s=$s&amp;m=$m&amp;x=$x\" title=\"" . $lang['form_button_cancel'] . "\">" . $lang['form_button_cancel'] . "</a></span>\n\t\t\t\t\t\t\t</div>\n";
			}
			echo "\t\t\t\t\t\t\t<div class=\"safclear\"></div>\n\t\t\t\t\t\t</fieldset>\n";
				echo "\t\t\t\t\t</form>";
			}
		}
	} 
// ------------------------------------------------------------------
// build module page
	function admin_module($module_name, $table_name, $order_by, $asc_desc, $exclude = array(NULL), $edit_exclude = array(NULL), $view_number, $tags) { 
	
	  global $type, $go, $page, $message, $s, $m, $x, $edit, $submit_new, $submit_edit, $delete, $messageok, $new, $search_submit, $field, $search_words;
	  
		if ((isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 1)) {

			$type = 'module';

			if ((isset($go)) && ($go == 'new') && (isset($table_name))) {
				admin_head();
				admin_new($table_name, $edit_exclude);
			} else if ((isset($edit)) && ($edit) && (isset($table_name))) {
				admin_head();
				admin_edit($table_name, $module_name . '_id', $edit, $edit_exclude);
			} else if (isset($table_name)) {
				
				admin_carousel($x);
				
				echo "\n\t\t\t\t<div id=\"blocks\">\n";
				admin_block_search($type);
				if ((isset($tags)) && ($tags == 'yes')) {
					admin_block_tag_cloud($table_name, $module_name . "_id >= 0");
				}
				echo "\t\t\t\t</div>\n";

				admin_head();
				echo "\t\t\t\t<div id=\"pixie_content\">";
					admin_overview($table_name, '', $order_by, $asc_desc, $exclude, $view_number, $type);
				echo "\t\t\t\t</div>\n";
			}
	  }
	}

// ------------------------------------------------------------------
// display page information
	function admin_head() {
		global $s, $m, $x, $page_display_name, $page_id, $edit, $go, $lang, $tag, $search_words, $search_submit;
		$rs = safe_row('*', 'pixie_core', "page_name = '$x' limit 0,1");
		if ($rs) {
			extract($rs);
			if ((isset($tag)) && ($tag)) {
				$stitle = $page_display_name . " (" . ucwords($lang['all_posts_tagged']) . ": " . $tag .")";
			} else if ($search_words) {
				$stitle = $page_display_name . " (" . $lang['search'] . ": " . chopme(sterilise($search_words), 40) . ")";
			} else if ($search_submit) {
				$stitle = $page_display_name . " (" . $lang['search'] . ": $search_submit)";
			} else {
				$stitle = $page_display_name;
			}

			if ((!isset($edit)) or (!$edit)) {
				if ((!isset($go)) or (!$go)) {
				// do not want people to be able to add to comments in this way
				if ($x != 'comments') {
				echo "
				<ul id=\"page_tools\">
					<li><a href=\"?s=$s&amp;m=$m&amp;x=$x&amp;go=new\" title=\"" . $lang['new_entry'] . "$page_display_name " . str_replace('.', "",$lang['entry']) . "\">" . $lang['new_entry'] . "$page_display_name " . str_replace('.', "", $lang['entry']) . "</a></li>
				</ul>\n";
				}
				}
			}
			echo "\t\t\t\t<div id=\"page_header\">
					<h2>$stitle</h2>
			</div>\n";		
		}
	}
// ------------------------------------------------------------------
// display admin block for searching
	function admin_block_search($type) {
		global $s, $m, $x, $lang;
		echo "\n\t\t\t\t\t<div id=\"admin_block_search\" class=\"admin_block\">
			\t\t\t<h3 class=\"$type\">" . $lang['search'] . "</h3>\n";
		echo "\t\t\t\t\t\t<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;m=$m&amp;x=$x\" method=\"post\" id=\"search\">
							<fieldset>
							<legend>" . $lang['search'] . "</legend>
								<div class=\"form_row\">
									<div class=\"form_label\"><label for=\"search-keywords\">" . $lang['form_search_words'] . "</label></div>
									<div class=\"form_item\"><input type=\"text\" name=\"search_words\" id=\"search-keywords\" value=\"\" class=\"form_text\" size=\"25\" /></div>
								</div>							
								<div class=\"form_row_button\">
									<input type=\"submit\" name=\"search_submit\" id=\"search_submit\" value=\"" . $lang['search'] . "\" />
								</div>
							</fieldset>
						</form>";
		echo "\n\t\t\t\t\t</div>\n";
	}
// ------------------------------------------------------------------ 
// view table overview
	function admin_overview($table_name, $condition, $order_by, $asc_desc, $exclude = array(NULL), $view_number, $type)  {
		global $page, $message, $s, $m, $x, $messageok, $search_submit, $field, $search_words, $tag, $lang;

		$table_name = adjust_prefix($table_name);
		
		$searchwords = trim($search_words);
		
		if ($page) {
			$searchwords = $search_submit;
		}
			
		if (($search_submit) && (isset($table_name))) {
			$searchwords = sterilise($searchwords, FALSE);
			//build search sql
			$r2 = safe_query("show fields from $table_name");
			for ($j = 0; $j < mysql_num_rows($r2); $j++) {
				if ($F = mysql_fetch_array($r2)) {
					$an[$j] = $F['Field'];
				}
				if (last_word($an[$j]) != 'id') {
					if($an[$j] != 'posted') {
						if($an[$j] != 'author') {
							if($an[$j] != 'comments') {
								if($an[$j] != 'public') {
									if(first_word($an[$j]) != 'last') {
										if($an[$j] != 'date') {
											$search_sql .= $an[$j] . " like '%" . $searchwords . "%' OR ";
										}
									}
								}
							}
						}
					}
				}
			}
			$search_sql = substr($search_sql, 0, (strlen($search_sql) - 3)) . "";
			//echo $search_sql;
		}

	if (isset($tag)) { $tag = squash_slug($tag); }

	    if (isset($table_name)) { 

		if ($search_submit)	{
			if ($m == 'dynamic') {
				$page_id = get_page_id($x);
				$r1 = safe_query("select * from $table_name where page_id = '$page_id' and (" . $search_sql . ") order by $order_by $asc_desc");
			} else {
				$r1 = safe_query("select * from $table_name where " . $search_sql . " order by $order_by $asc_desc");
			}
		} else if ((isset($tag)) && ($tag)) {
			$r1 = safe_query("select * from $table_name where tags REGEXP '[[:<:]]" . $tag . "[[:>:]]' order by $order_by $asc_desc");
		} else {
			$r1 = safe_query("select * from $table_name $condition order by $order_by $asc_desc");
		}

	    }

		if ($r1) {  

 	 	 	$total = mysql_num_rows($r1);

			if ((!isset($page)) && (isset($table_name))) {
				$lo = 0;
				$page = 1;

				if ($search_submit)	{
					if ($m == 'dynamic') {
						$page_id = get_page_id($x);
						$r = safe_query("select * from $table_name where page_id = '$page_id' and (" . $search_sql . ") order by $order_by $asc_desc");
					} else {
						$r = safe_query("select * from $table_name where " . $search_sql . " order by $order_by $asc_desc");
					}
				} else if ((isset($tag)) && ($tag)) {
					$r = safe_query("select * from $table_name where tags REGEXP '[[:<:]]" . $tag . "[[:>:]]' order by $order_by $asc_desc");
				} else {
					$r = safe_query("select * from $table_name $condition order by $order_by $asc_desc limit $lo,$view_number");
				}
			} else if (isset($table_name)) {
				$lo = ($page - 1) * $view_number;
				if ($search_submit)	{
					if ($m == 'dynamic') {
						$page_id = get_page_id($x);
						$r = safe_query("select * from $table_name where page_id = '$page_id' and (" . $search_sql . ") order by $order_by $asc_desc");
					} else {
						$r = safe_query("select * from $table_name where " . $search_sql . " order by $order_by $asc_desc");
					}
				} else if ((isset($tag)) && ($tag)) {
					$r = safe_query("select * from $table_name where tags REGEXP '[[:<:]]" . $tag . "[[:>:]]' order by $order_by $asc_desc");				
				} else {	
					$r = safe_query("select * from $table_name $condition order by $order_by $asc_desc limit $lo,$view_number");
				}
			}

			if ($r) {				
				$rows = mysql_num_rows($r);
				$hi = $lo + $view_number; if ($hi > $total) { $finalmax = $total-$lo; $hi = $total; }
				$pages = ceil($total/$view_number);

				if ($pages < 1) {
					$pages = 1;
				}
			}

			/* Was : */ /* $a = &new Paginator_html($page, $total); */ /* but it's providing a "Assigning the return value of new by reference is deprecated" message. */
			$a = new Paginator_html($page, $total);
   			$a->set_Limit($view_number);
   			$a->set_Links(4);
   			$whereami = "?s=$s&amp;m=$m&amp;x=$x";

			if ((isset($tag)) && ($tag)) {
				$whereami = "?s=$s&amp;m=$m&amp;x=$x&amp;tag=$tag";
			}

			if ($search_submit) {
				$whereami = "?s=$s&amp;m=$m&amp;x=$x&amp;search_submit=$searchwords";
			}

   		echo "\n\t\t\t\t\t<div class=\"admin_table_holder pcontent\">\n\t\t\t\t\t";
	   	$wheream = "?s=$s&amp;m=$m&amp;x=$x&amp;page=$page";

	   	if ( (isset($table_name)) && ($rows) ) {

		    if ( isset($finalmax) && ($finalmax) ) { } else { $finalmax = NULL; }

		    $Table = new ShowTable ($r, $exclude, $table_name, $view_number, $lo, $finalmax, $wheream, $type, $s);
		    $Table->DrawBody();
		    $loprint = $lo + 1;
		    echo "\n\t\t\t\t\t\t<div id=\"admin_table_overview\">\n\t\t\t\t\t\t\t<p>" . $lang['total_records'] . ": $total (" . $lang['showing_from_record'] . " $loprint " . $lang['to'] . " $hi) $pages " . $lang['page(s)'] . ".</p>\n\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t<div id=\"admin_table_pages\">\n\t\t\t\t\t\t\t";
		    echo "<p>"; 
		    $a->previousNext($whereami);
		    echo "</p>";
		    echo "\n\t\t\t\t\t\t</div>";
	    	
	   	} else {
	   		if (($search_submit) or (isset($tag)) && ($tag)) {
 	   			echo "<div class=\"helper\"><h3>" . $lang['help'] . "</h3><p>" . $lang['helper_search'] . "</p></div>";
	   		} else {
	   			echo "<div class=\"helper\"><h3>" . $lang['help'] . "</h3><p>" . $lang['helper_nocontent'] . "</p></div>";
	   		}
				echo "\n\t\t\t\t\t</div>\n"; 
			}
			if ($rows) {
				echo "\n\t\t\t\t\t</div>\n";
			}
  	}
	}
// ------------------------------------------------------------------
// show the page carousel
	function admin_carousel($current) {
		global $s, $lang;

		echo "<h2>" . $lang['nav2_pages'] . "</h2>\n";

		$rz = safe_rows('*', 'pixie_core', "public = 'yes'  and publish = 'yes' order by page_order asc");
		$cc = 1;

		if (count($rz) <= 1) {
				if ((isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 2)) {
	   			echo "\t\t\t\t<div class=\"helper\"><h3>" . $lang['help'] . "</h3><p>" . $lang['helper_nopages404'] . " " . $lang['helper_nopagesadmin'] . "</p></div>\n";
				} else {
					echo "\t\t\t\t<div class=\"helper\"><h3>" . $lang['help'] . "</h3><p>" . $lang['helper_nopages404'] . " " . $lang['helper_nopagesuser'] . "</p></div>\n";
				}
		} else {
			
		echo "\t\t\t\t<ul id=\"mycarousel\" class=\"jcarousel-skin-tango\">\n";
		if (isset($GLOBALS['pixie_user_privs'])) {
		$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'yes' and publish = 'yes' and page_type != 'plugin' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_order asc");
		}
		if ($rs) {	
			$num = count($rs);
			$i = 0;
			while ($i < $num){
				$out = $rs[$i];
				$page_display_name = $out['page_display_name'];
				$page_name = $out['page_name'];
				$page_type = $out['page_type'];
				$page_id = $out['page_id'];		

				$m = $page_type;
				$x = $page_name;

				if ($current == $x) {
					$class = 'current';
					$scroll = $cc;
				} else {
					$class ="";
				}
				if ($m == 'dynamic') {
					echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page innav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_dynamic.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				} else if ($m == 'module') {
				  echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page innav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_module.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				} else {
				  echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page innav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x&amp;edit=$page_id\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_static.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				}
				$cc++;
				$i++;
			}
		}

		if (isset($GLOBALS['pixie_user_privs'])) {
		$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'no' and publish = 'yes' and page_type != 'plugin' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_name asc");
		}

		if ($rs) {
			$num = count($rs);
			$i = 0;
			while ($i < $num){
				$out = $rs[$i];
				$page_display_name = $out['page_display_name'];
				$page_name = $out['page_name'];
				$page_type = $out['page_type'];
				$page_id = $out['page_id'];		

				$m = $page_type;
				$x = $page_name;

				if ($current == $x) {
					$class = 'current';
					$scroll = $cc;
				} else {
					$class ="";
				}
				
				if ($m == 'dynamic') {
					echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page outnav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_dynamic_white.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				} else if ($m == 'module') {
				  echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page outnav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_module_white.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				} else {
				  echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page outnav $class\"><a href=\"?s=$s&amp;m=$m&amp;x=$x&amp;edit=$page_id\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_static_white.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				}
				
				$cc++;
				$i++;
			}
		}

		if (isset($GLOBALS['pixie_user_privs'])) {
		$rs = safe_rows('*', 'pixie_core', "public = 'yes' and in_navigation = 'no' and publish = 'yes' and page_type = 'plugin' and privs <= '" . $GLOBALS['pixie_user_privs'] . "' order by page_order asc");
		}
		if ($rs) {
			$num = count($rs);
			$i = 0;
			while ($i < $num){
				$out = $rs[$i];
				$page_display_name = $out['page_display_name'];
				$page_name = $out['page_name'];
				$page_type = $out['page_type'];
				$page_id = $out['page_id'];		

				$m = $page_type;
				$x = $page_name;
				
				if ($current == $x) {
					$class = 'current';
					$scroll = $cc;
				} else {
					$class ="";
				}				

				echo "\t\t\t\t\t<li id=\"c_$page_name\" class=\"page plugin $class\"><a href=\"?s=$s&amp;m=module&amp;x=$x\"><span class=\"page_title\">$page_display_name</span><img src=\"admin/theme/images/icons/page_plugin.png\" alt=\"$m\" class=\"picon\" /></a></li>\n";
				
				$cc++;
				$i++;
			}
		}	
		echo "\t\t\t\t</ul>\n";
		}

	}
// ------------------------------------------------------------------
// edit table entry
	function admin_edit($table_name, $edit_id, $edit, $edit_exclude) {
	  global $message, $m, $lang;
	  
	  	if (isset($table_name)) { $table_name = adjust_prefix($table_name); }
		if ((isset($edit)) && (isset($table_name))) {
		$sql = "select * from $table_name where " . $edit_id . "=" . $edit . "";
		$r2 = safe_query($sql);
		}

		if ($r2) {
					$an = NULL;
					$at = NULL;
					$al = NULL;
					$af = NULL;
					$az = NULL;

			if ($f = mysql_fetch_array($r2))  {
				for ($j = 0; $j < mysql_num_fields($r2); $j++) {
					$an .= mysql_field_name($r2, $j) . "|";
					$at .= mysql_field_type($r2, $j) . "|";
					$al .= mysql_field_len($r2, $j) . "|";
					$af .= mysql_field_flags($r2, $j) . "|";
					$az .= $f[$j] . "|";
				}

				if ($m == 'static') {
					echo "\n\t\t\t\t<div class=\"admin_form form_static\">\n\n\t\t\t\t\t";
				} else {
					echo "\n\t\t\t\t<div class=\"admin_form\">\n\n\t\t\t\t\t";
				}
				if (isset($table_name)) {
				    if (!isset($nam)) { $nam = NULL; }
				$Blank = new ShowBlank($an, $at, $al, $af, $az, $nam, $edit_exclude, $table_name);
				$Blank->ShowBody();
				}
				echo "\n\t\t\t\t</div>";
	 		}
		} else {
			$message = $lang['form_build_fail'];
		}
	}
// ------------------------------------------------------------------
// add new table entry
	function admin_new($table_name, $edit_exclude) {

	    if (isset($table_name)) {

		$an = $at = $af = $az = $al = '';
		
		$r2 = safe_query('show fields from ' . PFX . "$table_name");	
		$r3 = safe_query('select * from ' . PFX . "$table_name WHERE 1=0");
		for ($j = 0; $j < mysql_num_rows($r2); $j++) {  
			$flags = mysql_field_flags($r3, $j);
			$af .= $flags . '|';
		  
			if ($F = mysql_fetch_array($r2)) {
				$an .= $F['Field'] . '|';
				/* Was : */ /* $at .= ereg_replace('([()0-9]+)', "", $F['Type']) . '|'; */ /* But ereg_replace() is now depreciated. */
				$at .= preg_replace('([()0-9]+)', "", $F['Type']) . '|';
			}
			if (preg_match('([0-9]+)', $F['Type'], $str)) { /* Was if (ereg ('([0-9]+)', $F['Type'], $str)) { */ /* But ereg is depreciated */
				$al .= $str[0] . '|';
			} else {
				$al .= '|';
				$az .= $F['Default'] . '|';
			}
			if ($F['Key'] == "PRI") {
				$nam = $F['Field'];
			}
		}

	      echo "\n\t\t\t\t<div id=\"admin_form\">\n\n\t\t\t\t\t";  
	      if (isset($table_name)) {
	      $Blank = new ShowBlank($an, $at, $al, $af, $az, $nam, $edit_exclude, $table_name);
	      $Blank->ShowBody();
	      }
	      echo "\n\t\t\t\t</div>";
	    }

	}
// ------------------------------------------------------------------
// delete code
	if ((isset($GLOBALS['pixie_user'])) && (isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 1)) {
		if (isset($delete)) {
			if ((isset($s)) && ($s == 'settings') && ($delete == 1)) {
				// protect 404
			} else if ((isset($s)) && ($s == 'settings')) {
				$table = 'pixie_core';
				$id = 'page_id';
			} else if ((isset($s)) && ($s == 'publish') && ($m == 'dynamic')) {
				$table = 'pixie_dynamic_posts';
				$id = 'post_id';
			} else if ((isset($s)) && ($s == 'publish') && ($m == 'module')) {
				$table = 'pixie_module_' . $x;
				$id = $x . '_id';
			}
			
			$table = adjust_prefix($table);
				
			$getdetails = extract(safe_row('*', "$table", "$id='$delete' limit 0,1"));
			if ($getdetails) {
				$del = safe_delete("$table", "$id='$delete'");
			}
	
			if ((isset($del)) && ($del)) {
				if ( (isset($s)) && (isset($m)) && ($s == 'settings') && ($m == 'dynamic') ) {
					$page_display_name = safe_field('page_display_name', 'pixie_core', "page_id='$del'");
					//do not delete the posts as one false click could destroy lots of data. Backup first?
					//safe_delete("pixie_dynamic_posts", "page_id='$delete'"); 
					safe_delete('pixie_dynamic_settings', "page_id='$delete'");
				}
		
				if ((isset($s)) && (isset($m)) && (isset($del)) && ($s == 'settings') && ($m == 'static')) {
					$page_display_name = safe_field('page_display_name', 'pixie_core', "page_id='$del'");
					safe_delete('pixie_static_posts', "page_id='$delete'");
				}
		
				if ((isset($s)) && (isset($m)) && ($s == 'settings') && ($m == 'module')) {
					$table_mod = PFX . 'pixie_module_' . $page_name;
					$table_mod_settings = PFX . 'pixie_module_' . $page_name . '_settings';
					
					$sql = "DROP TABLE IF EXISTS $table_mod";
					$sql1 = "DROP TABLE IF EXISTS $table_mod_settings";
					
					//do not drop the tables as one false click could destroy lots of data. Backup first?
					//safe_query($sql);
					//safe_query($sql1);
					
					//do not remove the file as we might want to reinstall at a later date
					//file_delete("modules/".$page_name.".php");
				}
		
				if ($table == PFX . 'pixie_core') {
					$messageok = $lang['ok_delete_page'] . " " . $page_display_name . " " . $lang['page'];
					$icon = 'site'; 
					$alert = 'yes';
				} else {
					$page_display_name = safe_field('page_display_name', 'pixie_core', "page_name='$x'");
					$messageok = $lang['ok_delete_entry'] . " " . $page_display_name . " " . $lang['page'];
					$icon = 'page';
					$alert = 'no';
				}
				logme($messageok, $alert, $icon);
				if (isset($table_name)) { safe_optimize("$table_name"); safe_repair("$table_name"); }
			} else {
				if (!$message) {
					if ((isset($s)) && ($s == 'settings') && ($delete == 1)) {
						$message = $lang['failed_protected_page'];
						$imp = 'yes';
					} else {
						$message = $lang['failed_delete'];
						$imp = 'no';
					}
					logme($message, $imp, 'error');
				}
			}
		}
	}
// ------------------------------------------------------------------
// save and edit code	/* This is too much of a mess to add an isset $table_name check. It needs to be cleaned up. */
	if ((isset($GLOBALS['pixie_user'])) && (isset($GLOBALS['pixie_user_privs'])) && ($GLOBALS['pixie_user_privs'] >= 1)) {
		
		if ((isset($submit_edit)) && ($submit_edit) or (isset($submit_new)) && ($submit_new)) {
			$rs = safe_row('*', 'pixie_core', "page_name = '$x' limit 0,1");
			
			if ($rs) {
				extract($rs);
			}
			
			foreach ($_POST as $key=>$value) {
				if (($key == 'day') or ($key == 'month') or ($key == 'year') or ($key == 'time')) {
					$value = str_replace(':', "", $value);
					
					if ($key == 'time') {
						if (strlen($value) == 3) {
							$value = 0 . $value;
						}
					}
					
					$timey[] = $value;
				}
				//echo "$key - $value <br>"; //enable to see $_post output
			}
			
			if ( (isset($timey)) && ($timey) ) {

			    if ( (!checkdate($timey[1], $timey[0], $timey[2])) ) {

				$error .= $lang['date_error'] . ' ';

			    } else {

				$minute = substr($timey[3], 2, 4);
				$hour = substr($timey[3], 0, 2);
				$unixtime = mktime($hour, $minute, 00, $timey[1], $timey[0], $timey[2]);
			    }
			}

		$r2 = safe_query('show fields from ' . adjust_prefix($table_name));
		$r3 = safe_query('select * from ' . adjust_prefix($table_name) . ' WHERE 1=0');
		for ($j = 0; $j < mysql_num_rows($r2); $j++) {
		  	$flags = mysql_field_flags($r3, $j);
		  	$af[$j] = $flags;
      	if ($F = mysql_fetch_array($r2)) {
      		$an[$j] = $F['Field'];
		/* Was : */ /* $at[$j] = ereg_replace('([()0-9]+)', "", $F['Type']); */ /* But ereg_replace() is now depreciated. */
      		$at[$j] = preg_replace('([()0-9]+)', "", $F['Type']);
      	}
      	//echo $an[$j]."-".$at[$j]."-".$af[$j]."<br>"; //enable to see field properties 

	}

    for ($j = 0; $j < mysql_num_rows($r2); $j++) {

			$check = new Validator ();

			if ($at[$j] == 'timestamp' && !array_key_exists("$an[$j]", $_POST)) {

			    $check->validateNumber($unixtime, 'invalid time' . ' ');

				if ( (isset($sql)) ) { } else { $sql = NULL; }

				$sql .= "" . $an[$j] . " = '" . returnSQLtimestamp($unixtime) . "',";

			} else if ( (last_word($an[$j]) == 'id') ) {

			    if ( (isset($had_id)) ) { } else {

				$had_id = 1;
				$editid = $_POST[$an[$j]];
				$idme = $an[$j];
			    }

			} else if (($an[$j] == 'page_content') && (isset($s)) && ($s == 'settings')) {
				//skip it to protect the php in the page_content field
			} else if (($an[$j] == 'admin') && (isset($s)) && ($s == 'settings')) {
				//skip it to protect the php code in the admin field
			} else {     	
				$value = $_POST[$an[$j]];
				if ($an[$j] == 'title') { $tit = $value; }
				if ($at[$j] == 'varchar') { $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }

				// check for posts with duplicate title/slug and increment
				if ($an[$j] == 'post_slug') {
					if (!$value) {
						$value = make_slug($tit);
						$value = strtolower($value);
						$searchforslug = safe_rows('*', $table_name, "post_slug REGEXP '[[:<:]]" . $value . "[[:>:]]'");
						if ($searchforslug) {
							$addslug = count($searchforslug);
							$value = $value . '-' . $addslug;
						}
					}
				}

				// check for pages with duplicate title/slug and increment
				if ($an[$j] == 'page_name') {
					$oldvalue = safe_field('page_name', $table_name, "page_id='$editid'");
					if ($value != $oldvalue) {
						$searchforpage = safe_rows('*', $table_name, "page_name REGEXP '[[:<:]]" . $value . "[[:>:]]'");
						if ($searchforpage) {
							$addpage = count($searchforpage);
							$value = $value . '-' . $addpage;
						}
					}
					// force the value to be lowercase and without spaces for slug
					$value = strtolower(str_replace(" ", "", preg_replace('/\s\s+/', ' ', trim($value))));
				}
	      	
				// set a page_order, and navigation settings for a newly saved page
				if ($an[$j] == 'public') {
					if ($value == 'yes') {
						$itspublic = 'yes';
					}
				}
				if ($an[$j] == 'in_navigation') {
					if ($value == 'yes') {
						$innavigation = 'yes';
					}
				}
				if ($an[$j] == 'page_order') {	      		
					if ($itspublic) {
						if ($value != 0) {
							if ($innavigation) {
								if ((isset($submit_new)) && ($submit_new)) {
									$value = count(safe_rows('*', $table_name, "public='yes' and in_navigation='yes' order by post_order asc"))+1;
								}
							} else {
								$value = 0;
							}
						} else {
							if ($innavigation) {
								$value = count(safe_rows('*', $table_name, "public='yes' and in_navigation='yes' order by post_order asc"))+1;
							} else {
								$value = $value;
							}
						}
					} else {
							$value = 0;
					}
				}
	      	
				// validate and clean input
				$value = str_replace('|', '&#124;', $value);
				$nullf = explode(" ", $af[$j]);	      	
				if ($an[$j] == 'tags') { $value = make_tag($value); }
				if (get_magic_quotes_gpc() == 0) { $value = addslashes ($value); }
				if ($at[$j] == 'varchar') { sterilise(strip_tags($value)); }
				if (($an[$j] == 'url') or ($an[$j] == 'website')) {
					if ($nullf[0] == 'not_null') { 
						$check->validateURL($value, $lang['url_error'] . ' ' );
					} else if ($value != "") { 
						$check->validateURL($value, $lang['url_error'] . ' ' );
					}	
				}
	     
				if ($at[$j] == 'longtext') {
					// remove para from <!--more-->
					if ( (isset($m)) && ($m == 'dynamic') ) {
						// hacky to try and clean the more
						$value = str_replace('<p><!--more--></p>', '<!--more-->', $value);
						$value = str_replace('<p> <!--more--></p>', '<!--more-->', $value);
						$value = str_replace('<!--more--></p>', '</p><!--more-->', $value);
						$value = str_replace('<p><!--more-->', '<!--more--><p>', $value);
					}
				} 
				
				if ($an[$j] == 'email') {
					if ($nullf[0] == 'not_null') {
						$check->validateEmail($value, $lang['email_error'] . ' ');
					} else if ($value != "") {
						$check->validateEmail($value, $lang['email_error'] . ' ');
					}
				}
				if (($nullf[0] == 'not_null') && ($value == "")) { $error .= ucwords($an[$j]) . " " . $lang['is_required'] . ' '; }
				
				// if empty int set to 0
				if( $at[$j] == 'int' ) $value = ($value ? $value : 0);

				    if ( isset($sql) ) { } else { $sql = NULL; }

					$sql .= "`" . $an[$j] . "` = '" . $value . "',";

				if ($check->foundErrors()) { $error .= $check->listErrors('x'); }
	      	
			}
		}

		if ( isset($sql) ) { } else { $sql = NULL; }

		    $sql = substr($sql, 0, (strlen($sql) - 1)) . "";

		//echo $sql; //view the SQL for current form save
				
		if (!isset($error)) {
			if ((isset($submit_new)) && ($submit_new)) {
				$ok = safe_insert($table_name, $sql);
				$idofsave = mysql_insert_id();
				safe_optimize($table_name);
				safe_repair($table_name);
				
			  if (!$ok) {
				$message = $lang['unknown_error'];
				logme($message, 'no', 'error'); 
			  } else {

					if ((isset($s)) && ($s == 'settings') && ($page_type == 'dynamic')) {
						$sql = "`page_id` = '$idofsave', `posts_per_page` = '10', `rss` = 'yes'"; 
						safe_insert('pixie_dynamic_settings', $sql);
					}

					if ($table_name == 'pixie_core') {
						$output = safe_field('page_display_name', 'pixie_core', "page_id='$idofsave'");
						$icon = 'site';
						$messageok = $lang['saved_new_page'] . ": $output.";
					} else {
						$ptitle = $title;
						$output = $page_display_name;
						$icon = 'page';
						if (isset($ptitle)) {
							$messageok = $lang['saved_new'] . ": $ptitle " . $lang['in_the'] . " $output " . $lang['page'];
						} else {
							$messageok = $lang['saved_new'] . " (#$idofsave) " . $lang['in_the'] . " $output " . $lang['page'];
						}
					}
					
					logme($messageok, 'no', $icon); 
				}
			}
			if ((isset($submit_edit)) && $submit_edit) {
				$ok = safe_update("$table_name", "$sql", "`$idme` = '$editid'");
				if (!$ok) {
					$message = $lang['unknown_error'];
				} else {
				
					if ((isset($s)) && ($s == 'settings')) {
						$output = $page_display_name;
							$icon = 'site';
						if ($output) {
							$messageok = $lang['saved_new_settings_for'] . " " . $output . " " . $lang['page'];
						} else {
							$output = safe_field('page_display_name', 'pixie_core', "page_id='$page_id'");
							$messageok = $lang['saved_new_settings_for'] . " " . $output . " " . $lang['page'];
						}
						page_order_reset();
					}


					if ((isset($s)) && ($s == 'publish')) {
						$output = $title;
						$icon = 'page';
						$pname = safe_field('page_display_name', 'pixie_core', "page_id='$page_id'");
						if ($m == 'static') {
							$messageok = 'Saved updates to the ' . $pname . ' page.';
						} else {
							if ($output) {
								$messageok = $lang['save_update_entry'] . ': ' . $output . " " . $lang['on_the'] . " " . $pname . " ". $lang['page'];
							} else {
								$messageok = $lang['save_update_entry'] . " (#" . $editid . ") " . $lang['on_the'] . " " . $pname . " " . $lang['page'];
							}
						}
					}
					logme($messageok, 'no', $icon); 				  	
				}
			}					

		} else {
			$err = explode('|', $error);
			$message = $err[0];
		}	
		}
	}
?>