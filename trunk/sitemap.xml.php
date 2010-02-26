<?php
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Sitemap Generation                                       //
//*****************************************************************//

		include_once 'admin/config.php';           																				
		include_once 'admin/lib/lib_db.php';       																				
		include_once 'admin/lib/lib_misc.php';     																				
		include_once 'admin/lib/lib_date.php';																					
		include_once 'admin/lib/lib_tags.php';																					
	
		$prefs = get_prefs();           																				
		extract($prefs);  
		
    	require_once( 'admin/lib/lib_sitemap.php' );

		$rs = safe_rows('*', 'pixie_core', "public='yes' and page_name!='404' and page_type!='plugin' order by page_views desc");
		$num = count($rs);
		
		$i = 0;
		while ($i < $num) {
			$out = $rs[$i];
			$pageid = $out['page_id'];
  			$pagename = $out['page_name'];
  			$type = $out['page_type'];
  			$lastmodified = $out['last_modified'];
  		
	  		$url = createURL($pagename);
	  	
			if ($type == 'dynamic') {
				$change = 'weekly';
				
					$rz = safe_rows('*', 'pixie_dynamic_posts', "page_id='$pageid' and public = 'yes' order by post_views desc");
					$num1 = count($rz);
					
					$j = 0;
					while ($j < $num1) {
						$dynpg = $rz[$j];
						$dynpgslug = $dynpg['post_slug'];
						$dynpglastmodified = $dynpg['last_modified'];
						$dynpgurl = createURL($pagename, 'permalink', $dynpgslug);
					
						$log = returnUnixtimestamp($dynpglastmodified);
						$dynpglm = safe_strftime('%Y-%m-%d', $log);
	
					
						$cats[] = array (
				 	'loc' => $dynpgurl,
				 	'changefreq' => 'yearly',
				 	'lastmod' => $dynpglm,
						);
				
				  $j++;
				  }
				  
				  // pagination
				  $total = count(safe_rows('*', 'pixie_dynamic_posts', "page_id='$pageid' and public = 'yes' order by post_views desc"));
				  $show = safe_field('posts_per_page','pixie_dynamic_settings',"page_id='$pageid'");
				  $roundup = ceil($total/$show);
				  $latestdate = safe_field('posted','pixie_dynamic_posts',"page_id='$pageid' and public = 'yes' order by posted desc limit 1");
				  $log = returnUnixtimestamp($latestdate);
				  $recent =  safe_strftime('%Y-%m-%d', $log);				  
				  
				  $k = 2;
				  while ($k <= $roundup) {
				  	
					$dynpgurl = createURL($pagename, 'page', $k);

					
				  	$cats[] = array (
				 	'loc' => $dynpgurl,
				 	'changefreq' => 'monthly',
				 	'lastmod' => $recent,
						);
				  
				  $k++;
				  }
				  
				  // tag list /dynamic/tags/
				  $dynpgurl = createURL($pagename, 'tags');	
				  $cats[] = array (
				 	'loc' => $dynpgurl,
				 	'changefreq' => 'monthly',
				 	'lastmod' => $recent,
				  );
				  
				  // popular /dynamic/popular/
				  $dynpgurl = createURL($pagename, 'popular');	
				  $cats[] = array (
				 	'loc' => $dynpgurl,
				 	'changefreq' => 'monthly',
				 	'lastmod' => $recent,
				  );
				  				  
				  // archives /dynamic/arhcives/
				  $dynpgurl = createURL($pagename, 'archives');	
				  $cats[] = array (
				 	'loc' => $dynpgurl,
				 	'changefreq' => 'monthly',
				 	'lastmod' => $recent,
				  );
				  
				  // every tag /dynamic/tag/$tagname
				  $tags_array = all_tags('pixie_dynamic_posts', "public = 'yes' and page_id = '$pageid'");	
	
					if (count($tags_array) != 0) {
						
						sort($tags_array);
						for ($final = 1; $final < (count($tags_array)); $final++) {
							$current = $tags_array[$final];			
							$link = str_replace(" ", "-",$current);
							$url1 = createURL($pagename, 'tag', $link);
							
							//print $final." ".$current."\n";
							$cats[] = array (
								'loc' => $url1,
								'changefreq' => 'monthly',
								'lastmod' => $recent,
							);
						}
					}
					
				// also need a dynamic prority calculator 0 -> 1  
			
	  	} else if ($type == 'module') {
	  		$change = 'monthly';	  			
	  	} else {
	  		$change = 'monthly';
	  	}
	  	
	  	$logunix = returnUnixtimestamp($lastmodified);
	  	$lm = safe_strftime('%Y-%m-%d', $logunix);
	  	
	  	$cats[] = array (
                   'loc' => $url,
                   'changefreq' => $change,
                   'lastmod' => $lm,
								);

			$i++;
		}

    $site_map_container = new google_sitemap();

    for ( $i=0; $i < count( $cats ); $i++ )
    {
        $value = $cats[ $i ];

        $site_map_item = new google_sitemap_item( $value[ 'loc' ], $value[ 'lastmod'], $value[ 'changefreq' ], '0.7');

        $site_map_container->add_item( $site_map_item );
    }

/* http://php.net/manual/en/function.header.php
header() must be called before any actual output is sent, either by normal HTML tags, blank lines in a file, or from PHP.
There must be no spaces or empty lines that are output before header() is called. What's happening here then? */
/* I think we should use goto for this */
header( "Content-type: application/xml; charset=\"" . $site_map_container->charset . "\"", TRUE );
header( 'Pragma: no-cache' );

    print $site_map_container->build();
?>