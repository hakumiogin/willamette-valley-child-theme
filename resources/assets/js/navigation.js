import { docReady } from "./utilities"

export let navigationInit = () => {
	docReady(() => {
		// adds data attributes to be used in pseudo elements in the main menu css
		// to prevent the bold on hover from causing layout shift
		// by using invisible pseudo elements to set the size of the item
		document.querySelectorAll(".nav-bar ul.menu > li > a").forEach((el) => {
			el.dataset.text = el.innerHTML.replace("&amp;", "&")
		})

		
		let menuLinks = document.querySelectorAll(".nav-bar .menu a")
		menuLinks.forEach ((el) => {
			el.addEventListener("click", (e) => {
				window.location.href = e.target.href
			})
		})
		

		//search toggle
		document.getElementById("searchToggle").onclick = (e) => {
			e.preventDefault()
			let el = document.getElementById("searchInput")
			if (el.value === "") {
				el.classList.toggle("toggle-search")
				setTimeout(() => {
					let searchBar = document.getElementById("searchInput")
					searchBar.focus()
				}, 600)
			} else {
				document.getElementById("searchForm").submit()
			}
		}

		//mobile hambuger menu prevent background scrolling
		document.querySelector("#menuToggle input[type='checkbox']").onclick = () => {
			document.getElementById("willamette-body").classList.toggle("no-scroll")
		}
		//mobile hamburger menu +/- toggle dropdowns
		let mobileMenuExpandIcon = document.querySelectorAll(".mobile-menu > .menu > li > div")
		mobileMenuExpandIcon.forEach((el) => {
			el.onclick = (e) => {
				e.preventDefault()
				el.classList.toggle("expand")
				el.classList.toggle("toggle-icon__plus")
				for (let i = 0; i < el.children.length; i++) {
					if (el.classList.contains("toggle-icon")){
						el.classList.toggle("toggle-icon__plus")
					}
				}
			}
		})

	})

}