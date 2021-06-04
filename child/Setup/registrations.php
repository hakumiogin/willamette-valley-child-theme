<?php
namespace Madden\Theme\Setup;
use function Madden\Theme\App\config;

function register_willamette_menus() {
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', config('textdomain') ),
		)
	);
	register_nav_menus(
		array(
			'about-us-footer-menu' => __( 'About Us Footer Menu', config('textdomain') ),
		)
	);
	register_nav_menus(
		array(
			'regions-footer-menu' => __( 'Regions Footer Menu', config('textdomain') ),
		)
	);
	register_nav_menus(
		array(
			'explore-footer-menu' => __( 'Explore Footer Menu', config('textdomain') ),
		)
	);

}
add_action( 'init', __NAMESPACE__.'\register_willamette_menus' );

function register_madden_block_pattern_category(){
	register_block_pattern_category(
		'madden',
		array( 'label' => __( 'Madden', config('textdomain') ) )
	);
}
add_action( 'init', __NAMESPACE__.'\register_madden_block_pattern_category' );

?>