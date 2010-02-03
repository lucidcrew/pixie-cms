<?php
error_reporting(0);	// Turns off error reporting
if (!file_exists('../config.php') || filesize('../config.php') < 10) {		// check for config
require '../lib/lib_db.php'; db_down(); exit();
}
if (!defined('DIRECT_ACCESS')) { define('DIRECT_ACCESS', 1); }	/* very important to set this first, so that we can use the new config.php */
	require '../lib/lib_misc.php';

	globalSec('Pixie Installer upgrade.php', 1);

	require '../config.php';
	include '../lib/lib_db.php';  

  /* This should become a core function in the admin area as part of an auto updater. Wdyt? */
include '../lib/lib_date.php';			//
include '../lib/lib_validate.php'; 		// 
include '../lib/lib_core.php';          //
include '../lib/lib_backup.php';	    //
			
// load external sql
$file = 'upgrade.sql';
$file_content = file($file);
foreach($file_content as $sql_line){
	safe_query($sql_line);
}
			  		
print '<p>database upgrades completed!</p>'; /* This should be way more intuiative than that */
?>

