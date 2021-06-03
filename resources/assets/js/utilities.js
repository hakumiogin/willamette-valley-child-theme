export const docReady = (fn) => {
	if (document.readyState === "complete" || document.readyState === "interactive") {
		setTimeout(fn, 1);
	} else {
		document.addEventListener("DOMContentLoaded", fn);
	}
}

export const debounce = function(func, wait, immediate){
	var timeout;
	return () => {
		const context = this, args = arguments;
		const later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		const callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

export const getWidth = () => {
	if (self.innerWidth) {
	  return self.innerWidth;
	}
  
	if (document.documentElement && document.documentElement.clientWidth) {
	  return document.documentElement.clientWidth;
	}
  
	if (document.body) {
	  return document.body.clientWidth;
	}
}
  