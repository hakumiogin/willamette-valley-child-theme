import $ from "jquery"
export let mapJs = () => {
	$('.filter_select').on('click', function(e){
		$('.filter_select').removeClass('active');
		var $target = $(e.target),
			cat = $target.data('term_id');
		$target.addClass('active');
		if( !markers ){
			var markers = [];
		}
		if( !mymap ){
			var mymap = [];
		}
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
}