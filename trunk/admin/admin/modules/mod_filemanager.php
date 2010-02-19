<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: File Manager.                                            //
//*****************************************************************//

include_once 'lib/lib_upload.php';	/* We need function convertBytes here */
if (isset($GLOBALS['pixie_user']) && $GLOBALS['pixie_user_privs'] >= 1) {

/* New! pxfinder, use Pixie's builtin file manager to upload and select files in ckeditor dialogues. */
if ((isset($ck)) && ($ck == 1)) { /* Here the dialogu sends ck=1 in the request url and only if that happens do we do the following : */
?>
<style type="text/css">
#nav_level_1,#pixie_title span,#pixie_footer,#admin_block_tags,#tools{display:none;}
html{background-color:#ffffff;}
#pixie_content{width:56%;margin-right:25px;}
#blocks,#pixie_title{position:relative;}
#pixie_body{margin:45px 0 0;}
#pixie_header{width: 80%;}
#pixie_placeholder{max-width: 800px;min-width: 600px;}
</style>
<script type="text/javascript">    //<![CDATA[
    var $j = jQuery.noConflict();
function getUrlParam(paramName) /* Helper function to get parameters from the query string. */
{
  var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
  var match = window.location.search.match(reParam) ;
 
  return (match && match.length > 1) ? match[1] : '' ;
}
<?php
if ($ckFuncNumReturn) { echo "var funcNum = $ckFuncNumReturn;"; } else {
echo "var funcNum = getUrlParam('CKEditorFuncNum');"; }
?>
$j(function() {
    $j('.pxfinder').each(function(index) { /* Stop the default click action */
	$j(this).click(function(event) {
	    var pxfinderFilename =  $j(this).attr('alt'); /* Grab the file's name and folder then jam it into a variable we can use */
	    var pxfinderLocation =  $j('#tool_view a').attr('href'); /* Grab the site's url and jam it into a variable we can use */
	    var pxfinderUrl =  pxfinderLocation + 'files' + pxfinderFilename; /* Create the url for the ckeditor plugin to insert into your post */
	    event.preventDefault();
	    window.opener.CKEDITOR.tools.callFunction(funcNum, pxfinderUrl);
	    window.close();
	});
    });

}); /* End jQuery function */
 //]]></script>
<?php
}

	if ((isset($del)) && ($del)) { 

		$deldb = safe_delete('pixie_files', "file_name='$del'");

		if ($deldb) {
			$file_ext = substr(strrchr($del, '.'), 1);
			$file_ext = strtolower($file_ext);
			
			if (($file_ext == 'jpg') || ($file_ext == 'gif') || ($file_ext == 'png')) {
				$dir = '../files/images/';
			} else if (($file_ext == 'mov') || ($file_ext == 'flv') || ($file_ext == 'avi') || ($file_ext == 'm4v') || ($file_ext == 'mp4') || ($file_ext == 'mkv')|| ($file_ext == 'ogv')) {
				$dir = '../files/video/';	
			} else if (($file_ext == 'mp3') || ($file_ext == 'flac') || ($file_ext == 'ogg') || ($file_ext == 'wav') || ($file_ext == 'pls') || ($file_ext == 'm4a') || ($file_ext == 'xspf')) {
				$dir = '../files/audio/';	
			} else {
				$dir = '../files/other/';
			}

			if (file_exists($dir . $del)) { 
				$delk = file_delete($dir . $del);
			}
			
			if ($delk) {
				$messageok = $lang['file_delete_ok'] . " $del";
				logme($messageok, 'no', 'folder');
	  			safe_optimize('pixie_files');
				safe_repair('pixie_files');
			} else {
				$message = $lang['file_delete_fail'] . " $del (DBOK)";
			}
		} else {
		  $message = $lang['file_delete_fail'] . " $del";
		}

		/* If the file cannot be deleted, lets not show a success message */
		$file_upload_check = $dir . $del;
		if (file_exists($file_upload_check)) { $message = 'File delete failed. Please manually delete the file.'; /* Needs language */ }

	}

	$max_size = 1024*100;
	
	if((isset($submit_upload)) && ($submit_upload)) {

		if ($file_tags) {
			$multi_upload = new muli_files;

			$file_name = str_replace(" ", '-', $_FILES['upload']['name'][0]);
			$file_ext = substr(strrchr($file_name, '.'), 1);
			$file_ext = strtolower($file_ext);
			
			if (($file_ext == 'jpg') || ($file_ext == 'gif') || ($file_ext == 'png')) {
				$dir = '../files/images/';
				$file_type = 'Image';
			} else if (($file_ext == 'mov') || ($file_ext == 'flv') || ($file_ext == 'avi') || ($file_ext == 'm4v') || ($file_ext == 'mp4') || ($file_ext == 'mkv')|| ($file_ext == 'ogv')) {
				$dir = '../files/video/';
				$file_type = "Video";
			} else if (($file_ext == 'mp3') || ($file_ext == 'flac') || ($file_ext == 'ogg') || ($file_ext == 'wav') || ($file_ext == 'pls') || ($file_ext == 'm4a') || ($file_ext == 'xspf')) {
				$dir = '../files/audio/';
				$file_type = "Audio";
			} else {
				$dir = '../files/other/';
				$file_type = 'Other';
			}

			$multi_upload->upload_dir = $dir; 
			$multi_upload->extensions = array('.png', '.jpg', '.gif', '.zip', '.mp3', '.pdf', '.exe', '.rar', '.swf', '.vcf', '.css', '.dmg', '.php', '.doc', '.xls', '.xml', '.eps', '.rtf', '.iso', '.psd', '.txt', '.ppt', '.mov', '.flv', '.avi', '.m4v', '.mp4', '.gz', '.bz2', '.tar', '.7z', '.svg', '.svgz', '.lzma', '.sig', '.sign', '.js', '.rb', '.ttf', '.html', '.phtml', '.flac', '.ogg', '.wav', '.mkv', '.pls', '.m4a', '.xspf', '.ogv');
			$multi_upload->message[] = $multi_upload->extra_text(4);
			$multi_upload->do_filename_check = 'y';
			$multi_upload->tmp_names_array = $_FILES['upload']['tmp_name'];
			$multi_upload->names_array = str_replace(" ", '-', $_FILES['upload']['name']);
			$multi_upload->error_array = $_FILES['upload']['error'];
			$multi_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : 'n';
			$multi_upload->upload_multi_files();

			if (lastword($multi_upload->show_error_string()) == 'uploaded.')	{

				if (!isset($_POST['replace'])) {
					$sql = "file_name = '$file_name', file_extension = '$file_ext', file_type = '$file_type', tags = '$file_tags'"; 
					$ok = safe_insert('pixie_files', $sql);
				} else {
					$sql = "file_name = '$file_name', file_extension = '$file_ext', file_type = '$file_type', tags = '$file_tags'";
					$ok = safe_update('pixie_files', "$sql", "file_name = '$file_name'");

					// sometimes a file will be present on the server but not in the file manager, we need to check for this
					$check_2 = safe_field('file_extension','pixie_files',"file_name ='$file_name'");
					if (!$check_2) {
						$sql = "file_name = '$file_name', file_extension = '$file_ext', file_type = '$file_type', tags = '$file_tags'"; 
						$ok = safe_insert('pixie_files', $sql);
					}
				}

				if (!$ok) {
					$message = $lang['file_upload_error'];
				} else {
					$messageok = $multi_upload->show_error_string();
					logme($messageok,'no', 'folder');
					safe_optimize('pixie_files');
					safe_repair('pixie_files');
				}

			} else { $message = $multi_upload->show_error_string(); }
		} else { $message = $lang['file_upload_tag_error']; }

		// If the folder is not writeable, we need to indicate that to the user
		$file_upload_success = $dir . $file_name;
		if (!file_exists($file_upload_success)) { $message = 'Upload failed. Please check that the folder is writeable and has the correct permissions set.'; /* Needs language */ }

	}

	echo "<div id=\"blocks\">
					<div class=\"admin_block\" id=\"admin_block_filemanager\">
						<h3>" . $lang['upload'] . "</h3>
						<form accept-charset=\"UTF-8\" action=\"?s=$s&amp;x=$x\" method=\"post\" id=\"upload_form\" enctype=\"multipart/form-data\">
						<fieldset>
						<legend>" . $lang['upload'] . "</legend>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"upload\">" . $lang['form_upload_file'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_upload_file'] . " " . $lang['file_manager_info']."</span></div>
							<div class=\"form_item_file\"><input type=\"file\" class=\"form_text\" name=\"upload[]\" id=\"upload\" size=\"18\" /></div>";
							echo '<div class=\form_label\><span><small>Your host server will accept uploads for the maximum file size of : ' . convertBytes( ini_get( 'upload_max_filesize' ) ) / 1048576 . 'MB.</small></span></div>';  /* Needs language */
						echo "</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"file_tags\">" . $lang['tags'] . " <span class=\"form_required\">" . $lang['form_required'] . "</span></label><span class=\"form_help\">" . $lang['form_help_upload_tags'] . "</span></div>
								<div class=\"form_item\"><input type=\"text\" class=\"form_text\" id=\"file_tags\" name=\"file_tags\" size=\"18\" /></div>
							</div>
							<div class=\"form_row\">
								<div class=\"form_label\"><label for=\"replace\">" . $lang['form_upload_replace_files'] . "</label><span class=\"form_help\">" . $lang['form_help_upload_replace_files']."</span></div>
								<div class=\"form_item_check\"><input type=\"checkbox\" id=\"replace\" name=\"replace\" value=\"y\" /></div>
							</div>
							<div class=\"form_row_button\">
								<input type=\"submit\" class=\"form_submit\" name=\"submit_upload\" value=\"" . $lang['upload'] . "\" />
								<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_size\" />";
								if ((isset($ck)) && ($ck)) { echo "<input type=\"hidden\" name=\"ckFuncNumReturn\" value=\"$CKEditorFuncNum\" />"; }
								if ((isset($ck)) && ($ck)) { echo "<input type=\"hidden\" name=\"ck\" value=\"1\" />"; }
								if ((isset($ckfile)) && ($ckfile)) { echo "<input type=\"hidden\" name=\"ckfile\" value=\"1\" />"; }
								if ((isset($ckimage)) && ($ckimage)) { echo "<input type=\"hidden\" name=\"ckimage\" value=\"1\" />"; }
	echo "				</div>
						</fieldset>
						</form>
					</div>";

					$type = 'module';
					admin_block_tag_cloud('pixie_files', 'file_id >= 0');
					
	echo "\t\t\t\t</div>\n";

					if ((isset($tag)) && ($tag)) {
						$title = $lang['file_manager_tagged'] . " " . $tag;
						$tag = squash_slug($tag);
						$rs = safe_rows_start('*', 'pixie_files', "tags REGEXP '[[:<:]]" . $tag . "[[:>:]]' order by file_name");
					} else {
						$title = $lang['file_manager_latest'];
						$rs = safe_rows_start('*', 'pixie_files', "file_type != 'x' order by file_id desc limit 30");
					}

	echo "
				<div id=\"pixie_content\" class=\"filemanager\">
					<h2>" . $lang['nav2_files'] . "</h2>";
						if ((isset($ck)) && ($ck)) { $messageok = 'Click on a file by name to create a link.'; } /* Needs language */
	echo "					<div id=\"filemanager_table\">
						<table class=\"tbl\" summary=\"" . $title . " @ " . str_replace('http://', "", $site_url) . "\">
						<thead>
							<tr>
								<th class=\"tbl_heading\" id=\"theicon\"></th>
								<th class=\"tbl_heading\" id=\"thefilename\">" . $lang['filename'] . "</th>";
								if ((!isset($ck)) || (!$ck)) { echo "<th class=\"tbl_heading\" id=\"thedatestamp\">" . $lang['filedate'] . "</th>"; }
	echo "							<th class=\"tbl_heading\" id=\"thetags\">" . $lang['tags'] . "</th>
								<th class=\"tbl_heading\" id=\"thefile_view\"></th>
								<th class=\"tbl_heading\" id=\"thefile_delete\"></th>
							</tr>
						</thead>
						<tbody>";
	if ($rs) {
		$counter = 1;
		while ($a = nextRow($rs)) {
			extract($a);
			
			if (is_even($counter)) {
				$trclass = 'even';
			} else {
				$trclass = 'odd';
			}

			if ((isset($ckimage)) && ($ckimage == 1)) {
			if ($file_type == 'Image') {
				$last_modified = filemtime('../files/images/' . $file_name);
				echo "
						<tr class=\"$trclass\">
							<td class=\"tbl_row\" headers=\"theicon\"><img src=\"admin/theme/images/icons/image.png\" alt=\"$file_extension\" /></td>";
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/images/$file_name\" class=\"thickbox\" alt=\"/images/$file_name\">" . $file_name . "</a></td>"; }
							if ((isset($ck)) && ($ck)) { echo "<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/images/$file_name\" class=\"pxfinder\" alt=\"/images/$file_name\">" . $file_name . "</a></td>"; }
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thedatestamp\">" . safe_strftime($date_format, $last_modified) . "</td>"; }
				echo "			<td class=\"tbl_row\" headers=\"thetags\">"; if (isset($tags)) { echo $tags; } echo "</td>
							<td class=\"tbl_row tbl_edit\" headers=\"thefile_view\"><a href=\"../files/images/$file_name\" class=\"thickbox\">" . $lang['view'] . "</a></td>
							<td class=\"tbl_row tbl_delete\" headers=\"thefile_delete\"><a href=\"?s=$s&amp;x=$x&amp;del=$file_name\" onclick=\"return confirm('" . $lang['delete_file'] . " ($file_name)')\">" . $lang['delete'] . "</a></td>
						</tr>";
			}

			} else {

			if ($file_type == 'Image') {
				$last_modified = filemtime('../files/images/' . $file_name);
				echo "
						<tr class=\"$trclass\">
							<td class=\"tbl_row\" headers=\"theicon\"><img src=\"admin/theme/images/icons/image.png\" alt=\"$file_extension\" /></td>";
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/images/$file_name\" class=\"thickbox\" alt=\"/images/$file_name\">" . $file_name . "</a></td>"; }
							if ((isset($ck)) && ($ck)) { echo "<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/images/$file_name\" class=\"pxfinder\" alt=\"/images/$file_name\">" . $file_name . "</a></td>"; }
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thedatestamp\">" . safe_strftime($date_format, $last_modified) . "</td>"; }
				echo "			<td class=\"tbl_row\" headers=\"thetags\">"; if (isset($tags)) { echo $tags; } echo "</td>
							<td class=\"tbl_row tbl_edit\" headers=\"thefile_view\"><a href=\"../files/images/$file_name\" class=\"thickbox\">" . $lang['view'] . "</a></td>
							<td class=\"tbl_row tbl_delete\" headers=\"thefile_delete\"><a href=\"?s=$s&amp;x=$x&amp;del=$file_name\" onclick=\"return confirm('" . $lang['delete_file'] . " ($file_name)')\">" . $lang['delete'] . "</a></td>
						</tr>";
			} else if ($file_type == 'Audio') {
				$last_modified = filemtime('../files/audio/' . $file_name);
				echo "
						<tr class=\"$trclass\">
							<td class=\"tbl_row\" headers=\"theicon\"><img src=\"admin/theme/images/icons/audio.png\" alt=\"$file_extension\" /></td>
							<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/audio/$file_name\" class=\"pxfinder\" alt=\"/audio/$file_name\">" . $file_name . "</a></td>";
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thedatestamp\">" . safe_strftime($date_format, $last_modified) . "</td>"; }
				echo "			<td class=\"tbl_row\" headers=\"thetags\">"; if (isset($tags)) { echo $tags; } echo "</td>
							<td class=\"tbl_row tbl_edit\" headers=\"thefile_view\"><a href=\"../files/audio/$file_name\">" . $lang['download'] . "</a></td>
							<td class=\"tbl_row tbl_delete\" headers=\"thefile_delete\"><a href=\"?s=$s&amp;x=$x&amp;del=$file_name\" onclick=\"return confirm('" . $lang['delete_file'] . " ($file_name)')\">" . $lang['delete'] . "</a></td>
						</tr>";
			} else if ($file_type == 'Video') {		  		
				$last_modified = filemtime('../files/video/' . $file_name);
				echo "
						<tr class=\"$trclass\">
							<td class=\"tbl_row\" headers=\"theicon\"><img src=\"admin/theme/images/icons/film.png\" alt=\"$file_extension\" /></td>
							<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/video/$file_name\" class=\"pxfinder\" alt=\"/video/$file_name\">" . $file_name . "</a></td>";
							if ((isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thedatestamp\">" . safe_strftime($date_format, $last_modified) . "</td>"; }
				echo "			<td class=\"tbl_row\" headers=\"thetags\">"; if (isset($tags)) { echo $tags; } echo "</td>
							<td class=\"tbl_row tbl_edit\" headers=\"thefile_view\"><a href=\"../files/video/$file_name\">" . $lang['download'] . "</a></td>
							<td class=\"tbl_row tbl_delete\" headers=\"thefile_delete\"><a href=\"?s=$s&amp;x=$x&amp;del=$file_name\" onclick=\"return confirm('" . $lang['delete_file'] . " ($file_name)')\">" . $lang['delete'] . "</a></td>
						</tr>";

			} else {
				if (file_exists('admin/theme/images/icons/file_' . $file_extension . '.png')) {
					$img = 'admin/theme/images/icons/file_' . $file_extension . '.png';
				} else {
					$img = 'admin/theme/images/icons/folder.png';
				}
				
				$last_modified = filemtime('../files/other/' . $file_name);
				echo "
						<tr class=\"$trclass\">
							<td class=\"tbl_row\" headers=\"theicon\"><img src=\"$img\" alt=\"$file_extension\" /></td>
							<td class=\"tbl_row\" headers=\"thefilename\"><a href=\"../files/other/$file_name\" class=\"pxfinder\" alt=\"/other/$file_name\">" . $file_name . "</a></td>";
							if ((!isset($ck)) || (!$ck)) { echo "<td class=\"tbl_row\" headers=\"thedatestamp\">" . safe_strftime($date_format, $last_modified) . "</td>"; }
				echo "			<td class=\"tbl_row\" headers=\"thetags\">"; if (isset($tags)) { echo $tags; } echo "</td>
							<td class=\"tbl_row tbl_edit\" headers=\"thefile_view\"><a href=\"../files/other/$file_name\">" . $lang['download'] . "</a></td>
							<td class=\"tbl_row tbl_delete\" headers=\"thefile_delete\"><a href=\"?s=$s&amp;x=$x&amp;del=$file_name\" onclick=\"return confirm('" . $lang['delete_file'] . " ($file_name)')\">" . $lang['delete'] . "</a></td>
						</tr>";										
			}

				} /* End if ckimage does not equal 1 */

			$counter++;
		}
	}
	echo "\n\t\t\t\t\t\t</tbody>\n\t\t\t\t\t\t</table>\n\t\t\t\t\t</div>\n\t\t\t\t</div>";
}
?>