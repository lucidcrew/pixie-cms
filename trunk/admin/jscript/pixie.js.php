<?php
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
 * Title: Pixie's Core Admin JavaScript
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
$refering = NULL;
$refering = parse_url(($_SERVER['HTTP_REFERER']));
if (($refering['host'] == $_SERVER['HTTP_HOST'])) {
	if (defined('DIRECT_ACCESS')) {
		require_once '../lib/lib_misc.php';
		pixieExit();
		exit();
	}
	define('DIRECT_ACCESS', 1);
	require_once '../lib/lib_misc.php';
	/* perform basic sanity checks */
	bombShelter();
	/* check URL size */
	error_reporting(0);
	/* Please note : We do not need to specify the header type of this document using php because
	index.php already wraps this in a script tag. If we included it instead, we would need to. */
	// Note : If you use this file, any global vars now have the prefix pixie, so what was $s is now $pixie_s
	
	/* !IMPORTANT - This file thinks it's being run from admin/ */
	/* instead of admin/jscript so paths are relative to admin */
	extract($_REQUEST, EXTR_PREFIX_ALL, 'pixie');
?>
    //<![CDATA[
    var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j('#message').click(function(){ $j(this).slideUp('normal'); $j('#message span').fadeOut('slow'); });
});  /* End jQuery document ready function */

    <?php
	if ((isset($pixie_s)) && $pixie_s != 'login') {
?>
$j(document).ready(function(){

	var tagselect = { backgroundColor : '#0497d3', color : '#ffffff', padding : '1px 4px 1px 4px' };
	var tagnorm = { padding : '1px 4px 1px 4px', backgroundColor: '#ffffff', color: '#0497d3' };
	var tagnormhover = { padding : '1px 4px 1px 4px' };

	if (!$j.browser.msie) {
	// Should use jQuery.support instead of jQuery.browser
		$j('#tags').jTagging($j('#form_tags_list'), " ", tagnorm, tagselect, tagnormhover);
		$j('#page_blocks').jTagging($j('#form_block_list'), " ", tagnorm, tagselect, tagnormhover);
	}
    <?php
		if ((isset($pixie_s)) && $pixie_s == 'settings') {
?>
	$j('#pages').Sortable(
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
			serial = $j.SortSerialize('pages');
			$j.ajax({
				type: 'POST',
	   			url: 'admin/modules/ajax_pages.php',
	   			data: serial.hash,
			 	success: function(msg){
			  }
 			});
		}
	})

	$j('.more_upload').show();
	$j('.image_preview select').bind('change', preview);
    <?php
			/* End if $pixie_s == settings */
		}
?>
    <?php
		if ((isset($pixie_s)) && $pixie_s == 'myaccount' or 'publish') {
?>
/* A function to apply the table sorter */
function applyTablesort() {

    $j(function() {

	$j.getScript('jscript/tablesorter.js', function(){
	$j('.tbl').tablesorter({ /* Call the tablesorter plugin */
        debug: false /* Enable debug mode */
	});
	});

	$j(document).ready(function() {
	$j('.tbl_heading').hover(function(index) { /* Ensure we get a pointer cursor on hover to indicate you can sort the table */
	$j(this).css('cursor','pointer'); }, function() {
	$j(this).css('cursor','auto');
	});
	});

    });  /* End jQuery function */


};  /* End function applyTablesort */


/* A function to load tablesorter.js via ajax and then call the applyTablesort function to use it  */
function fetchTablesorterJs() {

    $j(function() {

	$j.ajaxSetup({async: false}); /* Set jQuery to load the scripts synchronously */
	    $j.getScript('jscript/tablesorter.js', function(){ /* Load tablesorter.js via ajax, using a callback */
		    $j.ajaxSetup({async: true});  /* Set jQuery back to load the scripts asynchronously (The default.) */
			    if ($j('.tbl').length >= 1) { $j(document).ready(function() { applyTablesort(); }); /* Apply the tablesorter by calling it's function */ }
	    });  /* End load tablesorter.js function */

    });  /* End jQuery function */


};  /* End function fetchTablesorterJs */



	/* Table sorter code */
	fetchTablesorterJs();

});  /* End jQuery document ready function */
    <?php
			/* End if $pixie_s == myaccount or publish */
		}
?>
    <?php
		if ((isset($pixie_s)) && ($pixie_s == 'publish' or 'settings') or ($pixie_x == 'myprofile')) {
?>
/* preview image */
function preview() {

	$j('.thickbox').remove();

	var image = $j(this).find('option[@selected]').text();
	var check = $j(this).parent().find('.thickbox').html();

	if (image != '-') {
		$j(this).parent().find('.more_upload').prepend("<a href=\"../files/images/" + image + "\" onclick=\"\" class=\"thickbox\">preview</a> ");
		tb_init('a.thickbox');
	} else {
		$j(this).parent().find('.thickbox').hide();
	}


}

// ajax file upload

var temp = "";
var tfield = "";

function upswitch(field) {
	$j('.thickbox').remove();
	temp = $j('#' + field).parent().html();
	tfield = field;
	$j('#' + field).parent().find('.more_upload').replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");
	$j('.more_upload').hide();
	$j('#' + field).replaceWith("<form accept-charset=\"UTF-8\" action=\"admin/modules/ajax_fileupload.php\" method=\"post\" id=\""+field+"\" class=\"inline_form\" enctype=\"multipart/form-data\" onsubmit=\"return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})\"><input type=\"file\" name=\"upload[]\" id=\"upload\" size=\"18\" /><input type=\"hidden\" name=\"field\" value=\""+field+"\"><input type=\"submit\" name=\"submit_upload\" class=\"submit_upload\" value=\"Upload\" /><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"10240\"></form>");
	$j('.form_submit').attr('disabled', 'true');


}



function cancel() {
	$j('#' + tfield).replaceWith(temp);
	$j('.more_upload').show();
	$j('.form_submit').removeAttr('disabled');
	$j('#' + tfield).parent().find('.more_upload_start').replaceWith("");
	$j('#' + tfield).parent().find('input').replaceWith("");
	$j('.image_preview select').bind('change', preview);


}



function startCallback() {
	$j('.submit_upload').attr('disabled', 'true');
	$j('#' + tfield).parent().find('.more_upload_start').replaceWith("<img src='admin/theme/images/loading.gif' alt='loading' width='15' height='15' id='upload_wait'/>");
	return true;
}



function completeCallback(response) {
	if (response) {
		alert(response);
		$j('.submit_upload').removeAttr('disabled');
		$j('#upload').removeAttr('disabled');
		$j('#upload_wait').replaceWith("<span class='more_upload_start'><a href='#' onclick='cancel(); return false;' title='Cancel'>Cancel</a></span>");

	} else {
		/* refresh the drop down with new list, select the file and enable the button to proceed */
		$j('#upload_wait').replaceWith("");
		
		if ($j.browser.msie) {
		/* Should use jQuery.support instead of jQuery.browser */
			$j.post('admin/modules/ajax_fileupload.php', { form: tfield, ie: 'true' }, function(data){
				$j('#' + tfield).replaceWith(data);
				$j('.more_upload').show();
			});
		} else {
			$j.post('admin/modules/ajax_fileupload.php', { form: tfield }, function(data){
				$j('#' + tfield).replaceWith(data);
				$j('.more_upload').show();
			});	
		}
		
		$j('.form_submit').removeAttr('disabled');
	}


}


/* A function to apply ckeditor instances to any textarea that has the class ck-textarea */
function useCkeditor() {

    CKEDITOR.plugins.addExternal('pixieGeSHi', globalUrlVars.pixieSiteUrl + 'admin/jscript/editor-plugins/pixieGeSHi/'); /* Relative paths above the ckeditor/plugins/ dir don't work without a full path, I think it's a bug */
    CKEDITOR.plugins.addExternal('pixiePageBreak', globalUrlVars.pixieSiteUrl + 'admin/jscript/editor-plugins/pixiePageBreak/'); /* Relative paths above the ckeditor/plugins/ dir don't work without a full path, I think it's a bug */
    CKEDITOR.config.customConfig = '../ckeditor-config.js';
    CKEDITOR.replaceClass = 'ck-textarea';


};  /* End function useCkeditor */


/* A function to apply an advanced toolbar toggle switch to the top right right of ckeditor */
function ckToolbarSlider() {

    $j('.form_item_textarea_ckeditor').prepend('<a class=\"advanced-cke-toggle\" href=\"javascript:void(0);\" title=\"<?php
			print $pixie_advmode;
?>\">&#43;</a>');
    $j('.advanced-cke-toggle').css('float', 'left').css('position', 'absolute').css('right', '4%').css('margin-top', '5px');
    $j('.advanced-cke-toggle').click(function(event) { 
	event.preventDefault();
	$j('.cke_skin_ckPixie .cke_toolbox span:first-child+span[class$=toolbar]').toggle(); /* http://www.smashingmagazine.com/2009/08/17/taming-advanced-css-selectors/ */ /* If you want to learn about advanced css selectors */
    });


};  /* End function ckToolbarSlider */


/* A function to apply the carousel */
function carouselInit() {

    /* A function to move the carousel to the current page */
    function mycarousel_itemFirstInCallback(carousel, item, idx, state) { if (state == 'init') carousel.scroll(5, false);};
	$j(document).ready(function(){
	    $j('#mycarousel').jcarousel({animation:'500', wrap:'both', scroll:5, itemFirstInCallback:{onAfterAnimation:mycarousel_itemFirstInCallback}

	});
	var currentLi = $j('.current a').parent();

	    $j(document).ready(function(){
		$j('#mycarousel li').not(currentLi).css('opacity', '1');
		$j(currentLi).fadeIn().css('opacity', '0.9');
		$j('.current a').fadeOut(500).fadeIn(1000);});
		    $j('#mycarousel li').hover(function() { $j(this).css('opacity', '0.9'); }, 
			function () { $j(this).css('opacity', '1'); });

	    });


};  /* End function carouselInit */


/* The main jQuery function */
$j(function() {

	if ($j('.ck-textarea').length >= 1) { useCkeditor(); ckToolbarSlider(); } /* If ckeditor.js is loaded, lets see if we can use it on anything... */
	if ($j('#mycarousel').length >= 1) { carouselInit(); } /* If the carousel container is present, load up the carousel... */

}); /* End jQuery function */
    <?php
			/* End if $pixie_s == publish */
		}
?><?php
		/* End if not logged in */
	}
?>
    //]]>

<?php
} else {
	header('Location: ../../../');
	exit();
}
?>