/* ================================ management of the stars rating ================================== */

console.log("bonjour");

window.onload = () => {

	//seraching stars
	const stars = document.querySelectorAll(".la-star");
	
	//searching the input
	const note = document.querySelector("#note");

	//we loop on the stars to add them to events listener
	for(let i=0; i<stars.length; i++){
		//we listen the mouse hover
		stars[i].addEventListener("mouseover", function(){
			resetStars();
			this.style.color = "orange";
			stars[i].classList.add("las");
			stars[i].classList.remove("lar");
			//element précédent
			let previousStar = this.previousElementSibling;
			while(previousStar){
				previousStar.style.color = "orange";
				previousStar.classList.add("las");
				previousStar.classList.remove("lar");
				previousStar = previousStar.previousElementSibling;
			}
		});

		stars[i].addEventListener("click", function(){
			note.value = this.dataset.value;
		});

		stars[i].addEventListener("mouseout", function(){
			resetStars(note.value);

		});
	}

	function resetStars(note = 0){
		for(let i=0; i<stars.length; i++){
			if(stars[i].dataset.value > note){
				stars[i].style.color = "black";
				stars[i].classList.add("lar");
				stars[i].classList.remove("las");
			}else{
				stars[i].style.color = "orange";
				stars[i].classList.add("las");
				stars[i].classList.remove("lar");
			}
		}
	}

}

/* ================================ end of management of the stars rating ================================== */
