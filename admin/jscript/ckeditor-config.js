/*
Pixie default ckeditor config
*/

var cssShortPath = 'admin/themes/';
var cssDir = cssShortPath + globalUrlVars.pixieThemeDir;

/* Use the optional stylesheets, if we've got them */
if (globalUrlVars.cssCssie) { var cssCssie = ', ' + cssDir + globalUrlVars.cssCssie; }
if (globalUrlVars.cssCssie6) { var cssCssie6 = ', ' + cssDir + globalUrlVars.cssCssie6; }
if (globalUrlVars.cssCssie7) { var cssCssie7 = ', ' + cssDir + globalUrlVars.cssCssie7; }
if (globalUrlVars.cssHandheld) { var cssHandheld = ', ' + cssDir + globalUrlVars.cssHandheld; }

/* Tell ckeditor how we want it to be configured */
CKEDITOR.editorConfig = function(config) {

	config.baseHref = globalUrlVars.pixieSiteUrl;
	config.docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
	config.contentsCss = [ cssDir + '/core.css', cssDir + '/layout.css', cssDir + '/navigation.css' cssCssie cssCssie6 cssCssie7 cssHandheld ];
        config.filebrowserBrowseUrl = '?s=publish&x=filemanager&ck=1&ckfile=1';
        config.filebrowserImageBrowseUrl = '?s=publish&x=filemanager&ck=1&ckimage=1';
	config.filebrowserWindowWidth = '800';
        config.filebrowserWindowHeight = '600';
	/* Define changes to default configuration here. For example: */
	/* config.language = 'en-uk'; */ /* Not required. ckeditor automatically selects language based on what your browser is set to */
	/* config.contentsLangDirection = 'rtl'; */  /* Unhash this setting if you are using a right to left language like Japanese */
	config.skin = 'office2003'; /* Use config.skin = 'v2'; instead to make it look like it's tinymce */
	config.emailProtection = 'encode'; /* Protect email links from spammers */
	config.resize_enabled = false; /* Many will never want to or even realise that they can */
	config.colorButton_enableMore = false; /* This is the default option, just adding for completeness */
        config.toolbar = [
	['Bold', 'Italic', 'Underline', 'Strike', 'SpecialChar', 'TextColor', '-', 'SpellChecker', 'Scayt', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', '-', 'JustifyRight', 'JustifyCenter', 'JustifyLeft', 'JustifyBlock', '-', 'Link', 'Unlink', 'Anchor', '-', 'Image', 'Flash', 'Smiley', 'BGColor', '-', 'PageBreak', '-', 'Preview', '-', 'Maximize', '-', 'Source']
	];
	config.enterMode = CKEDITOR.ENTER_BR; /* Pet dislike. Enter key means br not p */
	config.shiftEnterMode = CKEDITOR.ENTER_P; /* Paragraphs are now made by pressing shift and enter together instead */

};
