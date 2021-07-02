import $ from "jquery"

$(document).ready(function($) {
	function loadMore( $el, $categories, $date, $keyword, post_types ='poi' ){
		/* global ajax_pagination  */
		console.log('categories',$categories);
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
					'date' : $date,
					'keyword' : $keyword
				}
			},
			fail: function(result){
				console.log('fail', result);
			},
			success: function( result ) {
				console.log('secuuces',result);
				$el.html(result.posts);
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

				window.ajaxPage++;
			}
		})		
	}
	console.log( "slider::", $('.otis-slider') );
	$('.otis-slider').each(function(k,v){
		var catsArray =  $(v).data('categories');
		console.log( "on each::", $(v) + "---" + catsArray);
		loadMore( $(v),  catsArray);	
	})
	$('.otisDropdowns .otisDropdown').on('click', function(e){
		var $target = $(e.target);
		if( $target.hasClass('dropdown_select') ){
			console.log( $target );
			$target.toggleClass('active');
			alert(1);			
		}
	})
	if('undefined' != typeof window.blogModules){
		var categories = [];
		$.each( $('.blog-controls .option'), function(a,b){
			categories.push( $(b).data('term_id') );
		})
		var post_types = ['poi'];
		$.each(window.blogModules, function(a,b){
			loadMore(b,categories, null, null, post_types);
		})
		$('.blog-controls .date-select').click(function(e){
			e.preventDefault();
			var date = $(e.target).data('date_stamp');
			var id = "archive-list";
			window.ajaxPage = 1;
			$('.blog-container').html('');
			loadMore(id, null, date, "", "");
		})
		$('.blog-controls .select').click(function(e){
			e.preventDefault();
			$('.option').removeClass('active');
			$(e.target).addClass('active');
			var category = $(e.target).data('term_id'),
				parent = $(e.target).parent(),
				id = "archive-list";
			var date = "";
			var keyword = "";
			if( $(e.target).data('parent_id') > 0 ){
				var parent_id = $(e.target).data('parent_id');
				$('[data-term_id=' + parent_id + ']').addClass('active');
			}
			if( parent.hasClass('parent') ){
				$('.child-option').not('[data-parent_id=' + category + ']').hide();
				$('.child-option[data-parent_id=' + category + ']').show();
			}
			$('.blog-container').html('');
			window.ajaxPage = 1;
			loadMore(id, category, date, keyword, post_types);
		})
		$('a#blog_search').click(function(e){
			e.stopPropagation();
			e.preventDefault();
			$('.blog-container').html('');
			var id = $(e.target).data('id');
			var category = $('#' + id).find('#blog_category').find(":selected").data('term_id');
			var date = $('#' + id).find('#blog_date').find(":selected").data('date_stamp');
			var keyword = $('#' + id).find('#blog_keyword').val();
			window.ajaxPage = 1;
			loadMore(id, category, date, keyword);
		})

	}
})