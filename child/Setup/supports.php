<?php

namespace Madden\Theme\Child\Setup;

/*
|-----------------------------------------------------------
| Theme Supports
|-----------------------------------------------------------
|
| This file enables theme supports, which activates various
| WordPress functions used or required by this child
| theme. By default we enabled most common for you.
|
*/

use function Madden\Theme\Child\config;

/**
 * Loads the child theme textdomain.
 *
 * @return void
 */
function load_textdomain() {
    $paths = config('paths');
    $directories = config('directories');

    load_child_theme_textdomain(config('textdomain'), "{$paths['directory']}/{$directories['languages']}");
}
add_action('after_setup_theme', __NAMESPACE__.'\load_textdomain');

function setup_supports() {
    remove_theme_support('core-block-patterns');
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 229, 205, true );
    add_image_size( 'big-thumbnail', 250, 250, true );
    add_image_size( 'small-thumb', 150, 150, true );
    add_image_size( 'two-thirds', 720, 9999 );
    add_image_size( 'full-width', 1200, 9999 );
    add_image_size( 'hero', 1600, 9999);
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_attr__( 'peach', config('textdomain') ),
            'slug' => 'peach',
            'color' => '#e29d7e',
        ),
        array(
            'name' => esc_attr__( 'orange', config('textdomain') ),
            'slug' => 'orange',
            'color' => '#d87d53',
        ),
        array(
            'name' => esc_attr__( 'lime', config('textdomain') ),
            'slug' => 'lime',
            'color' => '#b4bc33',
        ),
        array(
            'name' => esc_attr__( 'green', config('textdomain') ),
            'slug' => 'green',
            'color' => '#68813b',
        ),
        array(
            'name' => esc_attr__( 'purple', config('textdomain') ),
            'slug' => 'purple',
            'color' => '#6a3b5d',
        ),
        array(
            'name' => esc_attr__( 'teal', config('textdomain') ),
            'slug' => 'teal',
            'color' => '#046d70',
        ),
        array(
            'name' => esc_attr__( 'blue', config('textdomain') ),
            'slug' => 'blue',
            'color' => '#a2c4d1',
        ),
        array(
            'name' => esc_attr__( 'dark blue', config('textdomain') ),
            'slug' => 'dark-blue',
            'color' => '#7bacbe',
        ),
        array(
            'name' => esc_attr__( 'tan', config('textdomain') ),
            'slug' => 'tan',
            'color' => '#f6f3ee',
        ),
        array(
            'name' => esc_attr__( 'white', config('textdomain') ),
            'slug' => 'white',
            'color' => '#fff',
        ),
        array(
            'name' => esc_attr__( 'dark grey', config('textdomain') ),
            'slug' => 'dark-grey',
            'color' => '#404040',
        ),
        array(
            'name' => esc_attr__( 'light grey', config('textdomain') ),
            'slug' => 'light-gray',
            'color' => '#dadada',
        ),
        array(
            'name' => esc_attr__( 'grey', config('textdomain') ),
            'slug' => 'grey',
            'color' => '#616161',
        ),
        array(
            'name' => esc_attr__( 'black', config('textdomain') ),
            'slug' => 'black',
            'color' => '#000',
        ),
    ) );
}
add_action('after_setup_theme', __NAMESPACE__.'\setup_supports');


