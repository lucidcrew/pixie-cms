<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                          //
// Title: RSS feed.                                                //
//*****************************************************************//
?>
					<div id="block_rss" class="block">
						<div class="block_header">
							<h4>BBC News</h4>
						</div>
						<div class="block_body">
						<ul>
							<?php
							echo "\n";
							// Enter the URL of your RSS feed here:
							$feed = new SimplePie('http://newsrss.bbc.co.uk/rss/newsonline_world_edition/front_page/rss.xml');
							$feed->handle_content_type();
							foreach ($feed->get_items() as $item):
								$itemlink = $item->get_permalink();
								echo "\t\t\t\t\t\t\t<li><a href=\"" . $item->get_permalink() . "\">" . $item->get_title() . "</a></li>\n";
							endforeach;
							echo "\n";
							echo "<li style=\"display:none;\"></li>";	// Prevents invalid markup if the list is empty
							?>
						</ul>
						</div>
						<div class="block_footer">
						</div>
					</div>