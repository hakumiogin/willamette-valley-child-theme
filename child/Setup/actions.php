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

function wp_head(){
	// use this action to hook into theme head 
	do_action('theme/head');
}
add_action( 'wp_head', 'Madden\Theme\Child\Setup\wp_head' );
