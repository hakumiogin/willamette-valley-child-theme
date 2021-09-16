
import { navigationInit } from "./navigation"
//import AOS from 'aos';
import { layout } from "./layout"
import $ from "jquery"
import { slideshow } from './slideshow'
import { anchorOffset } from './anchorOffset'
import { dropdown } from './dropdown'
import { cookieStart } from './cookie-consent'
import { mapJs } from './map'
$(document).ready(() => {
	navigationInit()
	// AOS.init()
	
	layout()
	slideshow()
	anchorOffset(window.document, window.history, window.location)
	dropdown()
	cookieStart()
	mapJs();
})