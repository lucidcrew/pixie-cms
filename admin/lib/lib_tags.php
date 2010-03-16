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
 * Title: lib_tags
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

// ------------------------------------------------------------------
// get all current tags from a table
function all_tags( $table, $condition )
{
	$rs         = safe_rows( '*', $table, $condition );
	$num        = count( $rs );
	$tags_array = array();
	$first      = NULL;
	$last       = NULL;
	
	if ( ( $rs ) ) {
		$i = 0;
		while ( $i < $num ) {
			$out = $rs[$i];
			
			if ( isset( $out['tags'] ) ) {
			} else {
				$out['tags'] = NULL;
			}
			
			$all_tags = $out['tags'];
			$all_tags = strip_tags( $all_tags );
			$all_tags = str_replace( '&quot;', "", $all_tags );
			if ( ( $all_tags != 0 ) ) {
				$last = $all_tags{strlen( $all_tags ) - 1};
			}
			if ( ( $all_tags != 0 ) ) {
				$first = $all_tags{strlen( $all_tags ) - strlen( $all_tags )};
			}
			
			if ( $last != " " ) {
				$all_tags = $all_tags . " ";
			}
			if ( $first != " " ) {
				$all_tags = " {$all_tags}";
			}
			
			$tags_array_temp = explode( " ", $all_tags );
			
			for ( $count = 0; $count < ( count( $tags_array_temp ) ); $count++ ) {
				$current = $tags_array_temp[$count];
				if ( $current != 0 ) {
					$first = $current{strlen( $current ) - strlen( $current )};
				}
				if ( $current != 0 ) {
					$last = $current{strlen( $current ) - 1};
				}
				if ( $first == " " ) {
					$current = substr( $current, 1, strlen( $current ) - 1 );
				}
				if ( !in_array( $current, $tags_array ) ) {
					$tags_array[] = $current;
				}
			}
			$i++;
		}
		return $tags_array;
	}
}
// ------------------------------------------------------------------
// creates a public tag cloud
function public_tag_cloud( $table, $condition )
{
	global $s, $m, $x, $site_url, $lang;
	$tags_array = all_tags( $table, $condition );
	
	if ( count( $tags_array ) != 0 ) {
		$max = 0;
		$min = 1;
		for ( $findmax = 1; $findmax < ( count( $tags_array ) ); $findmax++ ) {
			$current = $tags_array[$findmax];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			if ( $total > $max ) {
				$max = $total;
			}
			if ( $total < $max ) {
				$min = $total;
			}
		}
		$cloud = NULL;
		sort( $tags_array );
		for ( $final = 1; $final < ( count( $tags_array ) ); $final++ ) {
			$current = $tags_array[$final];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			
			if ( $total == 0 ) {
				$total = 1;
			}
			
			if ( $total >= $max ) {
				$tag_class = 'tag_max';
			} else if ( $total == $min ) {
				$tag_class = 'tag_min';
			} else {
				$inc       = floor( ( $total * 10 ) / $max );
				$tag_class = 'tag_' . $inc;
			}
			
			$link = str_replace( " ", '-', $current );
			if ( ( isset( $s ) ) && ( isset( $current ) ) ) {
				$cloud .= "\t\t\t\t\t\t\t<a href=\"" . createURL( $s, 'tag', $link ) . "\" title=\"" . $lang['view'] . " " . $lang['all_posts_tagged'] . ": " . $current . "\" class=\"$tag_class\" rel=\"tag\">" . $current . "</a>,\n";
			}
		}
		$cloud = substr( $cloud, 0, ( strlen( $cloud ) - 2 ) ) . "";
		echo "$cloud\n";
	}
}
// ------------------------------------------------------------------
// creates a tag cloud in block
function admin_block_tag_cloud( $table, $condition )
{
	global $s, $m, $x, $type, $lang;
	
	$tags_array = all_tags( $table, $condition );
	if ( count( $tags_array ) != 0 ) {
		echo "\n\t\t\t\t\t<div id=\"admin_block_tags\" class=\"admin_block\">
			\t\t\t<h3 class=\"$type\">" . $lang['tags'] . "</h3>\n";
		
		
		$max = 0;
		$min = 1;
		for ( $findmax = 1; $findmax < ( count( $tags_array ) ); $findmax++ ) {
			$current = $tags_array[$findmax];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			if ( $total > $max ) {
				$max = $total;
			}
			if ( $total < $max ) {
				$min = $total;
			}
		}
		
		sort( $tags_array );
		for ( $final = 1; $final < ( count( $tags_array ) ); $final++ ) {
			$current = $tags_array[$final];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			if ( $total == 0 ) {
				$total = 1;
			}
			
			if ( $total >= $max ) {
				$tag_class = 'tag_max';
			} else if ( $total == $min ) {
				$tag_class = 'tag_min';
			} else {
				$inc       = floor( ( $total * 10 ) / $max );
				$tag_class = 'tag_' . $inc;
			}
			if ( ( isset( $s ) ) && ( isset( $current ) ) ) {
				if ( ( isset( $cloud ) ) ) {
				} else {
					$cloud = NULL;
				}
				
				$cloud .= "\t\t\t\t\t\t<a href=\"?s=$s&amp;m=$m&amp;x=$x&amp;tag=" . make_slug( $current ) . "\" title=\"" . $lang['view'] . " " . $lang['all_posts_tagged'] . ": " . $current . "\" class=\"$tag_class\" rel=\"tag\">" . $current . "($total)</a>\n";
			}
		}
		$cloud = substr( $cloud, 0, ( strlen( $cloud ) - 1 ) ) . "";
		echo "$cloud\n";
		echo "\n\t\t\t\t\t</div>\n";
	}
}
// ------------------------------------------------------------------
// creates a form tag adder
function form_tag( $table, $condition )
{
	global $s, $m, $x, $site_url, $lang;
	$tags_array = all_tags( $table, $condition );
	
	if ( count( $tags_array ) != 0 ) {
		$max = 0;
		
		for ( $findmax = 1; $findmax < ( count( $tags_array ) ); $findmax++ ) {
			$current = $tags_array[$findmax];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			
			if ( $total > $max ) {
				$max = $total;
			}
			$max = $max - 1;
			$min = 1;
		}
		
		sort( $tags_array );
		for ( $final = 1; $final < ( count( $tags_array ) ); $final++ ) {
			$current = $tags_array[$final];
			$rz      = safe_rows( '*', $table, $condition . " AND tags REGEXP '[[:<:]]" . $current . "[[:>:]]'" );
			$total   = count( $rz );
			
			if ( isset( $cloud ) ) {
			} else {
				$cloud = NULL;
			}
			
			$cloud .= "\t\t\t\t\t\t\t\t\t<a href=\"#\" rel=\"tag\" onclick=\"return false;\" title=\"Add tag " . $current . "\">" . $current . "</a>\n";
		}
		$cloud = substr( $cloud, 0, ( strlen( $cloud ) - 1 ) ) . "";
		if ( $rz ) {
			echo "\t\t\t\t\t\t\t\t<div class=\"form_tags_suggestions\" id=\"form_tags_list\">";
			echo "<span class=\"form_tags_suggestions_text\">" . $lang['form_help_current_tags'] . "</span>\n $cloud\n";
			echo "\t\t\t\t\t\t\t\t</div>\n";
		}
	}
}
?>