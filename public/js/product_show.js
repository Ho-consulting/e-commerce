
/*
//on traite les boutons + et - :

//recuperation des élement à partir du l'HTML
var btmoins = document.getElementById("btmoins");
var btplus = document.getElementById("btplus");
var qte = document.getElementById("qte");


btplus.onclick=myPlus; // declaration de la fonction qui rajoute la qte
btmoins.onclick=myMoins; //declaration de la fonction qui diminue la quantité


function myPlus(){ //la fonction qui rajoute
	if(parseInt(qte.innerHTML)<10) //si la quantité est inferieure à 10
	{
		qte.innerHTML=parseInt(qte.innerHTML)+1; // diminuer la quantité
	}
}


function myMoins(){
	if(parseInt(qte.innerHTML)>1) // si la quantité est superieur à 1
	{
		qte.innerHTML=parseInt(qte.innerHTML)-1; //diminuer la quantité
	}
}

*/




/*
 // ***************************** traitement du changement des images (miniature) *****************************


//récuperation des images à partir de l'HTML et les stockés dans des variables
 
 var img1 = document.getElementById("image1");
 var img2 = document.getElementById("image2");
 var img3 = document.getElementById("image3");
 var img4 = document.getElementById("image4"); 


//declaration de la fonction qui fait le changement des images lorsqu'on clic
 img1.onclick=changeImage;
 img2.onclick=changeImage;
 img3.onclick=changeImage;
 img4.onclick=changeImage;


var monImage = document.getElementById("imgprincip");

function changeImage() //la fonction qui change les images
 {
 	var img = monImage;
 	img.setAttribute('src',this.src);
 }

*/