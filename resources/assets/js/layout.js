import { docReady, getWidth, isElementInViewport } from "./utilities"

export let layout = () => {
	docReady(() => {
		//fix background position for patterned backgrounds
		let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		if (patternedBackgrounds) {
			patternedBackgrounds.forEach((el) => {
				el.nextSibling.nextElementSibling.style.marginTop = "-15px"
			})
		}
		
		//parallaxing
		if (window.pageYOffset < 100){
			let alignedfull = document.querySelectorAll('.alignfull > img')
			if (alignedfull) {
				let alignedfullobject = {}
				let i = 0
				alignedfull.forEach ((el) => {
					alignedfullobject[i] = { scroll: 0, startingPosition: -1}
					i++
				})
				let timer
				window.addEventListener('scroll', function(){
					if (timer){
						window.clearTimeout (timer)
					}
					timer = window.setTimeout(() => {
						if (getWidth() > 900){
							let scrolled = window.pageYOffset;
							let hero = document.querySelector('.hero')
							if (isElementInViewport(hero)){
								hero.style.backgroundPositionY = (- scrolled*.08).toString() + "px"
							}
							
							let alignedfull = document.querySelectorAll('.alignfull > img')
							let i = 0
							alignedfull.forEach((el) => {
								if (isElementInViewport(el)){
									if (alignedfullobject[i].startingPosition === -1){
										alignedfullobject[i].startingPosition = window.pageYOffset
									}
									let scrolled = window.pageYOffset - alignedfullobject[i].startingPosition
									el.style.objectPosition = "0px " + (- scrolled*.06).toString() + "px";
								}
							})
						}	
					}, 5)
				})
			}
		}

		//hover effects
		//js is the only way, because every block is a different color.
		let hoverLinks = document.querySelectorAll(".wp-block-willamette-blocks-image-box__content > h2 > a")
		if (hoverLinks){
			hoverLinks.forEach((el) => {
				let color = window.getComputedStyle(el.parentElement).getPropertyValue("background-color")
				let imageTarget = el.parentElement.parentElement.previousElementSibling
				let backgroundTarget = el.parentElement.parentElement.parentElement
				backgroundTarget.style.backgroundColor = color

				el.addEventListener("mouseover", () => {
					imageTarget.classList.add("transparent")
				})
				el.addEventListener("mouseout", () => {
					imageTarget.classList.remove("transparent")
				})

			})
		}

		// weird height hack fix
		// for some reason, every image-box block is 4px taller than it should be based on its content
		// so I'm just manually setting every height 4px shorter than its calculated height
		// because I feel like I don't have time right now to figure out why they're too tall
		let heightAdjustElements = document.querySelectorAll(".wp-block-column .wp-block-willamette-blocks-image-box h2 > a")
		if (heightAdjustElements){
			heightAdjustElements.forEach((el) => {
				let targetElement = el.parentElement.parentElement.parentElement
				targetElement.style.height = (targetElement.clientHeight - 4).toString() + "px"
			})
		}
	})
}
