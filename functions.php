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

function wordwrap_parse($content, $number_of_characters){
  $wordwrap = wordwrap($content, $number_of_characters, "\n");
  $wordwrapsplit = explode("\n", $wordwrap);
  $wordwrap = $wordwrapsplit[0];
  if (count($wordwrapsplit) > 1){
      $wordwrap = $wordwrap. "...";
  }
}
function textWrap($text, $number_of_characters) {
  $new_text = '';
  $text_1 = explode('>',$text);
  $sizeof = sizeof($text_1);
  for ($i=0; $i<$sizeof; ++$i) {
      $text_2 = explode('<',$text_1[$i]);
      if (!empty($text_2[0])) {
          $new_text .= preg_replace('#([^\n\r .]{25})#i', '\\1  ', $text_2[0]);
      }
      if (!empty($text_2[1])) {
          $new_text .= '<' . $text_2[1] . '>';   
      }
  }
  return $new_text;
}

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

