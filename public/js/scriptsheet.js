$(document).ready(function() {
	if ($(document.body)[0].scrollHeight < $(window).height()) {
	    $('.footer').css('position', 'absolute');
	} else {
		$('.footer').css('position', 'relative');
	}
	if (getCookie('NSFW_CHECK') == 'TRUE') {
		$('.blurry-logo, .blurry-container, .nsfw-banner').remove();
		$('.blurry').removeClass('blurry');
	}
	$(document).on('click', '.modal-nsfw-allow', function(event) {
		document.cookie = "NSFW_CHECK=TRUE;path=/";
		$('.blurry-logo, .blurry-container, .nsfw-banner').remove();
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
	$(document).on('click', '#password-reset-submit', function(event) {
		event.preventDefault();
		submitPasswordReset();
	});
	$('.thread-body').each(function(index, el) {
		if ($(this).prop('scrollHeight') > 600) {
			$(this).parent().find('.thread-info:first').prepend('<button class="thread-read-more">Ver más</button>');
			$(this).css('height', '600px');
		}
	});
	$(document).on('click', '.thread-read-more', function(event) {
		event.preventDefault();
		var threadBody = $(this).parent().parent().find('.thread-body');
		if ($(threadBody).prop('scrollHeight') > 600) {
			$(threadBody).css('height', 'max-content');
			$(this).text('Ver menos');
			$(this).attr('class', 'thread-read-less');
		}
	});
	$(document).on('click', '.thread-read-less', function(event) {
		event.preventDefault();
		var threadBody = $(this).parent().parent().find('.thread-body');
		if ($(threadBody).prop('scrollHeight') > 600) {
			$(threadBody).css('height', '600px');
			$(this).text('Ver más');
			$(this).attr('class', 'thread-read-more');
		}
	});
	if (getCookie('DARK_THEME_CHECK') == 'TRUE') {
		$('html').css('background-color', '#1b1b1b');
		$('.profile-dark-theme').attr('class', 'profile-light-theme');
		$('.profile-light-theme').text('Tema Claro');
		$('.empty-data').css('color', 'ghostwhite');
	}
	$(window).scroll(function(){
		if ($(document.body)[0].scrollHeight < $(window).height()) {
		 	$('.footer').css('position', 'absolute');
		} else {
			$('.footer').css('position', 'relative');
		}
	});
	$('.search-button').click(function(event) {
		var input = $('.search-input').val();
		if (input) {
			var values = input.replace(/[ ,.]/g, "+");
			window.open('https://www.google.com/search?q='+values+'%20site%3Aforohub.com', '_blank');
		} else {
			window.open('https://www.google.com/search?q=forohub', '_blank');
		}
	});
	$('.thread-date, .thread-reply-date, .reply-date').each(function(index, el) {
		$(this).text("Hace "+(moment($(this).text(), 'YYYY-MM-DD HH:mm:ss').fromNow(true)));
	});

	$('.thread-reply-user-register, .element-date-affiliate, .user-register-date').each(function(index, el) {
		$(this).text(moment($(this).text()).format('MMM YYYY'));
	});
	$('.thread-info').each(function(index, el) {
		 $(this).children('span').first().click(function(event) {
		 	var input = document.body.appendChild(document.createElement("input"));
		 	var url = $(this).prev('a').attr('href');
		 	$(this).parent().parent().children('.thread-title').find('a').attr('href');
		 	input.value = "https://www.forohub.com"+url;
		 	input.select();
		 	document.execCommand('copy');
		 	input.parentNode.removeChild(input);
		 	notifyUser("🔗 Enlace copiado 🔗");
		 });	
	});
	$(document).on('click', '.spoiler-container button', function(event) {
		event.preventDefault();
		var spoiler = $(this).parent().find('.spoiler-data:first');
		if (spoiler.is(':visible')) {
			$(this).text('Spoiler +');
			$(this).siblings('label').text(' (Pulsa para visualizar)');
			spoiler.hide('400');
		} else {
			$(this).text('Spoiler -');
			$(this).siblings('label').text(' (Pulsa para ocultar)');
			spoiler.show('400');
		}
	});
	$(document).on('click', '#reset-password-button', function(event) {
		event.preventDefault();
		$('.error').remove();
		$.ajax({
			url: '/HpcyzfjU5XVmthirMI9HuLCq63JLSyjuxQELob8IIH47rXGuMbvmTXqsxI1iToXS',
			type: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				reset_token: window.location.href.split('/')[4],
				email: window.location.href.split('/')[5],
				password: $('input[name="reset-password-new-password"]').val(),
				password_repeat: $('input[name="reset-password-confirm-password"]').val(),
			},
		}).done(function(data) {
			if ($.isEmptyObject(data.error)) {
				$('#reset-password-container').not('#reset-password-container > img').empty();
				createElement('div', {id: 'success-container'}, '#reset-password-container');
				createElement('p', null, '#success-container', 'Tu contraseña se ha actualizado con éxito!');
				createElement('p', null, '#success-container', 'Serás redirigido automáticamente en 5 segundos');
				setTimeout(function () {
					location.replace('/');
				}, 5000);
			} else {
				createElement('p', {class: 'error'}, '#reset-password-container', data.error);
			}
		}).fail(function() {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		});
	});
	$('marquee').click(function(event) {
		createModal();
		createElement('h2', null, '.modal-body', $(this).parent().parent().find('.thread-title').text());
		createElement('p', {class: 'modal-marquee'}, '.modal-body', $(this).text());
	});

	$(document).on('mouseover', '.reward', function(event) {
		event.preventDefault();
		$('.reward-title').text($(this).attr('data-title'));	
		$('.reward-description').text($(this).attr('data-description'));
	});

	$(document).on('mouseleave', '.reward', function(event) {
		event.preventDefault();
		$('.reward-title').text('Aquí podrás ver todos tus logros');	
		$('.reward-description').text('Desliza el cursor por encima para obtener más información');
	});

	$(document).on('mouseover', '.profile-rewards-cube img', function(event) {
		event.preventDefault();
		$(this).parent().parent().find('.profile-rewards-text > b').text($(this).attr('data-title'));	
		$(this).parent().parent().find('.profile-rewards-text > label').text($(this).attr('data-description'));	
	});

	$(document).on('mouseleave', '.profile-rewards-cube img', function(event) {
		event.preventDefault();
		$(this).parent().parent().find('.profile-rewards-text > b').text('Aquí podrás ver los últimos logros del usuario');		
		$(this).parent().parent().find('.profile-rewards-text > label').text('Desliza el cursor sobre el logro para obtener más información');	
	});

	$(document).on('keydown', '#user-rewards', function(event) {
    	if (event.keyCode == 32) {
    		return false;	
    	} 
	});

	$(document).on('click', '.thread-quick-reply-emoji', function(event) {
		let emojiPanel = $(this).parent().find('.emoji-panel');
		if (emojiPanel.is(':visible')) {
			emojiPanel.hide('400');
		} else {
			emojiPanel.show('400');
		}
	});

	$(document).on('click', '.emoji-panel-close', function(event) {
		$(this).closest('.thread-quick-reply').find('.emoji-panel').hide('400');
	});

	$(document).on('click', '.emoji-panel-selector label', function(event) {
		let textarea = $(this).closest('.thread-quick-reply').find('textarea')
		let emoji = $(this).text();
		$(textarea.val(textarea.val()+emoji));
	});

	$(document).on('click', '.modal-close, .modal-exit', function(event) {
		$('.modal').fadeOut('fast', function() {
			$('.modal').remove();
		})
	});
	
	$('.option-data').each(function(index, val) {
		$(this).css("background", "linear-gradient(to left, "+pickRandomColour()+" 0%, black 100%)");
	});

	$.each($('.slideshow-page'), function(index, val) {
		var elemLength =  $(this).parent().attr('data-source').split(",").length;
		$(this).text('1/'+elemLength);
	});

	$(document).on('click', '.slide-previous', function(event) {
		event.preventDefault();
		var sourceArray = $(this).parent().attr('data-source').split(",");
		var currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		if (currentIndex == 0) {
			$(this).siblings('.slideshow-media').find('img').attr('data-id', sourceArray.length-1);
			currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		}
		else if (currentIndex <= 0) {
			$(this).siblings('.slideshow-media').find('img').attr('data-id', sourceArray.length-1);
			currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		} else {
			$(this).siblings('.slideshow-media').find('img').attr('data-id', currentIndex-1);
			currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		}
		$(this).siblings('.slideshow-page').text(parseInt(currentIndex)+1+"/"+sourceArray.length);
		$(this).siblings('.slideshow-media').find('img').attr('src', sourceArray[currentIndex]);
	});

	$(document).on('click', '.slide-next', function(event) {
		event.preventDefault();
		var sourceArray = $(this).parent().attr('data-source').split(",");
		var currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		if (currentIndex > (sourceArray.length-1)-1) {
			$(this).siblings('.slideshow-media').find('img').attr('data-id', 0);
			currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		} else {
			$(this).siblings('.slideshow-media').find('img').attr('data-id', parseInt(currentIndex)+1);
			currentIndex = $(this).siblings('.slideshow-media').find('img').attr('data-id');
		}
		$(this).siblings('.slideshow-page').text(parseInt(currentIndex)+1+"/"+sourceArray.length);
		$(this).siblings('.slideshow-media').find('img').attr('src', sourceArray[currentIndex]);
	});
	$('.lateral-community-rule').click(function(event) {
		event.preventDefault();
		var description = $(this).children('.rule-description:first');
		if (description.is(':visible')) {
			$(this).children('label:first').text('▼')
			description.hide('400');
		} else {
			$(this).children('label:first').text('▲')
			description.show('400');
		}
	});
	if (window.location.hash) {
		var hash = window.location.hash.substring(1);
		$('#'+hash).css({
			animation: 'hashAnimation 1s infinite alternate',
		});
	}
});

function createElement(element, attributes, position, text) {
	var object = $(document.createElement(element)); // Element creation
	$.each(attributes, function(key, value) { // Array of attributes
		object.attr(key, value); // Attr: Value
	});
	$(object).appendTo(position); // Place
	$(object).append(text); // Text
}

function displayClock() {
	var time = new Date();
	document.getElementsByClassName('clock')[0].innerHTML = time.toLocaleTimeString();
}

function validateRegister() {
	event.preventDefault();
	document.documentElement.style.cursor = "progress";
	$('.modal-error').css('display', 'none');
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});  
	$.ajax({
		url: '/register',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			email: $('.modal-input input[name="email"]').val(),
			name: $('.modal-input input[name="name"]').val(),
			password: $('.modal-input input[name="password"]').val(),
			terms: $('.modal-input input[name="checkbox"]').is(':checked'),
		},
	})
	.done(function(data) {
		document.documentElement.style.cursor = "default";
		if ($.isEmptyObject(data.error)) {
			$('.modal-register-form, .modal-body p').remove();
			createElement('div', {class: 'modal-success'}, '.modal-body');
			createElement('p', null, '.modal-success', 'Bienvenido a Forohub!');
			createElement('p', null, '.modal-success', 'Te hemos enviado un correo para que verifiques tu cuenta');
			createElement('p', null, '.modal-success', 'Serás redirigido automáticamente en 5 segundos');
			setTimeout(function () {
				location.reload();
			}, 5000);
		} else {
			$('.modal-error').css('display', 'table-caption');
			$('.modal-error ul').empty();
			$.each(data.error, function(index, val) {
				 createElement('li', null, '.modal-error ul', val[0]);
			});
		}
	})
	.fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}

function dateConvert() {
	if ($('.thread-date').length > 0) {
		$('.thread-date').each(function(index, el) {
			if ($(this).text() == moment().format('L')) {
				$(this).text('Hoy');
			} else if ($(this).text() == moment().subtract(1,'days').format('L')) {
				$(this).text('Ayer');
			}
		});
	}
	if ($('.msgTime').length > 0) {
		$('.msgTime').each(function(index, el) {
			if ($(this).text() == moment().format('L')) {
				$(this).text('Hoy');
			} else if ($(this).text() == moment().subtract(1,'days').format('L')) {
				$(this).text('Ayer');
			}
		});
	}
}

function createModal() {
	// Modal
		createElement('div', {class: 'modal'}, 'body');
		// Modal Content
			createElement('div', {class: 'modal-content'}, '.modal');
			// Modal Header
				createElement('div', {class: 'modal-header'}, '.modal-content');
				createElement('button', {class: 'modal-close'}, '.modal-header', '❌'); // Exit Button
			// Modal Body
				createElement('div', {class: 'modal-body'}, '.modal-content');
			// Modal Footer
				createElement('div', {class: 'modal-footer'}, '.modal-content');
				// Modal Footer Elements
					createElement('label', {style: 'font-size: 12px;'}, '.modal-footer', 'Copyright© 2020 Forohub®');
}

function modalSuccess(msg) {
	$('.modal-body').contents(':not(img)').remove();
	// Modal Body Elements
		createElement('div', {class: 'modal-success'}, '.modal-body');
		createElement('p', null, '.modal-success', msg);
}

function userVerifiedSuccess() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Verificación de cuenta'); // Title
		createElement('div', {class: 'modal-success'}, '.modal-body');
		createElement('p', null, '.modal-success', 'Tu cuenta ha sido verificada con éxito');
}

function nsfwModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('label', {style: 'font-size: 50px;'}, '.modal-body', '🔞'); // Title
		createElement('p', null, '.modal-body', 'Estás a punto de acceder a contenido NSFW (+18)<br>y dirigido exclusivamente a <b>mayores de 18 años</b>'); // Message
		createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?'); // Message
		// Allow Button
		createElement('button', {class: 'modal-button modal-nsfw-allow'}, '.modal-body', 'Sí, soy mayor de 18');	
		// Deny Button
		createElement('button', {class: 'modal-button modal-nsfw-deny'}, '.modal-body', 'Volver');	
}

function registerModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Formulario de registro'); // Title
		createElement('p', null, '.modal-body', 'Todos los campos son obligatorios (*)'); // Message
		createElement('form', {class: 'modal-register-form', method: 'POST', action: '/register', onsubmit: 'return validateRegister()'}, '.modal-body'); // Form
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-register-form');
			createElement('ul', null, '.modal-error');		
		// Token Input
			createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-register-form');
		// Email Input
			createElement('div', {class: 'modal-input'}, '.modal-register-form');
			createElement('input', {type: 'text', name: 'email', maxlength: 64, placeholder: 'Correo electrónico', autofocus: "on", autocomplete: "off"}, '.modal-input:last');
		// Username Input
			createElement('div', {class: 'modal-input'}, '.modal-register-form');
			createElement('input', {type: 'text', name: 'name', maxlength: 20, placeholder: 'Nombre de usuario', spellcheck: 'false', autocomplete: "off"}, '.modal-input:last');
		// Password Input
			createElement('div', {class: 'modal-input'}, '.modal-register-form');
			createElement('input', {type: 'password', name: 'password', maxlength: 64, placeholder: 'Contraseña', autocomplete: "off"}, '.modal-input:last');
		// Terms Checkbox
			createElement('div', {class: 'modal-input', style: 'text-align: left;'}, '.modal-register-form');
			createElement('input', {type: 'checkbox', name: 'checkbox', style: 'vertical-align: middle;'}, '.modal-input:last');
			createElement('label', {style: 'font-size: 12px;'}, '.modal-input:last', 'Acepto los <a href="" target="_blank">términos y condiciones</a>');
		// Submit Button
			createElement('button', {type: 'submit', style: 'margin-top: 10px;'}, '.modal-register-form', 'Registrarse');
}

function displayProfile(id) {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body'); // Title
		// User Profile Avatar
		createElement('div', {class: 'modal-profile-avatar'}, '.modal-body');
		createElement('img', null, '.modal-profile-avatar');
		// User Profile Avatar
		createElement('div', {class: 'modal-profile-data'}, '.modal-body');
		// Title Input
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Título:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('label', {class: 'modal-profile-title'}, '.modal-profile-data div:last');
		// Registration Date 
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Fecha de registro:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('label', {class: 'modal-profile-date', style: 'text-transform: capitalize'}, '.modal-profile-data div:last');
		// Replies
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Nº de respuestas:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('label', {class: 'modal-profile-reply-count'}, '.modal-profile-data div:last');
		// Upvotes & Downvotes
			createElement('table', null, '.modal-profile-data');
			createElement('tr', null, '.modal-profile-data table');
			createElement('td', {class: 'modal-profile-data-upvotes'}, '.modal-profile-data table tr');
			createElement('i', {class: 'fa fa-thumbs-o-up upvotes'}, '.modal-profile-data-upvotes');
			createElement('td', {class: 'modal-profile-data-downvotes'}, '.modal-profile-data table tr');
			createElement('i', {class: 'fa fa-thumbs-down downvotes'}, '.modal-profile-data-downvotes');
		// AJAX Call	
			$.get('/user/'+id, function(data) {
				$('.modal-body h1').text(data[0].name);
				$('.modal-profile-avatar img').attr('src', data[0].avatar);
				$('.modal-profile-title').text(data[0].title);
				$('.modal-profile-date').text(moment(data[0].created_at).format('MMMM YYYY'));
				$('.modal-profile-reply-count').text(data[0].total_replies);				$('.modal-profile-data-upvotes').prepend(data[1].total_upvotes+' ');
				$('.modal-profile-data-downvotes').prepend(data[2].total_downvotes+' ');
			});	
}

function profileModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body'); // Title
		// User Profile Avatar
		createElement('div', {class: 'modal-profile-avatar'}, '.modal-body');
		createElement('img', {src: 'https://i1.sndcdn.com/avatars-ZsHFOLyvCDd8z3DL-xnBzSw-t500x500.jpg'}, '.modal-profile-avatar');
		// User Profile Avatar
		createElement('div', {class: 'modal-profile-data'}, '.modal-body');
		// Email Input
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Correo electrónico:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('input', {type: 'text', name: 'email', maxlength: 64}, '.modal-profile-data div:last');
		// Title Input
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Título:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('input', {type: 'text', name: 'title', maxlength: 20}, '.modal-profile-data div:last');
		// Registration Date 
			createElement('div', null, '.modal-profile-data');
			createElement('b', null, '.modal-profile-data div:last', 'Fecha de registro:');
			createElement('br', null, '.modal-profile-data div:last');
			createElement('label', {id: 'profile-date', style: 'text-transform: capitalize'}, '.modal-profile-data div:last');
			createElement('button', null, '.modal-body', 'Guardar cambios');	

	$.get('/test', function(data) {
			$('.modal-body h1').text(data[0].name);
			$('input[name="email"]').val(data[0].email);
			$('input[name="title"]').val(data[0].title);
			$('#profile-date').text(moment(data[0].created_at).format('MMMM YYYY'));
		});	
}

function reportThreadModal(thread_id) {
	createModal();
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Reportar tema'); // Title
		// Report Advice
			createElement('label', {style: 'font-weight: bold; font-size: 12px;'}, '.modal-body', '· Los reportes que no cumplan con las normas o sean falsos, serán sancionados ·');
			createElement('div', { class: 'modal-report-id'}, '.modal-body');
			createElement('b', null, '.modal-report-id:last','ID:&nbsp;');
			createElement('label', {id: 'thread-id'}, '.modal-report-id:last', thread_id);
		// Select
			createElement('div', { class: 'modal-report-type'}, '.modal-body');
			createElement('b', null, '.modal-report-type', 'Motivo del reporte: ');
			var reportList = ['Spam o Flood','Contenido violento o repulsivo','Información falsa o fraude','Acoso o Bullying','Contenido vejatorio o de incitación al odio','Contiene información confidencial y/o personal','Ventas no autorizadas','Suicidio o autolesiones','Maltrato infantil o pedofilia','Contenido de carácter terrorista'];
			createElement('select', {class: 'modal-select'}, '.modal-report-type');
			$.each(reportList, function(index, val) {
				createElement('option', null, '.modal-report-type select', val);
			});
		// Commentary Area
			createElement('div', { class: 'modal-report-description'}, '.modal-body');
			createElement('b', {style: 'float: left'}, '.modal-report-description', 'Descripción:');
			createElement('textarea', {class: 'modal-report-textarea', maxlength: 140, placeholder: 'Descripción del reporte (Máx. 140 carácteres)'}, '.modal-report-description');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.modal-report-description');
			createElement('label', null, '.modal-report-description .character-counter', '0');
			createElement('label', null, '.modal-report-description .character-counter', '/140');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');
		// Report Buttons
			createElement('div', {class: 'modal-report-buttons'}, '.modal-body');
			createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-report-buttons', 'Cancelar');
			createElement('button', {class: 'modal-report-thread-send'}, '.modal-report-buttons', 'Enviar');
}

function reportReplyModal(reply_id) {
	createModal();
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Reportar mensaje'); // Title
		// Report Advice
			createElement('label', {style: 'font-weight: bold; font-size: 12px;'}, '.modal-body', '· Los reportes que no cumplan con las normas o sean falsos, serán sancionados ·');
			createElement('div', { class: 'modal-report-id'}, '.modal-body');
			createElement('b', null, '.modal-report-id:last','ID:&nbsp;');
			createElement('label', {id: 'reply-id'}, '.modal-report-id:last', reply_id);
		// Select
			createElement('div', { class: 'modal-report-type'}, '.modal-body');
			createElement('b', null, '.modal-report-type', 'Motivo del reporte: ');
			var reportList = ['Spam o Flood','Troll','Información falsa','Acoso o Bullying','Información confidencial y/o personal','Racismo o Sexismo'];
			createElement('select', {class: 'modal-select'}, '.modal-report-type');
			$.each(reportList, function(index, val) {
				createElement('option', null, '.modal-report-type select', val);
			});
		// Commentary Area
			createElement('div', { class: 'modal-report-description'}, '.modal-body');
			createElement('b', {style: 'float: left'}, '.modal-report-description', 'Descripción:');
			createElement('textarea', {class: 'modal-report-textarea', maxlength: 140, placeholder: 'Descripción del reporte (Máx. 140 carácteres)'}, '.modal-report-description');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.modal-report-description');
			createElement('label', null, '.modal-report-description .character-counter', '0');
			createElement('label', null, '.modal-report-description .character-counter', '/140');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');
		// Report Buttons
			createElement('div', {class: 'modal-report-buttons'}, '.modal-body');
			createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-report-buttons', 'Cancelar');
			createElement('button', {class: 'modal-report-reply-send'}, '.modal-report-buttons', 'Enviar');
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
   	for (var i = 0; i < ca.length; i++) {
    	var c = ca[i];
     	while (c.charAt(0) == ' ') {
       		c = c.substring(1);
     	}
    	if (c.indexOf(name) == 0) {
      		return c.substring(name.length, c.length);
     	}
    }
  	return "";
}

function submitVote(element) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});    
	$.ajax({
		url: '/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc',
		type: 'POST',
		data: {
			_token: $('input[name="_token"]').val(),
			thread_id: $(element).data('thread-id'),
			vote_type: $(element).data('thread-vote')
		},
	})
	.done(function(data) {
		if ($(data).has(data.votes)) {
			$(element).closest('.thread-votes-data').find('.thread-vote-count').fadeOut();
			$(element).closest('.thread-votes-data').find('.thread-vote-count').text(data.votes).fadeIn();
		} else {

		}
	})
	.fail(function(data) {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}

function notifyUser(msg) {
	var elem = $("<div>"+msg+"</div>").appendTo('.notification-bar');
	setTimeout(function() {
		$(elem).fadeOut('fast', function() {
			$(elem).remove();
		})
	}, 4000);
}

function loadMore() {
	$('.threads-panel').load('?page=2');
	$('.lateral-panel:last').remove();
	$('.header:last').remove();
}

function getRewards() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Logros'); // Title
		$.get('/ttdKHuNiH5AGpk3iVy04ORoMxfimsEW77ggVCbEA9Bvl9ZMbrXFqED7DjgCwkjEi', function(data) {
			if (data.length == 0) {
			// Modal Error
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', 'Ha ocurrido un problema con tu petición (Error 500)&nbsp;&nbsp;');
			} else {
				// Rewards Text
				createElement('div', {class: 'modal-rewards-text'}, '.modal-body');
				createElement('b', {class: 'reward-title'}, '.modal-rewards-text', 'Aquí podrás ver todos tus logros');
				createElement('label', {class: 'reward-description'}, '.modal-rewards-text', 'Desliza el cursor por encima para obtener más información');
				// Rewards
				createElement('div', {class: 'modal-rewards'}, '.modal-body');
				$.each(data, function(index, val) {
					createElement('img', {
						class: 'reward',
						src: '/src/rewards/'+val.filename,
						'data-title': val.name,
						'data-description': val.text,
						'data-unlocked': val.user_has_reward
					}, '.modal-rewards');
				});
			}
		}).fail(function(errorThrown) {
	        // Modal Error
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', 'Ha ocurrido un problema con tu petición (Error 500)&nbsp;&nbsp;');
    	});	
}

function getNotifications() {
	$("title:first").text($("title:first").text().replace(/ *\([^)]*\) */g, ""));
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Notificaciones');
		$.get('/yT5rjyh3QA1Pk8kH4A3rLchG1oGgGMtr7Hs3qpwvhgC8UagAaVoSlCZgEzdiMHxn', function(data) {
			if (data.length == 0) {
				createElement('label', null, '.modal-body', 'No tienes notificaciones');
			} else {
				// Notifications
				createElement('div', {class: 'modal-notifications'}, '.modal-body');
				$.each(data, function(index, val) {
					if (val.read == false) {
						createElement('div', {class: 'modal-notification unread'}, '.modal-notifications');
					} else {
						createElement('div', {class: 'modal-notification'}, '.modal-notifications');
					}
					// Notification Image
					createElement('div', {class: 'notification-image'}, '.modal-notification:last');
					if (val.type == "reward") {
						var reward = $.parseJSON(val.notification);
						createElement('img', {class: 'reward-unlocked', src: '/src/rewards/'+reward.reward_logo}, '.notification-image:last');	
					} else if (val.type == "mention") {
						createElement('img', {src: '/src/media/pcxzXveYfflI0wyaZVGqjDQkW2NJkgE4m4r2itlqO1ZZnrtnZ88uFhy6L1qQ1KUi.webp'}, '.notification-image:last');	
					} else if (val.type == "thread_report") {
						createElement('img', {src: '/src/media/a42LpoWdP5QGTjDyoSCcWUCdF9sp249AxWfjY1PvA6xEj8zbbnIhcHuAURbwZQMU.webp'}, '.notification-image:last')
					} else if (val.type == "community_rank" || val.type == "community_ban") {
						var data = $.parseJSON(val.notification);
						createElement('img', {class: 'community', src: data.community_logo}, '.notification-image:last');
					}
					// Notification Info
					createElement('div', {class: 'notification-info'}, '.modal-notification:last');
					if (val.type == 'reward') {
						createElement('b', null, '.notification-info:last', 'Logro desbloqueado: '+reward.reward_title);
					} else if (val.type == 'mention') {
						createElement('b', null, '.notification-info:last', 'Te han mencionado ');
						createElement('a', { href: /c/+val.community+'/t/'+val.notification, title: val.thread}, '.notification-info b:last', 'en un tema');
					} else if (val.type == 'thread_report') {
						createElement('b', null, '.notification-info:last', 'Han reportado ');
						createElement('a', { href: /c/+val.community+'/t/'+val.notification, title: val.thread}, '.notification-info b:last', 'un tema ');
						createElement('b', null, '.notification-info:last', 'de ');
						createElement('a', { href: /c/+val.community+'/reportes', title: val.community_title}, '.notification-info b:last', ' tu comunidad');
					} else if (val.type == "community_rank") {
						createElement('b', null, '.notification-info:last', 'Se ha actualizado tu rango a '+data.user_rank+'<br>');
						createElement('a', {href: '/c/'+data.community_tag}, '.notification-info:last', data.community_title);
					} else if (val.type == "community_ban") {
						createElement('b', null, '.notification-info:last', 'Has sido expulsado de <br>');
						createElement('a', {href: '/c/'+data.community_tag}, '.notification-info:last', data.community_title);
					} else {
						createElement('b', null, '.notification-info:last', val.notification);
					}
					createElement('br', null, '.notification-info:last');
					createElement('label', null, '.notification-info:last', "Hace "+moment.utc(val.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow(true), 'Europe/Madrid');
				});
			}
		}).fail(function(errorThrown) {
	        // Modal Error
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', 'Ha ocurrido un problema con tu petición (Error 500)&nbsp;&nbsp;');
    	});
}

function submitQuickReply(element) {
	$(element).parent().find('.thread-quick-reply-error, .thread-quick-reply-success').remove();
	$.post('/bkXekAj1QU3vFgFB3Sk8XtZxnxzsuSaKmJbktKTXVEz8jm9JKBs8v3QC7RoKfbIm', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			thread_id: $(element).closest('.thread').attr('data-id'),
			text: $(element).parent().find('.thread-quick-reply-text').val()
		}, function(data, textStatus, xhr) {
			$.each(data, function(index, val) {
				if (data.success) {
					createElement('p', {class: 'thread-quick-reply-success'}, $(element).parent(), val);	
				} else if (data.remaining_time) {
					createElement('p', {class: 'thread-quick-reply-error'}, $(element).parent(), 'Espera '+val+' segundo(s) para enviar el mensaje');	
				} else if (data.empty || data.closed || data.banned) {
					createElement('p', {class: 'thread-quick-reply-error'}, $(element).parent(), val);
				} else {
					$.each(data.error, function(index, val) {
						createElement('p', {class: 'thread-quick-reply-error'}, $(element).parent(), val);	
					});
				}
			});
	}).fail(function(errorThrown) {
        createElement('p', {class: 'error'}, $(element).parent(), 'Ha ocurrido un problema con tu petición (Error 500)');	
	});
}

function updateProfilePicture() {
	createModal();
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Actualizar avatar'); // Title
		// User Current Avatar
			createElement('img', {class: 'modal-avatar-picture', src: $('.user-avatar:first').attr('src')}, '.modal-body');
		// Form
			createElement('div', {class: 'modal-avatar-form'}, '.modal-body');
			createElement('form', {method: 'POST', action: '/hT8IFRUl6hAVCSCmv7iBeGDKBSMgT0XQl3quQh4EJOzeMCQ1ZwTMzWE6VMWo3le7', enctype: "multipart/form-data"}, '.modal-avatar-form');
			createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-avatar-form form');
			createElement('input', {type: 'file', id: 'avatar-update-file', name: 'avatar', accept: 'image/*, .jpeg, .jpg, .webp, .png'}, '.modal-avatar-form form');
		// Report Buttons
			createElement('div', {class: 'modal-avatar-buttons', style: 'margin-top: 10px'}, '.modal-avatar-form form');
			createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-avatar-buttons', 'Cancelar');
			createElement('button', {class: 'modal-avatar-update'}, '.modal-avatar-buttons', 'Enviar');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');		
}

function pickRandomColour() {
	var makeColorCode = '0123456789ABCDEF';
	var code = '#';
	for (var count = 0; count < 6; count++) {
		code = code+makeColorCode[Math.floor(Math.random() * 16)];
	}
	return code;
}

function votePollOption(option) {
	var option_id = $(option).closest('.poll-option').attr('data-id');
	var thread_id = $(option).closest('.thread').attr('data-id');
	$.post('/S4Tv3XILDMnGXYwp8bqof0Of5A4kEAzehcoJKnGj6KyOf8fKCQrklvGuWZ7ATU43', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			option_id: option_id,
			thread_id: thread_id
	}, function(data, textStatus, xhr) {
		$(option).closest('.thread').find('.poll-content > .poll-option').each(function(index, el) {
			$(this).find('.option-data').css('width', data.success[index].percentage+'%');
			$(this).find('.option-data > label').text(data.success[index].percentage+'% ('+data.success[index].votes_count+' votos)');
		});
	});
}

function passwordResetModal() {
	createModal();
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Restablecer contraseña'); // Title
		createElement('p', null, '.modal-body', 'Introduce la dirección de correo electrónico vinculada a la cuenta<br>que estás intentando recuperar:')
		createElement('input', {type: 'text', id: 'password-reset-input', placeholder: 'Correo electrónico', style: 'font-size: 16px; padding: 12px; width: 80%'}, '.modal-body');
		createElement('button', {id: 'password-reset-submit', style: 'margin-top: 20px;'}, '.modal-body', 'Recuperar contraseña');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');	
}

function submitPasswordReset() {
	$.ajax({
		url: '/a6vqpp8yQftQSQv2QcYVnI5nYyEig6BhB1lHnZmykmdcwq4FOIOogko1u7YDgqsl',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			email: $("#password-reset-input").val(),
		},
	}).done(function(data) {
		if (!$.isEmptyObject(data.error)) {
			$('.modal-error').css('display', 'block');
			$('.modal-error ul').empty();
			createElement('li', null, '.modal-error ul', data.error);
		} else {
			$('.modal-body *:not(".modal-logo")').remove();
			createElement('div', {class: 'modal-success'}, '.modal-body');
			createElement('p', null, '.modal-success', 'Te hemos enviado un correo electrónico para restablecer tu contraseña');
			createElement('p', null, '.modal-success', 'Dispones de 60 minutos para efectuar los cambios correspondientes');
		}
	}).fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}

function displayEmojiPanel(textarea) {
	$('#emoji-panel').remove();
	// Emoji Panel
		createElement('div', {id: 'emoji-panel', 'data-target': textarea}, 'body');
		// Emoji Close
		createElement('div', {id: 'emoji-panel-close'}, '#emoji-panel', '❌');
		// Emoji Selection
		createElement('div', {id: 'emoji-panel-selection'}, '#emoji-panel');
		// Emoji -> Characters
			let smileys = ["😀","😃","😄","😁","😆","😅","😂","🤣","😊","😇","🙂","🙃","😉","😌","😍","🥰","😘","😗","😙","😚","😋","😛","😝","😜","🤪","🤨","🧐","🤓","😎","🤩","🥳","😏","😒","😞","😔","😟","😕","🙁","☹️","😣","😖","😫","😩","🥺","😢","😭","😤","😠","😡","🤬","🤯","😳","🥵","🥶","😱","😨","😰","😥","😓","🤗","🤔","🤭","🤫","🤥","😶","😐","😑","😬","🙄","😯","😦","😧","😮","😲","🥱","😴","🤤","😪","😵","🤐","🥴","🤢","🤮","🤧","😷","🤒","🤕","🤑","🤠","😈","👿","👹","👺","🤡","💩","👻","💀","☠️","👽","👾","🤖","🎃","😺","😸","😹","😻","😼","😽","🙀","😿","😾"];
			createElement('div', {class: 'emoji-panel-title'}, '#emoji-panel-selection', 'Personajes'); 
			createElement('div', null, '#emoji-panel-selection');
			$.each(smileys, function(index, val) {
				createElement('label', null, '#emoji-panel-selection div:last', val);
			});
		// Emoji -> Gestures
			let gestures = ["👋","🤚","🖐","✋","🖖","👌","🤏","✌️","🤞","🤟","🤘","🤙","👈","👉","👆","🖕","👇","☝️","👍","👎","✊","👊","🤛","🤜","👏","🙌","👐","🤲","🤝","🙏","✍️","💅","🤳","💪","🦾","🦵","🦿","🦶","👣","👂","🦻","👃","🧠","🦷","🦴","👀","👁","👅","👄","💋","🩸"];
			createElement('div', {class: 'emoji-panel-title'}, '#emoji-panel-selection', 'Gestos');
			createElement('div', null, '#emoji-panel-selection');
			$.each(gestures, function(index, val) {
				createElement('label', null, '#emoji-panel-selection div:last', val);
			});
		// Emoji -> People & Fantasy
			let people = ["🗣","👤","👥","👶","👦","👧","🧒","👨","👩","🧑","👱‍♀️","👱","🧔","👴","👵","🧓","👲","👳‍♀️","👳","🧕","👮‍♀️","👮","👷‍♀️","👷","💂‍♀️","💂","🕵️‍♀️","🕵️","👩‍⚕️","👨‍⚕️","👩‍🌾","👨‍🌾","👩‍🍳","👨‍🍳","👩‍🎓","👨‍🎓","👩‍🎤","👨‍🎤","👩‍🏫","👨‍🏫","👩‍🏭","👨‍🏭","👩‍💻","👨‍💻","👩‍💼","👨‍💼","👩‍🔧","👨‍🔧","👩‍🔬","👨‍🔬","👩‍🎨","👨‍🎨","👩‍🚒","👨‍🚒","👩‍✈️","👨‍✈️","👩‍🚀","👨‍🚀","👩‍⚖️","👨‍⚖️","🤶","🎅","👸","🤴","👰","🤵","👼","🤰","🤱","🙇‍♀️","🙇","💁","💁‍♂️","🙅","🙅‍♂️","🙆","🙆‍♂️","🙋","🙋‍♂️","🤦‍♀️","🤦‍♂️","🤷‍♀️","🤷‍♂️","🙎","🙎‍♂️","🙍","🙍‍♂️","💇","💇‍♂️","💆","💆‍♂️","🧖‍♀️","🧖‍♂️","🧏","🧏‍♂️","🧏‍♀️","🧙‍♀️","🧙‍♂️","🧛‍♀️","🧛‍♂️","🧟‍♀️","🧟‍♂️","🧚‍♀️","🧚‍♂️","🧜‍♀️","🧜‍♂️","🧝‍♀️","🧝‍♂️","🧞‍♀️","🧞‍♂️","🕴","💃","🕺","👯","👯‍♂️","🚶‍♀️","🚶","🏃‍♀️","🏃","🧍","🧍‍♂️","🧍‍♀️","🧎","🧎‍♂️","🧎‍♀️","👨‍🦯","👩‍🦯","👨‍🦼","👩‍🦼","👨‍🦽","👩‍🦽","🧑‍🤝‍🧑","👫","👭","👬","💑","👩‍❤️‍👩","👨‍❤️‍👨","💏","👩‍❤️‍💋‍👩","👨‍❤️‍💋‍👨","👪","👨‍👩‍👧","👨‍👩‍👧‍👦","👨‍👩‍👦‍👦","👨‍👩‍👧‍👧","👩‍👩‍👦","👩‍👩‍👧","👩‍👩‍👧‍👦","👩‍👩‍👦‍👦","👩‍👩‍👧‍👧","👨‍👨‍👦","👨‍👨‍👧","👨‍👨‍👧‍👦","👨‍👨‍👦‍👦","👨‍👨‍👧‍👧","👩‍👦","👩‍👧","👩‍👧‍👦","👩‍👦‍👦","👩‍👧‍👧","👨‍👦","👨‍👧","👨‍👧‍👦","👨‍👦‍👦","👨‍👧‍👧"];
			createElement('div', {class: 'emoji-panel-title'}, '#emoji-panel-selection', 'Gente y fantasía');
			createElement('div', null, '#emoji-panel-selection');
			$.each(people, function(index, val) {
				createElement('label', null, '#emoji-panel-selection div:last', val);
			});
		// Emoji -> Clothing & Accessories
			let clothing = ["🧳","🌂","☂️","🧵","🧶","👓","🕶","🥽","🥼","🦺","👔","👕","👖","🧣","🧤","🧥","🧦","👗","👘","🥻","🩱","🩲","🩳","👙","👚","👛","👜","👝","🎒","👞","👟","🥾","🥿","👠","👡","🩰","👢","👑","👒","🎩","🎓","🧢","⛑","💄","💍","💼"];
			createElement('div', {class: 'emoji-panel-title'}, '#emoji-panel-selection', 'Ropa y accesorios');
			createElement('div', null, '#emoji-panel-selection');
			$.each(clothing, function(index, val) {
				createElement('label', null, '#emoji-panel-selection div:last', val);
			});
	$('#emoji-panel').css({
		top: event.clientY+"px",
		left: event.clientX+"px"
	}).show();
}