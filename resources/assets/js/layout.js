import { docReady, getWidth, isElementInViewport } from "./utilities"

export let layout = () => {
	docReady(() => {
		//adjust background position for patterned backgrounds
		let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		if (patternedBackgrounds) {
			patternedBackgrounds.forEach((el) => {
				if (el.nextSibling.nextElementSibling){
					el.nextSibling.nextElementSibling.style.marginTop = "-25px"
				}
			})
		}
		
		//parallaxing
		if (window.pageYOffset < 100){
			let alignedfull = document.querySelectorAll('.alignfull > img')
			let alignedfullobject = []
			if (alignedfull) {
				console.log("alingedfull")
				for (let i = 0; i < alignedfull.length; i++) {
					console.log("foreach")
					alignedfullobject.push({ ref: alignedfull[i], scroll: 0, startingPosition: -1})
				}
			}
			let alginedfullBackgrounds = document.querySelectorAll(".alignfull > .wp-block-willamette-blocks-image-box__image")
			if (alginedfullBackgrounds){
				console.log("alginedfullbg")
				for (let i = 0; i < alginedfullBackgrounds.length; i++) {
					console.log("foreach")
					alignedfullobject.push({ ref: alginedfullBackgrounds[i], scroll: 0, startingPosition: -1})
					if (window.pageYOffset > alginedfullBackgrounds[i].offsetTop + alginedfullBackgrounds[i].offsetHeight){
						alginedfullBackgrounds[i].style.backgroundPositionY = "bottom"
						console.log("offset > than stuff")
					}
				}
			}
			console.log(alignedfullobject)
			if (alignedfullobject.length > 0){
				console.log("lenth is greater than zero")
				let timer
				window.addEventListener('scroll', function(){
					if (timer){
						window.clearTimeout (timer)
					}
					timer = window.setTimeout(() => {
						if (getWidth() > 900){
							let hero = document.querySelector('.hero')
							alignedfullobject.unshift({ref: hero, scroll: 0, startingPosition: -1})

							let i = 0
							alignedfullobject.forEach((image) => {
								if (isElementInViewport(image.ref)){
									if (image.startingPosition === -1){
										image.startingPosition = window.pageYOffset
									}
									let scrolled = window.pageYOffset - image.startingPosition
									if (image.ref.nodeName == "IMG"){
										console.log("img")
										image.ref.style.objectPosition = "0px " + (- scrolled*.08).toString() + "px";
										console.log("moved" + i.toString())	
									}
									if (image.ref.nodeName == "DIV"){
										console.log("div")
										image.ref.style.backgroundPositionY = (- scrolled*.08).toString() + "px"
									}
								}
								i++
							})
						}	
					}, 5)
				})
			}
		}

		//hover effects
		//js is the only way, because every block is a different color and that color is only grabbale as an h2 style.
		let hoverLinks = document.querySelectorAll(".wp-block-willamette-blocks-image-box__content > h2 > a")
		if (hoverLinks){
			hoverLinks.forEach((el) => {
				let color = window.getComputedStyle(el.parentElement).getPropertyValue("background-color")
				color = color.replace(/[^,]+(?=\))/, '0.5') //replace color opacity with 50%
				console.log(color)
				let imageTarget = el.parentElement.parentElement.parentElement
				el.addEventListener("mouseover", () => {
					imageTarget.style.boxShadow = color + " 0 0 0 10000px inset"
				})
				el.addEventListener("mouseout", () => {
					imageTarget.style.boxShadow = "none"
				})

			})
		}
		// layout.js:63 rgba(106, 59, 93, 0.9)
		// layout.js:63 rgba(180, 188, 51, 0.85)
		// layout.js:63 rgba(104, 129, 59, 0.9)
		// layout.js:63 rgba(180, 188, 51, 0.85)
		// layout.js:63 rgba(216, 125, 83, 0.75)
		// layout.js:63 rgba(95, 155, 177, 0.58)
		// layout.js:63 rgba(0, 94, 98, 0.67)

		// remove titles for the category slider if there is no category slider displaying
		let slider = document.querySelectorAll(".category-slider-parent")
		if (slider) {
			slider.forEach((el) => {
				let sliderTitle = el.previousElementSibling
				if (sliderTitle.nodeName == "H1" || sliderTitle.nodeName == "H2" || sliderTitle.nodeName == "H3" || sliderTitle.nodeName == "H4" || sliderTitle.nodeName == "H5"){
					if (el.innerHTML.trim() == ""){
						sliderTitle.style.display = "none"
						console.log("displaying none")
					}
				}
			})
		}
	})
}
