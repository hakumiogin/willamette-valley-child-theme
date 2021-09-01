<?php
namespace Madden\Theme\Setup;
use function Madden\Theme\App\config;

define( 'THEME_PREFIX', config('textdomain') );


function willamette_blocks_category($categories, $post) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'madden',
                'title' => __('Madden Blocks', config('textdomain')),
                'icon' => '<?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="-178.231 -49.808 43.848 51.183" enable-background="new -176.436 -47.885 176.438 47.886" xmlns="http://www.w3.org/2000/svg"><g><path d="M-137.111-39.063c0.002-0.016,0.002-0.031,0-0.047c-0.004-0.085-0.021-0.169-0.051-0.249 c-0.034-0.081-0.077-0.157-0.129-0.228l-0.026-0.039c-0.054-0.067-0.117-0.126-0.188-0.176h-0.026 c-0.072-0.05-0.151-0.089-0.235-0.116h-0.025c-0.045-0.014-0.091-0.024-0.139-0.03h-0.167c-0.083,0-0.166,0.013-0.244,0.039h-0.048 c-0.084,0.029-0.164,0.069-0.235,0.12l-14.366,10.179l-21.903-18.107l-0.068-0.047l-0.068-0.043l-0.073-0.034l-0.099-0.043h-0.082 h-0.073h-0.086h-0.163c-0.027-0.002-0.057-0.002-0.086,0h-0.029h-0.042l-0.086,0.025l-0.072,0.03l-0.073,0.039l-0.063,0.026 l-0.039,0.021c0,0,0,0-0.024,0l-0.061,0.06l-0.057,0.056l-0.051,0.064l-0.047,0.064l-0.035,0.069 c-0.013,0.025-0.024,0.051-0.034,0.077l-0.025,0.073c-0.002,0.027-0.002,0.054,0,0.082c-0.005,0.024-0.005,0.049,0,0.073 c-0.002,0.03-0.002,0.061,0,0.09c0,0,0,0.026,0,0.043v34.704c0,0.199,0.063,0.395,0.179,0.557c0.114,0.164,0.277,0.287,0.467,0.354 c0.104,0.037,0.212,0.057,0.322,0.056c0.135-0.009,0.267-0.046,0.387-0.108c0.12-0.063,0.225-0.15,0.309-0.257l9.075-11.196 l17.004,22.564c0.044,0.053,0.092,0.102,0.144,0.146h0.029c0.043,0.033,0.09,0.062,0.139,0.086l0.052,0.025 c0.049,0.025,0.101,0.043,0.154,0.057h0.034c0.059,0.006,0.116,0.006,0.177,0h0.035c0.06,0.006,0.119,0.006,0.18,0h0.051 l0.129-0.043h0.03h0.03l0.076-0.043l0.063-0.039l0.064-0.051l0.056-0.053l0.056-0.06l0.047-0.06 c0.018-0.022,0.03-0.045,0.044-0.069l0.038-0.069c0-0.025,0-0.047,0.03-0.072c0.011-0.025,0.02-0.051,0.026-0.078V-0.67 l3.625-14.023l4.854,2.482c0.133,0.067,0.28,0.103,0.431,0.104c0.18,0,0.354-0.049,0.508-0.142c0.14-0.087,0.255-0.209,0.336-0.353 c0.081-0.145,0.123-0.307,0.124-0.473v-25.967C-137.128-39.045-137.118-39.052-137.111-39.063z M-139.686-36.708l-8.102,31.353 l-4.184-22.605L-139.686-36.708z M-173.015-43.641l17.996,14.856l-10.109,3.152L-173.015-43.641z M-174.561-42.353l7.766,17.747 l-7.766,9.582V-42.353z M-164.077-23.94l10.309-3.204l4.161,22.38L-164.077-23.94z M-139.038-14.642l-3.827-1.94l3.827-14.827 V-14.642z" style=""/></g></svg>'
            )
        )
    );
}

add_filter('block_categories', 'Madden\Theme\Setup\willamette_blocks_category', 10, 2);

function willamette_block_register() {
    // wp_register_script(
    //     'willamette-image-box-editor-script', 
    //     get_template_directory(). "/public/js/gutenberg.js",
    //     array(
    //         'wp-blocks',
    //         'wp-i18n'
    //     )
    // );

    register_block_type(
        'willamette/image-box',
        array(
            'editor_script' => 'willamette-image-box-editor-script',
            // 'script' => '',
            // 'style' => '',
            // 'editor_style' => '',
        )
    );
}
add_action('init', 'Madden\Theme\Setup\willamette_block_register');

add_action('acf/init', 'Madden\Theme\Setup\willamette_acf_block_register');
function willamette_acf_block_register() {
	if( function_exists('acf_register_block') ) {
		acf_register_block(array(
			'name'				=> 'category-slider',
			'title'				=> __('Madden Category Slider'),
			'description'		=> __('Madden Category Slider.'),
			'render_callback'	=> 'willamette_acf_block_render_callback',
			'category'			=> 'madden',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'category', 'slider' ),
		));
		acf_register_block(array(
			'name'				=> 'otis-slider',
			'title'				=> __('otis Category Slider'),
			'description'		=> __('otis Category Slider.'),
			'render_callback'	=> 'willamette_acf_block_render_callback',
			'category'			=> 'madden',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'category', 'slider' ),
		));
        acf_register_block(array(
			'name'				=> 'featured-slider',
			'title'				=> __('Madden Featured Slider'),
			'description'		=> __('Madden Featured Slider.'),
			'render_callback'	=> 'willamette_acf_block_render_callback',
			'category'			=> 'madden',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'featured', 'slider' ),
		));
        acf_register_block(array(
			'name'				=> 'functional-map',
			'title'				=> __('Madden Functional Map'),
			'description'		=> __('Madden Functional Map.'),
			'render_callback'	=> 'willamette_acf_block_render_callback',
			'category'			=> 'madden',
			'icon'				=> 'admin-comments',
			'keywords'			=> array( 'map' ),
		));	

	}
}
?>