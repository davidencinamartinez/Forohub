$(document).ready(function() {
	$.get('/test', function(data) {
		console.log(data);
	});

	$('.thread-date, .reply-date').each(function(index, el) {
		$(this).text("Hace "+(moment($(this).text(), 'YYYY-MM-DD HH:mm:ss').fromNow(true)));
	});

	$('.thread-info').each(function(index, el) {
		 $(this).children('span').first().click(function(event) {
		 	var input = document.body.appendChild(document.createElement("input"));
		 	var url = $(this).parent().parent().children('.thread-title').find('a').attr('href');
		 	input.value = "https://www.forohub.com/"+url;
		 	input.select();
		 	document.execCommand('copy');
		 	input.parentNode.removeChild(input);
		 	notifyUser("🔗 Enlace copiado 🔗");
		 });	
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

	$(document).on('keydown', '#user-rewards', function(event) {
    	if (event.keyCode == 32) {
    		return false;	
    	} 
	});

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
		if ($.isEmptyObject(data.error)) {
			$('.modal-form, .modal-body p').remove();
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
		console.log("error");
	})
	.always(function() {
		console.log("complete");
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
}

function userVerifiedSuccess() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Verificación de cuenta'); // Title
		createElement('div', {class: 'modal-success'}, '.modal-body');
		createElement('p', null, '.modal-success', 'Tu cuenta ha sido verificada con éxito');
	// Modal Footer Elements
		createElement('label', {style: 'font-size: 12px;'}, '.modal-footer', 'Copyright© 2020 Forohub®');
}

function nsfwModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', '🔞'); // Title
		createElement('p', null, '.modal-body', 'Estás a punto de acceder a contenido NSFW (+18)'); // Message
		createElement('p', null, '.modal-body', 'Deseas visualizarlo?'); // Message
	// Modal Footer Elements
		// Allow Button
			createElement('button', {class: 'modal-button modal-nsfw-allow'}, '.modal-footer', 'Permitir');	
		// Deny Button
			createElement('button', {class: 'modal-button modal-nsfw-deny'}, '.modal-footer', 'Denegar');	
}

function loginModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Login'); // Title
		createElement('p', null, '.modal-body', 'Introduce tu usuario y contraseña'); // Message
		createElement('form', {class: 'modal-form', method: 'POST', action: '/login'}, '.modal-body'); // Form	
		// Username Input
			createElement('div', {class: 'modal-input'}, '.modal-form');
			createElement('input', {type: 'text', maxlength: 20, placeholder: 'Usuario', spellcheck: 'false'}, '.modal-input:last');
		// Password Input
			createElement('div', {class: 'modal-input'}, '.modal-form');
			createElement('input', {type: 'password', maxlength: 64, placeholder: 'Contraseña'}, '.modal-input:last');
	// Modal Footer Elements
		// Submit Button
			createElement('button', null, '.modal-footer', 'Entrar ↪️');
		// Forgot Password
			createElement('p', null, '.modal-footer', 'Has olvidado tu contraseña? ');
			createElement('a', {href: '/forgot'}, '.modal-footer p', 'Click aquí');		
}

function registerModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('img', {class: 'modal-logo', src: '/src/media/logo_black.webp'}, '.modal-body');
		createElement('h2', null, '.modal-body', 'Formulario de registro'); // Title
		createElement('p', null, '.modal-body', 'Todos los campos son obligatorios (*)'); // Message
		createElement('form', {class: 'modal-form', method: 'POST', action: 'http://192.168.1.5:8000/register', onsubmit: 'return validateRegister()'}, '.modal-body'); // Form
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-form');
			createElement('ul', null, '.modal-error');		
		// Token Input
			createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-form');
		// Email Input
			createElement('div', {class: 'modal-input'}, '.modal-form');
			createElement('input', {type: 'text', name: 'email', maxlength: 64, placeholder: 'Correo electrónico', autofocus: "on", autocomplete: "off"}, '.modal-input:last');
		// Username Input
			createElement('div', {class: 'modal-input'}, '.modal-form');
			createElement('input', {type: 'text', name: 'name', maxlength: 20, placeholder: 'Nombre de usuario', spellcheck: 'false', autocomplete: "off"}, '.modal-input:last');
		// Password Input
			createElement('div', {class: 'modal-input'}, '.modal-form');
			createElement('input', {type: 'password', name: 'password', maxlength: 64, placeholder: 'Contraseña', autocomplete: "off"}, '.modal-input:last');
		// Terms Checkbox
			createElement('div', {class: 'modal-input', style: 'text-align: left;'}, '.modal-form');
			createElement('input', {type: 'checkbox', name: 'checkbox', style: 'vertical-align: middle;'}, '.modal-input:last');
			createElement('label', {style: 'font-size: 12px;'}, '.modal-input:last', 'Acepto los <a href="" target="_blank">términos y condiciones</a>');
		// Submit Button
			createElement('button', {type: 'submit', style: 'margin-top: 10px;'}, '.modal-form', 'Registrarse');
	// Modal Footer Elements
		createElement('label', {style: 'font-size: 12px;'}, '.modal-footer', 'Copyright© 2020 Forohub®');
}

function registerUser() {
	var emailInput = $(".modal-input input[name='email']").val();
	var userInput = $(".modal-input input[name='user']").val();
	var passwordInput = $(".modal-input input[name='password']").val();
	var checkboxInput = $('.modal-input input[name="checkbox"]').is(':checked');
	var tokenInput = $('input[name="_token"]').val();
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
	// Modal Footer Elements
		createElement('button', null, '.modal-footer', 'Guardar cambios');	

	$.get('/test', function(data) {
			$('.modal-body h1').text(data[0].name);
			$('input[name="email"]').val(data[0].email);
			$('input[name="title"]').val(data[0].title);
			$('#profile-date').text(moment(data[0].created_at).format('MMMM YYYY'));
		});	
}

function getCookie(cname) {
   var name = cname + "=";
   var ca = document.cookie.split(';');
   for(var i = 0; i < ca.length; i++) {
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
		url: '/ajax/Pvda2ubTcQSFI7bhHgJRP3VS9PrQf8zpK4PuDwg0z57S9uLyWd6zPRy0MPUJasnc',
		type: 'POST',
		data: {
			_token: $('input[name="_token"]').val(),
			thread_id: $(element).data('thread-id'),
			vote_type: $(element).data('thread-vote')
		},
	})
	.done(function(data) {
		notifyUser(data.response);
		if ($(data).has(data.votes)) {
			$(element).closest('.thread-votes-data').find('.thread-vote-count').fadeOut();
			$(element).closest('.thread-votes-data').find('.thread-vote-count').text(data.votes).fadeIn();
		} else {

		}
	})
	.fail(function(data) {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	})
	.always(function() {
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

function showMoreThreads() {
	$.get('/test', function(data) {
		console.log(data);
	});
}


/*function createThread() {
	data
	// Thread 
		createElement('div', {class: 'thread'}, '.threads-panel');
		// Thread Data
			createElement('div', {class: 'thread-data'}, '.threads:last');
			// Thread Votes
				createElement('div', {class: 'thread-votes'}, '.thread-data:last');
				createElement('b', {class: 'thread-votes-data'}, '.thread-votes:last');
				createElement('span', {class: 'thread-vote upvote', data-thread-id: ''}, '.thread-votes-data:last');
}
*/

function loadMore() {
	$('.threads-panel').load('?page=2');
	$('.lateral-panel:last').remove();
	$('.header:last').remove();
}

function getRewards() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Logros'); // Title
		// Rewards Text
		createElement('div', {class: 'modal-rewards-text'}, '.modal-body');
		createElement('b', {class: 'reward-title'}, '.modal-rewards-text', 'Aquí podrás ver todos tus logros');
		createElement('label', {class: 'reward-description'}, '.modal-rewards-text', 'Desliza el cursor por encima para obtener más información');
		// Rewards
		createElement('div', {class: 'modal-rewards'}, '.modal-body');
		$.get('/ajax/ttdKHuNiH5AGpk3iVy04ORoMxfimsEW77ggVCbEA9Bvl9ZMbrXFqED7DjgCwkjEi', function(data) {
			$.each(data, function(index, val) {
				createElement('img', {
					class: 'reward',
					src: '/src/rewards/'+val.filename,
					'data-title': val.name,
					'data-description': val.text,
					'data-unlocked': val.user_has_reward
				}, '.modal-rewards');
			});
		});	
	// Modal Footer Elements
		createElement('label', {style: 'font-size: 12px;'}, '.modal-footer', 'Copyright© 2020 Forohub®');
}