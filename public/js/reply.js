// REPLIES

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
	$('div[name="replyMsg"]').keydown( function(event) {
	    if (event.keyCode === 13) {
			document.execCommand('insertHTML', false, '<br><br>');
	      	return false;
	    }
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
	$('.wysiwyg').eq(4).on('click' , function(event) { // YOUTUBE EMBED BUTTON
		var urlPrompt = prompt('Introduce el enlace del vídeo:\nPor ejemplo:\nhttps://www.youtube.com/watch?v=dc3KETiybOI');
		if(urlPrompt != null && urlPrompt.split("?v=")[1].length == 11){
			$('div[name="replyMsg"]').focus();
			var videoEmbed = '<iframe src="https://www.youtube.com/embed/'+urlPrompt.split("?v=")[1]+'">';
	    	document.execCommand("insertHtml", false, videoEmbed);
		} else {
			event.preventDefault();
			return false;
		}
	});
	$('.wysiwyg').eq(5).on('click' , function(event) { // YOUTUBE EMBED BUTTON
		var embedPrompt = prompt('Introduce el iFrame del vídeo:\n¡ATENCIÓN!\nEl contenido de carácter pedófilo o gore queda estrictamente prohibido.');
		if(embedPrompt != null){
			$('div[name="replyMsg"]').focus();
	    	document.execCommand("insertHtml", false, embedPrompt);
		} else {
			event.preventDefault();
			return false;
		}
	});
	$('.wysiwyg').eq(6).on('click' , function(event) { // ADD LINK BUTTON
		var urlPrompt = prompt('Introduce el enlace de la página:\n¡ATENCIÓN!\nEl contenido de carácter pedófilo o gore queda estrictamente prohibido.');
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
	var content = $('div[name="replyMsg"]').text();
	var replyStatus = 0;
	if (content.length <= 0) {
		errorDisplay($('#replyButton'),'No puedes enviar un mensaje vacío. Debes escribir al menos un carácter.');
		replyStatus = false;
	} else {
		content.replace(/(<\/?(?:b|i|u|a|div|ul|ol|li|iframe|img|div)[^>]*>)|<[^>]+>/ig, '$1'); // WHITELIST
		$('input[name="thread_id"]').attr('value', window.location.pathname.split('/')[2]);
		$('input[name="creator"]').attr('value', $('.userLoged a b').text());
		$('input[name="content"]').attr('value', $('div[name="replyMsg"]').html());
		replyStatus = true;
	}
	return replyStatus;
}