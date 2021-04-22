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
	'btn_text' => 'Learn More'
]);
template('layout/header', [
	'title' => 'Flop Click!'
]);
