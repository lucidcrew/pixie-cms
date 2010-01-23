<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Flickr.                                                  //
//*****************************************************************//

	// add your flickr id here (http://idgettr.com/)
	$flickr_id = '51694355@N00';
	
?>
					<div id="block_flickr" class="block">
						<div class="block_header">
					 		<h4>Flickr</h4>
					 	</div>
					 	<div class="block_body">
							<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=9&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php print $flickr_id;?>"></script>
						</div>
						<div class="block_footer"></div>		
					</div>
