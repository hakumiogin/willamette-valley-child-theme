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
<div class="functional-map">
	<h1><?php echo get_field('map_title'); ?></h1>
	<div id="mapid"></div>
</div>
<?php

use function Madden\Theme\Child\Setup\get_otis_posts;
$categories = get_field('map_categories');
    $pageposts = get_otis_posts( $categories );
    $listings = [];
    foreach ($pageposts as $array ) {
        $post_id = $array[0];
        $poi = get_post($post_id);
        $meta = get_post_meta( $post_id );
        $popup = "<h3>" . $poi->post_title . "</h3><a href=''>View Website</a>";
        $long = "-123.105375";
        $lat = "45.058221";
        $listings[] = [
            'lat' => $meta['latitude'][0],
            'long' => $meta['longitude'][0],
            'popup' => $popup            
        ];
    }
    $lat = "-123.105375";
    $long = "45.058221";

?>
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

var locations = [

<?php foreach($listings as $listing) : 
    ?>
  ["<?php echo $listing['popup']; ?>", <?php echo $listing['lat']; ?>, <?php echo $listing['long']; ?>],
//    	var marker = L.marker([<?php echo $listing['lat']; ?>,<?php echo $long; ?>]).addTo(mymap);
  //  	marker.bindPopup("<b> popup </b>").openPopup();
    <?php endforeach; ?>
];
for (var i = 0; i < locations.length; i++) {

  marker = new L.marker([locations[i][1], locations[i][2]])
    .bindPopup(locations[i][0])
    .addTo(mymap);
}
</script>