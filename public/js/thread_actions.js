$(document).ready(function() {
	$(document).on('click', '.thread-delete', function(event) {
	    var thread_id = $('.thread:first').attr('data-id');
	    CR_displayDeleteThreadModal(thread_id);
	});
	$(document).on('click', '.modal-delete-thread', function(event) {
	    event.preventDefault();
	    var thread_id = $(this).attr('data-thread-id');
	    CR_deleteThread(thread_id);
	});
	$(document).on('click', '.thread-options.thread-close', function(event) {
	    var thread_id = $('.thread:first').attr('data-id');
	    CR_displayCloseThreadModel(thread_id);
	});
	$(document).on('click', '.modal-close-thread', function(event) {
	    event.preventDefault();
	    var thread_id = $(this).attr('data-thread-id');
	    CR_closeThread(thread_id);
	});
	$(document).on('click', '.delete-reply', function(event) {
		event.preventDefault();
		var reply_id = $(this).closest('.thread-reply').attr('data-id');
		CR_displayWipeReplyModal(reply_id);
	});
	$(document).on('click', '.modal-delete-reply', function(event) {
		event.preventDefault();
		var reply_id = $(this).attr('data-report-id');
		CR_wipeReply(reply_id);
	});
});

function CR_displayDeleteThreadModal(thread_id) {
	createModal();
	createElement('h1', null, '.modal-body', 'Eliminar Tema');
	createElement('p', null, '.modal-body', 'Se eliminarán todos los datos relativos al tema:');
	createElement('ul', null, '.modal-body');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Todos los mensajes');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Todos los votos');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Estadísticas (Comunidad y usuario)');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Reportes relacionados (Tema y mensajes)');
	createElement('p', null, '.modal-body', 'Estás seguro de eliminar este tema?');
	createElement('div', null, '.modal-body');
	createElement('button', {class: 'modal-button modal-exit'}, '.modal-body div:last', 'Volver');
	createElement('button', {class: 'modal-button modal-delete-thread', 'data-thread-id': thread_id}, '.modal-body div:last', 'Eliminar Tema');
}

function CR_deleteThread(thread_id) {
	$.post('/MnwBIllIldnKdXEQIPjzD5Lw9afwhWnlwhPbNR74rqJwnY4GOpVho1k86BtzlmAe', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			thread_id: thread_id
		}, function(data, textStatus, xhr) {
		if ($.isEmptyObject(data.error))  {
			window.location.replace(window.location.origin);
		} else {
			notifyUser(data.error);
		}
	});
}
function CR_displayCloseThreadModel(thread_id) {
	createModal();
	createElement('h1', null, '.modal-body', 'Cerrar Tema');
	createElement('label', null, '.modal-body', 'Evitará que ningún usuario pueda volver a escribir un mensaje');
	createElement('br', null, '.modal-body');
	createElement('p', null, '.modal-body', '<b>* No se podrá revertir esta acción *</b>');
	createElement('p', null, '.modal-body', 'Estás seguro de cerrar este tema?');
	createElement('div', null, '.modal-body');
	createElement('button', {class: 'modal-button modal-exit'}, '.modal-body div:last', 'Volver');
	createElement('button', {class: 'modal-button modal-close-thread', 'data-thread-id': thread_id}, '.modal-body div:last', 'Cerrar Tema 🔒');
}

function CR_closeThread(thread_id) {
	$.post('/yj6fXnl79TqYcl0qzQcSgDf5nmffpks17WHwwl0XSa4Awv4QQF7oG1BamLMPRX2o', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			thread_id: thread_id
		}, function(data, textStatus, xhr) {
		if ($.isEmptyObject(data.error))  {
			window.location.reload();
		} else {
			notifyUser(data.error);
		}
	});
}

function CR_displayWipeReplyModal(reply_id) {
	createModal();
	createElement('h1', null, '.modal-body', 'Borrar Mensaje');
	createElement('p', null, '.modal-body', 'Se borrará el contenido del mensaje');
	createElement('b', {style: 'font-size: 12px'}, '.modal-body', '* Se mantendrán las citas a este mensaje *');
	createElement('p', null, '.modal-body', 'Estás seguro de continuar?');
	createElement('div', null, '.modal-body');
	createElement('button', {class: 'modal-button modal-exit'}, '.modal-body div:last', 'Volver');
	createElement('button', {class: 'modal-button modal-delete-reply', 'data-report-id': reply_id}, '.modal-body div:last', 'Borrar Mensaje');	
}

function CR_wipeReply(reply_id) {
	$.post('/T1QjrednUfNiJxYousLYfcBNGu8f5UzSgtb6JgL7ZicvswZgv8T0gkfh97PqVqFu', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			reply_id: reply_id
		}, function(data, textStatus, xhr) {
		if ($.isEmptyObject(data.error))  {
			location.reload();
		} else {
			notifyUser(data.error);
		}
	});
}