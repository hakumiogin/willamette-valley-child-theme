<?php

namespace Madden\Theme\Child\Setup;

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
	echo 'var nonce = "'.$nonce.'"\n';
	echo '</script>';
}
add_action("theme/after-body", __NAMESPACE__."\add_ajax_url_to_js");

add_action( 'wp', __NAMESPACE__.'\add_redirect' );
function add_redirect()
{
	if( '/' == substr($_SERVER['REQUEST_URI'], -1)){
		$trimmed_uri = preg_replace('#/#', '', trim( $_SERVER['REQUEST_URI'] ) ) ;
		$post = get_page_by_path( $trimmed_uri, OBJECT, 'POST' );
		if( $post ){
			$url = get_permalink( $post->ID );
		    wp_redirect( $url );
		}
	}
}
