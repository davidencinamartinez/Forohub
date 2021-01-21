@extends('layouts.desktop.main')

@section('title', 'Crear Tema - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/new_thread.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/newthread.js"></script>
@endpush
@section('body')
<div class="index-panel">
    <div style="width: 10%;"></div>
    <div class="threads-panel">
        <form method="POST" id="new-thread-form" action="/aLzEAm3NB3BelFXWhNnPm7lt4enHzGFu0f64eX6Yt7ExAqkRWmnUQspibxZN5UkX" enctype="multipart/form-data" autocomplete="off">
        	@csrf
	        <div class="new-thread">
	        	<h1>Crear Tema</h1>
	        	<div style="text-align: center;">
	        		<b>* Antes de crear cualquier tema, asegúrate de que cumpla con la <a href="/normativa">normativa de creación de temas</a> *</b>
	        	</div>
	        	<div class="thread-community">
	        		<b class="input-title">Comunidad:</b>
	        		<div class="community-error"></div>
	        		<input type="search" name="community" data-communities="" placeholder="Selecciona una comunidad ...">
	        	</div>
	        	<div class="thread-title">
	        		<b class="input-title">Título:</b>
	        		<div class="title-error"></div>
	        		<input name="title" maxlength="300" placeholder="Introduce un título ...">
	        		<div class="character-counter">
	        			<label>0</label>
	        			<label>/300</label>
	        		</div>
	        	</div>
	        	<div class="thread-type">
	        		<b class="input-title">Tipo:</b>
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
	        			<label title="Tema Serio:&#13;&#10;Tema para tratar de forma seria y donde las respuestas sean coherentes y relacionadas con el sujeto especificado">?</label>
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
	        		<div class="tags-error"></div>
	        		<b>* Para añadir tags, es necesario separarlos por comas (,) *</b>
	        		<b>* La longitud mínima del tag es de 3 carácteres *</b>
	        		<input type="text" placeholder="Tags ..." maxlength="20">
	        		<div class="tags-container"></div>
	        	</div>
	        	<div class="thread-buttons">
	        		<button class="new-thread-submit" type="submit">Crear Tema</button>
	        		<button class="new-thread-exit">Volver</button>
	        		<button class="esteboton">click</button>
	        	</div>
	        </div>
        </form>
    </div>
    <div class="lateral-panel">
       
    </div>
</div>
@endsection