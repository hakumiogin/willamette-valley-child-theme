
/*
jQuery(document).ready(function($) {
	function buildBlogSummary($post){
		var description = $post.post_content,
			date = $post.pretty_date,
			author = $post
		if( $post.post_excerpt ){
			description = $post.post_excerpt;
		}
		var output = `<a target="_blank" href="` + $post.permalink + `">
			<div class="business-detail">
				<div class="detail-wrapper">
					<div class="title-wrapper mobile">
						<h3 class="blog-title mobile">` + $post.post_title + `</h3>
					</div>
					<div class="bg-image business" style="background-image:url(` + $post.url + `);">
				</div>
				<div class="title-wrapper">
					<div class="title-wrap">
						<h3 class="blog-title desktop">` + $post.post_title + `</h3>`;
						if('post' == $post.post_type){
							output += `<div class="date">` + $post.pretty_date + `</div>
							<div class="username">` + $post.author_info.user_nicename + `</div>`;
						}
						output += `<p class="description">` + description + `</p>
						<div class="meta-wrapper">`;
						if($post.cats_string){
							output += `<div class="categories">` + $post.cats_string + `</div>`;
						}
						output += `</div>
						</div>
				</div>
			</div>
		</div>`;
		if( !$post.hide_detail_page ){
			output += `</a>`;
		}

		return output; 
	}
	function loadMore( $id, $category_id, $date, $keyword, post_types ){
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
					'post_types' : ['poi'],
					//'category_id': $category_id,
					//'date' : $date,
					//'keyword' : $keyword
				}
			},
			fail: function(result){
				//console.log('fail', result);
			},
			success: function( result ) {
				console.log(result);
				if(result.posts.length > 0){
					$.each(result.posts, function(k,post){
						//console.log('POST',post);
						var div = buildBlogSummary(post);
						$('#' + $id).find('.blog-container').append(div);
						//console.log('div' + $id,div);
					})
				}
				window.ajaxPage++;
			}
		})		
	}
loadMore();

	if('undefined' != typeof window.blogModules){
		var categories = [];
		$.each( $('.blog-controls .option'), function(a,b){
			categories.push( $(b).data('term_id') );
		})
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
*/