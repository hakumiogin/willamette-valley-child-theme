<?php
namespace Madden\Theme\Child\Http;
use function Madden\Theme\Child\asset_path;

/**
 * ? scripts 
 * @see assets/scripts.php
 * 
 * ? stylesheets
 * @see assets/stylesheets.php
 */

/**
 * * dequeue_parent_assets
 * Let's dequeue the parent theme's assets...
 * @return void
 */
function dequeue_parent_assets(){
  wp_dequeue_style('app');
  wp_dequeue_script('app');
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\dequeue_parent_assets');

function enqueue_child_assets (){
  wp_enqueue_script( 'appscript', asset_path('js/app.js'), ['jquery'], null, true );
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\enqueue_child_assets');
