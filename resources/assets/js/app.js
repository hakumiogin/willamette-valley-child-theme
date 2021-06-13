
import { navigationInit } from "./navigation"
//import AOS from 'aos';
import { layout } from "./layout"
import $ from "jquery"
import { slideshow } from './slideshow'
import { anchorOffset } from './anchorOffset'

$(document).ready(() => {
	navigationInit()
	// AOS.init()
	layout()
	slideshow()
	if (window.location.hash.length > 0) {
		setTimeout(function() {
			window.scrollTo(0, $(window.location.hash).offset().top)
		}, 100)
	}
	anchorOffset(window.document, window.history, window.location)
})

