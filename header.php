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

$hero = "";
if (has_post_thumbnail()){
	$hero = get_the_post_thumbnail_url(get_the_id(),"full");
} else if (is_front_page()){
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/home_hero.jpg";
} else if (get_post_type() == "post"){
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/articles-hero.jpg";
} else if (get_post_type() == "poi"){
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/events-hero.jpg";
} else {
	//default hero
	$hero = "/wp-content/themes/mm-willametteValley-child-theme/public/images/events-hero.jpg";
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

$title_tag = "h1";
if (is_search()) {
	$page_title = "Search";
} else if (is_404()){
	$page_title = "404";
} else if (get_post_type() === "post"){
	$page_title = "Articles";
	$title_tag = "h2";
} else {
	$page_title = get_the_title();
}
template('layout/header', [
	'image_url' => get_stylesheet_directory_uri()."/public/images/",
	'hero' => $hero,
	'title_color' => $title_color,
	'hero_overlay' => is_front_page() ?
		"<img src=".get_stylesheet_directory_uri()."/public/images/adventure_ahead.svg alt='Adventure lies ahead' />"
		: "<$title_tag class='hero__title' style='background-color: ".$title_color."'>".$page_title."</h1>",
]);
