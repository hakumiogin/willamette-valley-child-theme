<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <style>
   #mapid { height: 380px; }
   .leaflet-popup-content-wrapper {
        padding: 2rem;
   }
   .leaflet-popup-content-wrapper h3{
        color: #6a3b5d;
        text-transform: none;
        font-size: 2rem;
        width: 100%;
        display: block;
        margin-bottom: 1rem;
    }
   .leaflet-popup-content-wrapper a{
        width: 100%;
   }
.leaflet-popup-content-wrapper .leaflet-popup-content {
}

.leaflet-popup-tip-container {
}
  </style>

<?php

use function Madden\Theme\Child\Setup\get_otis_posts;
$categories = get_field('map_categories');
    $pageposts = get_otis_posts( $categories, null,null , 500);
    $listings = [];
    $filter_buttons = [];
    $filter_cats_all = [];
    foreach ($pageposts as $array ) {
        $post_id = $array[0];
        $poi = get_post($post_id);
        $filter_cats = [];
        $meta = get_post_meta( $post_id );
        $cats = wp_get_object_terms( $post_id, 'type' );
        foreach( $cats as $cat_array ){
            if( in_array($cat_array->term_id, $categories )){
                $filter_cats[] = $cat_array->term_id;
                $filter_cats_all[] = $cat_array->term_id;
            }
        }
        $popup = "<h3>" . $poi->post_title . "</h3><a href=''>View Website</a>";
        $long = "-123.105375";
        $lat = "45.058221";
        $listing = [
            'lat' => $meta['latitude'][0],
            'long' => $meta['longitude'][0],
            'popup' => $popup
        ];
        if( count($filter_cats) > 0 ){
            $listing['categories'] = json_encode( $filter_cats );
        }
        $listings[] = $listing;
    }
    $lat = "-123.105375";
    $long = "45.058221";
    $categories = $filter_cats_all;
?>
<div style="width:20%;  display:inline-block; vertical-align:top">
        <div class="filters otisfilters otisFilters">
            <?php if( count( $categories )> 1 ) : ?>
                <?php $terms = []; $has_events = 0; foreach ($categories as $categoryi) : ?>
                    <?php 
                        $term = get_term_by('ID', $categoryi, 'type');
                        // check if is event
                        $termchildren = get_term_children( $categoryi, 'type' );
                        if( count($termchildren) > 0){
                            foreach ($termchildren as $child_id){
                                if (!in_array($child_id, $terms)){
                                    $child = get_term_by('ID', $child_id, 'type');
                                  if( property_exists(  $child, 'term_id') && $child->term_id ){
                                        $terms[$child->term_id] = $child;
                                    }
                                }
                            }
                        }
                        else{
                            // dont show category as filter option if it is a parent? 
                            if (!array_key_exists($categoryi, $terms)){
                                if( property_exists( $term, 'term_id') && $term->term_id ){
                                    $terms[$categoryi] = $term;
                                } 
                            }
                        }

                    ?>
                <?php endforeach;  ?>
                <div class="filter-wrapper">
                    <div class="filter <?= $category ? "" : ""; ?> categoryfilter otisfilter">
                        <span id="filterlink" href class="filter__button filter__button__triangle"><?= $category ? $category : "category" ?></span>
                        <div id="filter__links" class="filter__content show">
                            <a class="filter_select" data-term_id="all">All</a>
                            <?php foreach( $terms as $term ) : ?>
                                <a class="filter_select" data-term_id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!--
            <div class="filter-wrapper">
                <div class="filter <?= $regions ? "" : ""; ?> regionsfilter otisfilter">
                    <a id="filterlink" href class="filter__button filter__button__triangle"><?= $regions ? $regions : "regions" ?></a>
                    <div id="filter__links" class="filter__content show">
                        <a class="filter_select"  data-region="all">All</a>
                        <a class="north-valley filter_select"  data-region="north-valley">North Valley</a>
                        <a class="mid-valley filter_select" data-region="mid-valley">Mid Valley</a>
                        <a class="south-valley filter_select" data-region="south-valley" >South Valley</a>
                        <a class="west-cascades filter_select" data-region="west-cascades" >West Cascades</a>
                    </div>
                </div>
            </div>
            --> 
        </div>
</div>

<div class="functional-map" style="width:75%; display:inline-block;">
    <div class="region-toggle">
        <button id="all">Willamette</button>
        <button id="north">North Valley</button>
        <button id="south">South Valley</button>
    </div>
    <div id="mapid"></div>
</div>
<script type="text/javascript">

	var mymap = L.map('mapid').setView([<?php echo $long; ?>, <?php echo $lat; ?>], 9);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoidHJpcGdyYXNzIiwiYSI6ImNrdDFxdTB1MDA5ZnEyb3BjMW80MmgweWEifQ.KtHsSQ0DOCXRsy1OA_oUJA'
}).addTo(mymap);
window.mymap = mymap;
var locations = [

<?php foreach($listings as $listing) : 
    ?>
  ["<?php echo $listing['popup']; ?>", <?php echo $listing['lat']; ?>, <?php echo $listing['long']; ?>, <?php echo $listing['categories']; ?>],
    <?php endforeach; ?>
];

markers = [];
for (var i = 0; i < locations.length; i++) {

  marker = new L.marker([locations[i][1], locations[i][2]])
    .bindPopup(locations[i][0])
    .addTo(mymap);
    marker.categories = locations[i][3];
    markers.push(marker);
}
window.markers = markers;
var southLatlngs = [
[44.64952030802673, -123.40158412890625],
[44.644635176300845, -123.25601528125],
[44.59184953854572, -123.25464199023438],
[44.57033052130299, -123.07062099414063],
[44.48613430594797, -123.0527682109375],
[44.48417480634835, -123.3054537578125],
[ 43.78417480634835,-122.3054537578125], 
[43.78417480634835,-123.3054537578125], 
[44.501807933192374, -123.40295741992188]
];
var southPolygon = L.polygon(southLatlngs, {color: '#b4bc33'});
southPolygon.addTo(mymap);

var northLatlngs = [
    [44.76956500021106, -123.40570400195313],
    [45.71867647895989,-123.31500556210082],
    [45.71867647895989,-122.31500556210082],
    [44.77833898265701, -123.16125820117188],
    [44.771514889289115, -123.04315517382813],
    [44.711037717470866, -123.04590175585938],
    [44.585981505553306, -123.07062099414063],
    [44.594783332883935, -123.22992275195313],
    [44.661242945594374, -123.22236965136719],
    [44.66661502916929, -123.39643428759766]
];
var northPolygon = L.polygon(northLatlngs, {color: '#533049'});
northPolygon.addTo(mymap);
</script>