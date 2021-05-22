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
?>