import { docReady, getWidth, isElementInViewport } from "./utilities"

export let layout = () => {
	docReady(() => {
		let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		patternedBackgrounds.forEach((el) => {
			el.nextSibling.nextElementSibling.style.marginTop = "-15px"
		})
		let alignedfull = document.querySelectorAll('.alignfull > img')
		let alignedfullobject = {}
		let i = 0
		alignedfull.forEach ((el) => {
			alignedfullobject[i] = { scroll: 0, startingPosition: -1}
			el.parentElement.style.overflow = "hidden"
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
						hero.style.backgroundPositionY = (- scrolled*.15).toString() + "px"
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
							//alert("yes")
						}
					})
				}	
			}, 5)
		})
	
	})
}
