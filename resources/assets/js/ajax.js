import $ from "jquery"

$(document).ready(function($) {
	function loadMore( $el, $categories, $dateSort, $keyword, post_types ='poi', regions = null ){
		/* global ajax_pagination  */
		$el.addClass('loading').html('');
		$.ajax({
			url: ajax_pagination.ajaxurl,
			type: 'post',
			async:    true,
			cache:    false,
			dataType: 'json',			
			data: {
				action: 'ajax_pagination',
				params: {
					'paged': '1',
					'post_types' : post_types,
					'categories': $categories,
					'dateSort' : $dateSort,
					'keyword' : $keyword,
					'regions' : regions
				}
			},
			fail: function(result){
				console.log('fail', result);
			},
			success: function( result ) {
				$el.html(result.output);
				setTimeout(function() { 
					$el.removeClass('loading');
				}, 100);
				if( result.post_count > 0 ){
					$el.find('.slider').slick({
						accessibility: false,
						lazyLoad: 'ondemand',
						arrows: true,
						dots: false,
						infinite: false,
						speed: 300,
						slidesToShow: 4,
						slidesToScroll: 4,
						responsive: [
							{
								breakpoint: 1150,
								settings: {
									slidesToShow: 3,
									slidesToScroll: 3,
									infinite: true,
									dots: true
								}
							},
							{
								breakpoint: 890,
								settings: {
									slidesToShow: 2,
									slidesToScroll: 2
								}
							},
							{
								breakpoint: 646,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1
								}
							}
						// You can unslick at a given breakpoint now by adding:
						// settings: "unslick"
						// instead of a settings object
						]
					})
					if( !result.has_events ){
						$el.closest('.otis-block').find('.date-toggle').remove();
					}
					window.ajaxPage++;
				}
			}
		})		
	}
	$('.otis-slider').each(function(k,v){
		var catsArray =  $(v).data('categories');
		loadMore( $(v),  catsArray);	
	})
	$('.otisDropdowns .otisDropdown').on('click', function(e){
		var $target = $(e.target);
		if( $target.hasClass('dropdown_select') ){
			$(e.target).closest('.dropdown').find('.dropdown_select').removeClass('active');
			$target.toggleClass('active');
			$(e.target).closest('.dropdown').find('.dropdown__button').html( $target.html() + '<span class="dropdown__button__triangle"></span>' );
			submitOtis(e);
		}
	})
	function submitOtis(e){
		e.preventDefault();
		var categories = [];
		var slider = $(e.target).closest('.otis-block').find('.otis-slider');
		// possible categories are limited to the block's selected categories 
		$('.categoryDropdown .dropdown_select.active').each(function(k,v){
			if( 'all' != $(v).data('term_id') ){
				categories.push( $(v).data('term_id') );
			}
		})
		if( categories.length < 1){
			var original_categories = $(e.target).closest('.otis-block').find('.otis-slider').data('categories');
			for ( var i = 0; i < original_categories.length; i++) {
				categories.push( original_categories[i] );
			}
		}
		var regions = [];
		$('.regionsDropdown .dropdown_select.active').each(function(k,v){
			if( 'all' != $(v).data('region') ){
				regions.push( $(v).data('region') );
			}
		})
		var dateSort = $('.dateDropdown .dropdown_select.active').html();
		loadMore( slider,  categories, dateSort,'','',regions);

	}
	$('.otisSubmit').on('click', function(e){
		submitOtis(e);
	})	
})