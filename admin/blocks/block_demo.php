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
 * Title: Demo Block
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

?>
					<div id="block_demo" class="block">
						<div class="block_header">
					 		<h4>Demo Block</h4>
					 	</div>
					 	<div class="block_body">
					 		<p>Blocks are small chunks of content that sit beside your pages, at the moment you need to edit the blocks manually,
					 		You will find your blocks in the admin/blocks folder, we have included some examples to get you started.</p>
					 		
					 		<p>To choose the blocks on this page head into the "settings" section within Pixie, select "settings" on this page and choose your blocks. 
					 		We hope to improve the way blocks work in future versions. More information can be found <a href="http://code.google.com/p/pixie-cms/wiki/BlockDevelopment" title="Blocks Wiki Page">here</a>.</p>
						</div>
						<div class="block_footer"></div>		
					</div>