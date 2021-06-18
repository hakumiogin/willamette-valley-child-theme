<?php

namespace Madden\Theme\Child\Setup;

add_filter( 'wp_otis_rest_auth', function ( $params ) {
	$params['username'] = 'API_WVVA';
	$params['password'] = '1potat02';
	return $params;
});

add_filter(
	'wp_otis_listings',
	function ( $params ) {
		$params['type'] = 'Bed & Breakfasts|Boutique Hotels|Events|Farm & Ranch Stays|Hostels|Campgrounds|Glamping & Treehouses|RV Parks|Vacation Rentals|Hotels & Motels|Resorts|Wine & Wineries';
		$params['region'] = 'Willamette Valley';
		return $params;
	}
);