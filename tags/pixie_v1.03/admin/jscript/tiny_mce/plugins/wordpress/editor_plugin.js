/**
 * Wordpress plugin.
 */

(function() {
	var DOM = tinymce.DOM;

	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('wordpress');

	tinymce.create('tinymce.plugins.WordPress', {
		init : function(ed, url) {
			var t = this;
            var moreHTML = '<img src="' + url + '/img/trans.gif" class="mceWPmore mceItemNoResize" title="'+ed.getLang('wordpress.wp_more_alt')+'" />';

			// Register commands
			ed.addCommand('WP_More', function() {
				ed.execCommand('mceInsertContent', 0, moreHTML);
			});
			
			// Register buttons
			ed.addButton('wp_more', {
				title : 'Split the post with a More tag.',
				image : url + '/img/more.gif',
				cmd : 'WP_More'
			});
			
			// Add listeners to handle more break
			t._handleMoreBreak(ed, url);
			
			ed.onPostProcess.add(function(se, o) {
   				o.content = o.content.replace(/\r?\n/g, ' ');
			});
		},

		getInfo : function() {
			return {
				longname : 'WordPress Plugin',
				author : 'WordPress', // add Moxiecode?
				authorurl : 'http://wordpress.org',
				infourl : 'http://wordpress.org',
				version : '3.0'
			};
		},

		// Internal functions

		_handleMoreBreak : function(ed, url) {
			var moreHTML = '<img src="' + url + '/img/trans.gif" alt="$1" class="mceWPmore mceItemNoResize" title="'+ed.getLang('wordpress.wp_more_alt')+'" />';

			// Load plugin specific CSS into editor
			ed.onInit.add(function() {
				ed.dom.loadCSS(url + '/css/content.css');
			});

			// Display morebreak instead if img in element path
			ed.onPostRender.add(function() {
				if (ed.theme.onResolveName) {
					ed.theme.onResolveName.add(function(th, o) {
						if (o.node.nodeName == 'IMG') {
                            if ( ed.dom.hasClass(o.node, 'mceWPmore') )
                                o.name = 'wpmore';
                        }
							
					});
				}
			});

			// Replace morebreak with images
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = o.content.replace(/<!--more(.*?)-->/g, moreHTML);
			});

			// Replace images with morebreak
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = o.content.replace(/<img[^>]+>/g, function(im) {
						if (im.indexOf('class="mceWPmore') !== -1) {
                            var m;
                            var moretext = (m = im.match(/alt="(.*?)"/)) ? m[1] : '';

                            im = '<!--more'+moretext+'-->';
                        }
						
                        return im;
					});
			});

			// Set active buttons if user selected pagebreak or more break
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('wp_more', n.nodeName === 'IMG' && ed.dom.hasClass(n, 'mceWPmore'));
			});
		}
	});

	// Register plugin
	tinymce.PluginManager.add('wordpress', tinymce.plugins.WordPress);
})();