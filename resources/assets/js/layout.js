import { docReady, getWidth, isElementInViewport } from "./utilities"

export let layout = () => {
	docReady(() => {
		// //adjust background position for patterned backgrounds
		// let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		// if (patternedBackgrounds) {
		// 	patternedBackgrounds.forEach((el) => {
		// 		if (el.nextSibling.nextElementSibling){
		// 			el.nextSibling.nextElementSibling.style.marginTop = "-25px"
		// 		}
		// 	})
		// }
		
		//parallaxing
		if (window.pageYOffset < 100){
			let alignedfull = document.querySelectorAll('.alignfull > img')
			let alignedfullobject = []
			if (alignedfull) {
				for (let i = 0; i < alignedfull.length; i++) {
					alignedfullobject.push({ ref: alignedfull[i], scroll: 0, startingPosition: -1})
				}
			}
			let alginedfullBackgrounds = document.querySelectorAll(".alignfull > .wp-block-willamette-blocks-image-box__image")
			if (alginedfullBackgrounds){
				for (let i = 0; i < alginedfullBackgrounds.length; i++) {
					alignedfullobject.push({ ref: alginedfullBackgrounds[i], scroll: 0, startingPosition: -1})
					if (window.pageYOffset > alginedfullBackgrounds[i].offsetTop + alginedfullBackgrounds[i].offsetHeight){
						alginedfullBackgrounds[i].style.backgroundPositionY = "bottom"
					}
				}
			}
			if (alignedfullobject.length > 0){
				let timer
				window.addEventListener('scroll', function(){
					if (timer){
						window.clearTimeout (timer)
					}
					timer = window.setTimeout(() => {
						if (getWidth() > 900){
							let hero = document.querySelector('.hero')
							alignedfullobject.unshift({ref: hero, scroll: 0, startingPosition: -1})

							alignedfullobject.forEach((image) => {
								if (isElementInViewport(image.ref)){
									if (image.startingPosition === -1){
										image.startingPosition = window.pageYOffset
									}
									let scrolled = window.pageYOffset - image.startingPosition
									if (image.ref.nodeName == "IMG"){
										image.ref.style.objectPosition = "center " + (- scrolled*.08).toString() + "px";
									}
									if (image.ref.nodeName == "DIV"){
										image.ref.style.backgroundPositionY = (- scrolled*.08).toString() + "px"
									}
								}
							})
						}	
					}, 5)
				})
			}
		}

		let imageBoxLinks = document.querySelectorAll(".wp-block-willamette-blocks-image-box__content > h2 > a")
		if (imageBoxLinks){
			imageBoxLinks.forEach((el) => {
				//move the link from the h2 to the parent
				let link = el.href
				let linkTarget = el.target
				let imageBox = el.parentElement.parentElement.parentElement;
				let newLink = document.createElement("a")
				let parent = imageBox.parentElement
				parent.replaceChild(newLink, imageBox)
				newLink.appendChild(imageBox)
				newLink.href = link
				newLink.target = linkTarget

				//add the hover effect
				let color = window.getComputedStyle(el.parentElement).getPropertyValue("background-color")
				color = color.replace(/[^,]+(?=\))/, '0.5') //replace color opacity with 50%
				newLink.addEventListener("mouseover", () => {
					imageBox.style.boxShadow = color + " 0 0 0 10000px inset"
				})
				newLink.addEventListener("mouseout", () => {
					imageBox.style.boxShadow = "none"
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
						el.style.display = "none"
					}
				}
			})
		}
		let clickToScroll = false
		let showBackToTopButton = () => {
			// showback to top button on scroll
			let rootElement = document.documentElement
			let scrollToTopBtn = document.querySelector(".back-to-top__button")
			let scrollTotal = rootElement.scrollHeight - rootElement.clientHeight
			if ((rootElement.scrollTop / scrollTotal ) > 0.60 ) {
				if (getWidth() > 800){
					scrollToTopBtn.classList.add("showBtn")
				}
			} else if (!clickToScroll){
				scrollToTopBtn.classList.remove("showBtn")
			}
		}
		document.addEventListener("scroll", showBackToTopButton)
		let scrollToTopBtn = document.querySelector(".back-to-top__button")
		scrollToTopBtn.addEventListener("click", () => {
			window.scrollTo(0,0)
		})
		let anchorLinks = document.querySelectorAll('a[href*="#"]')
		anchorLinks.forEach((el) => {
			if (!/^#/.test(el.href) && getWidth() > 800) {
				el.addEventListener("click", () => {
					clickToScroll = true
					window.setTimeout(() => {
						let scrollToTopBtn = document.querySelector(".back-to-top__button")
						scrollToTopBtn.classList.add("showBtn")
					}, 500)
					window.setTimeout(() => {
						clickToScroll = false
					}, 1500)
				})
			}
		})

	})
}
