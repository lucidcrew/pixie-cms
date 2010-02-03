/*
Pixie default ckeditor config
*/

CKEDITOR.editorConfig = function( config )
{
	/* Define changes to default configuration here. For example: */
	/* config.language = 'en'; */
	config.skin = 'office2003'; /* Use skin : 'v2', instead to make it look like it's tinymce */
        config.toolbar =
        [
	['Bold','Italic','Underline','Strike', 'SpecialChar', 'TextColor', '-','SpellChecker', 'Scayt', '-', 'NumberedList','BulletedList','-','Outdent','Indent','Blockquote', '-', 'JustifyRight','JustifyCenter','JustifyLeft', 'JustifyBlock', '-', 'Link','Unlink','Anchor', '-', 'Image','Flash', 'Smiley', 'BGColor', '-', 'Preview', '-', 'Maximize', '-', 'Source']
        ];
};
