$(document).ready(function() {
	$(document).on('click', '.checkbox-button.affiliate', function(event) {
		var userId = $(this).closest('.element').attr('data-id');
		var userName = $(this).closest('.element').attr('data-name');
		makeAffiliate(userId, userName);
	});
	$(document).on('click', '.checkbox-button.moderator', function(event) {
		var userId = $(this).closest('.element').attr('data-id');
		var userName = $(this).closest('.element').attr('data-name');
		makeModerator(userId, userName);
	});
	$(document).on('click', '.checkbox-button.leader', function(event) {
		var userId = $(this).closest('.element').attr('data-id');
		var userName = $(this).closest('.element').attr('data-name');
		makeLeader(userId, userName);
	});
	$(document).on('click', '.ban-user-button', function(event) {
		var userId = $(this).closest('.element').attr('data-id');
		var userName = $(this).closest('.element').attr('data-name');
		kickAffiliate(userId, userName);
	});
});

function makeAffiliate(userId, userName) {
	createModal();
	createElement('h1', null, '.modal-body', 'Modificación de Afiliados');
	createElement('p', null, '.modal-body', 'El usuario <b>'+userName+'</b> pasará a tener el rango de <b>Afiliado</b>');
	createElement('p', null, '.modal-body', 'El usuario perderá los permisos como administrador');
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', {style: 'display: inline-flex'}, '.modal-body');
	createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-body div:last', 'Volver');
	createElement('form', {method: 'POST', action: '/MgJCirumZx0M57VrYsez96UcOcLDldCSdSlbUB8htSQaHP81rSFHWLm1GfEfX3K0'}, '.modal-body div:last');
	createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'user_id', value: userId}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'community_tag', value: window.location.href.split('/')[4]}, '.modal-body div:last form');
	createElement('button', {type: 'submit'}, '.modal-body div:last form', 'Actualizar Rango');
}

function makeModerator(userId, userName) {
	createModal();
	createElement('h1', null, '.modal-body', 'Modificación de Afiliados');
	createElement('p', null, '.modal-body', 'El usuario <b>'+userName+'</b> pasará a tener el rango de <b>Moderador</b>');
	createElement('p', null, '.modal-body', 'El usuario obtendrá los siguientes permisos:');
	createElement('ul', null, '.modal-body');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Acceso al panel de reportes');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Cerrar y borrar temas');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Borrar mensajes de la comunidad');
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', {style: 'display: inline-flex'}, '.modal-body');
	createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-body div:last', 'Volver');
	createElement('form', {method: 'POST', action: '/4DzqRtvvMOTK0UIy6z9wXPaHwDTu0qiJk9288x8SGVv9DGkOWYh5elW2tad2ab6T'}, '.modal-body div:last');
	createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'user_id', value: userId}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'community_tag', value: window.location.href.split('/')[4]}, '.modal-body div:last form');
	createElement('button', {type: 'submit'}, '.modal-body div:last form', 'Actualizar Rango');
}

function makeLeader(userId, userName) {
	createModal();
	createElement('h1', null, '.modal-body', 'Modificación de Afiliados');
	createElement('p', null, '.modal-body', 'El usuario <b>'+userName+'</b> pasará a tener el rango de <b>Líder</b>');
	createElement('b', null, '.modal-body', '❗ AVISO IMPORTANTE ❗<br>Perderás todos los derechos en esta comunidad')
	createElement('p', null, '.modal-body', 'El usuario obtendrá los siguientes permisos:');
	createElement('ul', null, '.modal-body');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Acceso al panel de afiliados');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Acceso al panel de reportes');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Cerrar y borrar temas');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Borrar mensajes de la comunidad');
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', {style: 'display: inline-flex'}, '.modal-body');
	createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-body div:last', 'Volver');
	createElement('form', {method: 'POST', action: '/nn6pOlrj9U80946uspAXdcdBQylNZEK5cvyQKWDcZHTm05PQAfAaTpX8lH27IFVm'}, '.modal-body div:last');
	createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'user_id', value: userId}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'community_tag', value: window.location.href.split('/')[4]}, '.modal-body div:last form');
	createElement('button', {type: 'submit'}, '.modal-body div:last form', 'Actualizar Rango');
}

function kickAffiliate(userId, userName) {
	createModal();
	createElement('h1', null, '.modal-body', 'Expulsar Afiliado');
	createElement('p', null, '.modal-body', 'El usuario <b>'+userName+'</b> será baneado de la comunidad');
	createElement('p', null, '.modal-body', 'Se mantendrán:');
	createElement('ul', null, '.modal-body');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Temas creados en la comunidad');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Mensajes escritos en temas de la comunidad');
	createElement('li', {style: 'text-align: left'}, '.modal-body ul', 'Reportes enviados por el usuario');
	createElement('label', null, '.modal-body', 'El usuario perderá el derecho a interactuar con<br>los demás miembros dentro de la comunidad')
	createElement('p', null, '.modal-body', '<b>* Esta acción no se podrá revertir *</b>')
	createElement('p', null, '.modal-body', 'Estás seguro de querer continuar?');
	createElement('div', {style: 'display: inline-flex'}, '.modal-body');
	createElement('button', {class: 'modal-exit', style: 'margin-right: 2px'}, '.modal-body div:last', 'Volver');
	createElement('form', {method: 'POST', action: '/Tlka8Kyzu5R0srMvRS6oXzoDqmjcuGc6747JTgBamYS5lBwYgzZExLg2ii6KSOPO'}, '.modal-body div:last');
	createElement('input', {type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content')}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'user_id', value: userId}, '.modal-body div:last form');
	createElement('input', {type: 'hidden', name: 'community_tag', value: window.location.href.split('/')[4]}, '.modal-body div:last form');
	createElement('button', {type: 'submit'}, '.modal-body div:last form', 'Expulsar');
}