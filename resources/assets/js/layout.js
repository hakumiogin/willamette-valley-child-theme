import { docReady, getWidth, isElementInViewport } from "./utilities"

export let layout = () => {
	docReady(() => {
		let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		patternedBackgrounds.forEach((el) => {
			el.nextSibling.nextElementSibling.style.marginTop = "-15px"
		})

		window.addEventListener('scroll', function(){
			if (getWidth() > 900){
				let scrolled = window.pageYOffset;
				let hero = document.querySelector('.hero');
				let alignedfull = document.querySelectorAll('.alignfull > img');
				hero.style.backgroundPositionY = (- scrolled*.15).toString() + "px";
				alignedfull.forEach((el) => {
					if (isElementInViewport(el)){
						el.style.objectPosition = "0px " + (- scrolled*.15).toString() + "px";
						//alert("yes")
						console.log(el);
					}
				})
			}
		})
	
	})
}
