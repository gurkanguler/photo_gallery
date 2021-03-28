let profil_buton = document.getElementById("profil-buton");

let photo_upload_plus = document.querySelector('.photo-upload-plus button');

let photo_upload_plus_close = document.querySelector("#photo-upload-content-close");

let profil_buton_sayac = 0;

let photo_upload_plus_sayac = 0;



let sekme_links = document.querySelectorAll('.menus ul li button');


let photo_upload_plus_func = () => {
		
	photo_upload_plus_sayac++;

	$('.photo-upload-content').slideDown("fast");

	if(photo_upload_plus_sayac % 2 == 0){
		$('.photo-upload-content').slideUp("fast");
	}

}

let profil_btn = () => {

	profil_buton_sayac++;

	$(".profil-menu-submenu").slideDown("fast");

	if(profil_buton_sayac % 2 == 0){
		$(".profil-menu-submenu").slideUp("fast");
	}

}


window.onload = () => {

	$(document).ready(function(){
		
		profil_buton.addEventListener("click", profil_btn);
		photo_upload_plus.addEventListener("click", photo_upload_plus_func);
		$(photo_upload_plus_close).click(function(){
			$('.photo-upload-content').slideUp("fast");
		});
	});

	

}