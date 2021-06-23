/* eslint-disable */
import $ from "jquery"

$(window).scroll(function () {
	// End of the document reached?
	if ($(document).height() - $(this).height() == $(this).scrollTop()) {
		$.ajax({
			url: myAjax.ajaxurl,
			type: 'POST',
			data: {
				action: "getPosts",
				nonce: nonce
			},
			success: function (data, textStatus, jqXHR) {
				console.log(data);
				console.log("success!")
			}
		});				
	}
});

