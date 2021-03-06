<?php 
namespace Madden\Theme\Child\Setup;
use WP_Query;

use function Madden\Theme\Child\config;
use function Madden\Theme\Child\card_colors;
function get_cities_from_region( $region ){
	/*
	$regions = [
		'north-valley' => [
			'McMinnville',
			'Yamhill',
			'Newberg',
			'Wilsonville',
			'Dundee',
			'Dundee Hills',
			'Amity', 
			'Dayton',
			'St. Paul', 
			'Carlton',
			'Dayton' 
		],
		'mid-valley' => [
			'Salem',
			'Albany',
			'Corvallis', 
			'Philomath',
			'Independence', 
			'Rickreall',
			'Keizer',
			'Brooks',
			'Alsea'
		],
		'south-valley' => [
			'Eugene', 
			'Creswell',
			'Springfield', 
			'Cottage Grove' 
		],
		'west-cascades' => [
			'Silverton',
			'Wesfir',
			'Oakridge',
			'Lebanon',
			'Detroit',
			'Mill City', 
			'Sweet Home',
			'Vida',
			'Lowell'
		]
	];
	*/
	$region_names = [
		'north-valley' => 'north_valley_cities',
		'south-valley' => 'south_valley_cities',
		'mid-valley' => 'mid_valley_cities',
		'west-cascades' => 'west_cascades_cities'
	];

	$acf_regions = get_field( $region_names[$region], 'option');
	foreach( $acf_regions as $region_array ){
		$region_cities[] = $region_array['city_otis_spelling'];
	}
//	return $regions[$region];
	return $region_cities;
}
function get_otis_posts( $categories = null , $regions = null, $dateSort = null, $limit = 100 ){
    $taxonomy_name = 'type';
    $terms = [];
    $city_meta = [];
    $city_WHERE = "";
    if( is_array($regions) ){
    	//error_log(print_r($regions,true));
    	$city_WHERE .= " ( ";
        foreach ($regions as $region){
        	$cities = get_cities_from_region( $region );
        	if(is_array($cities)){
        		foreach($cities as $city){
        			// city is saved by otis as a poi and is related to another poi by its post_id
        			$city_post = get_page_by_title( $city, OBJECT, 'poi' );
        			if( is_object( $city_post )  && property_exists($city_post, 'ID')){
	        			$city_meta[] = "( `meta_key` = 'city' AND meta_value = " . $city_post->ID . ")";
        			}
        			else{
        				//error_log( $city );
        			}
        		}
        	}
        }
        $city_WHERE .= implode( " OR ", $city_meta) . " )";
    }
    if( $city_WHERE ){
    	$city_WHERE .= " AND ";
    }
    if( is_array($categories) ){
        foreach ($categories as $category){
            $term = get_term_by('ID', $category, 'type');
            $termchildren = get_term_children( $category, $taxonomy_name );
            if (!in_array($category, $terms)){
                $terms[] = $category;
            }
            foreach ($termchildren as $child){
                if (!in_array($child, $terms)){
                    $terms[] = $child;
                }
            }
        }
    }
    $in_terms = "";
    if(is_array( $terms ) && count($terms) > 0 ){
	    $termstring = implode(", ", $terms);
    	$in_terms = "( wp_term_relationships.term_taxonomy_id IN ( " . $termstring . " ) ) AND ";
    }
    global $wpdb;
    $sql = "SELECT max(wp_posts.ID) AS ID FROM wp_posts LEFT JOIN wp_postmeta c 
        ON (wp_posts.ID = c.post_id) LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE " . $city_WHERE . $in_terms . " wp_posts.post_type = 'poi' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'dp-rewrite-republish' OR wp_posts.post_status = 'private') GROUP BY wp_posts.post_title, wp_posts.post_date $orderby LIMIT 0, " . $limit;
    error_log($sql);
    //	    echo $sql;
    $pageposts = $wpdb->get_results($sql);
    $posts = [];
    if(1 == 1){
	    foreach($pageposts as $the_post){
	        $date = get_field("start_date", $the_post->ID);
	        if ($date){
	            $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
	            $timestamp = $dateTime->format('U');
	        } else {$timestamp = 0;}
		    $posts[]  = [$the_post->ID, $timestamp];		    	
		    if( "Oldest" == $dateSort ){
		        usort($posts, "sort_times_reverse");
		    }
		    else{
		        usort($posts, "sort_times");
		    }
	    }    	
    }
    return $posts;
}
function is_event($post_id){
	$types = get_the_terms( $post_id, 'type' );
	foreach( $types as $type){
		if("event-type" == $type->slug){
			return true;
		}
	}
}
function build_otis_slider( $posts ){
	$colors = card_colors();
	$output = '<div class="slider category-slider">';
    $i = 0;
    $has_events = 0;
    if( is_array( $posts ) &&  count($posts)> 0 ){

	    foreach ($posts as $the_post):
	        $post_id = $the_post[0];
	        if(is_event($post_id)){
			}
	        $postobject = get_post($post_id);
	        $links = get_field("links", $postobject);
	        if ($links) {
				$link = $links[0]["url"];
				foreach($links as $acf_link_field){
					if($acf_link_field["network_type"] == "Website"){
						$link = $acf_link_field["url"];
					}
				}
	        } else {
	            $link = "#";
	        }
	        $date = get_field("start_date", $postobject);
	        if ($date){
	        	$has_events = 1;
	            $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
	            if( is_event($post_id)){
		            if (new \DateTime() > $dateTime){
		                continue;
	    	        }
	    	    }
	            $formatted_date = $dateTime->format('F j Y');
	            $output .= '<div class="category-slider__item">';
	            $output .= '<a href="'.$link.'" target="_blank">';    
	            $output .= '<div class="category-slider__item__date '.$colors[$i].'">'.$formatted_date.'</div>';
	        } else {
	            $output .= '<div class="category-slider__item">';
	            $output .= '<a href="'.$link.'" target="_blank">';    
	        }

	        $output .= '<div class="category-slider__item__image">';
	        $photos = get_field("photos", $postobject);

	        if ($photos) {
	            $thumbnail = $photos[0]["image_url"];
	            $output .= "<img src='$thumbnail' alt='".$photos[0]["image_alt"]."'>";
	        } else {
	            $output .= "<img src='".get_stylesheet_directory_uri()."/resources/assets/images/events-thumbnail.png' alt='The Willamette Valley'>";
	        }
	        $output .= '<div class="category-slider__item__external-warning"></div>';
	        $output .= '</div>';
	        $output .= '<div class="category-slider__item__title '.$colors[$i].'">';
	        $wordwrap = wordwrap(get_the_title($postobject->ID), 80, "\n");
	        $wordwrapsplit = explode("\n", $wordwrap);
	        $wordwrap = $wordwrapsplit[0];
	        if (count($wordwrapsplit) > 1){
	            $wordwrap = $wordwrap. "...";
	        }
	        $output .= '<p>'.$wordwrap.'</p>';
	        $output .= '</div></a></div>';
	        $i++;
	        if ($i > count($colors) - 1){
	            $i = 0;
	        }
	    endforeach;
	}
	else{
		$output .= "<div class='error pattern-bg'><p>Sorry...we couldn't find anything that matches those filters.</p></div>";
	}
    $output .= '</div>';
	wp_reset_postdata();
	$result = [
		'output' => $output,
		'has_events' => $has_events,
		'post_count' => count($posts),
		'posts' => $posts
	];
	return $result;
}

?>