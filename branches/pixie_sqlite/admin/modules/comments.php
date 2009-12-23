<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Comments Plugin                                          //
//*****************************************************************//


   
switch ($do) {
	// general information
	case "info":
	
	   $m_name = "Comments";
	   $m_description = "This plugin will allow visitors to leave a comment on any post in a dynamic page.";
	   $m_author = "Scott Evans";
	   $m_url = "http://www.toggle.uk.com";
	   $m_version = "1";
	   $m_type = "plugin";
	   $m_publish = "yes";

	break;

	// install
	
	// pre (to be run before page load)
	
  	// admin of module
	case "admin":
	
	   $module_name= "comments";																			
	   $table_name = "pixie_module_comments";														
	   $order_by = "posted";		  																
	   $asc_desc = "desc";        																	
	   $view_exclude = array('comments_id','post_id','page_id','url','admin_user');
	   $edit_exclude = array('comments_id','post_id');
	   $view_number = "20";	
	   $tags = "no";
	   
	   admin_module($module_name,$table_name,$order_by,$asc_desc,$view_exclude,$edit_exclude,$view_number, $tags);

	break;

  	// show module
	default:
		// I am not here to show anything, I am used as part of the dynamic pages page.
	break;
}

?>