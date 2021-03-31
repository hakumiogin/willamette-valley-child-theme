<?php

namespace Madden\Theme\Child\Setup;

use function Madden\Theme\Child\{
  asset_pack,
  asset_uri,
  asset_path,
  config
};

/**
 * enqueue_assets
 * --------------------------------------------------------- 
 * takes an array of asset location strings and
 * automagically preps them to be enqueued w/ enqueue_asset
 *
 * @param  array $assets[ handle => file ]
 * @return void
 * @since 0.0.2
 */
function enqueue_assets( array $assets ){
  foreach( $assets as $handle => $asset ){
    $path   = config('paths')['directory'];
    $public = config('directories')['public'];
    $file   = "{$path}/{$public}/{$asset}";
    if( file_exists( $file ) )
      do_action('enqueue_asset', [
        'handle' => $handle,
        'src' => asset_uri( $asset )
      ] + asset_pack( $asset ));
  }
}
add_action( 'enqueue_assets', __NAMESPACE__.'\enqueue_assets' );

/**
 * enqueue_asset
 * --------------------------------------------------------
 * receives an array of args meant to be passed to either:
 *  *.js  - wp_enqueue_script(...$args)
 *  *.css - wp_enqueue_style(...$args)
 *
 * @param  mixed $asset
 * @param  mixed $args
 * @return void
 * @since 0.0.2
 */
function enqueue_asset( $args ){
  switch ( pathinfo( $args['src'], PATHINFO_EXTENSION ) ) {
    case 'js':
      // handle specific scripts
      switch( $args[ 'handle' ] ){
				case config('textdomain')  :
					// put these scripts in the footer
          $args['in_footer'] = true;
        break;
      }
      wp_enqueue_script( ...array_values( $args ) );
    break;
    case 'css':
      $args['dependencies'] = false; // no dependencies
      wp_enqueue_style( ...array_values( $args ) );
    break;
  }
}
add_action( 'enqueue_asset', __NAMESPACE__.'\enqueue_asset', 1, 2 );