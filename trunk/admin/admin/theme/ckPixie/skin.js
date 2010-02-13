/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.skins.add("ckPixie",function(){return{preload:[],editor:{css:["editor.css"]},dialog:{css:["dialog.css"]},templates:{css:["templates.css"]},margins:[0,14,18,14]}}());
(function(){function e(){CKEDITOR.dialog.on("resize",function(f){var a=f.data,g=a.dialog;if(a.skin=="ckPixie"){g.parts.contents.setStyles({width:a.width+"px",height:a.height+"px"});if(CKEDITOR.env.ie){a=function(){var c=g.parts.dialog.getChild([0,0,0]),d=c.getChild(0),b=c.getChild(2);b.setStyle("width",d.$.offsetWidth+"px");b=c.getChild(7);b.setStyle("width",d.$.offsetWidth-28+"px");b=c.getChild(4);b.setStyle("height",d.$.offsetHeight-31-14+"px");b=c.getChild(5);b.setStyle("height",d.$.offsetHeight-
31-14+"px")};setTimeout(a,100);f.editor.lang.dir=="rtl"&&setTimeout(a,1E3)}}})}CKEDITOR.dialog?e():CKEDITOR.on("dialogPluginReady",e)})();