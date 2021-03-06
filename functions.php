<?php

/*
 |------------------------------------------------------------------
 | Bootstraping a Child Theme
 |------------------------------------------------------------------
 |
 | This file is responsible for bootstrapping your theme. Autoloads
 | composer packages and loads child theme files. Most likely,
 | you don't need to change anything in this file. Your
 | theme custom logic should be distributed across a
 | separated components in the `/app` directory.
 |
 */

// Require Composer's autoloading file
// if it's present in theme directory.
use function Madden\Theme\Child\template;

if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require $composer;
}

// Child theme **HAVE TO** be bootstraped after parent
// theme load. We will use `after_load` action
// to delay loading of this child theme.
add_action('tonik/gin/autoloader/after_load', function () {
    static $bootstraped = false;

    if (! $bootstraped) {
        $bootstraped = true;

        $theme = require_once __DIR__ . '/bootstrap/theme.php';

        (new Tonik\Gin\Foundation\Autoloader($theme->get('child.config')))->register();
    }
});

function custom_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchForm" class="searchform" action="' . home_url( '/' ) . '" >
	  <label aria-label="search">
	  <input type="text" name="s" id="searchInput" placeholder="search" /></label>
	</form>';
	return $form;
  }
  
  add_filter( 'get_search_form', 'custom_search_form', 100 );
  
  function willamette_acf_block_render_callback($block){
    $slug = str_replace('acf/', '', $block['name']);
    template("/blocks/".$slug, array(
        "block" => $block,
      )
    );
}



/**
 * Sets the extension and mime type for .webp files.
 *
 * @todo Confirm with group and move these to the parent tonik theme ASAP (it's a weekend right now and I need this.)
 *
 * @param array  $wp_check_filetype_and_ext File data array containing 'ext', 'type', and
 *                                          'proper_filename' keys.
 * @param string $file                      Full path to the file.
 * @param string $filename                  The name of the file (may differ from $file due to
 *                                          $file being in a tmp directory).
 * @param array  $mimes                     Key is the file extension with value as the mime type.
 */
function add_file_and_ext_webp( $types, $file, $filename, $mimes ) {
  if ( false !== strpos( $filename, '.webp' ) ) {
    $types['ext'] = 'webp';
    $types['type'] = 'image/webp';
  }

  return $types;
}
add_filter('wp_check_filetype_and_ext', '\add_file_and_ext_webp', 10, 4);

/**
 * Adds webp filetype to allowed mimes
 *
 * @todo Confirm with group and move these to the parent tonik theme ASAP (it's a weekend right now and I need this.)
 * 
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
 * 
 * @param array $mimes Mime types keyed by the file extension regex corresponding to
 *                     those types. 'swf' and 'exe' removed from full list. 'htm|html' also
 *                     removed depending on '$user' capabilities.
 *
 * @return array
 */
function allow_webp_uploads( $mimes ) {
  $mimes['webp'] = 'image/webp';

  return $mimes;
}
add_filter( 'upload_mimes', '\allow_webp_uploads' );

//enable upload for webp image files.
function webp_upload_mimes($existing_mimes) {
  $existing_mimes['webp'] = 'image/webp';
  return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

//enable preview / thumbnail for webp image files.
function webp_is_displayable($result, $path) {
  if ($result === false) {
      $displayable_image_types = array( IMAGETYPE_WEBP );
      $info = @getimagesize( $path );

      if (empty($info)) {
          $result = false;
      } elseif (!in_array($info[2], $displayable_image_types)) {
          $result = false;
      } else {
          $result = true;
      }
  }

  return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

function sort_times($array, $array2){
  return $array[1] > $array2[1];
}
function sort_times_reverse($array, $array2){
  return $array[1] < $array2[1];
}


/* make gravity forms available to Editor role */
function add_editor_cap(){
  $role = get_role( 'editor' );
  $role->add_cap('manage_options');
  $role->add_cap( 'gform_full_access' );
}
add_action( 'admin_init', 'add_editor_cap' );


function filter_search_post_types($query) {
	if ($query->is_search && !is_admin()) {
		$query->set('post_type', array('post', 'page'));
	}
	return $query;
}
add_filter('pre_get_posts', 'filter_search_post_types');

/* limit sweeps form country dropdown to us/canada only */
function sweeps_limit_countries( $form ) {

  add_filter( 'gform_countries', function( $countries ) {
    return array( 'United States', 'Canada' );
  });

  return $form;
}
add_filter( 'gform_pre_render_4', 'sweeps_limit_countries' );
add_filter( 'gform_pre_validation_4', 'sweeps_limit_countries' );
add_filter( 'gform_pre_submission_filter_4', 'sweeps_limit_countries' );
add_filter( 'gform_admin_pre_render_4', 'sweeps_limit_countries' );

/**
 * Disable REST API endpoints for non-logged in users. Danke https://stackoverflow.com/a/62430375
 *
 * @param array $endpoints      The original endpoints
 * @return array $endpoints     The updated endpoints
 */
function disable_rest_endpoints ( $endpoints ) {

  $endpoints_to_remove = array(
      '/wp/v2/media',
      '/wp/v2/types',
      '/wp/v2/statuses',
      '/wp/v2/taxonomies',
      '/wp/v2/tags',
      '/wp/v2/users',
      '/wp/v2/comments',
      '/wp/v2/settings',
      '/wp/v2/themes',
      '/wp/v2/blocks',
      '/wp/v2/oembed',
      '/wp/v2/block-renderer',
      '/wp/v2/search',
      '/wp/v2/categories'
  );

  if ( ! is_user_logged_in() ) {
      foreach ( $endpoints_to_remove as $rem_endpoint ) {
          // $base_endpoint = "/wp/v2/{$rem_endpoint}";
          foreach ( $endpoints as $maybe_endpoint => $object ) {
              if ( stripos( $maybe_endpoint, $rem_endpoint ) !== false ) {
                  unset( $endpoints[ $maybe_endpoint ] );
              }
          }
      }
  }
  return $endpoints;
}
add_filter( 'rest_endpoints', 'disable_rest_endpoints' );
