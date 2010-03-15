<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Block Tag Cloud.                                         //
//*****************************************************************//

if (isset($s)) {
$id = get_page_id($s);
$type = check_type($s);
global $lang;

if ($type == 'dynamic') {
	$table = 'pixie_dynamic_posts';
} else if ($type == 'module') {
	$table = 'pixie_module_' . $s;
}

echo "\t\t\t\t\t<div id=\"block_tagcloud\" class=\"block\">\n\t\t\t\t\t\t<div class=\"block_header\">\n\t\t\t\t\t\t\t<h4>" . $lang['tags'] . "</h4>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_body\">\n";
if ($type == 'dynamic') {
	public_tag_cloud($table, 'page_id = ' . $id . ' and posted < utc_timestamp()');
} else {
	$condition = $s . "_id >= '0'";
	if ( isset($table) ) { public_tag_cloud($table, $condition); }
}
echo "\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"block_footer\"></div>\n\t\t\t\t\t</div>\n";
}
?>