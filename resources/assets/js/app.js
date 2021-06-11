
import { navigationInit } from "./navigation"
//import AOS from 'aos';
import { layout } from "./layout"
import $ from "jquery"
import { slideshow } from './slideshow'

$(document).ready(() => {
	navigationInit()
	//AOS.init()
	layout()
	slideshow()
})