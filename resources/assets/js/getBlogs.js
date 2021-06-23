export let getBlogs = () => {
	$(".loadingScreen").removeClass("disabled");
	var data = {
		action: "getBlogs",
		page: $(".pagination").data("page"),
		sortType: $(".sortType .sort.active").data("sort-type")
	};
	var categories = [];
	$(".selectCategories .category input:checked").each(function() {
		categories.push($(this).val());
	});
	if (categories.length) {
		data["categories"] = categories;
	}
	if ($("#blogSearchInput").val()) {
		data["s"] = $("#blogSearchInput").val();
	}
	console.log(data);
	jQuery.post(
		wp_ajax.ajax_url,
		data,
		function(response) {
			console.log(response);
			$(".loadingScreen").addClass("disabled");
			$(".blogGrid").html(response.html);
			jQuery("*[data-load-type]").lazyLoad();
			$(".pagination .count").html(
				response.offset +
				1 +
				"-" +
				(response.offset + response.number_returned) +
				" of " +
				response.count
			);
			$(".pagination").data("page", response.page);
			$(".prev, .first, .next, .last").removeClass("disabled");
			if (response.isFirst) {
				$(".prev, .first").addClass("disabled");
			}
			if (response.isLast) {
				$(".next, .last").addClass("disabled");
			}
			window.scrollTo(window.scrollX, window.scrollY - 1);
			window.scrollTo(window.scrollX, window.scrollY + 1);
			//scroll up so it's obvious a change happened
			$("html, body").animate(
				{
					scrollTop: $(".blogs").offset().top - $(".header").outerHeight()
				},
				"medium"
			);
		},
		"json"
	);
}