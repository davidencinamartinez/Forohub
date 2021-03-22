$(document).ready(function() {
	$('.report-date').each(function(index, el) {
		$(this).text("Hace "+(moment($(this).text(), 'YYYY-MM-DD HH:mm:ss').fromNow(true)));	
	});
	$('.thread-solve').click(function(event) {
		var report_id = $(this).closest('.thread-report').attr('data-id');
		CR_displaySolveThreadModal(report_id);
	});
	$(document).on('click', '.modal-solve-thread', function(event) {
		event.preventDefault();
		var report_id = $(this).attr('data-report-id');
		CR_solveThread(report_id);
	});
	$('.reply-delete').click(function(event) {
		var report_id = $(this).closest('.reply-report').attr('data-id');
		CR_displayWipeReplyModal(report_id);
	});
	$(document).on('click', '.modal-delete-reply', function(event) {
		event.preventDefault();
		var report_id = $(this).attr('data-report-id');
		CR_wipeReply(report_id);
	});
	$('.reply-solve').click(function(event) {
		var report_id = $(this).closest('.reply-report').attr('data-id');
		CR_displaySolveReplyModal(report_id);
	});
	$(document).on('click', '.modal-solve-reply', function(event) {
		event.preventDefault();
		var report_id = $(this).attr('data-report-id');
		CR_solveReply(report_id);
	});
});

function CR_displaySolveThreadModal(report_id) {
	createModal();
	createElement('h1', null, '.modal-body', 'Resolver Reporte');
	createElement('p', null, '.modal-body', 'El reporte quedará marcado como resuelto');
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', null, '.modal-body');
	createElement('button', {class: 'modal-button modal-exit'}, '.modal-body div:last', 'Volver');
	createElement('button', {class: 'modal-button modal-solve-thread', 'data-report-id': report_id}, '.modal-body div:last', 'Marcar como resuelto');
}

function CR_solveThread(report_id) {
	$.post('/O6pbHM8Jj18jTPAAwKAyLfL0TCbduWNcGxykzWm7qwb876B2y3pJAdeD9ZOgaZX3', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			report_id: report_id
		}, function(data, textStatus, xhr) {
		if ($.isEmptyObject(data.error))  {
			location.reload();
		} else {
			notifyUser(data.error);
		}
	});
}

function CR_displaySolveReplyModal(report_id) {
	createModal();
	createElement('h1', null, '.modal-body', 'Resolver Reporte');
	createElement('p', null, '.modal-body', 'El reporte quedará marcado como resuelto');
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', null, '.modal-body');
	createElement('button', {class: 'modal-button modal-exit'}, '.modal-body div:last', 'Volver');
	createElement('button', {class: 'modal-button modal-solve-reply', 'data-report-id': report_id}, '.modal-body div:last', 'Marcar como resuelto ✔️');
}

function CR_solveReply(report_id) {
	$.post('/fs8wk39otA5BO5feaB7xWkvhMCBgXOHuWZIhYjNe72Zy9XBMpTYUAFQHyFtdI7iS', 
		{
			_token: $('meta[name="csrf-token"]').attr('content'),
			report_id: report_id
		}, function(data, textStatus, xhr) {
		if ($.isEmptyObject(data.error))  {
			location.reload();
		} else {
			notifyUser(data.error);
		}
	});
}