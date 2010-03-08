<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: An RSS feed block which uses simplepie.                  //
//*****************************************************************//

    $number_of_items = 24; /* Set the maximum number of items here */

    $rss_url = 'http://newsrss.bbc.co.uk/rss/newsonline_world_edition/front_page/rss.xml'; /* Enter the URL of your RSS feed here */

    $show_errors = 'no' /* Block not showing any content? Set this to yes to find out why */ /* If you get a curl error and curl is installed, it's a simplepie bug because unfortunately the simplepie developers insist on using curl unfortunately */

?>
    <div id="block_rss" class="block">
	<div class="block_header">
	    <h4>BBC News</h4>
	</div>
	    <div class="block_body">
		<ul>

		    <?php

			echo "\n";
			$feed = new SimplePie();
			$feed->set_timeout(30);
			$feed->set_feed_url($rss_url);
			$feed->enable_cache(TRUE);
			$feed->set_cache_location('files/cache');
			$feed->set_item_limit($number_of_items);
			$feed->set_cache_duration(900);
			$feed->init();
			$feed->handle_content_type();
			$feed_items = $feed->get_items(0, $number_of_items);
			if ( ($show_errors == 'yes') && ($feed->error()) ) { echo $feed->error(); }

			    foreach ($feed_items as $item) :

				    $item_link = $item->get_permalink();
				    $item_title = $item->get_title();
				    echo "\t\t\t\t\t\t\t<li><a href=\"{$item_link}\">{$item_title}</a></li>\n";

			    endforeach;

			echo "<li style=\"display:none;\"></li>\n"; /* Prevents invalid markup if the list is empty */

?>
		</ul>
	    </div>
	<div class="block_footer"></div>
    </div>