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
  error_log('404 template');
	if( (!is_home() && !is_front_page()) ){
		$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
		$trimmed_uri = preg_replace('#-#', ' ', $trimmed_uri ) ;
		$post = get_page_by_title( $trimmed_uri, OBJECT, 'POST' );
		error_log("42 start::".$_SERVER['REQUEST_URI']);
		if( $post ){
			$url = get_permalink( $post->ID );
				error_log("44 pagenmae::".$_SERVER['REQUEST_URI']);
		    wp_redirect( $url , 301);
		    exit;
		}
		else{
		error_log("49 no name::".$_SERVER['REQUEST_URI']);

			if( '/' == substr($_SERVER['REQUEST_URI'], -1)){
				$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
				$post = get_page_by_path( $trimmed_uri, OBJECT, 'POST' );
				error_log("55 with slash::".$_SERVER['REQUEST_URI'] );
				if( $post ){
				error_log("57 with slash and post::".$_SERVER['REQUEST_URI']);
					$url = get_permalink( $post->ID );
				   wp_redirect( $url , 301);
				   exit;
				}
			}
			else{
				$post = get_page_by_path( $_SERVER['REQUEST_URI'] , OBJECT, 'POST' );
				error_log("65 no trailing::".$_SERVER['REQUEST_URI']);
				if( $post ){
				error_log("67 no trailing::".$_SERVER['REQUEST_URI']);
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
	$posts_per_page = 10;
	 error_log("params". print_r( $params, true));
	if( array_key_exists('posts_per_page',$params) ){
		$posts_per_page = $params['posts_per_page'];
	}
	$categories = "";
	if( array_key_exists('categories', $params)){
		$categories = $params['categories'];
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
		'categories' => $categories,
		'date' => $date,
		'keyword' => $keyword
	);
	 error_log(json_encode($param));
	 $posts = get_otis_posts( $categories );
	 $slider = build_otis_slider( $posts );
		$response['posts'] = $slider ;
	echo json_encode( $response );
	exit;
}	
