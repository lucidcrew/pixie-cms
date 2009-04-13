<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Pixie JavaScript                                         //
//*****************************************************************//

header('Content-Type: text/javascript');
error_reporting(0);
extract($_REQUEST);
include "../config.php";           																			
include "../lib/lib_db.php";       																			
include "../lib/lib_misc.php";     																			
include "../lib/lib_auth.php";	

?>
$(document).ready(function(){
	
	var tagselect = { backgroundColor : "#0497d3", color : "#ffffff", padding : "1px 4px 1px 4px" };
	var tagnorm = { padding : "1px 4px 1px 4px", backgroundColor: "#ffffff", color: "#0497d3" };
	var tagnormhover = { padding : "1px 4px 1px 4px" };
	
	if (!$.browser.msie) {
		$("#tags").jTagging($("#form_tags_list"), " ", tagnorm, tagselect, tagnormhover);
		$("#page_blocks").jTagging($("#form_block_list"), " ", tagnorm, tagselect, tagnormhover);
	}
	
	$("#message").click(function(){ $(this).slideUp("normal"); $("#message span").fadeOut("slow"); });

	$('#pages').Sortable(
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
			serial = $.SortSerialize('pages');
			$.ajax({
				type: "POST",
	   			url: "admin/modules/ajax_pages.php",
	   			data: serial.hash,
			 	success: function(msg){
			  }
 			});
		}
	})
	
	$(".more_upload").show();
	
	$(".image_preview select").bind("change",preview);
	
	<?php
	// disabled for now due to error
	//if ($s == "publish") {
	//	echo "$(\".table\").tablesorter();";
	//}
	?>
    

});


// preview image

function preview() {

	$(".thickbox").remove();

	var image = $(this).find("option[@selected]").text();
	var check = $(this).parent().find(".thickbox").html();

	if (image != "-") {
		$(this).parent().find(".more_upload").prepend("<a href=\"../files/images/"+image+"\" onclick=\"\" class=\"thickbox\">preview</a> ");
		tb_init('a.thickbox');
	} else {
		$(this).parent().find(".thickbox").hide();
	}

}
	
// ajax file upload

var temp = "";
var tfield = "";

function upswitch(field) {
	$(".thickbox").remove();
	temp = $("#"+field).parent().html();
	tfield = field;
	$("#"+field).parent().find(".more_upload").replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");
	$(".more_upload").hide();
	$("#"+field).replaceWith("<form action=\"admin/modules/ajax_fileupload.php\" method=\"post\" id=\""+field+"\" class=\"inline_form\" enctype=\"multipart/form-data\" onsubmit=\"return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})\"><input type=\"file\" name=\"upload[]\" id=\"upload\" size=\"18\" /><input type=\"hidden\" name=\"field\" value=\""+field+"\"><input type=\"submit\" name=\"submit_upload\" class=\"submit_upload\" value=\"Upload\" /><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240\"></form>");
	$(".form_submit").attr("disabled", "true");

}

function cancel() {
	$("#"+tfield).replaceWith(temp);
	$(".more_upload").show();
	$(".form_submit").removeAttr("disabled");
	$("#"+tfield).parent().find(".more_upload_start").replaceWith("");
	$("#"+tfield).parent().find("input").replaceWith("");
	$(".image_preview select").bind("change",preview);
}

function startCallback() {
	$(".submit_upload").attr("disabled", "true");
	$("#"+tfield).parent().find(".more_upload_start").replaceWith("<img src='jscript/tiny_mce/themes/advanced/skins/default/img/progress.gif' alt='loading' width='15' height='15' id='upload_wait'/>");
	return true;
}

function completeCallback(response) {
	if (response) {
		alert(response);
		$(".submit_upload").removeAttr("disabled");
		$("#upload").removeAttr("disabled");
		$("#upload_wait").replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");

	} else {
		// refresh the drop down with new list, select the file and enable the button to proceed
		$("#upload_wait").replaceWith("");
		
		if ($.browser.msie) {
			$.post("admin/modules/ajax_fileupload.php",{ form: tfield, ie: "true" }, function(data){
				$("#"+tfield).replaceWith(data);
				$(".more_upload").show();
			});
		} else {
			$.post("admin/modules/ajax_fileupload.php",{ form: tfield }, function(data){
				$("#"+tfield).replaceWith(data);
				$(".more_upload").show();
			});	
		}
		
		$(".form_submit").removeAttr("disabled");
	}
}
