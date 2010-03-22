/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @file Horizontal Page Break
 */

// Register a plugin named "pixiePageBreak".
CKEDITOR.plugins.add( 'pixiePageBreak',
{

	lang : [ 'en' ],

	init : function( editor )
	{
		// Register the command.
		editor.addCommand( 'pixiePageBreak', CKEDITOR.plugins.pixiePageBreakCmd );

		// Register the toolbar button.
		editor.ui.addButton( 'pixiePageBreak',
			{
				label : editor.lang.langPixiePageBreak.label,
				command : 'pixiePageBreak'
			});

		// Add the style that renders our placeholder.
		editor.addCss(
			'img.cke_pixiePageBreak' +
			'{' +
				'background-image: url(' + CKEDITOR.getUrl( this.path + 'images/pixiePageBreak.gif' ) + ');' +
				'background-position: center center;' +
				'background-repeat: no-repeat;' +
				'clear: both;' +
				'display: block;' +
				'float: none;' +
				'width: 100%;' +
				'border-top: #999999 1px dotted;' +
				'border-bottom: #999999 1px dotted;' +
				'height: 5px;' +
				'page-break-after: always;' +

			'}' );
	},

	afterInit : function( editor )
	{
		// Register a filter to displaying placeholders after mode change.

		var dataProcessor = editor.dataProcessor,
			dataFilter = dataProcessor && dataProcessor.dataFilter;

		if ( dataFilter )
		{
			dataFilter.addRules(
				{
					elements :
					{
						p : function( element )
						{
							var attributes = element.attributes,
								style = attributes && attributes.style,
								child = style && element.children.length == 1 && element.children[ 0 ],
								childStyle = child && ( child.name == 'span' ) && child.attributes.style;

							if ( childStyle && ( /page-break-after\s*:\s*always/i ).test( style ) && ( /display\s*:\s*none/i ).test( childStyle ) )
								return editor.createFakeParserElement( element, 'cke_pixiePageBreak', 'p' );
						}
					}
				});
		}
	},

	requires : [ 'fakeobjects' ]
});

CKEDITOR.plugins.pixiePageBreakCmd =
{
	exec : function( editor )
	{
		// Create the element that represents a print break.
		var breakObject = CKEDITOR.dom.element.createFromHtml( '<p class="page-break-p" style="page-break-after: always;"><span class="page-break-span" style="display: none;"><!--more--></span></p><br /><br />' );

		// Creates the fake image used for this element.
		breakObject = editor.createFakeElement( breakObject, 'cke_pixiePageBreak', 'p' );

		var ranges = editor.getSelection().getRanges();

		for ( var range, i = 0 ; i < ranges.length ; i++ )
		{
			range = ranges[ i ];

			if ( i > 0 )
				breakObject = breakObject.clone( true );

			range.splitBlock( 'p' );
			range.insertNode( breakObject );
		}
	}
};
