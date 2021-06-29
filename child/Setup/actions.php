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
	if( (!is_home() && !is_front_page()) ){
		if( '/' == substr($_SERVER['REQUEST_URI'], -1)){
			$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
			$post = get_page_by_path( $trimmed_uri, OBJECT, 'POST' );
			if( $post ){
			error_log("with slash::".$_SERVER['REQUEST_URI']);
				$url = get_permalink( $post->ID );
			    wp_redirect( $url );
			}
		}
		else{
			$post = get_page_by_path( $_SERVER['REQUEST_URI'] , OBJECT, 'POST' );
			if( $post ){
			error_log("no trailing::".$_SERVER['REQUEST_URI']);
				$url = get_permalink( $post->ID );
			    wp_redirect( $url );
			}			
		}
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
	 $news = get_otis_posts();
	$result = json_decode(json_encode($news), true);
	$response['posts'] = $result;
	echo json_encode( $response );
	exit;
}	
