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

add_filter( '404_template',  __NAMESPACE__.'\redirect_posts' );
function redirect_posts( $template )
{
	if( (!is_home() && !is_front_page()) ){
		$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
		$trimmed_uri = preg_replace('#-#', ' ', $trimmed_uri ) ;
		$post = get_page_by_title( $trimmed_uri, OBJECT, 'POST' );
		if( $post ){
			$url = get_permalink( $post->ID );
		    wp_redirect( $url , 301);
		    exit;
		}
		else{
			if( '/' == substr($_SERVER['REQUEST_URI'], -1)){
				$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
				$post = get_page_by_path( $trimmed_uri, OBJECT, 'POST' );
				if( $post ){
					$url = get_permalink( $post->ID );
				   wp_redirect( $url , 301);
				   exit;
				}
			}
			else{
				$post = get_page_by_path( $_SERVER['REQUEST_URI'] , OBJECT, 'POST' );
				if( $post ){
					$url = get_permalink( $post->ID );
				   wp_redirect( $url , 301);
				   exit;
				}			
			}
		}
		return $template;
	}
}



add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\ajax_blog_enqueue' );
function ajax_blog_enqueue() {
	wp_enqueue_script( 'ajax_pagination',  get_stylesheet_directory_uri() . '/public/js/ajax.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'ajax_pagination', 'ajax_pagination', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
}

add_action( 'wp_ajax_nopriv_ajax_pagination', __NAMESPACE__ . '\otis_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination',  __NAMESPACE__ . '\otis_ajax_pagination' );
function otis_ajax_pagination() {
	$params = $_REQUEST['params'];
	$posts_per_page = -1;
	$categories = "";
	if( array_key_exists('categories', $params)){
		$categories = $params['categories'];
	}
	$dateSort = "";
	if( array_key_exists('dateSort', $params)){
		$dateSort = $params['dateSort'];
	}
	$regions = "";
	if( array_key_exists('regions', $params)){
		$regions = $params['regions'];
	}
	$param = array(
		'post_types' => $post_types, 
		'posts_per_page' => $posts_per_page, 
		'categories' => $categories,
		'date' => $date,
		'regions' => $regions
	);
	 $posts = get_otis_posts( $categories , $regions, $dateSort );
	 $results = build_otis_slider( $posts );
	echo json_encode( $results );
	exit;
}	

add_action('acf/init',  __NAMESPACE__ . '\acf_add_cities_page');
function acf_add_cities_page() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Region Cities'),
            'menu_title'    => __('Region Cities'),
            'menu_slug'     => 'region-cities',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}