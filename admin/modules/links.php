<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Links Module	                                           //
//*****************************************************************//

// The module is loaded into Pixie in many different instances, the variable
// $do is used to run the module in different ways.
switch ($do) {

	// General information:
	// The general information is used to show information about the module within Pixie. 
	// Simply enter details of your module here:
	case 'info' :
		// The name of your module
		$m_name = 'Links';
		// A description of your module
		$m_description = 'Store a collection of links on your website and group them by tag.';
		// Who is the module author?
		$m_author = 'Scott Evans';
		// What is the URL of your homepage
		$m_url = 'http://www.toggle.uk.com';
		// What version is this?
		$m_version = 1;
		// Can be set to module or plugin.
		$m_type = 'module';
		// Is this a module that needs publishing to?
		$m_publish = 'yes';

	break;

	// Install
	// This section contains the SQL needed to create your modules tables
	case 'install' :
		// Create any required tables
		$execute = "CREATE TABLE IF NOT EXISTS `pixie_module_links` (`links_id` int(4) NOT NULL auto_increment,`link_title` varchar(150) collate utf8_unicode_ci NOT NULL default '',`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',`url` varchar(255) collate utf8_unicode_ci NOT NULL default '',PRIMARY KEY  (`links_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;";
	break;

	// The administration of the module (add, edit, delete)
	// This is where Pixie really saves you time, these few lines of code will create the entire admin interface
	case 'admin' :
		// The name of your module
		$module_name= 'Links';
		// The name of the table																
		$table_name = 'pixie_module_links';
		// The field to order by in table view														
		$order_by = 'link_title';
		// Ascending (asc) or decending (desc)		  													
		$asc_desc = 'asc';
		// Fields you want to exclude in your table view        														
		$view_exclude = array('links_id', 'tags');
		// Fields you do not want people to be able to edit			
		$edit_exclude = array('links_id');
		// The number of items per page in the table view
		$items_per_page = 15;
		// Does this module support tags (yes or no)														
		$tags = 'yes';

		admin_module($module_name, $table_name, $order_by, $asc_desc, $view_exclude, $edit_exclude, $items_per_page, $tags);

	break;

	// The three sections below are all for the module output, a module is loaded at three different stages of a page build.

	// Pre
	// Any code to be run before HTML output, any redirects or header changes must occur here
	case 'pre' :
		
		// lets have a look at $m to see what we are trying to get out of the page
		switch ($m) {
			
			// ok so the visitor has come along to www.mysite.com/links/tag/something lets show them all links tagged "something"
			case 'tag' :
				
				// we need $x to be a valid variable so lets check it
				$x = squash_slug($x); 
				$rz = safe_rows('*', 'pixie_module_links', "tags REGEXP '[[:<:]]" . $x . "[[:>:]]'");
				if ($rz) {
					
					// we have found a entry tagged "something" to lets change the page title to reflect that
					// first lets get the current sites title
					$site_title = safe_field('site_name', 'pixie_settings', "settings_id = '1'");
					// $ptitle will overwrite the current page title
					$ptitle = $site_title . " - Links - Tagged - $x";
				
				} else {
				
					// no tags were found, lets redirect back to the defualt view again.
					// createURL is your friend... its one of the most useful functions in Pixie
					$redirect = createURL($s);
					header("Location: $redirect");
	 				exit();
	 				
				}
				
			break;
			
			default:
			
				// By default this module is called the links module, Pixie will work this out for us so I do not need
				// to set $ptitle here. Pixie will always TRY and create a unique, accurate page title if one is not set. 
				
			break;

		}

	break;
	
	// Head
	// This will output code into the end of the head section of the HTML, this allows you to load in external CSS, JavaScript etc
	case 'head' :
	
	break;

	// Show Module
	// This is where your module will output into the content div on the page
	default:

		// Switch $m (our second variable from the URL) and adjust ouput accordingly
		switch ($m) {
			
			// $m is set to tag the we want to filter our links page to only check this tag
			case 'tag' :
				
				if ($x) {
					// turn $x back into a tag from a slug
					$x = squash_slug($x);
					extract(safe_row('*', 'pixie_core', "page_name = '$s'"));
					// find all the links with a matching tag to $x
					$rz = safe_rows('*', 'pixie_module_links', "tags REGEXP '[[:<:]]" . $x . "[[:>:]]'");

					if ($rz) {
						echo "<div id=\"$s\">\n\t\t\t\t\t<h3>$page_display_name</h3>\n";
						$num = count($rz);
						echo "\t\t\t\t\t<div id=\"$x\" class=\"link_list\">\n\t\t\t\t\t\t<h4>" . ucwords($x) . "</h4>\n\t\t\t\t\t\t<ul>\n";
						$i = 0;
						// now loop out the results
						while ($i < $num){
							$out = $rz[$i];
							$url = $out['url'];
							$link_title = $out['link_title'];
							echo "\t\t\t\t\t\t\t<li><a href=\"$url\" title=\"$link_title\">$link_title</a></li>\n";
						$i++;
					}
					echo "<li style=\"display:none;\"></li>";	// Prevent invalid markup if the list is empty
					echo "\n\t\t\t\t\t\t</ul>\n\t\t\t\t\t</div>\n";
					echo "\t\t\t\t</div>\n";
					}
				}

			break;

			default:
				
				// get the page display name from the database
				extract(safe_row('*', 'pixie_core', "page_name = '$s'"));
				// print the display name into a h3
				echo "<div id=\"$s\">\n\t\t\t\t\t<h3>$page_display_name</h3>\n";

				// get all the tags from the links page using the all_tags function within Pixie
				$tags_array = all_tags('pixie_module_links', "links_id >= '0'");
				
				// make sure we actually got something
				if (count($tags_array) != 0) {
					// sort the tags in the array
					sort($tags_array);
					$max = 0;
					// begin to loop the array of tags			
					for ($c = 1; $c < (count($tags_array)); $c++) {
						// get the current tag
						$current = $tags_array[$c];
						// search for links tagged with the current tag
						$rz = safe_rows('*', 'pixie_module_links', "tags REGEXP '[[:<:]]" . $current . "[[:>:]]'");
						$num = count($rz);
						// if found then output all those links into an unordered list
						if ($rz) {
							echo "\t\t\t\t\t<div id=\"$current\" class=\"link_list\">\n\t\t\t\t\t\t<h4>" . ucwords($current) . "</h4>\n\t\t\t\t\t\t<ul>\n";
							$i = 0;
							while ($i < $num){
								$out = $rz[$i];
  								$url = $out['url'];
  								$link_title = $out['link_title'];
								echo "\t\t\t\t\t\t\t<li><a href=\"$url\" title=\"$link_title\">$link_title</a></li>\n";
								$i++;
							}
							echo "<li style=\"display:none;\"></li>";	// Prevent invalid markup if the list is empty
							echo "\n\t\t\t\t\t\t</ul>\n\t\t\t\t\t</div>\n";
						}
					}
				}

				echo "\t\t\t\t\t</div>\n";

			break;

		}

	break;
}
?>