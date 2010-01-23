<?php

  /* This should become a core function in the admin area as part of an auto updater. Wdyt? */
include '../config.php';           		// load cofiguration
include '../lib/lib_db.php';       		// load libraries order is important
include '../lib/lib_misc.php';     		//			
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
			  		
print '<p>database upgrades completed!</p>';
?>

