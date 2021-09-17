import $ from "jquery"
export let mapJs = () => {
	$('.filter_select').on('click', function(e){
		$('.filter_select').removeClass('active');
		var $target = $(e.target),
			cat = $target.data('term_id');
		$target.addClass('active');
		var markers = window.markers,
			mymap = window.mymap;

		if( cat == 'all'){
			$.each(markers,function(k,v){
				mymap.addLayer(v);
			})
		}
		else{
			$.each(markers,function(k,v){
				if( v.categories.includes(cat) ){
					console.log(k,v.categories);
					mymap.addLayer(v);
				}
				else{
					mymap.removeLayer(v);				
				}
			})
		}
	})
	$('.region-toggle button').on('click', function(e){
		var $target = $(e.target),
			region = $target.attr('id');
			var regions = {};
			regions.south = [];
			regions.south.center = [44.032916, -123.081473];
			regions.south.zoom = 8;
			regions.north = [];
			regions.north.center = [45.104889,-123.142299];
			regions.north.zoom = 8;
			regions.all = [];
			regions.all.center = [44.530919,-123.268372];
			regions.all.zoom = 7;
			
		window.mymap.setView(regions[region].center, regions[region].zoom);
	});
}