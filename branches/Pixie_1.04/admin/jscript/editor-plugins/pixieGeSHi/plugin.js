/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file GeSHi Syntax Highlighter
 */

/* Register a plugin named "pixieGeSHi". */
CKEDITOR.plugins.add( 'pixieGeSHi',
{

	requires: [ 'iframedialog' ],
	lang : [ 'en' ],

	init : function( editor )
	{

		var pluginName = 'pixieGeSHi';

		/* Register the dialog. */
		CKEDITOR.dialog.addIframe('GeSHi', 'GeSHi Parser',this.path + 'dialogs/dialog.php',500,300,function(){ /* oniframeload */ })

		var command = editor.addCommand( 'pixieGeSHi', new CKEDITOR.dialogCommand( 'GeSHi' ) );
		command.modes = { wysiwyg:1, source:1 };
		command.canUndo = false;

		/* Set the language and the command */
		editor.ui.addButton( 'pixieGeSHi',
			{
				label : editor.lang.langPixieGeSHi.label,
				command : pluginName
			});

	},

})

