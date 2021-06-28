<?php

namespace Madden\Theme\Child\Setup;
use WP_Query;

use function Madden\Theme\Child\config;

/*
|-----------------------------------------------------------
| Theme Actions
|-----------------------------------------------------------
|
| This file purpose is to include your custom
| actions hooks, which process a various
| logic at specific parts of WordPress.
|
*/
function add_back_to_top_button(){
	echo "<div class='back-to-top'><button class='back-to-top__button'>back to top</button></div>";
}
add_action("theme/after-body", __NAMESPACE__."\add_back_to_top_button");

function add_ajax_url_to_js(){
	echo '<script type="text/javascript">';
	echo 'var ajaxurl = "'.admin_url('admin-ajax.php')."\"\n";
	$nonce = wp_create_nonce("getPosts_nonce");
	echo 'var nonce = "'.$nonce."\"\n";
	echo "</script>";
}
add_action("theme/after-body", __NAMESPACE__."\add_ajax_url_to_js");

add_action( 'wp', __NAMESPACE__.'\add_redirect' );
function add_redirect()
{
	if( (!is_home() && !is_front_page()) && '/' == substr($_SERVER['REQUEST_URI'], -1)){
		$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
		$post = get_page_by_path( $trimmed_uri, OBJECT, 'POST' );
		if( $post ){
			$url = get_permalink( $post->ID );
		    wp_redirect( $url );
		}
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\ajax_blog_enqueue' );
function ajax_blog_enqueue() {
	wp_enqueue_script( 'ajax_pagination',  get_stylesheet_directory_uri() . '/public/js/ajax.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'ajax_pagination', 'ajax_pagination', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
}

add_action( 'wp_ajax_nopriv_ajax_pagination', __NAMESPACE__ . '\my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination',  __NAMESPACE__ . '\my_ajax_pagination' );
function get_all_news( $args = array() ){
	$news = array();

	$defaults = array(
		'posts_per_page' => 2,
		'paged' => '1'
	);
	$post_type = $args['post_types'];
	$params = array_replace_recursive($defaults, $args);
	$category_id = "";
	if( array_key_exists('category_id', $params)){
		$category_id = $params['category_id'];
	}
	$params['posts_per_page'] = -1;
	$args=array(
		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => $params['posts_per_page'],
		'paged' => $params['paged'],
	    'orderby' => 'post_title',
	    'order'   => 'ASC'
	);
	if( 'business' != $post_type){
		$args['orderby'] = 'publish_date';
		$args['order']   = 'DESC';
	}
	if( $params['category_id'] ){
		$args['tax_query'] = [
            [
                'taxonomy' => 'business-categories',
                'field'    => 'term_id',
                'terms'    => $params['category_id']
            ],
        ];
	}
	$date = "";
	if( array_key_exists('date', $params) && $params['date'] > 0 ){
		$date = $params['date'];
		$firstDateObj = new DateTime();
		$firstDateObj->setTimestamp($date);
		$firstDateOut = $firstDateObj->format('F d, Y');

		$firstDateObj->modify('last day of this month 00:00:00');
		$lastDateOut = $firstDateObj->format('F d, Y');

	}		
	if( array_key_exists('keyword', $params) && $params['keyword'] ){
		$args['s'] = $params['keyword'];
	}
	if( $date ){
		$args['date_query'] = array(
	        array(
	            'after'     => $firstDateOut,
	            'before'    => $lastDateOut,
	            'inclusive' => true,
	        ),
	    );
	}
	$news_query = new WP_Query($args);
	//error_log(print_r($news_query,true));
	$news = [];
	$categoriesObj = get_categories();
	$cats = [];
	foreach($categoriesObj as $cat){
		$cats[$cat->term_id] = [
			'name' => $cat->name,
			'slug' => $cat->slug
		];
	}
	if( $news_query->have_posts() ):
		foreach( $news_query->posts as $post ){
			$post->permalink = get_permalink($post->ID);
			$author_info = get_user_by( 'ID', $post->post_author );
			$post->author_info = $author_info->data;
			$post_catsArr = get_the_terms( $post->ID, 'business-categories' );
			$post->post_cats = [];
			$post_cats_name_arr = [];
			$post->cats_string = "";
			if( is_array($post_catsArr) ){
				foreach($post_catsArr as $cat){
					$name = $cat->name;
					$post->post_cats[] = [
						'term_id'=> $cat->term_id,
						'name' => $name,
						'slug' => $cat->slug
					];
					$post->cats_string .= "<div class='category-button'>" . $name . "</div>";
				}
				$default_image = get_field('default_image', $post_catsArr[0]);
				if( !$default_image && $post_catsArr[0]->parent){
					$term = get_term_by( 'ID',$post_catsArr[0]->parent,'business-categories');
					$default_image = get_field('default_image', $term);
				}

			}
			if( $nail = get_post_thumbnail_id($post->ID) ){
				$thumb_url_array = wp_get_attachment_image_src($nail, 'large', true);
				$post->url = $thumb_url_array[0];
			}
			else{
				if($default_image){
					$post->url = $default_image['url'];
				}
				else{
					$post->url = get_stylesheet_directory_uri() . "/resources/assets/images/default.jpg";				
				}
			}
			//	error_log(print_r($post_cats_name_arr,true));

			$date = strtotime( $post->post_date );
			$post->pretty_date = date( 'Y/m/d', $date );
			$post->bus_description = ( get_field('business_description', $post->ID) ? get_field('business_description', $post->ID) : '' );
			$post->bus_address = get_field('business_address_address', $post->ID);
			$post->bus_phone = get_field('business_phone_number', $post->ID);
			$post->hide_detail_page = get_field('business_hide_detail_page', $post->ID);
			$post->hide_featured_image = get_field('business_hide_featured_image', $post->ID);
			//$post->post_title = get_mason_post_title( $post->ID );
			$news[] = $post;
		}
	endif;
	return $news;
}
function my_ajax_pagination() {
	$params = $_REQUEST['params'];
	$posts_per_page = 10;
	if( array_key_exists('posts_per_page',$params) ){
		$posts_per_page = $params['posts_per_page'];
	}
	$category_id = "";
	if( array_key_exists('category_id', $params)){
		$category_id = $params['category_id'];
	}
	$date = "";
	if( array_key_exists('date', $params)){
		$date = $params['date'];
	}
	$keyword = "";
	if( array_key_exists('keyword', $params)){
		$keyword = $params['keyword'];
	}
	$post_types = "post";
	if( array_key_exists('post_types', $params)){
		$post_types = $params['post_types'][0];
	}
	$param = array(
		'post_types' => $post_types, 
		'posts_per_page' => $posts_per_page, 
		'paged' => $params['paged'], 
		'category_id' => $category_id,
		'date' => $date,
		'keyword' => $keyword
	);
	 error_log(json_encode($param));
	$news = get_all_news( $param );
	$result = json_decode(json_encode($news), true);
	$response['posts'] = $result;
	echo json_encode( $response );
	exit;
}	
