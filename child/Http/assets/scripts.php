<?php
namespace Madden\Theme\Child\Http;

/** 
 * -----------------------------------------------------------------
 * Child Theme Scripts 
 * -----------------------------------------------------------------
 * This file is for registering child theme scripts
 * 
*/

use function Madden\Theme\Child\config;

/**
 * register_scripts
 * ---------------------------------------------------------------
 * register scripts via array passed to enqueue_assets 
 * ex: handle-name => dir/file.name
 * @return void
 */
function register_scripts(){
  // scripts 
  
  $scripts = [
    config('textdomain') => 'js/app.js',
  ];
  // stop scripts 

  // enqueue assets
  do_action('enqueue_assets', $scripts);
}
add_action('wp_enqueue_scripts', __NAMESPACE__.'\register_scripts');






// <?php
// namespace Madden\Theme\Child\Http;

// /** 
//  * -----------------------------------------------------------------
//  * Child Theme Scripts 
//  * -----------------------------------------------------------------
//  * This file is for registering child theme scripts
//  * 
// */

// use function Madden\Theme\Child\config;
// use function Madden\Theme\Child\asset_path;

// /**
//  * register_scripts
//  * ---------------------------------------------------------------
//  * register scripts via array passed to enqueue_assets 
//  * ex: handle-name => dir/file.name
//  * @return void
//  */
// function register_scripts(){
//   // scripts 
//   wp_enqueue_script('appjs', asset_path('js/app.js'), ['jquery'], null, false);
//   // stop scripts 
// }
// add_action('wp_enqueue_scripts', __NAMESPACE__.'\register_scripts');