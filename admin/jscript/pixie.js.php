<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Pixie JavaScript                                         //
//*****************************************************************//

header('Content-Type: text/javascript');
error_reporting(0);
extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');
include "../config.php";           																			
include "../lib/lib_db.php";       																			
include "../lib/lib_misc.php";     																			
include "../lib/lib_auth.php";	

?>
jQuery(document).ready(function(){
	
	var tagselect = { backgroundColor : "#0497d3", color : "#ffffff", padding : "1px 4px 1px 4px" };
	var tagnorm = { padding : "1px 4px 1px 4px", backgroundColor: "#ffffff", color: "#0497d3" };
	var tagnormhover = { padding : "1px 4px 1px 4px" };
	
	if (!jQuery.browser.msie) {
// Should use jQuery.support instead of jQuery.browser
		jQuery("#tags").jTagging(jQuery("#form_tags_list"), " ", tagnorm, tagselect, tagnormhover);
		jQuery("#page_blocks").jTagging(jQuery("#form_block_list"), " ", tagnorm, tagselect, tagnormhover);
	}
	
	jQuery("#message").click(function(){ jQuery(this).slideUp("normal"); jQuery("#message span").fadeOut("slow"); });

	jQuery('#pages').Sortable(
	{
		accept : 'page',
		activeclass : 'sortableactive',
		hoverclass : 'sortablehover',
		helperclass : 'sorthelper',
		opacity : 	0.5,
		handle : '.page_handle',
		fit :	true,
		axis : 'vertically',
		revert : true,
		onChange : function(ser)
		{
			serial = jQuery.SortSerialize('pages');
			jQuery.ajax({
				type: "POST",
	   			url: "admin/modules/ajax_pages.php",
	   			data: serial.hash,
			 	success: function(msg){
			  }
 			});
		}
	})
	
	jQuery(".more_upload").show();
	
	jQuery(".image_preview select").bind("change",preview);
	
	<?php
	/* Disabled for now due to error */
//	$tablesorter_init = <<<'EOD'
//      jQuery('.table').tablesorter();
//	EOD;

//	if ($pixie_s == "publish") { print $tablesorter_init; }
	?>

});


// preview image

function preview() {

	jQuery(".thickbox").remove();

	var image = jQuery(this).find("option[@selected]").text();
	var check = jQuery(this).parent().find(".thickbox").html();

	if (image != "-") {
		jQuery(this).parent().find(".more_upload").prepend("<a href=\"../files/images/"+image+"\" onclick=\"\" class=\"thickbox\">preview</a> ");
		tb_init('a.thickbox');
	} else {
		jQuery(this).parent().find(".thickbox").hide();
	}

}
	
// ajax file upload

var temp = "";
var tfield = "";

function upswitch(field) {
	jQuery(".thickbox").remove();
	temp = jQuery("#"+field).parent().html();
	tfield = field;
	jQuery("#"+field).parent().find(".more_upload").replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");
	jQuery(".more_upload").hide();
	jQuery("#"+field).replaceWith("<form action=\"admin/modules/ajax_fileupload.php\" method=\"post\" id=\""+field+"\" class=\"inline_form\" enctype=\"multipart/form-data\" onsubmit=\"return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})\"><input type=\"file\" name=\"upload[]\" id=\"upload\" size=\"18\" /><input type=\"hidden\" name=\"field\" value=\""+field+"\"><input type=\"submit\" name=\"submit_upload\" class=\"submit_upload\" value=\"Upload\" /><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240\"></form>");
	jQuery(".form_submit").attr("disabled", "true");

}

function cancel() {
	jQuery("#"+tfield).replaceWith(temp);
	jQuery(".more_upload").show();
	jQuery(".form_submit").removeAttr("disabled");
	jQuery("#"+tfield).parent().find(".more_upload_start").replaceWith("");
	jQuery("#"+tfield).parent().find("input").replaceWith("");
	jQuery(".image_preview select").bind("change",preview);
}

function startCallback() {
	jQuery(".submit_upload").attr("disabled", "true");
	jQuery("#"+tfield).parent().find(".more_upload_start").replaceWith("<img src='jscript/tiny_mce/themes/advanced/skins/default/img/progress.gif' alt='loading' width='15' height='15' id='upload_wait'/>");
	return true;
}

function completeCallback(response) {
	if (response) {
		alert(response);
		jQuery(".submit_upload").removeAttr("disabled");
		jQuery("#upload").removeAttr("disabled");
		jQuery("#upload_wait").replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");

	} else {
		// refresh the drop down with new list, select the file and enable the button to proceed
		jQuery("#upload_wait").replaceWith("");
		
		if (jQuery.browser.msie) {
// Should use jQuery.support instead of jQuery.browser
			jQuery.post("admin/modules/ajax_fileupload.php",{ form: tfield, ie: "true" }, function(data){
				jQuery("#"+tfield).replaceWith(data);
				jQuery(".more_upload").show();
			});
		} else {
			jQuery.post("admin/modules/ajax_fileupload.php",{ form: tfield }, function(data){
				jQuery("#"+tfield).replaceWith(data);
				jQuery(".more_upload").show();
			});	
		}
		
		jQuery(".form_submit").removeAttr("disabled");
	}
}
