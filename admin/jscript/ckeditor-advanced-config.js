/*
Pixie advanced ckeditor config
*/

CKEDITOR.editorConfig = function(config)
{
	/* Define changes to the advanced configuration here. For example: */
	config.language = 'en-uk';
	config.enterMode = CKEDITOR.ENTER_BR; /* Pet dislike. Enter key means br not p */
	config.shiftEnterMode = CKEDITOR.ENTER_P; /* Paragraphs are now made by pressing shift and enter together */
	config.skin = 'office2003'; /* Use skin = 'v2'; instead to make it look like it's tinymce */
//	see : http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)
// 	http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)/Dialogs_-_Adding_File_Browser
//	http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)/Custom_File_Browser
//	The next two lines don't work but we want them to, how?
//	        config.filebrowserBrowseUrl = 'admin/index.php?s=publish&x=filemanager';
//	        config.filebrowserUploadUrl = 'admin/index.php?s=publish&x=filemanager';
/*        config.uiColor = '#9AB8F3'; */		/* Use to add color to the editor */
        config.toolbar =
        [
	['Preview', '-', 'Cut','Copy','Paste', 'Find', 'Undo','Redo', '-','SelectAll','RemoveFormat', 'Table','HorizontalRule','PageBreak', 'ShowBlocks', '-', 'Templates', '-', 'Styles','Format', '-', 'Font','FontSize'],
	'/',
	['Bold','Italic','Underline','Strike', 'SpecialChar', 'TextColor', '-','SpellChecker', 'Scayt', '-', 'NumberedList','BulletedList','-','Outdent','Indent','Blockquote', '-', 'JustifyRight','JustifyCenter','JustifyLeft', 'JustifyBlock', '-', 'Link','Unlink','Anchor', '-', 'Image','Flash', 'Smiley', 'BGColor', '-', 'NewPage', '-', 'Source', '-', 'Maximize']
        ];
};
