<?php
namespace Madden\Theme\Child\Http;

/** 
 * -----------------------------------------------------------------
 * Child Theme Stylesheets
 * -----------------------------------------------------------------
 * This file is for registering your child theme stylesheets
 * 
*/

use function Madden\Theme\Child\config;

/**
 * register_stylesheets
 * ---------------------------------------------------------------
 * register stylesheets via array passed to enqueue_assets 
 * ex: handle-name => dir/file.name
 * @return void
 */
function register_stylesheets(){
  global $post, $wp_query;

  // THE SLUG - IF THERE IS ONE... 
  $slug = $wp_query->queried_object->rewrite['slug'] ?? $post->post_name ?? false ;

  // STYLESHEETS 
  $stylesheets = [
    // BASE DIR IS CHILD_THEME/public
    'willamette-valley' => 'css/app.css',                          // Main site/app
    'gutenberg'          => 'css/gutenberg.css',                    // gutenberg blocks
  ];
  // END: STYLESHEETS 

  // 404 STYLE
  if( is_404() )
    $stylesheets[404] = "css/404.css";

  // ADD SLUG SPECIFIC CSS 
  if( $slug )
    $stylesheets[$slug] = "css/{$slug}.css";

  // ENQUEUE ASSETS
  do_action( 'enqueue_assets', $stylesheets );
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\register_stylesheets');
