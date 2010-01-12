<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Digg RSS Feed                                            //
//*****************************************************************//

	// add your digg user name here
	$digg_username = "kevinrose";
	
?>

					<div id="block_digg" class="block">
						<div class="block_header">
							<h4>I Digg:</h4>
						</div>
						<div class="block_body">
						<ul>
							<?php
							echo "\n";
							// Enter the URL of your RSS feed here:
							$feed = new SimplePie('http://digg.com/users/'.$digg_username.'/history.rss');
							$feed->handle_content_type();
							$i = 1;
							foreach ($feed->get_items() as $item):
								if ($i <= 10) {
								$itemlink = $item->get_permalink();
								echo "\t\t\t\t\t\t\t<li><a href=\"".$item->get_permalink()."\">".$item->get_title()."</a></li>\n";
								}
								$i++;
							endforeach;
							echo "\n";
							echo "<li style=\"display:none;\"></li>";	// Prevents invalid markup if the list is empty
							?>
						</ul>
						</div>
						<div class="block_footer">
						</div>
					</div>
