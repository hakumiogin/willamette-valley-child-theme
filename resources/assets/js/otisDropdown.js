export let otisDropdown = () => {
	let dropdownToggles = document.getElementsByClassName("dropdown__button")
	let i;
	for (i = 0; i < dropdownToggles.length; i++) {
		dropdownToggles[i].addEventListener ("click", (e) => {
			e.preventDefault()
			e.target.nextElementSibling.classList.toggle("show");
		})
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
		let item = document.querySelector("."+filter+"-toggle")
		if (item){
			item.addEventListener("click", (e) => {
				e.preventDefault()
				showFilter(filter)
				console.log("show filter")
			})
		}
	})
}
let showFilter = (el) => {
	let dropdown = document.querySelector("."+el+"Dropdown")
	dropdown.classList.toggle("showDropdown")
}