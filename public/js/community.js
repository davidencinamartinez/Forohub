/* $(document).ready(function() {
	$(document).on('click', '.community-configuration-trigger', function(event) {
		event.preventDefault();
		if ($('.community-configuration').css('display') == 'none') {
			$('.threads-panel').children().css('display', 'none');
            $('.community-configuration').css('display', 'block');
            return false;
		} else {
			$('.threads-panel').children().css('display', 'block');
            $('.community-configuration').css('display', 'none');
            return false;
		}
	});
	$(document).on('click', '.edit-element', function(event) {
		event.preventDefault();
		if ($(this).closest('.community-configuration-set').hasClass('configuration-title')) {
			if ($(this).siblings('.configuration-panel').is(':visible')) {
				$(this).siblings('.configuration-panel').hide('400');
			} else {
				COM_TitleUpdatePanel(this);
			}
		}
		if ($(main).hasClass('configuration-title')) {
			
		}
	});
	$(document).on('click', '.configuration-update-title', function(event) {
		event.preventDefault();
		COM_TitleUpdate();
	});
	
});

function COM_TitleUpdatePanel(element) {
	$(element).parent().append('<div class="community-update-title configuration-panel"></div>');
	// TITLE
		createElement('h3', null, '.community-update-title', 'Modificar título');
	// OLD PASSWORD
		createElement('div', {class: 'new-title'}, '.community-update-title');
		createElement('b', null, '.community-update-title div:last', 'Nuevo título:');
		createElement('input', {type: 'text', class: 'form-input', placeholder: 'Título', autocomplete: 'off', maxlength: '50'}, '.community-update-title div:last');
		// Character Counter
			createElement('div', {class: 'character-counter'}, '.new-title');
			createElement('label', null, '.new-title .character-counter', '0');
			createElement('label', null, '.new-title .character-counter', '/50');
	// UPDATE PASSWORD
		createElement('div', null, '.community-add-rule');
		createElement('button', {class: 'configuration-update-title'}, '.new-title', 'Actualizar');
	$('.community-update-title').show(400);
}

function COM_TitleUpdate() {
	$('.configuration-panel .error, .configuration-panel .success').remove();
	$.ajax({
		url: '/kXQ2kAuP1djrzKllFvbRBQGKJlvg9iHzmUyhfZM7PcsAJcQBOGvPY1rZ8E1GjlN6',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			title: $('.new-title input').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if ($(data).has(data.error)) {
			createElement('p', {class: 'error'}, '.new-title', data.error);
		}
		if ($(data).has(data.success)) {
			createElement('p', {class: 'success'}, '.new-title', data.success);
		}
	})
	.fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	})
	.always(function() {
		console.log("complete");
	});
}
*/

$(document).ready(function() {
	$(document).on('click', '.community-configuration-trigger', function(event) {
		event.preventDefault();
		if ($('.configuration-panel').css('display') == 'none') {
			$('.threads-panel').children().css('display', 'none');
            $('.configuration-panel').css('display', 'block');
            return false;
		} else {
			$('.threads-panel').children().css('display', 'block');
            $('.configuration-panel').css('display', 'none');
            return false;
		}
	});
	$(document).on('click', '.edit-element', function(event) {
		event.preventDefault();
		var datafield = $(this).siblings('.configuration-datafield');
		if ($(datafield).is(':visible')) {
			$(datafield).hide('400');
		} else {
			$(datafield).show('400');
		}
	});
	$(document).on('click', '.community-update.title', function(event) {
		titleUpdate();
	});
	$(document).on('change', '.configuration-datafield.logo input', function(event) {
		var file =  $(this).get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $(".configuration-logo > img").attr("src", reader.result);
                $(".configuration-logo > img").css({ animation: 'fileAnimation 1s infinite alternate'});
            }
            reader.readAsDataURL(file);
        }
	});
	$(document).on('click', '.community-update.logo', function(event) {
		logoUpdate();
	});
});

function titleUpdate() {
	$('.configuration-datafield.title .error').remove();
	$.ajax({
		url: '/kXQ2kAuP1djrzKllFvbRBQGKJlvg9iHzmUyhfZM7PcsAJcQBOGvPY1rZ8E1GjlN6',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			title: $('.configuration-datafield.title input').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			createElement('p', {class: 'error'}, '.configuration-datafield.title', data.error);
		} else {
			location.reload();
		}	
	})
	.fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	})
	.always(function() {
	});
}

function logoUpdate() {
	$('.configuration-datafield.logo .error').remove();
	logoForm = new FormData();
	logoForm.append('logo', $('.configuration-datafield.logo input').get(0).files[0]);
	logoForm.append('community', window.location.href.split('/').slice(-1)[0]);
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});  
	$.ajax({
		url: '/RQvm8SR9ZOTZ7nSCFEYCCxirXnlam7VblDkIEYkVbbTCUaKuBnlCJG6DBlW7E8nF',
		type: 'POST',
		data: logoForm,
		processData: false,
		contentType: false
	}).done(function(data) {
		if (!$.isEmptyObject(data)) {
			createElement('p', {class: 'error'}, '.configuration-datafield.logo', data.error);
		} else {
			location.reload();
		}	
	}).fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}