<?php 
/* Template Name: 404 
*/ 

// our redirects
$redirects = [
	"/articles/hike-here-drink-there-your-guide-to-fall-foliage-hikes-and-post-adventure-in-the-willamette-valley/" => "/relaunched/",
	"/articles/wine/wine-trails/places-to-sip-between-the-wonders/" => "/relaunched/",
	"/covid-19-resources-for-small-businesses-and-nonprofits/" => "/relaunched/",
	"/enjoy-the-willamette-valleys-wide-open-spaces/" => "/relaunched/",
	"/eugenes-running-scene-track-town-u.s.a./" => "/relaunched/",
	"/fall2018grants/" => "/relaunched/",
	"/family-fun-in-the-north-willamette-valley/" => "/relaunched/",
	"/family-fun-in-the-south-willamette-valley/" => "/relaunched/",
	"/food-trails-showcase-regions-bounty/" => "/relaunched/",
	"/hike-here-drink-there-your-guide-to-fall-foliage-hikes-and-post-adventure-in-the-willamette-valley/" => "/relaunched/",
	"/home/" => "/relaunched/",
	"/places-to-sip-between-the-wonders/" => "/relaunched/",
	"/stay-local-and-safe-when-wine-tasting-in-the-willamette-valley/" => "/relaunched/",
	"/articles/linn-benton-farm-to-table-dinner-series/" => "/relaunched/",
	"/articles/plan-your-trip-to-salem-for-the-great-american-solar-eclipse-2017/" => "/relaunched/",
	"/art-exhibit-showcases-confederated-tribes-of-grand-ronde-culture-and-history/" => "/relaunched/",
	"/articles/10-years-of-trolley-tours-in-corvallis/" => "/relaunched/",
	"/articles/a-wine-country-getaway-for-you-and-your-four-legged-friend/" => "/relaunched/",
	"/articles/art-exhibit-showcases-confederated-tribes-of-grand-ronde-culture-and-history/" => "/relaunched/",
	"/articles/bike-bridges-and-hike-foothills-in-linn-county/" => "/relaunched/",
	"/articles/celebrate-fall-with-arts-sports-and-so-much-more-in-corvallis/" => "/relaunched/",
	"/articles/celebrate-oregon-wine-month-at-taste-dundee/" => "/relaunched/",
	"/articles/celebrate-the-holiday-season-in-oregon-wine-country/" => "/relaunched/",
	"/articles/celebrate-yamhill-valleys-agricultural-bounty/" => "/relaunched/",
	"/articles/corvallis-a-town-with-a-story-to-tell/" => "/relaunched/",
	"/articles/early-harvest-for-yamhill-county/" => "/relaunched/",
	"/articles/experience-salems-world-class-wine-region/" => "/relaunched/",
	"/articles/explore-eugenes-urban-wineries-territorial-wine-trail-with-pinot-bingo/" => "/relaunched/",
	"/articles/explore-oregons-cascades-mountains-waterfalls-and-hotsprings-along-the-mckenzie-river-corridor/" => "/relaunched/",
	"/articles/fall-into-the-heart-of-the-willamette-valley/" => "/relaunched/",
	"/articles/farm-feast-wine-in-yamhill-county/" => "/relaunched/",
	"/articles/featured-stories/block-15-in-corvallis/" => "/relaunched/",
	"/articles/featured-stories/great-beer-and-cozy-vibes-in-albany-oregon/" => "/relaunched/",
	"/articles/featured-stories/mount-hoods-magical-soils-give-life-to-dahlias/" => "/relaunched/",
	"/articles/featured-stories/salem-craft-brews-at-gilgamesh/" => "/relaunched/",
	"/articles/featured-stories/sip-artisan-cider-in-eugene-oregon/" => "/relaunched/",
	"/articles/featured-stories/tours-connect-visitors-with-salem-agriculture/" => "/relaunched/",
	"/articles/foodie-fests-farm-dinners/" => "/relaunched/",
	"/articles/get-cozy-in-corvallis-all-winter-long/" => "/relaunched/",
	"/articles/lavender-festival-at-the-chehalem-cultural-center/" => "/relaunched/",
	"/articles/mount-hoods-magical-soils-give-life-to-dazzling-dahlias/" => "/relaunched/",
	"/articles/road-trip-santiam-wagon-road-and-paths-less-traveled/" => "/relaunched/",
	"/articles/small-business-saturday-and-holiday-shopping-in-the-willamette-valley/" => "/relaunched/",
	"/articles/spring-into-corvallis/" => "/relaunched/",
	"/join-our-annual-ornament-hunt-and-sweepstakes/" => "/relaunched/",
	"/stay-local-and-safe-in-oregon-wine-country-this-summer/" => "/relaunched/",
	"/st-josefs-winery-in-mt-hood-territory/" => "/relaunched/",
	"/oregons-scenic-bikeways-celebrate-10-years/" => "/relaunched/",
	"/enjoy-the-willamette-valley-outdoors-this-summer/" => "/relaunched/",
	"/stories/featured-stories/tours-connect-visitors-with-salem-agriculture/" => "/relaunched/",
	"/stories/featured-stories/sip-artisan-cider-in-eugene-oregon/" => "/relaunched/",
	"/stories/featured-stories/salem-craft-brews-at-gilgamesh/" => "/relaunched/",
	"/stories/featured-stories/mount-hoods-magical-soils-give-life-to-dahlias/" => "/relaunched/",
	"/stories/featured-stories/great-beer-and-cozy-vibes-in-albany-oregon/" => "/relaunched/",
	"/stories/featured-stories/block-15-in-corvallis/" => "/relaunched/",
	"/ornament/" => "/relaunched/",
	"/holiday-gift-guide/" => "/relaunched/",
];

// did we find a redirect?
$requestURI = ( substr( $_SERVER["REQUEST_URI"], -1, 1 ) == "/" ) ? $_SERVER["REQUEST_URI"] : "{$_SERVER["REQUEST_URI"]}/";
if ( isset( $redirects[$requestURI] ) ) {
	// send them off
	header( "HTTP/1.1 301 Moved Permanently" );
	header( "Location: /relaunched?url=".urlencode( $_SERVER["REQUEST_URI"] ) );
	exit;
}


use function Madden\Theme\Child\template;

/**
 * Renders layout's head.
 *
 * @see resources/templates/layout/head.tpl.php
 */
template('404');


?>