export const slideShow = () => {
	let leftButton = document.getElementById("slideshowleft")
	let rightButton = document.getElementById("slideshowright")
	if (rightButton && leftButton){ //if there is a slideshow on this page
		let leftSVG = leftButton.querySelector("svg")
		let rightSVG = rightButton.querySelector("svg")
		let slides = document.querySelector('.category-slider')
		let vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
		let scrollDistance = Math.min(vw, 1000)
		let distanceScrolled = 0
		let scrollOffset = 250

		// turn off the left control for starters
		leftSVG.style.visibility = "hidden"

		rightSVG.onclick = (e) => {
			e.preventDefault()
			slides.style.overflow = "visible"
			if (distanceScrolled < slides.offsetWidth ){
				distanceScrolled += Math.max(Math.floor(scrollDistance/scrollOffset) * scrollOffset, scrollOffset);
				leftSVG.style.visibility = "visible"
			} else {
				distanceScrolled = 0;
				leftSVG.style.visibility = "hidden"
			}
			slides.style.transform = "translateX(-" + (distanceScrolled).toString() + "px)"
		}
		leftSVG.onclick = (e) => {
			e.preventDefault()
			if (distanceScrolled > 0){
				distanceScrolled = Math.max(distanceScrolled - scrollDistance, 0)
				if (distanceScrolled == 0){
					slides.style.transform = "translateX( 0px)"
					leftSVG.style.visibility = "visible"
				} else {
					slides.style.transform = "translateX( -" + (distanceScrolled).toString() + "px)"
				}
			}
		}
	}
}