import { docReady } from "./utilities"

export let layout = () => {
	docReady(() => {
		let patternedBackgrounds = document.querySelectorAll(".pattern-bg")
		patternedBackgrounds.forEach((el) => {
			el.nextSibling.nextElementSibling.style.marginTop = "-15px"
		})
	})
}
