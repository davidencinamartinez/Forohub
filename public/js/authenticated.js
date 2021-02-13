$(document).ready(function() {
	if (getCookie('NSFW_CHECK') == 'TRUE') {
		$('.blurry-logo').remove();
		$('.blurry').removeClass('blurry');
	}
	$('.navbar button').mouseover(function(event) {
		$(this).children('label').addClass('animated flash infinite');
	});
	$('.navbar button').mouseleave(function(event) {
		$(this).children('label').removeAttr('class');
	});
	$('.top-button-panel button:eq(1)').click(function(event) {
		loginModal();
	});
	$('.top-button-panel button:eq(0)').click(function(event) {
		registerModal();
	});
	$(document).on('click', '.blurry', function(event) {
		nsfwModal();
	});
	$(document).on('click', '.modal-nsfw-allow', function(event) {
		document.cookie = "NSFW_CHECK=TRUE;";
		$('.blurry-logo').remove();
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
	$(document).on('click', '.profile-dark-theme', function(event) {
		document.cookie = "DARK_THEME_CHECK=TRUE;max-age=5184000;path=/";
		location.reload();
	});
	$(document).on('click', '.profile-light-theme', function(event) {
		event.preventDefault();
		document.cookie = "DARK_THEME_CHECK=TRUE;expires=Thu, 18 Dec 2013 12:00:00 UTC;path=/"
		location.reload();
	});
	$('.activate-reply').click(function(event) {
		if ($(this).parent().next('.thread-quick-reply').css('display') == 'block') {
			$(this).parent().next('.thread-quick-reply').css('display', 'none');	
		} else {
			$(this).parent().next('.thread-quick-reply').css('display', 'block');
		}
	});
	$('.quote').click(function(event) {
		$('.thread-quick-reply').css('display', 'block');
		if ($.trim($('.thread-quick-reply-text').val()).length == 0) {
			$('.thread-quick-reply-text').val($('.thread-quick-reply-text').val()+'#'+$(this).closest('.thread-reply').attr('id')+'\n').focus();			
		} else {
			$('.thread-quick-reply-text').val($('.thread-quick-reply-text').val()+'\n\n#'+$(this).closest('.thread-reply').attr('id')+'\n').focus();		
		}
	});
	$('.thread-quick-reply-cancel').click(function(event) {
		$(this).parent().parent('.thread-quick-reply').css('display', 'none');
	});
	$('.thread-vote.upvote').click(function(event) {
		$(this).attr('data-thread-vote', 1);
		$(this).closest('.thread-votes-data').find('.downvote-active').removeClass('downvote-active');
		if ($(this).closest('.thread-votes-data').find('.upvote').hasClass('upvote-active')) {
			$(this).closest('.thread-votes-data').find('.upvote').removeClass('upvote-active');
		} else {
			$(this).closest('.thread-votes-data').find('.upvote').addClass('upvote-active');
		}
		submitVote(this);
		$(this).removeAttr('data-thread-vote');
	});
	$('.thread-vote.downvote').click(function(event) {
		$(this).attr('data-thread-vote', 0);
		$(this).closest('.thread-votes-data').find('.upvote-active').removeClass('upvote-active');
		if ($(this).closest('.thread-votes-data').find('.downvote').hasClass('downvote-active')) {
			$(this).closest('.thread-votes-data').find('.downvote').removeClass('downvote-active');
		} else {
			$(this).closest('.thread-votes-data').find('.downvote').addClass('downvote-active');
		}
		submitVote(this);
		$(this).removeAttr('data-thread-vote');
	});
	$('#user-rewards').click(function(event) {
		getRewards();
	});

	$('#user-notifications, .user-unread-notifications').click(function(event) {
		getNotifications();
		$.post('/KlRf4ZSnlOuriz8ymbDDacEtaEdYPwUPi2uMOskmKxuh2coL11JwIdtyYH2qZRmG', 
			{_token: $('meta[name="csrf-token"]').attr('content')}, 
			function(data, textStatus, xhr) {
				$('.user-unread-notifications').remove();
		}).fail(function(data) {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		});
	});
	window.onclick = function(event) {
	  	if (event.target.className == 'modal') {
	  		$('.modal').fadeOut('fast', function() {
	  			$(this).remove();
	  		})
	  	}
	}
	$(document).on('click', '.thread-community-join', function(event) {
		var element = $(this);
		$.ajax({
			url: '/m825i5Wul0hEBxjHBh8GVS9n5WmFU8ARuDqPSfOEDrXaoeo7HCQYJgMWmYt1LeXJ',
			type: 'POST',
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				community: $(this).prev('.thread-community').find('.thread-community-name').text()
			},
		}).done(function(data) {
			if (data.success) {
				var parentCommunity = $(element).parent().find('.thread-community-name').text();
				var elements = $('.thread-community-join');
				$.each(elements, function(index, element) {
					if ($(element).parent().find('.thread-community-name').text() == parentCommunity) {
						$(element).fadeIn('fast');
						$(element).attr('class', 'required-auth thread-community-joined');
						$(element).text('Cancelar suscripción');
					}
				});
				notifyUser(data.success);
			} else {
				notifyUser(data.error);
			}
		}).fail(function() {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		});
	});
	$(document).on('click', '.thread-community-joined', function(event) {
		var element = $(this);
		$.ajax({
			url: '/g1VJH8HX7nsGvGuGPVZxASEW4rcSjyZ2oAuwrSWo8oor1f94OCk1WGxLKQIkA2cv',
			type: 'POST',
			context: $(this),
			data: {
				_token: $('meta[name="csrf-token"]').attr('content'),
				community: $(this).prev('.thread-community').find('.thread-community-name').text()
			},
		}).done(function(data) {
			if (data.success) {
				var parentCommunity = $(this).parent().find('.thread-community-name').text();
				var elements = $('.thread-community-joined');
				$.each(elements, function(index, element) {
					if ($(element).parent().find('.thread-community-name').text() == parentCommunity) {
						$(element).fadeIn('fast');
						$(element).attr('class', 'required-auth thread-community-join');
						$(element).text('Suscribirse');
					}
				});
				notifyUser(data.success);
			} else {
				notifyUser(data.error);
			}
		})
		.fail(function() {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		});
	});
	$(document).on('click', '.thread-quick-reply-send', function(event) {
		submitQuickReply($(this));
	});
	$(document).on('input', 'textarea, input', function(event) {
		$(this).next('.character-counter').find('label:first').text($(this).val().length);
	});
	$('.report-thread').click(function(event) {
		reportThreadModal($(this).parent().closest('.thread').attr('data-id'));
	});
	$(document).on('click', '.modal-report-thread-send', function(event) {
		$('.modal-error ul').empty();
		$.post('/zKj113txZHvkB86ZPWnnJxIYB438y7SeBfkKMR84zvp5XgC5DIsEpP5F1vOtPsoT', 
			{
				_token: $('meta[name="csrf-token"]').attr('content'),
				thread_id: $('.modal-body #thread-id').text(),
				type: $('.modal-select').val(),
				description: $('.modal-report-textarea').val()
		}, function(data, textStatus, xhr) {
			if (data.success) {
				modalSuccess(data.success);
				setTimeout(function() {
					$('.modal').fadeOut('fast', function() {
						$('.modal').remove();
					})
				}, 4000);
			} else if (data.remaining_time){
				$('.modal-error').css('display', 'block');
				createElement('li', null, '.modal-error ul', 'Espera '+data.remaining_time+' segundo(s) para enviar otro reporte');
			} else {
				$('.modal-error').css('display', 'block');
				createElement('li', null, '.modal-error ul', data.response);
			}
		}).fail(function(data) {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		})
	});
	$('.report-reply').click(function(event) {
		reportReplyModal($(this).closest('.thread-reply').attr('data-id'));
	});
	$(document).on('click', '.modal-report-reply-send', function(event) {
		$('.modal-error ul').empty();
		$.post('/gAKFLXK4xRsW8kMCRAFi3GjzwBYa8oMrSV4pQ6O0m14xoZP6Mi8hAAH6LEqdwsOl', 
			{
				_token: $('meta[name="csrf-token"]').attr('content'),
				reply_id: $('.modal-body #reply-id').text(),
				type: $('.modal-select').val(),
				description: $('.modal-report-textarea').val()
		}, function(data, textStatus, xhr) {
			if (data.success) {
				modalSuccess(data.success);
				setTimeout(function() {
					$('.modal').fadeOut('fast', function() {
						$('.modal').remove();
					})
				}, 4000);
			} else if (data.remaining_time){
				$('.modal-error').css('display', 'block');
				createElement('li', null, '.modal-error ul', 'Espera '+data.remaining_time+' segundo(s) para enviar otro reporte');
			} else {
				$('.modal-error').css('display', 'block');
				createElement('li', null, '.modal-error ul', data.response);
			}
		}).fail(function(data) {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		})
	});
	$('.user-avatar').click(function(event) {
		updateProfilePicture();
	});
	$(document).on('change', '.modal-avatar-form input', function(event) {
		var file =  $("input[type=file]").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $(".modal-avatar-picture:first").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
	});
	$(document).on('submit', '.modal-avatar-form form', function(event) {
		event.preventDefault();
		avatarForm = new FormData();
		avatarForm.append('avatar', $("input[type=file]").get(0).files[0]);
		$('.modal-error').css('display', 'none');
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});  
		$.ajax({
			url: '/hT8IFRUl6hAVCSCmv7iBeGDKBSMgT0XQl3quQh4EJOzeMCQ1ZwTMzWE6VMWo3le7',
			type: 'POST',
			data: avatarForm,
			processData: false,
			contentType: false
		}).done(function(data) {
			if ($.isEmptyObject(data.error)) {
				location.reload();
			} else {
				$('.modal-error').css('display', 'block');
				$('.modal-error ul').empty();
				$.each(data.error, function(index, val) {
					$.each(val, function(index, val) {
						 createElement('li', null, '.modal-error ul', val);
					});
				});
			}
		}).fail(function() {
			notifyUser('⚠️ Lo sentimos, hubo un problema con tu petición (Error 500) ⚠️');
		});
	});
	$(document).on('click', '.poll-vote-button', function(event) {
		event.preventDefault();
		votePollOption(this);
	});
	$(document).on('click', '.profile-configuration-trigger', function(event) {
		event.preventDefault();
		if ($('.profile-configuration').css('display') == 'none') {
			$('.threads-panel').children().css('display', 'none');
            $('.profile-configuration').css('display', 'block');
            return false;
		} else {
			$('.threads-panel').children().css('display', 'block');
            $('.profile-configuration').css('display', 'none');
            return false;
		}
	});	
});