<?php
if ( !defined( 'DIRECT_ACCESS' ) ) {
		header( 'Location: ../../' );
		exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: Digg RSS Feed Block
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */

$number_of_items = 24;
/* Set the maximum number of items here */

$digg_username = 'kevinrose';
/* Add your digg user name here */

$show_errors = 'no' /* Block not showing any content? Set this to yes to find out why */ /* If you get a curl error and curl is installed, it's a simplepie bug because unfortunately the simplepie developers insist on using curl unfortunately */ ?>
    <div id="block_digg" class="block">
	<div class="block_header">
	    <h4>I <a href="http://digg.com/">Digg</a> :</h4>
	</div>
	    <div class="block_body">
		<ul>

		    <?php

echo "\n";
$feed = new SimplePie();
$feed->set_timeout( 30 );
$feed->set_feed_url( "http://digg.com/users/{$digg_username}/history.rss" );
$feed->enable_cache( TRUE );
$feed->set_cache_location( 'files/cache' );
$feed->set_item_limit( $number_of_items );
$feed->set_cache_duration( 900 );
$feed->init();
$feed->handle_content_type();
$feed_items = $feed->get_items( 0, $number_of_items );
if ( ( $show_errors == 'yes' ) && ( $feed->error() ) ) {
		echo $feed->error();
}

foreach ( $feed_items as $item ):
		$item_link  = $item->get_permalink();
		$item_title = $item->get_title();
		echo "\t\t\t\t\t\t\t<li><a href=\"{$item_link}\">{$item_title}</a></li>\n";
endforeach;

echo "<li style=\"display:none;\"></li>\n";
/* Prevents invalid markup if the list is empty */

?>
		</ul>
	    </div>
	<div class="block_footer"></div>
    </div>