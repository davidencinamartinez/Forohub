$(document).ready(function() {
	$(document).on('click', '.profile-configuration-trigger', function(event) {
		event.preventDefault();
		if ($('.profile-configuration').css('display') == 'none') {
			$('.threads-panel').children().hide('400');
            $('.profile-configuration').show('400');
            return false;
		} else {
			$('.threads-panel').children().show('400');
            $('.profile-configuration').hide('400');
            return false;
		}
	});
	$(document).on('click', '.edit-element', function(event) {
		event.preventDefault();
		$('.configuration-datafield').hide('400');
		var datafield = $(this).siblings('.configuration-panel');
		if ($(datafield).is(':visible')) {
			$(datafield).hide('400');
		} else {
			$(datafield).show('400');
		}
	});
	$(document).on('click', '.configuration-update-password', function(event) {
		PA_PasswordUpdate();
	});
	$(document).on('click', '.configuration-update-title', function(event) {
		event.preventDefault();
		PA_TitleUpdate();
	});
});

function PA_PasswordUpdatePanel(element) {
	$(element).parent().append('<div class="configuration-password-panel configuration-panel"></div>');
	// TITLE
		createElement('h3', null, '.configuration-password-panel', 'Cambiar contraseña');
	// OLD PASSWORD
		createElement('div', {class: 'old-password'}, '.configuration-password-panel');
		createElement('b', null, '.configuration-password-panel div:last', 'Contraseña actual:');
		createElement('input', {type: 'password', class: 'form-input', placeholder: 'Contraseña actual', autocomplete: 'off', maxlength: '64'}, '.configuration-password-panel div:last');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.old-password');
			createElement('label', null, '.old-password .character-counter', '0');
			createElement('label', null, '.old-password .character-counter', '/64');
	// NEW PASSWORD
		createElement('div', {class: 'new-password'}, '.configuration-password-panel');
		createElement('b', null, '.configuration-password-panel div:last', 'Nueva contraseña:');
		createElement('input', {type: 'password', class: 'form-input', placeholder: 'Nueva contraseña', autocomplete: 'off', maxlength: '64'}, '.configuration-password-panel div:last');
	// UPDATE PASSWORD
		createElement('div', null, '.configuration-password-panel');
		createElement('button', {class: 'configuration-update-password'}, '.configuration-password-panel', 'Actualizar');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.new-password');
			createElement('label', null, '.new-password .character-counter', '0');
			createElement('label', null, '.new-password .character-counter', '/64');
	$('.configuration-password-panel').show(400);
}

function PA_PasswordUpdate() {
	$('.configuration-panel .error, .configuration-panel .success').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/fOvpJZWfCJAULgNxBxVINoFyr6k9rBxxqG2HMbGGDZjN3HidWmWTrUPqaJPNCIqV',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			oldPassword: $('.old-password input').val(),
			newPassword: $('.new-password input').val()
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('p', {class: 'error'}, '.configuration-password-panel', data.error);
		} else {
			location.reload();
		}	
	})
	.fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	})
	.always(function() {
		console.log("complete");
	});
}

function PA_TitleUpdatePanel(element) {
	$(element).parent().append('<div class="configuration-title-panel configuration-panel"></div>');
	// TITLE
		createElement('h3', null, '.configuration-title-panel', 'Modificar título');
		createElement('div', {class: 'new-title'}, '.configuration-title-panel');
		createElement('b', null, '.configuration-title-panel div:last', 'Nuevo título:');
		createElement('input', {type: 'search', class: 'form-input', placeholder: 'Título', autocomplete: 'off', maxlength: '40'}, '.configuration-title-panel div:last');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.new-title');
			createElement('label', null, '.new-title .character-counter', '0');
			createElement('label', null, '.new-title .character-counter', '/40');
	// UPDATE TITLE
		createElement('div', null, '.configuration-title-panel');
		createElement('button', {class: 'configuration-update-title'}, '.configuration-title-panel', 'Actualizar');
	$('.configuration-title-panel').show(400);
}

function PA_TitleUpdate() {
	$('.configuration-title-panel .error').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/FRsS0qDC72HsM1TxceEpmyUtU3vT4rA5T9H0j2QB8AJd1UdFklUpGSc5takQTpLg',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			title: $('.new-title input').val()
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('p', {class: 'error'}, '.configuration-title-panel', data.error);
		} else {
			location.reload();
		}
	})
	.fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	})
	.always(function() {
		console.log("complete");
	});
}