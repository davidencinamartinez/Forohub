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
        <form method="POST">
	        <div class="new-thread">
	        	<h1>Crear Tema</h1>
	        	<div style="text-align: center;">
	        		<b>* Antes de crear cualquier tema, asegúrate de que cumpla con la <a href="/normativa">normativa de creación de temas</a> *</b>
	        	</div>
	        	<div class="thread-community">
	        		<b class="input-title">Comunidad:</b>
	        		<input type="search" name="community" placeholder="Selecciona una comunidad ...">
	        	</div>
	        	<div class="thread-title">
	        		<b class="input-title">Título:</b>
	        		<textarea name="title" maxlength="300" placeholder="Introduce un título ..." oninput="this.style.height = this.scrollHeight+'px';"></textarea>
	        		<div class="character-counter">
	        			<label>0</label>
	        			<label>/300</label>
	        		</div>
	        	</div>
	        	<div class="thread-type">
	        		<b class="input-title">Tipo:</b>
	        		<input type="hidden" id="type" name="type">
	        		<div>
		        		<div class="thread-type-option" data-type="post">📝 Post</div>
		        		<div class="thread-type-option" data-type="multimedia">📷 Multimedia</div>
		        		<div class="thread-type-option" data-type="link">🔗 Enlace</div>
		        		<div class="thread-type-option" data-type="poll">🧮 Encuesta</div>
		        	</div>
	        	</div>
        		<div class="thread-content">
	        		
	        	</div>
	        	<div class="thread-options">
	        		<b class="input-title">Opciones:</b>
	        		<div>
	        			<input type="checkbox" id="vehicle1" name="important">
	        			<b for="vehicle1">📑 Tema Serio</b>
	        			<label title="Tema Serio:&#13;&#10;Tema para tratar de forma seria y donde las respuestas sean coherentes y relacionadas con el sujeto especificado">?</label>
	        		</div>
	        		<div>
	        			<input type="checkbox" id="vehicle1" name="important">
	        			<b for="vehicle1">🔞 NSFW</b>
	        			<label title="NSFW (Not Safe For Work):&#13;&#10;Tema con contenido o imágenes sólo para adultos u otras características que no sean convenientes para la visualización por parte de menores de edad">?</label>
	        		</div>
	        		<div>
	        			<input type="checkbox" id="vehicle1" name="important">
	        			<b for="vehicle1">💥 Spoiler</b>
	        			<label title='Spoiler:&#13;&#10;Tema el cuál contiene Spoilers. Revela o adelanta información que se ignora sobre la trama de un sujeto (cine, videojuegos, series, libros ...), por ende, arruinando el suspense o la sorpresa final'>?</label>

	        		</div>
	        	</div>
	        	<div class="thread-tags">
	        		<b class="input-title">Tags:</b>
	        		<input type="text" name="community" placeholder="Tags ...">
	        	</div>
	        	<div class="thread-buttons">
	        		<button class="new-thread-submit" type="submit">Crear Tema</button>
	        		<button class="new-thread-exit">Volver</button>
	        	</div>
	        </div>
        </form>
    </div>
    <div class="lateral-panel">
       
    </div>
</div>
@endsection