export const slideShow = () => {
	let leftButton = document.getElementById("slideshowleft")
	let rightButton = document.getElementById("slideshowright")
	let slides = document.querySelector('.category-slider')
	let vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
	let scrollDistance = Math.min(vw, 1000)
	let distanceScrolled = 0
	let scrollOffset = 250

	rightButton.onclick = (e) => {
		e.preventDefault()
		slides.style.overflow = "visible"
		if (distanceScrolled < 1750 ){
			distanceScrolled += Math.max(Math.floor(scrollDistance/scrollOffset) * scrollOffset, scrollOffset);
			slides.style.transform = "translateX(-" + (distanceScrolled).toString() + "px)"
		}
	}
	leftButton.onclick = (e) => {
		e.preventDefault()
		if (distanceScrolled > 0){
			distanceScrolled = Math.max(distanceScrolled - scrollDistance, 0)
			if (distanceScrolled == 0){
				slides.style.transform = "translateX( 0px)"
			} else {
				slides.style.transform = "translateX( -" + (distanceScrolled).toString() + "px)"
			}
		}
	}
}