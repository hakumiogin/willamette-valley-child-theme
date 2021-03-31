<?php

namespace Madden\Theme\Child\Http;

use function Madden\Theme\Child\Http\rest_api_data_localizer;

use function Madden\Theme\Child\{
	asset_uri,
	config
};

/**
 * Enqueue admin-only scripts and styles, including block styles
 * add scripts to register [ handle => file ]
 */
function register_admin_assets(){
  $scripts = [
    'admin-js'    			 => 'js/wp-admin.js'
  ];

  $styles =  [
    'admin-css'     		 => 'css/wp-admin.css',
    'gutenberg-css' 	   => 'css/gutenberg.css'
  ];

  $assets = $scripts + $styles;

  // enqueue scripts and styles
	do_action( 'enqueue_assets', $assets );
}
add_action('admin_enqueue_scripts', __NAMESPACE__.'\register_admin_assets', 1);

/**
 * Registers editor stylesheets.
 *
 * @return void
 */
function register_editor_stylesheets(){
  add_editor_style( asset_uri( 'css/app.css' ) );
}
add_action('admin_init', __NAMESPACE__.'\register_editor_stylesheets');
