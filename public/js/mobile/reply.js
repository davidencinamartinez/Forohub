function replyFormat() {
	$('#replyPanel').on('click' , function(event) { // DISPLAY REPLY MENU
		document.getElementById('replyPost').style.visibility = 'visible';
		document.getElementById('replyPost').style.display = 'inline-table';
		document.getElementsByName('replyMsg')[0].setAttribute('contenteditable', 'true');
	});
	$('div[name="replyMsg"]').on('paste', function(event) { // PASTE CONTENT
		event.preventDefault();
		var data = event.originalEvent.clipboardData.getData('text/plain');
		document.execCommand('insertText', false, data);
	});
	$('.wysiwyg').eq(0).on('click' , function(event) { // BOLD BUTTON
		$('div[name="replyMsg"]').focus();
		document.execCommand('bold');		
	});
	$('.wysiwyg').eq(1).on('click' , function(event) { // ITALIC BUTTON
		$('div[name="replyMsg"]').focus();
		document.execCommand('italic');		
	});
	$('.wysiwyg').eq(2).on('click' , function(event) { // UNDERLINE BUTTON
		$('div[name="replyMsg"]').focus();
		document.execCommand('underline');		
	});
	$('.wysiwyg').eq(3).on('click' , function(event) { // ADD IMAGE BUTTON
		var replyImg = prompt("Introduce la URL de la imagen:");
		if (replyImg != null) {
			$('div[name="replyMsg"]').focus();
			document.execCommand('insertimage', null, replyImg);		
		} else {
			return false;
		}
	});
	$('.wysiwyg').eq(4).on('click' , function(event) { // ADD LINK BUTTON
		var urlPrompt = prompt('Introduce el enlace de la página:');
		if (urlPrompt != null) {
			$('div[name="replyMsg"]').focus();
			document.execCommand('createLink', true, urlPrompt);
		} else {
			return false;
		}
	});
	$('#replyButton').on('click', function(event) {
		replyCorrect		
	});
}

function replyCorrect() {
	$('.error').remove();
	var content = $('div[name="replyMsg"]').html();
	var contentEmpty = content.replace(/^(?:&nbsp;|\s)+|(?:&nbsp;|\s)+$/ig,'');
	var replyStatus = 0;
	if (contentEmpty.length <= 0) {
		var error = $('<div style="text-align: center; margin: 1vh;"><p class="error">No puedes enviar un mensaje vacío.<br>Debes escribir al menos un carácter.</p></div>');
		$('#replyButton').before(error);
		replyStatus = false;
	} else {
		contentEmpty.replace(/(<\/?(?:b|i|u|a|div|ul|ol|li|iframe|img)[^>]*>)|<[^>]+>/ig, '$1'); // WHITELIST
		$('input[name="thread_id"]').attr('value', window.location.pathname.split('/')[2]);
		$('input[name="creator"]').attr('value', $('.userLoged a b').text());
		$('input[name="content"]').attr('value', $('div[name="replyMsg"]').html());
		replyStatus = true;
	}
	return replyStatus;
}