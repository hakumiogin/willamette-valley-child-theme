<?php

namespace Madden\Theme\Child;

use Tonik\Gin\Asset\Asset;
use Tonik\Gin\Foundation\Theme;
use Tonik\Gin\Template\Template;

/**
 * Gets theme instance.
 *
 * @param string|null $key
 *
 * @return \Tonik\Gin\Foundation\Theme
 */
function theme($key = null)
{
    if (null !== $key) {
        return Theme::getInstance()->get($key);
    }

    return Theme::getInstance();
}

/**
 * Gets theme config instance.
 *
 * @param string|null $key
 *
 * @return array
 */
function config($key = null)
{
    if (null !== $key) {
        return theme('child.config')->get($key);
    }

    return theme('child.config');
}

/**
 * Renders template file with data.
 *
 * @param  string $file Relative path to the template file.
 * @param  array  $data Dataset for the template.
 *
 * @return void
 */
function template($file, $data = [])
{
    $template = new Template(config());

    return $template
        ->setFile($file)
        ->render($data);
}

/**
 * Gets asset instance.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return \Tonik\Gin\Asset\Asset
 */
function asset($file){
  $asset = new Asset(config());

  return $asset->setFile($file);
}

/**
 * asset_exists
 *
 * @param  mixed $file
 * @return void
 */
function asset_exists( $file ){
  return asset( $file )->fileExists( $file );
}

/**
 * Gets asset file from public directory.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return string
 */
function asset_path( $file )
{
  return asset( $file )->getPath();
}

/**
 * Gets asset uri from file.
 *
 * @param  string $file Relative file path to the asset file.
 *
 * @return string
 */
function asset_uri( $file )
{
  return apply_filters( 'is_url', $file ) ? $file : asset( $file )->getUri();
}

/**
 * asset_pack
 *
 * Returns array from asset php file built by webpack.
 *
 * @param  string $file path to the asset file
 * @return array
 */
function asset_pack( $asset, $key = null )
{
  if(apply_filters( 'is_url', $asset ) ){
    return [];
  }

  $pack_file = preg_replace('/(.*)\/(.*)\.(.*)/', 'js/$2.asset.php', $asset);

  if( file_exists( $asset_path = asset_path( $pack_file ) ) ){
    $pack = include( $asset_path );
    return $key ? $pack[$key] : $pack;
  }
}