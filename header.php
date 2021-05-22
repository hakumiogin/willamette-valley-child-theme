<?php

namespace Madden\Theme\Header;

/*
|------------------------------------------------------------------
| Header Controller
|------------------------------------------------------------------
|
| Controller for outputting layout's opening markup. Template
| rendered here should include `wp_head()` function call.
|
*/

use function Madden\Theme\Child\template;

/**
 * Renders layout's head.
 *
 * @see resources/templates/layout/head.tpl.php
 */
template('layout/head');
template('layout/covid-banner', [
	'text' => 'Covid-19 updates and travel alerts',
	'btn_text' => 'More Info'
]);
template('layout/header', [
	'logo_src' => get_stylesheet_directory_uri()."/public/images/logo@1.png",
	'logo_src_2x' => get_stylesheet_directory_uri()."/public/images/logo@2.png",
	'mag_icon' => get_stylesheet_directory_uri()."/public/images/mag_glass.svg",
	'hero_img' => get_stylesheet_directory_uri()."/public/images/adventure_ahead.svg",
]);
