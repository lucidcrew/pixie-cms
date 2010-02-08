/*
Pixie advanced ckeditor config
*/

var cssShortPath = 'admin/themes/';
var cssDir = cssShortPath + globalUrlVars.pixieThemeDir;
var cssCssie
var cssCssie6
var cssCssie7
var cssHandheld

/* Use the optional stylesheets, if we've got them */
if (globalUrlVars.cssCssie) { cssCssie = ', ' + cssDir + globalUrlVars.cssCssie; }
if (globalUrlVars.cssCssie6) { cssCssie6 = ', ' + cssDir + globalUrlVars.cssCssie6; }
if (globalUrlVars.cssCssie7) { cssCssie7 = ', ' + cssDir + globalUrlVars.cssCssie7; }
if (globalUrlVars.cssHandheld) { cssHandheld = ', ' + cssDir + globalUrlVars.cssHandheld; }

var $j = jQuery.noConflict();

if ($j('.ck-textarea').length >= 1) { 
/* Tell ckeditor how we want it to be configured */
CKEDITOR.editorConfig = function(config) {

	config.baseHref = globalUrlVars.pixieSiteUrl;
	config.docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	/* The next two aren't ready for go live yet, themes need work to make them work better in ckeditor */
        /* config.bodyId = 'content'; */ /* Set this to see more of your theme inside the editor. Although it doesn't work entirely as expect in most cases. */
	/* config.contentsCss = [ cssDir + '/core.css', cssDir + '/layout.css', cssDir + '/navigation.css' + cssCssie + cssCssie6 + cssCssie7 + cssHandheld ]; */
        config.filebrowserBrowseUrl = '?s=publish&x=filemanager&ck=1&ckfile=1';
        config.filebrowserImageBrowseUrl = '?s=publish&x=filemanager&ck=1&ckimage=1';
	config.filebrowserWindowWidth = '800';
        config.filebrowserWindowHeight = '600';
	/* Define changes to the advanced configuration here. For example: */
	/* config.language = 'en-gb'; */ /* Not required. ckeditor automatically selects language based on what your browser is set to */
	/* config.contentsLangDirection = 'rtl'; */  /* Unhash this setting if you are using a right to left language like Japanese */
	config.skin = 'office2003'; /* Use config.skin = 'v2'; instead to make it look like it's tinymce */
	config.emailProtection = 'encode'; /* Protect email links from spammers */
	config.resize_enabled = true;
	config.colorButton_enableMore = true;
	/* config.removePlugins = 'elementspath'; */ /* Remove the name of elements at the bottom of the editor */
	config.toolbarCanCollapse = false; /* Remove the collapsing button of the toolbar */
        config.toolbar = [
	['Preview', '-', 'Cut', 'Copy', 'Paste', 'Find', 'Undo', 'Redo', '-', 'SelectAll', 'RemoveFormat', 'Table', 'HorizontalRule', 'PageBreak', 'ShowBlocks', '-', 'Templates', '-', 'Styles', 'Format', '-', 'Font', 'FontSize'],
	'/',
	['Bold', 'Italic', 'Underline', 'Strike', 'SpecialChar', 'TextColor', '-','SpellChecker', 'Scayt', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', '-', 'JustifyRight', 'JustifyCenter', 'JustifyLeft', 'JustifyBlock', '-', 'Link', 'Unlink', 'Anchor', '-', 'Image', 'Flash', 'Smiley', 'BGColor', '-', 'PageBreak', '-', 'NewPage', '-', 'Source', '-', 'Maximize']
        ];
	config.enterMode = CKEDITOR.ENTER_BR; /* Pet dislike. Enter key means br not p */
	config.shiftEnterMode = CKEDITOR.ENTER_P; /* Paragraphs are now made by pressing shift and enter together instead */

};

}/* End if class ck-textarea exists in the dom */
