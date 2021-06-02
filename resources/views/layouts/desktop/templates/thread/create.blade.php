@extends('layouts.desktop.main')

@section('title', 'Crear Tema - Forohub')

@section('description', 'Aquí podrás crear un tema, ya sea para resolver inquietudes que tengas, o abrir un debate con el resto de usuarios de la plataforma de Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/B7o87L2YkZdnuQkqz68BKA35j2mc0OLjT86jSOrps19DHKjTHCVjMrjaQCpz7m6k.css">
    <link rel="stylesheet" type="text/css" href="/css/q4qRRTPxmFxmP4XImrbCE0RV5M6g1zxkeabuZbe8f3SMElclqBrqZwkuHEHzTEIo.css">
    <link rel="stylesheet" type="text/css" href="/css/lMCdpjFSu5vMoCSIeycbdokrQqWyPZNLmvjARCwXWC4bkKQCg4BWhlpTQ1gqxMPI.css">
    <link rel="stylesheet" type="text/css" href="/css/8AE3kMi5LgMMKoboN0dEZF8aHTmAeZ1xmReLDBB2cJd4ytvHNPlzfT0m3SI5lH40.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/newthread.js"></script>
@endpush
@section('body')
<div class="index-panel">
    <div style="width: 10%;"></div>
    <div class="threads-panel">
    	<div class="new-thread-container">
	    	<div class="new-thread-title">Crear Tema</div>
	        <form method="POST" id="new-thread-form" action="/aLzEAm3NB3BelFXWhNnPm7lt4enHzGFu0f64eX6Yt7ExAqkRWmnUQspibxZN5UkX" enctype="multipart/form-data" autocomplete="off">
	        	@csrf
		        <div class="new-thread">
		        	<div style="text-align: center;">
		        		<b>* Antes de crear cualquier tema, asegúrate de que cumpla con la <a href="/normativa">normativa de creación de temas</a> *</b>
		        	</div>
		        	<div class="thread-community">
		        		<b class="input-title">Comunidad:</b>
		        		<br>
		        		<b>* Escribe el tag de la comunidad *</b>
		        		<div class="community-error"></div>
		        		<input type="search" name="community" data-communities="" placeholder="Selecciona una comunidad ...">
		        	</div>
		        	<div class="thread-title">
		        		<b class="input-title">Título:</b>
		        		<br>
		        		<b>* El título debe tener un mínimo de 3 carácteres *</b>
		        		<div class="title-error"></div>
		        		<input name="title" maxlength="300" placeholder="Introduce un título ...">
		        		<div class="character-counter">
		        			<label>0</label>
		        			<label>/300</label>
		        		</div>
		        	</div>
		        	<div class="thread-type">
		        		<b class="input-title">Tipo:</b>
		        		<br>
		        		<b>* Selecciona una de las opciones *</b>
		        		<div class="type-error"></div>
		        		<input type="hidden" id="type" name="type" value="post">
		        		<div class="thread-type-select">
			        		<div class="thread-type-option active" data-type="post">📝 Post</div>
			        		<div class="thread-type-option" data-type="multimedia">📷 Multimedia</div>
			        		<div class="thread-type-option" data-type="youtube">
			        			<label>►</label> Youtube</div>
			        		<div class="thread-type-option" data-type="poll">📊 Encuesta</div>
			        	</div>
		        	</div>
	        		<div class="thread-content">
	        			<b class="input-title">Descripción:</b>
	        			<b>* La descripción debe tener un mínimo de 10 carácteres *</b>
	        			<div class="body-error"></div>
	        			<textarea name="post" class="post-input" placeholder="Descripción ..." rows="10" maxlength="20000"></textarea>
	        			<div class="character-counter">
	        				<label>0</label>
		        			<label>/20000</label>
		        		</div>
	        		</div>
		        	<div class="thread-options">
		        		<b class="input-title">Opciones:</b>
		        		<div>
		        			<input type="checkbox" name="check_important">
		        			<b for="check_important">📑 Tema Serio</b>
		        			<label title="Tema Serio:&#13;&#10;Tema para tratar de forma seria y donde los mensajes recibidos deban ser coherentes y relacionadas con el sujeto especificado">?</label>
		        		</div>
		        		<div>
		        			<input type="checkbox" name="check_nsfw">
		        			<b for="check_nsfw">🔞 NSFW</b>
		        			<label title="NSFW (Not Safe For Work):&#13;&#10;Tema con contenido o imágenes sólo para adultos u otras características que no sean convenientes para la visualización por parte de menores de edad">?</label>
		        		</div>
		        		<div>
		        			<input type="checkbox" name="check_spoiler">
		        			<b for="check_spoiler">💥 Spoiler</b>
		        			<label title='Spoiler:&#13;&#10;Tema el cuál contiene Spoilers. Revela o adelanta información que se ignora sobre la trama de un sujeto (cine, videojuegos, series, libros ...), por ende, arruinando el suspense o la sorpresa final'>?</label>

		        		</div>
		        	</div>
		        	<div class="thread-tags">
		        		<b class="input-title">Tags:</b>
		        		<b>* Para añadir tags, es necesario separarlos por comas (,) *</b>
		        		<b>* La longitud mínima del tag es de 2 carácteres *</b>
		        		<div class="tags-error"></div>
		        		<input type="text" placeholder="Tags ..." maxlength="20">
		        		<div class="tags-container"></div>
		        	</div>
		        	<div class="thread-buttons">
		        		<button class="new-thread-submit" type="submit">Crear Tema</button>
		        		<button class="new-thread-exit">Volver</button>
		        	</div>
		        </div>
	        </form>
	    </div>
    </div>
    <div class="lateral-panel">
		<div class="lateral-cube">
			<div class="lateral-title">Antes de empezar</div>
			<div class="new-thread-rule">Has usado el buscador?<label>▼</label>
				<div class="rule-description">Antes de crear un tema, podrías u/o deberías asegurarte de si este existe o haya quizá alguno que se le parezca, para así ahorrarte tiempo esperando respuestas y resolver tus dudas (si las tienes)</div>
			</div>
			<div class="new-thread-rule">No hagas Spam<label>▼</label>
				<div class="rule-description">Hacer Spam no es una conducta correcta en el foro. Por lo cuál, comportará la expulsión (baneo) temporal o permanente de la cuenta</div>
			</div>
			<div class="new-thread-rule">Publicidad y actividades comerciales<label>▼</label>
				<div class="rule-description">Estará terminantemente prohibido crear un tema con fines comerciales como:
					<dl>
						<li>Solicitar u ofrecer servicios comerciales</li>
						<li>Compra-venta o intercambios (trueques)</li>
						<li>Publicidad y/o enlaces de páginas personales o comerciales, sean con ánimo de lucro o no.</li>
					</dl>
					Forohub no se hará responsable de ningún comportamiento u acción ajena a la normativa
				</div>
			</div>
			<div class="new-thread-rule">Escoge correctamente la comunidad<label>▼</label>
				<div class="rule-description">Al crear un tema, es importante escoger correctamente la comunidad donde este se encontrará. Si el sujeto del tema no se corresponde con los deseos de la comunidad donde se encuentre, los moderadores de la comunidad podrán cerrar u/o borrar el tema</div>
			</div>
			<div class="new-thread-rule">Usa las opciones<label>▼</label>
				<div class="rule-description">Al crear un tema, puedes establecer ciertas opciones en función del contenido. Por ejemplo, si el tema es para adultos, se usará la etiqueta <b>NSFW</b>. Si el tema requiere de una atención seria por parte de los usuarios, se usará la etiqueta <b>Tema Serio</b>. Por último, si el tema contiene información sensible y que no debería ser visible a simple vista, se usará la etiqueta <b>Spoiler</b></div>
			</div>
		</div>
		@include('layouts.desktop.templates.lateral.lateral_help_center')
    </div>
</div>
@endsection