$(document).ready(function() {
	$(document).on('input', '.thread-community input:first', function(event) {
		NT_getCommunity(this);
	});
	$(document).on('click', '.community-div', function(event) {
		NT_communityData(this);
	});
	$(document).on('click', 'body:not(.community-div)', function(event) {
		$('.thread-community-container').remove();
	});
	$('.thread-type-option').click(function(event) {
		$('.thread-content').empty();
		$('.thread-type-option').removeClass('active');
		$('#type').val($(this).attr('data-type'));
		$(this).addClass('active');
		NT_pickType($(this).attr('data-type'));
	});
	$(document).on('click', '.append-option', function(event) {
		event.preventDefault();
		NT_appendPollOption();
	});
	$(document).on('click', '.poll-option > button', function(event) {
		event.preventDefault();
		NT_removePollOption(this);
	});
	$(document).on('input', 'textarea', function(event) {
		$(this).next('.character-counter').find('label:first').text($(this).val().length);
	});
	$(document).on('keydown', '.thread-tags > input', function(event) {
		if (event.keyCode === 188) {
			event.preventDefault();
			NT_appendTag(this);
		}
	});
	$(document).on('click', '.thread-tag-remove', function(event) {
		NT_removeTag(this);
	});
	$(document).on('input', '.youtube-input', function(event) {
		$('.youtube-preview').remove();
		var url = $(this).val().split("?v=");
		var youtubeRef = ["https://m.youtube.com/watch", "https://www.youtube.com/watch"];
		if (youtubeRef.includes(url[0])) {
			var embed_id = url[1].replace($(this).val().split("&ab")[1], '').replace('&ab','');
			if (embed_id.length === 11) {
				NT_appendYoutube(embed_id);
			}
		}
	});
	
	$(document).on('click', '.new-thread-exit', function(event) {
		event.preventDefault();
		window.location.replace('/');
	});

	$(document).on('change', '.multimedia-input', function(event) {
		$('.body-error').empty();
		$('.multimedia-container').siblings('.input-title:last').remove();
		$('.multimedia-container').remove();
		var fileArray = [];
		$($(this)[0].files).each(function(index, element) {
			fileArray.push(element.type.split("/")[0]);
		});
		if (fileArray.length > 10) {
			createElement('label', {class: "error"}, '.body-error', 'Sólo se permiten diez (10) imágenes o un (1) vídeo');
			$('.multimedia-input').val("");
			return;
		}
		for (var i = 1; i < fileArray.length; i++) {
			if (fileArray[i] !== fileArray[i-1]) {
				createElement('label', {class: "error"}, '.body-error', 'Solo se permite un tipo de archivo a la vez (Imagen o Vídeo)');
				$('.multimedia-input').val("");
				return;
			}
			for (var x = 1; x < fileArray.length; x++) {
				if (fileArray[x] == "video" && fileArray[i] == "video") {
					createElement('label', {class: "error"}, '.body-error', 'Solo se permite subir un vídeo a la vez');
					$('.multimedia-input').val("");
					return;
				}
			}
		}
		if ($('.multimedia-container').length > 0) {
			$('.multimedia-container').empty();
		} else {
			createElement('b', {class: 'input-title'}, '.thread-content', 'Preview:');
			createElement('div', {class: 'multimedia-container'}, '.thread-content');
			$('.thread-content > .input-title:last').css('marginTop', '10px');
			$('.multimedia-container').css({
				border: 'solid 1px black',
				marginTop: '6px',
				padding: '10px',
				backgroundColor: 'ghostwhite',
			});
		}
        if (typeof (FileReader) != "undefined") {
        	$(".multimedia-container").empty();
           	$($(this)[0].files).each(function(index, element) {
	            var file = $(this);  
	            var filetype = file[0].type.split("/")[0];
	            if (filetype == "image") {
	                var reader = new FileReader();
	                reader.onload = function (e) {
	                	createElement('div', {class: 'multimedia-image', 'data-index': index}, '.multimedia-container');
	                	createElement('img', {'data-index': index, src: e.target.result}, '.multimedia-image:last');
	           		}
					reader.readAsDataURL($(this)[0]);
	            } else if (filetype == "video") {
	            	$('.multimedia-container').css({
	            		border: 'none',
	            		marginTop: '6px',
	            		padding: '0px',
	            		backgroundColor: 'rgba(0,0,0,0)',
	            	});
	            	createElement('video', {controls: true, preload: "none"}, '.multimedia-container');
	            	createElement('source', {src: URL.createObjectURL(element)}, '.multimedia-container > video');
            	} else {
					createElement('label', {class: 'error'}, '.body-error', 'El archivo nº'+(parseInt(index)+1)+' no cumple la normativa de ficheros');
					return;
            	}
            });
		} else {
			notifyUser('⚠️ Ha ocurrido un problema (Error 404) ⚠️');
		}
	});

	$(document).on('submit', '#new-thread-form', function(event) {
		return NT_validateThreadForm();
	});

	$('.new-thread-rule').click(function(event) {
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
});

function NT_communityData(element) {
	$('.thread-community input:first').val($(element).attr('data-tag'));
	$('.lateral-panel').prepend('<div class="lateral-cube lateral-community-data">');
	createElement('div', {class: 'lateral-title'}, '.lateral-community-data', 'Comunidad');
	createElement('img', {class: 'lateral-community-logo', src: $(element).find('.community-img img').attr('src')}, '.lateral-community-data');
	createElement('b', {class: 'lateral-community-title'}, '.lateral-community-data', $(element).find('.community-data b').text());
	createElement('label', {class: 'lateral-community-tag'}, '.lateral-community-data', $(element).find('.community-data label').text());
	createElement('p', {class: 'lateral-community-description'}, '.lateral-community-data', $(element).attr('data-description'));
	$('.thread-community-container').remove();
}

function NT_getCommunity(element) {
	var input = $(element).val();
	$(element).parent().children('label').remove();
	$('.lateral-community-data').remove();
	$('.thread-community-option-container').empty();
	if ($.trim($(element).val()) != '') {
		$.get('/9bKSmij7MRoNx6ZU9MWFzRe8zPre4klv7L3YxXYZ7Knl8qW5PYn1l3ESgejrV1cE/'+input, function(data) {
			$('.community-div').remove();
			$('.thread-community-container').empty();
			$('.thread-community-container').remove();
			createElement('div', {class: 'thread-community-container'}, '.thread-community');
			if ($.isEmptyObject(data)) {
				createElement('label', {class: 'community-div', style: 'pointer-events: none;'}, '.thread-community-container', 'No se han encontrado resultados');
			} else {
				$("input[name='community']").attr('data-communities', '');
				$.each(data, function(index, val) {
					var prevDataCommunities = $("input[name='community']").attr('data-communities');
					$("input[name='community']").attr('data-communities', prevDataCommunities+','+val.tag);
					// Community Div
						createElement('div', {class: 'community-div', 'data-tag': val.tag, 'data-description': val.description}, '.thread-community-container');
						// Community Div Image
							createElement('div', {class: 'community-img'}, '.community-div:last');
							createElement('img', {src: val.logo}, '.community-img:last');
						// Community Div Data
							createElement('div', {class: 'community-data'}, '.community-div:last');
							createElement('b', null, '.community-data:last', val.title);
							if (val.user_count == 1) {
								createElement('label', null, '.community-data:last', 'c/'+val.tag+' · '+val.user_count+' Miembro');
							} else {
								createElement('label', null, '.community-data:last', 'c/'+val.tag+' · '+val.user_count+' Miembros');
							}
				});
			}
		})
	} else {
		$('.thread-community-container').remove();
		$('.community-div').remove();
	}
}

function NT_pickType(type) {
	if (type == "post") {
		createElement('b', {class: 'input-title'}, '.thread-content', 'Descripción:');
		createElement('b', null, '.thread-content', '* La descripción debe tener un mínimo de 10 carácteres *');
		createElement('div', {class: 'body-error'}, '.thread-content');
		createElement('textarea', {name: 'post', class: 'post-input', placeholder: 'Descripción ...', rows: '10', maxlength: 20000}, '.thread-content');
		createElement('div', {class: 'character-counter'}, '.thread-content');
		createElement('label', null, '.thread-content > .character-counter', '0');
		createElement('label', null, '.thread-content > .character-counter', '/20000');
	} else if (type == "multimedia") {
		createElement('b', {class: 'input-title'}, '.thread-content', 'Archivos:');
		createElement('b', null, '.thread-content', '* Formatos válidos: *');
		createElement('b', null, '.thread-content', '- Imagen: jpg, png, gif, webp');
		createElement('b', null, '.thread-content', '- Vídeo: mp4, webm, ogg');
		createElement('div', {class: 'body-error'}, '.thread-content');
		createElement('input', {type: 'file', name: 'files[]', class: 'multimedia-input', accept: 'image/*, .jpeg, .jpg, .gif, .webp, .png, video/*, video/mp4', multiple: 'true'}, '.thread-content');
		createElement('br', null, '.thread-content');
		createElement('b', {class: 'input-title'}, '.thread-content', 'Leyenda (Opcional):');
		createElement('textarea', {name: 'caption', class: 'post-input', placeholder: 'Leyenda ...', rows: '6'}, '.thread-content');
	} else if (type == "youtube") {
		createElement('b', {class: 'input-title'}, '.thread-content', 'URL:');
		createElement('b', null, '.thread-content', '* Introduce el link completo del vídeo *');
		createElement('b', null, '.thread-content', '* Ejemplo: https://www.youtube.com/watch?v=99pHK7fOEQk&ab_channel=JuanPonce *');
		createElement('div', {class: 'youtube-error'}, '.thread-content');
		createElement('div', {class: 'body-error'}, '.thread-content');
		createElement('input', {type: 'text', class: 'youtube-input', placeholder: 'Introduce un enlace ...'}, '.thread-content');
	} else if (type = "poll") {
		createElement('b', {class: 'input-title'}, '.thread-content', 'Encuesta:');
		createElement('b', null, '.thread-content', '* No pueden haber opciones vacías *');
		createElement('div', {class: 'body-error'}, '.thread-content');
		createElement('div', {class: 'poll-container'}, '.thread-content');
		createElement('div', {class: 'poll-option'}, '.poll-container');
		createElement('input', {name: 'options[]', class: 'poll-input',type: 'text', placeholder: 'Opción 1', maxlength: 50}, '.poll-option:first');
		createElement('div', {class: 'poll-option'}, '.poll-container');
		createElement('input', {name: 'options[]', class: 'poll-input', type: 'text', placeholder: 'Opción 2', maxlength: 50}, '.poll-option:last');
		createElement('button', {class: 'append-option'}, '.thread-content', 'Añadir');
	}
}

function NT_appendPollOption() {
		createElement('div', {class: 'poll-option'}, '.poll-container');
		createElement('input', {name: 'options[]', class: 'poll-input', type: 'text', placeholder: 'Opción '+$('.poll-option').length, maxlength: 50}, '.poll-option:last');
		createElement('button', null, '.poll-option:last', '❌');
	if ($('.poll-option').length >= 10) {
		$('.append-option').css('display', 'none');
	}
	
}

function NT_removePollOption(element) {
	$(element).parent().remove();
	$.each($('.poll-option input'), function(index, val) {
		$(this).attr('placeholder', 'Opción '+(index+1));
	});
	if ($('.poll-option').length <= 10) {
		$('.append-option').css('display', 'block');
	}
}

function NT_appendTag(element) {
	if ($(element).val().length >= 2) {
		createElement('div', {class: 'thread-tag', 'data-tag':  $(element).val().split(",")}, '.tags-container', $(element).val().split(","));
		createElement('label', {class: 'thread-tag-remove'}, '.thread-tag:last', '❌');
		$(element).val(null);	
	}
}

function NT_removeTag(element) {
	$(element).parent().remove();
}

function NT_appendYoutube(embed_id) {
	$('.youtube-preview').remove();
	createElement('div', {class: 'youtube-preview'}, '.thread-content');
	createElement('b', {class: 'input-title'}, '.youtube-preview', 'Preview:');
	createElement('iframe', {src: 'https://www.youtube.com/embed/'+embed_id, frameborder: 0, allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture', allowfullscreen: true}, '.youtube-preview');
}

function NT_validateThreadForm() {
	$('.error').remove();
	var ISSUE_COUNT = 0;
	// THREAD COMMUNITY
		var community = $("input[name='community']").val();
		var communities = $("input[name='community']").attr('data-communities').split(',');
		if (community.trim()) {
			if (!communities.includes(community)) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.community-error', 'Esta comunidad no existe o no está disponible');
			}
		} else {
			ISSUE_COUNT++;
			createElement('label', {class: 'error'}, '.community-error', 'Campo vacío (Comunidad)');
		}
	// THREAD TITLE
		var title = $("input[name='title']").val();
		if (title.trim()) {
			if (title.trim().length < 3) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.title-error', 'El título no respeta la longitud mínima permitida (3 carácteres)');	
			}
			if (title.trim().length > 300) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.title-error', 'El título excede la longitud máxima permitida (300 carácteres)');		
			}
		} else {
			ISSUE_COUNT++;
			createElement('label', {class: 'error'}, '.title-error', 'Campo vacío (Título)');
		}
	// THREAD TYPE
		var type = $("input[name='type']").val();
		var types = ["post", "multimedia", "youtube", "poll"];
		if (!types.includes(type)) {
			ISSUE_COUNT++;
			createElement('label', {class: 'error'}, '.type-error', 'Debes seleccionar un formato de tema válido (Post, Multimedia, Youtube o Encuesta)');	
		}
	// THREAD BODY
		if (type === "post") { // POST
			var body = $("textarea[name='post']").val();
			if (body.trim().length === 0) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'Campo vacío (Descripción)');			
			} else if (body.trim().length < 10) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'La descripción del tema debe tener al menos 10 carácteres');			
			} else if (body.trim().length > 20000) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'La descripción excede el límite de carácteres (Máx: 30.000)');			
			}
		} else if (type === "multimedia") { // MULTIMEDIA
			var files = $(".multimedia-input").get(0).files;
			var caption = $("input[name='caption']");
			if (files.length === 0) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'No has seleccionado ningún archivo');
			}
			for (var i = 0; i < $(".multimedia-input").get(0).files.length; i++) {
				var media = $(".multimedia-input").get(0).files[i];
				var allowedFiletypes = ["video/mp4", "video/ogg", "video/webm", "image/gif", "image/png", "image/jpg", "image/jpeg", "image/bmp", "image/webp"];
				if (!allowedFiletypes.includes(media.type)) {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.body-error', 'El archivo nº'+(parseInt(i)+1)+' no cumple con la normativo de ficheros');
					break;
				} else {
					if (media.type.split("/")[0] === "image" && media.size/1024 > 2048) {
						ISSUE_COUNT++;
						createElement('label', {class: 'error'}, '.body-error', 'El archivo nº'+(parseInt(i)+1)+' excede el tamaño máximo para imágenes (2 Mb)');
						break;
					}
					if (media.type.split("/")[0] === "video" && media.size/1024 > 20480) {
						ISSUE_COUNT++;
						createElement('label', {class: 'error'}, '.body-error', 'El archivo nº'+(parseInt(i)+1)+' excede el tamaño máximo para vídeos (20 Mb)');
						break;
					}
				}
			}
		} else if (type === "youtube") { // YOUTUBE
			$("input[name='link']").remove();
			var youtubeInput = $(".youtube-input").val();
			if (youtubeInput.trim()) {
				var url = youtubeInput.split("?v=");
				var youtubeRef = ["https://m.youtube.com/watch", "https://www.youtube.com/watch"];
				if (youtubeRef.includes(url[0])) {
					var embed_id = url[1].replace($(".youtube-input").val().split("&ab")[1], '').replace('&ab','');
					if (embed_id.length != 11) {
						ISSUE_COUNT++;
						createElement('label', {class: 'error'}, '.body-error', 'La URL seleccionada no es válida');
					} else {
						createElement('input', {type: 'hidden', name: 'link', value: embed_id}, '.thread-content');
					}
				} else {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.body-error', 'La URL seleccionada no es válida');
				}
			} else {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'Campo vacío (URL)');
			}
		} else if (type === "poll") {
			var pollOptions = $(".poll-input");
			if (pollOptions.length < 2) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'Se requieren mínimo dos (2) opciones');	
			} else if (pollOptions.length > 10) {
				ISSUE_COUNT++;
				createElement('label', {class: 'error'}, '.body-error', 'Se ha excedido el límite de opciones (10)');
			} else {
				if (pollOptions.length >= 2) {
					$.each(pollOptions, function(index, val) {
						var optionLength = $(this).val().length
						if (optionLength === 0) {
							ISSUE_COUNT++;
							createElement('label', {class: 'error'}, '.body-error', 'Una o más opciones estan vacías');				
							return false;
						} else {
							if ($(this).val().trim()) {
								if (optionLength === 0) {
									ISSUE_COUNT++;
									createElement('label', {class: 'error'}, '.body-error', 'Una o más opciones estan vacías');				
									return false;
								} else if (optionLength > 50) {
									ISSUE_COUNT++;
									createElement('label', {class: 'error'}, '.body-error', 'La opción nº'+(parseInt(index)+1)+' excede el límite de longitud (50 carácteres)');				
									return false;
								}
							}
						}
						
					});
				}
			}
		}
	// THREAD TAGS
		$('.thread-tags input[name="tags[]"]').remove();
		var tags = $('.thread-tag');
		if (tags.length < 3) {
			ISSUE_COUNT++;
			createElement('label', {class: 'error'}, '.tags-error', 'Es necesario ingresar un mínimo de 3 tags');		
			return false;
		} else if (tags.length > 20) {
			ISSUE_COUNT++;
			createElement('label', {class: 'error'}, '.tags-error', 'Se ha excedido el límite de tags (20)');
			return false;
		} else {
			$.each(tags, function(index, val) {
				var tag = $(this).attr('data-tag');
				if (tag.length < 2) {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.tags-error', 'La longitud del tag nº'+(parseInt(index)+1)+' es inferior a 3 carácteres');
				} else if (tag.length > 20) {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.tags-error', 'El tag nº'+(parseInt(index)+1)+' supera el límite de 20 carácteres');
				}
				if (!tag.match(/^[0-9a-zA-Z]+$/)) {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.tags-error', 'El tag nº'+(parseInt(index)+1)+' no es alfanumérico (Sólo letras y números)');	
				}
				createElement('input', {type: 'hidden', name: 'tags[]', value: tag}, '.thread-tags');
			});
			var duplicatedTag = []
			for (var i = 0; i < tags.length; i++) {
				if (duplicatedTag.includes($(tags[i]).attr('data-tag'))) {
					ISSUE_COUNT++;
					createElement('label', {class: 'error'}, '.tags-error', 'No se permiten tags duplicados ('+$(tags[i]).attr('data-tag')+')');
					break;
				} else {
					duplicatedTag.push($(tags[i]).attr('data-tag'));
				}
			}
		}	
	if (ISSUE_COUNT > 0) {
		return false;
	}
	return true;
}