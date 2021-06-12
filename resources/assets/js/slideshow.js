import $ from "jquery"
import 'slick-carousel/slick/slick'

export function slideshow(){
	$(document).ready( () => {
		$('.slider').slick({
			accessibility: false,
			arrows: true,
			dots: false,
			infinite: true,
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
		$('.featured-slider').slick({
			accessibility: false,
			arrows: true,
			dots: false,
			infinite: true,
			speed: 300,
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: true,
		})
	})
}
