<?php 
namespace Madden\Theme\Child\Setup;
use WP_Query;

use function Madden\Theme\Child\config;

function get_otis_posts(){
	$categories = get_field("category");
//    print_r($categories);
    $taxonomy_name = 'type';
    $terms = [];
    if( is_array($categories) ){
        foreach ($categories as $category){
            $term = get_term_by('ID', $category, 'type');
            //print_r($term);
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
        if (in_array("Events", $terms)){
            $orderby = "ORDER BY wp_posts.post_date";
        } else {
            $orderby = "ORDER BY RAND()";
        }
    }
    $in_terms = "";
    if(is_array( $terms ) && count($terms) > 1 ){
	    $termstring = implode(", ", $terms);
    	$in_terms = "( wp_term_relationships.term_taxonomy_id IN ( " . $termstring . " ) ) AND ";
    }
    global $wpdb;
    $sql = "SELECT max(wp_posts.ID) AS ID FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE " . $in_terms . " wp_posts.post_type = 'poi' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'dp-rewrite-republish' OR wp_posts.post_status = 'private') GROUP BY wp_posts.post_title, wp_posts.post_date $orderby DESC LIMIT 0, 100";
    $pageposts = $wpdb->get_results($sql);
    return $pageposts;
}
function build_otis_slider( $posts, $colors ){
	$output = '<div class="slider category-slider">';
    $i = 0;
    foreach ($posts as $the_post):
        $post_id = $the_post[0];

        $postobject = get_post($post_id);
        $links = get_field("links", $postobject);
        if ($links) {
            $link = $links[0]["url"];
        } else {
            $link = "#";
        }
        $date = get_field("start_date", $postobject);
        if ($date){
            $dateTime = \DateTime::createFromFormat('d/m/Y', $date);
            if (new \DateTime() > $dateTime){
                continue;
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
    $output .= '</div>';
	wp_reset_postdata();
	return $output;
}

?>