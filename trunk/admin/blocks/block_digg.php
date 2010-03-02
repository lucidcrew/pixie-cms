<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Digg RSS Feed                                            //
//*****************************************************************//

    $number_of_items = 24; /* Set the maximum number of items here */

    $digg_username = 'kevinrose'; /* Add your digg user name here */

?>
    <div id="block_digg" class="block">
	<div class="block_header">
	    <h4>I Digg:</h4>
	</div>
	    <div class="block_body">
		<ul>

		    <?php

			echo "\n";

			$feed = new SimplePie();
			$feed->set_feed_url("http://digg.com/users/{$digg_username}/history.rss");
			$feed->enable_cache(TRUE);
			$feed->set_cache_location('files/cache');
			$feed->set_item_limit($number_of_items);
			$feed->set_timeout(30);
			$feed->set_cache_duration(900);
			$feed->init();
			$feed->handle_content_type();

			$i = 1;

			    foreach ($feed->get_items() as $item) :

				if ($i <= $number_of_items) {

				    $itemlink = $item->get_permalink();
				    echo "\t\t\t\t\t\t\t<li><a href=\"" . $item->get_permalink() . "\">" . $item->get_title() . "</a></li>\n";
				}
				$i++;

			    endforeach;

			echo "<li style=\"display:none;\"></li>\n"; /* Prevents invalid markup if the list is empty */

?>
		</ul>
	    </div>
	<div class="block_footer"></div>
    </div>