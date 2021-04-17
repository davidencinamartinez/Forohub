$(document).ready(function() {
	$(document).on('click', '.community-configuration-trigger', function(event) {
		event.preventDefault();
		if ($('.configuration-panel').css('display') == 'none') {
			$('.threads-panel').children().hide('400');
            $('.configuration-panel').show('400');
            return false;
		} else {
			$('.threads-panel').children().show('400');
            $('.configuration-panel').hide('400');
            return false;
		}
	});
	$(document).on('click', '.edit-element', function(event) {
		event.preventDefault();
		$('.configuration-datafield').hide('400');
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
	$(document).on('click', '.community-update.description', function(event) {
		descriptionUpdate();
	});
	$(document).on('click', '.add-rule', function(event) {
		communityRuleModal();
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
	$(document).on('change', '.configuration-datafield.background input', function(event) {
		var file =  $(this).get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $(".configuration-background > img").attr("src", reader.result);
                $(".configuration-background > img").css({ animation: 'fileAnimation 1s infinite alternate'});
            }
            reader.readAsDataURL(file);
        }
	});
	$(document).on('click', '.community-update.background', function(event) {
		backgroundUpdate();
	});
	$(document).on('click', '.community-update.modal-add-rule', function(event) {
		addCommunityRule();
	});
	$(document).on('click', '.edit-rule', function(event) {
		var id = $(this).closest('.configuration-rule').attr('data-id');
		var title = $(this).closest('.configuration-rule').find('.configuration-rule-title').text();
		var description = $(this).closest('.configuration-rule').find('.configuration-rule-description').text();
		editCommunityRuleModal(id,title,description);
	});
	$(document).on('click', '.modal-edit-rule', function(event) {
		editCommunityRule();
	});
	$(document).on('click', '.delete-rule', function(event) {
		var ruleId = $(this).closest('.configuration-rule').attr('data-id');
		deleteCommunityRuleModal(ruleId);
	});
	$(document).on('click', '.modal-delete-rule', function(event) {
		deleteCommunityRule();
	});
});

function titleUpdate() {
	$('.configuration-datafield.title .error').remove();
	document.documentElement.style.cursor = "progress";
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
			document.documentElement.style.cursor = "default";
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

function descriptionUpdate() {
	$('.configuration-datafield.title .error').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/OC7OuuXnoN00lT5xb9Mu49UcKBsy2Ghe6TOk0T2OA4Ucl4nM7azA4zaRI611e3xc',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			description: $('.configuration-datafield.description textarea').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('p', {class: 'error'}, '.configuration-datafield.description', data.error);
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
	document.documentElement.style.cursor = "progress";
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
			document.documentElement.style.cursor = "default";
			createElement('p', {class: 'error'}, '.configuration-datafield.logo', data.error);
		} else {
			location.reload();
		}	
	}).fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}

function backgroundUpdate() {
	$('.configuration-datafield.background .error').remove();
	document.documentElement.style.cursor = "progress";
	backgroundForm = new FormData();
	backgroundForm.append('background', $('.configuration-datafield.background input').get(0).files[0]);
	backgroundForm.append('community', window.location.href.split('/').slice(-1)[0]);
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});  
	$.ajax({
		url: '/4pT8SAeIt9rpNsm2W8tUd9cytXHUOXANLXec6V6aTqjbehfFd8EXT6f5Yp6jezQs',
		type: 'POST',
		data: backgroundForm,
		processData: false,
		contentType: false
	}).done(function(data) {
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('p', {class: 'error'}, '.configuration-datafield.background', data.error);
		} else {
			location.reload();
		}	
	}).fail(function() {
		notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
	});
}

function communityRuleModal() {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Añadir regla'); // Title
		// Rule Name
		createElement('b', null, '.modal-body', 'Título de la regla');
		createElement('input', {type: 'text', class: 'form-input configuration-add-rule-title', placeholder: 'Título', maxlength: '60'}, '.modal-body');
		createElement('div', {class: 'character-counter'}, '.modal-body');
		createElement('label', null, '.modal-body .character-counter:first', '0');
		createElement('label', null, '.modal-body .character-counter:first', '/60');
		// Rule Description
		createElement('b', null, '.modal-body', 'Descripción');
		createElement('textarea', {class: 'configuration-add-rule-textarea', placeholder: 'Descripción', rows: '6', maxlength: 300}, '.modal-body');
		createElement('div', {class: 'character-counter'}, '.modal-body');
		createElement('label', null, '.modal-body .character-counter:last', '0');
		createElement('label', null, '.modal-body .character-counter:last', '/300');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');
		// Rule Button
		createElement('button', {class: 'community-update fh-button modal-add-rule'}, '.modal-body', 'Añadir regla');
}

function editCommunityRuleModal(id,title,description) {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Modificar regla'); // Title
		// Rule Id
		createElement('input', {type: 'hidden', id: 'configuration-edit-rule-id', value: id}, '.modal-body');
		// Rule Name
		createElement('b', null, '.modal-body', 'Título de la regla');
		createElement('input', {type: 'text', class: 'form-input configuration-add-rule-title', placeholder: 'Título', maxlength: '60', value: title}, '.modal-body');
		createElement('div', {class: 'character-counter'}, '.modal-body');
		createElement('label', null, '.modal-body .character-counter:first', title.length);
		createElement('label', null, '.modal-body .character-counter:first', '/60');
		// Rule Description
		createElement('b', null, '.modal-body', 'Descripción');
		createElement('textarea', {class: 'configuration-add-rule-textarea', placeholder: 'Descripción', rows: '6', maxlength: 300}, '.modal-body', description);
		createElement('div', {class: 'character-counter'}, '.modal-body');
		createElement('label', null, '.modal-body .character-counter:last', description.length);
		createElement('label', null, '.modal-body .character-counter:last', '/300');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');
		// Rule Button
		createElement('button', {class: 'community-update fh-button modal-edit-rule'}, '.modal-body', 'Modificar regla');
}

function editCommunityRule() {
	$('.modal-error').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/FtxRLrW2w7crAx99m5gT6ukkiwxeG1HcZTq7tWreG0w5uiqbugrFGihXRQDGM7il',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			ruleId: $('#configuration-edit-rule-id').val(),
			ruleTitle: $('.configuration-add-rule-title').val(),
			ruleDescription: $('.configuration-add-rule-textarea').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', data.error);
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

function addCommunityRule() {
	$('.modal-error').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/hlZ2PLZqClmRv5hJiOx9yuTxloMkRc9dnIeIGvbGDLuSXZzgSLtMQeWWCRprHOTu',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			ruleTitle: $('.configuration-add-rule-title').val(),
			ruleDescription: $('.configuration-add-rule-textarea').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', data.error);
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

function deleteCommunityRuleModal(id) {
	createModal(); // Call function
	// Modal Body Elements
		createElement('h1', null, '.modal-body', 'Eliminar regla'); // Title
		// Rule Id
		createElement('input', {type: 'hidden', id: 'configuration-delete-rule-id', value: id}, '.modal-body');
		// Rule Name
		createElement('b', null, '.modal-body', 'Se eliminará la regla<br><br>*No se podrán revertir los cambios*<br><br>Deseas continuar?<br><br>');
		// Modal Error
			createElement('div', {class: 'modal-error', style: 'display: none'}, '.modal-body');
			createElement('ul', null, '.modal-error');
		// Rule Button
		createElement('button', {class: 'community-update fh-button modal-delete-rule'}, '.modal-body', 'Eliminar regla');
}

function deleteCommunityRule() {
	$('.modal-error').remove();
	document.documentElement.style.cursor = "progress";
	$.ajax({
		url: '/ShFf3C9lafsFix1WiQZaYibRKnNRnACmocgHSpHq4cPqVfXdkD0YzT6io2uV0keL',
		type: 'POST',
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			ruleId: $('#configuration-delete-rule-id').val(),
			community: window.location.href.split('/').slice(-1)[0]
		},
	})
	.done(function(data) {
		console.log(data);
		if (!$.isEmptyObject(data)) {
			document.documentElement.style.cursor = "default";
			createElement('div', {class: 'modal-error'}, '.modal-body');
			createElement('ul', null, '.modal-error');
			createElement('li', null, '.modal-error ul', data.error);
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