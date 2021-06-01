<?php
namespace Madden\Theme\Setup;
use function Madden\Theme\App\config;

function register_my_menus() {
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', config('textdomain') ),
		)
	);
}
add_action( 'init', __NAMESPACE__.'\register_my_menus' );

function register_madden_block_pattern_category(){
	register_block_pattern_category(
		'madden',
		array( 'label' => __( 'Madden', config('textdomain') ) )
	);
}
add_action( 'init', __NAMESPACE__.'\register_madden_block_pattern_category' );

?>