<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <style>
   #mapid { height: 380px; }
  </style>
<div class="functional-map">
	<h1>Functional Map</h1>
	<div id="mapid"></div>
</div>
<?php
	$long = "-123.105375";
	$lat = "45.058221";
    $listings = [
        [
            'lat' => -123.105375,
            'lon' => 45.058221,
            'popup' => "Björnson Vineyard"
        ],
        [
            'lat' => -123.344503,
            'lon' => 44.727614,
            'popup' => "Airlie Winery"
        ]        
    ];

?>
<script type="text/javascript">

	var mymap = L.map('mapid').setView([<?php echo $lat; ?>, <?php echo $long; ?>], 9);
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
  ["<?php echo $listing['popup']; ?>", <?php echo $listing['lon']; ?>, <?php echo $listing['lat']; ?>],
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