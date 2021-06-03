import { docReady, getWidth, elementInViewport } from "./utilities"

export let navigationInit = () => {
	docReady(() => {
		//set the main navigation links width so bolding on hover doesn't cause elements to adjust
		els = document.querySelectorAll(".nav-bar ul.menu > li").forEach((el) => {
			let width = el.clientWidth
			el.style.width = (width + 12).toString() + "px"
		});
		// next, we recalculate widths on window resize so the text doesn't overflow
		//Is this overkill? Yes.
		//debouncing the event so its not called more than once every 200ms
		
		// window.addEventListener('resize', debounce(() => {
		// 	els = document.querySelectorAll(".nav-bar ul.menu > li").forEach((el) => {
		// 		console.log(el.clientHeight)
		// 		if (el.offsetHeight > 50){ //50 is the height when it takes up 2 lines
		// 			el.style.width = "auto";
		// 		}
		// 	});
		// }, 200, false), false)

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
		let els = document.querySelectorAll(".menu > li > a")
		els.forEach((el) => {
			el.onclick = (e) => {
				e.preventDefault()
				el.classList.toggle("expand")
				for (let i = 0; i < el.children.length; i++) {
					if (el.children[i].classList.contains("toggle-icon")){
						el.children[i].classList.toggle("toggle-icon__plus")
					}
				}
			}
		})

	})
	window.addEventListener('scroll', function(){
		if (getWidth() > 900){
			let scrolled = window.pageYOffset;
			let hero = document.querySelector('.hero');
			let alignedfull = document.querySelectorAll('.alignfull > img');

			hero.style.backgroundPositionY = (- scrolled*.15).toString() + "px";
			alignedfull.forEach((el) => {
				if (elementInViewport(el)){
					el.style.objectPositionY = (- scrolled*.15).toString() + "px";
					//alert("yes")
					//console.log(el);
				}
			
			})
		}
	})

}