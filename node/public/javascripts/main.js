document.addEventListener("DOMContentLoaded", () => {
 	mobileMenuToggle();
})

function mobileMenuToggle(){
	let btns = document.getElementsByClassName('open-mobile-menu');
	for ( let btn of btns ) {
	  btn.onclick = function() {
	    this.classList.toggle('active')
	    document.querySelector('.header-items').classList.toggle('uk-hidden')
	    
	  }
	}
}