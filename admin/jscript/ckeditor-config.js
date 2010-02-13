/*
Pixie advanced ckeditor config - Clear your browser cache after every edit or you won't see the changes.
*/

var $j = jQuery.noConflict();

if ($j('.ck-textarea').length >= 1) { 
/* Tell ckeditor how we want it to be configured */
CKEDITOR.editorConfig = function(config) {

	config.baseHref = globalUrlVars.pixieSiteUrl;
	config.docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	config.contentsCss = [ 'admin/admin/theme/ckPixie/contents.css' ];
        config.filebrowserBrowseUrl = '?s=publish&x=filemanager&ck=1&ckfile=1';
        /* config.filebrowserImageBrowseUrl = '?s=publish&x=filemanager&ck=1&ckimage=1'; */ /* Disabled until http://dev.fckeditor.net/ticket/4987 is fixed */
	config.filebrowserWindowWidth = '800';
        config.filebrowserWindowHeight = '600';
	/* Define changes to the advanced configuration here. For example: */
	/* config.language = 'en-gb'; */ /* Not required. ckeditor automatically selects language based on what your browser is set to */
	/* config.contentsLangDirection = 'rtl'; */  /* Unhash this setting if you are using a right to left language like Japanese */
	config.skin = 'ckPixie,../../admin/theme/ckPixie/';
	config.height = '30em';
	config.protectedSource.push(/<\?[\s\S]*?\?>/g); /* Protect PHP Code from being stripped when moving to source mode */ /* Needs testing because we could use this! */
	config.extraPlugins = 'pixiePageBreak,pixieGeSHi';
	config.emailProtection = 'encode'; /* Protect email links from spammers */
	config.resize_enabled = true; /* Many will never want to or even realise that they can */ /* Enabled at Scott's request */
	config.colorButton_enableMore = true;
	config.removePlugins = 'elementspath'; /* Remove the name of elements at the bottom of the editor */
	config.toolbarCanCollapse = false; /* Remove the collapsing button of the toolbar */
        config.toolbar = [
	['Copy', 'Paste', 'Cut', 'Find', '-', 'Font', '-', 'FontSize', '-', 'Outdent', 'Indent', '-', 'ShowBlocks', 'Templates', '-', 'HiddenField', 'Select', 'Textarea', 'Form', 'TextField', 'Checkbox', 'Radio', 'Button', '-', 'Anchor', 'HorizontalRule', 'Blockquote', 'Flash', '-', 'pixieGeSHi', '-', 'SelectAll', '-', 'NewPage', '-', 'Preview', '-', 'About'],
	'/',
	['Bold', 'Underline', 'Italic', 'Strike', '-', 'Styles', '-', 'Format', '-', 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Link', 'Unlink', 'Image', 'SpecialChar', 'pixiePageBreak', 'Smiley', 'BGColor', 'TextColor', '-', 'Scayt', '-', 'RemoveFormat', 'Undo', 'Redo', '-', 'Maximize', '-', 'Source']
        ];
	config.enterMode = CKEDITOR.ENTER_BR; /* Pet dislike. Enter key means br not p */
	config.shiftEnterMode = CKEDITOR.ENTER_P; /* Paragraphs are now made by pressing shift and enter together instead */

};

}/* End if class ck-textarea exists in the dom */
