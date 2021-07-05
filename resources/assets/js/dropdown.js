export let dropdown = () => {
	let dropdownToggles = document.getElementsByClassName("dropdown__button")
	let i;
	for (i = 0; i < dropdownToggles.length; i++) {
		if( !dropdownToggles[i].classList.contains('otisSubmit') ){
			dropdownToggles[i].addEventListener ("click", (e) => {
				e.preventDefault()
				e.target.nextElementSibling.classList.toggle("show");
			})
		}
	}
	window.addEventListener("click", (e) => {
		if (!e.target.matches('.dropdown__button')) {
			let dropdowns = document.getElementsByClassName("dropdown__content");
			let i;
			for (i = 0; i < dropdowns.length; i++) {
				let openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
	})
	let filters = ["regions", "category", "date", "activity"]
	filters.forEach((filter) => {
		let items = document.querySelectorAll("."+filter+"-toggle")
		items.forEach((item) => {
			if (item){
				item.classList.add('testing');
				item.addEventListener("click", (e) => {
					e.preventDefault()
					let dropdown = e.target.closest('.dropdowns').querySelector("."+filter+"Dropdown")
					dropdown.classList.toggle("showDropdown")
				})
			}
		})
	})
}