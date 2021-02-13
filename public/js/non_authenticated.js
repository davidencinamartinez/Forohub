$(document).ready(function() {
	if (getCookie('nsfw') == 'allowed') {
		$('.blurry').removeClass('blurry');
		$('.blurry-logo').remove();
	}
	$(document).on('click', '.blurry', function(event) {
		nsfwModal();
	});
	$(document).on('click', '.modal-close', function(event) {
		$('.modal').fadeOut('fast', function() {
			$('.modal').remove();
		})
	});
	$(document).on('click', '.modal-nsfw-allow', function(event) {
		document.cookie = "nsfw=allowed";
		$('.blurry').removeClass('blurry');
		$('.modal').fadeOut('fast', function() {
			$('.modal').remove();
		})
	});
	$(document).on('click', '.modal-nsfw-deny', function(event) {
		$('.modal').fadeOut('fast', function() {
			$('.modal').remove();
		})
	});
	$('.required-auth').click(function(event) {	
		event.preventDefault();
		notifyUser("😁 Debes estar logeado para acceder a este contenido 😁");
	});
	window.onclick = function(event) {
	  	if (event.target.className == 'modal') {
	  		$('.modal').fadeOut('fast', function() {
	  			$(this).remove();
	  		})
	  	}
	}
});