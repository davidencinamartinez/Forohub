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
			window.location.replace(window.location.origin);
		} else {
			notifyUser(data.error);
		}
	});
}