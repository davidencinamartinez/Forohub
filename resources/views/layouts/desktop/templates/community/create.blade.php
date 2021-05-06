@extends('layouts.desktop.main')

@section('title', 'Crear Comunidad - Forohub')

@section('description', 'Aquí podrás crear tu propia comunidad, basándola en unos intereses concretos, y atraer a usuarios para hacerla crecer día a día')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/new_community.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/newcommunity.js"></script>
@endpush
@section('body')
<div class="index-panel">
    <div style="width: 10%;"></div>
    <div class="threads-panel">
    	<div class="new-community-container">
	    	<div class="new-community-title">Crear Comunidad</div>
	        <form method="POST" id="new-community-form" action="/aLzEAm3NB3BelFXWhNnPm7lt4enHzGFu0f64eX6Yt7ExAqkRWmnUQspibxZN5UkX" enctype="multipart/form-data" autocomplete="off">
	        	@csrf
		        <div class="new-community">
		        	<div style="text-align: center; margin-top: 0px !important;">
		        		<b>* Antes de crear una comunidad, asegúrate de cumplir con la <a href="/normativa">normativa de creación de comunidades</a> *</b>
		        	</div>
		        	<div class="community-title">
		        		<b class="input-title">Nombre:</b>
		        		<br>
		        		<b>* El nombre debe tener un mínimo de 3 carácteres *</b>
		        		<div class="name-error"></div>
		        		<input type="search" name="name" maxlength="50" placeholder="Nombre de la comunidad ...">
		        		<div class="character-counter">
		        			<label>0</label>
		        			<label>/50</label>
		        		</div>
		        	</div>
		        	<div class="community-label">
		        		<b class="input-title">Etiqueta:</b>
		        		<div class="tag-error"></div>
		        		<b>* La etiqueta debe tener un mínimo de 3 carácteres *</b>
		        		<input type="search" name="tag" maxlength="30" placeholder="Tag de la comunidad ...">
		        		<div class="character-counter">
		        			<label>0</label>
		        			<label>/30</label>
		        		</div>
		        	</div>
	        		<div class="community-description">
	        			<b class="input-title">Descripción:</b>
	        			<div class="description-error"></div>
	        			<b>* La descripción debe tener un mínimo de 3 carácteres *</b>
	        			<textarea name="description" class="post-input" placeholder="Descripción ..." rows="6" maxlength="500"></textarea>
	        			<div class="character-counter">
	        				<label>0</label>
		        			<label>/500</label>
		        		</div>
	        		</div>
		        	<div class="community-tags">
		        		<b class="input-title">Tags:</b>
		        		<div class="tags-error"></div>
		        		<b>* Para añadir tags, es necesario separarlos por comas (,) *</b>
		        		<b>* La longitud mínima del tag es de 2 carácteres *</b>
		        		<input type="text" placeholder="Tags ..." maxlength="20">
		        		<div class="tags-container"></div>
		        	</div>
		        	<div class="community-buttons">
		        		<button class="new-community-submit" type="submit">Crear Comunidad</button>
		        		<button class="new-community-exit">Volver</button>
		        	</div>
		        </div>
	        </form>
	    </div>
    </div>
    <div class="lateral-panel">
		<div class="lateral-cube">
			<div class="lateral-title">Antes de empezar</div>
			<div class="new-community-rule">Qué propósito tendrá la comunidad?<label>▼</label>
				<div class="rule-description">Las comunidades pueden variar en tamaño desde un puñado de suscriptores hasta millones, proporcionando a los usuarios un lugar para discutir sobre cualquier interés. Ya sea que la nueva comunidad exista como novedad, sirva a un pequeño grupo de lugareños o se concentre en grandes intereses comunes que puedan atraer a miles de miembros del foro, conocer su propósito puede ayudar a determinar qué reglas básicas establecer y hacer que la comunidad prospere</div>
			</div>
			<div class="new-community-rule">Existe ya una comunidad similar?<label>▼</label>
				<div class="rule-description">Es posible que descubras que la comunidad que querías crear ya existe. Está bien crear tu propia comunidad, incluso si el tema es similar a otros. Si existe una comunidad idéntica, podrías considerar unirte a ella, ser un participante activo en la comunidad y luego ofrecerte como moderador. Esto puede permitir que tus ideas y esfuerzos tengan un impacto inmediato para un grupo establecido de suscriptores</div>
			</div>
			<div class="new-community-rule">Moderarás activamente la comunidad?<label>▼</label>
				<div class="rule-description">Es importante estar dispuesto a moderar cualquier comunidad que planees crear. Esto ayuda a garantizar su buena reputación si se tiene algún problema con el <b>spam</b> u otro <b>contenido que rompa las reglas</b> del foro dentro de tu comunidad. Si tienes una gran idea para una nueva comunidad, pero te faltan recursos o no estás familiarizado con la moderación, querrás planificar la adición de moderadores en un futuro cercano para ayudar a que tu comunidad prospere. Ten en cuenta que cualquier problema con la comunidad, será únicamente responsabilidad tuya y del equipo de moderación, no de Forohub</div>
			</div>
		</div>
		@include('layouts.desktop.templates.lateral.lateral_help_center')
    </div>
</div>
@endsection