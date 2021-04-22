<?php

/*
|-----------------------------------------------------------
| Create the Theme
|-----------------------------------------------------------
|
| Create a new Theme instance which behaves as singleton.
| This allows for easily bind and resolve various
| parts across all theme components.
|
*/

$theme = Tonik\Gin\Foundation\Theme::getInstance();


/*
|-----------------------------------------------------------
| Bind Theme Config
|-----------------------------------------------------------
|
| We neet to bind all configs like theme's paths, directories
| and files to autoload. We look for child theme config
| file before binding values inside theme registry.
|
*/

$config = require __DIR__ . '/../config/app.php';

$theme->bind('child.config', function () use ($config) {
    return new Tonik\Gin\Foundation\Config($config);
});


/*
|-----------------------------------------------------------
| Return the Theme
|-----------------------------------------------------------
|
| Here we returns the theme instance. Later, this instance
| is used for autoload all theme's core component.
|
*/

return $theme;
