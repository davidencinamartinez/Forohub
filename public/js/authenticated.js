$(document).ready(function() {
	if (getCookie('nsfw') == 'allowed') {
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
		$.post('/m825i5Wul0hEBxjHBh8GVS9n5WmFU8ARuDqPSfOEDrXaoeo7HCQYJgMWmYt1LeXJ', 
			{
				_token: $('meta[name="csrf-token"]').attr('content'),
				community: $(this).prev('.thread-community').find('.thread-community-name').text()
			}, function(data, textStatus, xhr) {
				notifyUser(data.success);
		});
		$(this).fadeOut('fast', function() {
			$(this).fadeIn('fast');
			$(this).attr('class', 'required-auth thread-community-joined');
			$(this).text('Cancelar suscripción');
		});
	});
	$(document).on('click', '.thread-community-joined', function(event) {
		$.post('/g1VJH8HX7nsGvGuGPVZxASEW4rcSjyZ2oAuwrSWo8oor1f94OCk1WGxLKQIkA2cv', 
			{
				_token: $('meta[name="csrf-token"]').attr('content'),
				community: $(this).prev('.thread-community').find('.thread-community-name').text()
			}, function(data, textStatus, xhr) {
				notifyUser(data.success);
		});
		$(this).fadeOut('fast', function() {
			$(this).fadeIn('fast');
			$(this).attr('class', 'required-auth thread-community-join');
			$(this).text('Suscribirse');
		});
	});
	$(document).on('click', '.thread-quick-reply-send', function(event) {
		submitQuickReply($(this));
	});
	$('.report-thread, .report-reply').click(function(event) {
		reportModal();
	});
});