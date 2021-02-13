$(document).ready(function() {
	$(document).on('click', '.append-rule', function(event) {
		event.preventDefault();
		NC_appendRule();
	});
	$(document).on('keydown', '.community-tags > input', function(event) {
		if (event.keyCode === 188) {
			event.preventDefault();
			NC_appendTag(this);
		}
	});
	$(document).on('click', '.community-tag-remove', function(event) {
		NC_removeTag(this);
	});
	$('.new-community-rule').click(function(event) {
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
	$(document).on('click', '.new-community-submit', function(event) {
		event.preventDefault();
		NC_validateCommunityForm();
	});
	$(document).on('click', '.new-community-exit', function(event) {
		event.preventDefault();
		window.location.replace('/');
	});
});

function NC_appendRule() {
	createElement('div', {class: 'community-rule'}, '.community-rules');
	createElement('input', {type: 'text', class: 'community-rule-name', maxlength: 60, placeholder: 'Precepto ...'}, '.community-rule:last');
	createElement('textarea', {class: 'community-rule-description', rows: 4, maxlength: 300, placeholder: 'Descripción ...'}, '.community-rule:last');
}

function NC_appendTag(element) {
	if ($(element).val().length >= 2) {
		createElement('div', {class: 'community-tag', 'data-tag':  $(element).val().split(",")}, '.tags-container', $(element).val().split(","));
		createElement('label', {class: 'community-tag-remove'}, '.community-tag:last', '❌');
		$(element).val(null);	
	}
}

function NC_removeTag(element) {
	$(element).parent().remove();
}

function NC_validateCommunityForm() {
	$('.error').remove();
	var tagsArray = [];
	$('.community-tag').each(function(index, el) {
		tagsArray.push($(this).attr('data-tag'));
	});
	$.post('/67aOVLKR4DLJTUSL6OkdHewSt9fcCxJiCt0EkE1dCUejJ4VMhH5iiE0ecKxzxmMl', 
		{
			_token: $('input[name="_token"]').val(),
            tag: $('input[name="tag"]').val(),
            title: $('input[name="name"]').val(),
            description: $('textarea[name="description"]').val(),
            tags: tagsArray,
		}, function(data, textStatus, xhr) {
			/*
			if ($(data).has(data.error.title)) {
				createElement('label', {class: 'error'}, '.name-error', data.error.title);
			}
			if ($(data).has(data.error.title)) {
				createElement('label', {class: 'error'}, '.tag-error', data.error.tag);
			}
			if ($(data).has(data.error.description)) {
				createElement('label', {class: 'error'}, '.description-error', data.error.description);
			}
			if ($(data).has(data.error.tags)) {
				createElement('label', {class: 'error'}, '.tags-error', data.error.tags);
			} 
			else {
				window.location.href = data.url;
			}*/
			if (data.error) {
				$.each(data.error, function(index, val) {
					if (index == "title") {
						createElement('label', {class: 'error'}, '.name-error', data.error.title);
					}
					if (index == "tag") {
						createElement('label', {class: 'error'}, '.tag-error', data.error.tag);
					}
					if (index == "description") {
						createElement('label', {class: 'error'}, '.description-error', data.error.description);
					}
					if (index == "tags") {
						createElement('label', {class: 'error'}, '.tags-error', data.error.tags);
					}
				});
			} else {
				window.location.href = data.url;
			}
	});
}