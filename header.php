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
$featured_image = get_the_post_thumbnail_url();
$hero = "";
if ($featured_image){
	$hero = $featured_image;
} else if (is_home()){
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/home_hero.jpg";
} else {
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/home_hero.jpg";
}
$home_hero_img = "";
if (is_home()){
	$home_hero_img = get_stylesheet_directory_uri()."/public/images/adventure_ahead.svg";
}
$color = get_field("color");
$title_color = "rgba(106, 59, 93, .54)";
if ($color == "Lime"){
	$title_color = "rgba(180, 188, 51, 0.85)";
} else if ($color == "Purple"){
	$title_color = "rgba(106, 59, 93, .54)";
} else if ($color == "Green"){
	$title_color = "rgba(104, 129, 59, .76)";
} else if ($color == "Teal"){
	$title_color = "rgba(0, 94, 98, 0.67)";
}
template('layout/head');
template('layout/covid-banner', [
	'text' => 'Covid-19 updates and travel alerts',
	'btn_text' => 'More Info'
]);
$page_title = get_post_type() === "post" ? "News" : get_the_title();
template('layout/header', [
	'image_url' => get_stylesheet_directory_uri()."/public/images/",
	'hero' => $hero,
	'title_color' => $title_color,
	'home_hero_img' => $home_hero_img,
	'hero_overlay' => is_home() ? "<img src=".get_stylesheet_directory_uri()."/public/images/adventure_ahead.svg alt='Adventure lies ahead' />"
		: "<h1 class='hero__title' style='background-color: ".$title_color."'>".$page_title."</h1>",
]);
