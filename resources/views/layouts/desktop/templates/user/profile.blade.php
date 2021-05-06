@extends('layouts.desktop.main')

@section('title', $data->name.' - Forohub')

@section('description', $meta_description)

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/misc_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/user.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/profile_actions.js"></script>
@endpush
@section('body')
	<div class="index-panel">
	    <div style="width: 10%"></div>
	    <div class="threads-panel">
	    	@if (Auth::check() && Auth::user()->id == $data->id)
	    	<div class="profile-configuration">
				<div class="profile-configuration-title">Configuración</div>
	    	    <div class="profile-configuration-data">
	    	    	<div>
		        		<h4 class="input-title">Fecha de registro: <label class="user-register-date" style="text-transform: capitalize;">{{ Auth::user()->created_at }}</label></h4>
		        	</div>
	    	    	<div class="profile-configuration-set configuration-password">
	    	    		<div>
			        		<b class="input-title">Contraseña: </b>
			        		<label style="margin-left: 10px;">**********</label>
			        		<img class="edit-element" src="/src/media/edit_icon.webp">
			        		<div class="configuration-password-panel configuration-panel">
			        			<h3>Cambiar contraseña</h3>
			        			<div class="old-password">
			        				<b>Contraseña actual:</b>
			        				<input type="password" class="form-input" placeholder="Contraseña actual" autocomplete="off" maxlength="64">
			        				<div class="character-counter">
			        					<label>0</label>
			        					<label>/64</label>
			        				</div>
			        			</div>
			        			<div class="new-password">
			        				<b>Nueva contraseña:</b>
			        				<input type="password" class="form-input" placeholder="Nueva contraseña" autocomplete="off" maxlength="64">
			        				<div class="character-counter">
			        					<label>0</label>
			        					<label>/64</label>
			        				</div>
			        			</div>
			        			<button class="configuration-update-password">Actualizar</button></div>
		        		</div>
		        	</div>
		        	<div class="profile-configuration-set configuration-title">
		        		<div>
			        		<b class="input-title">Título: </b>
			        		<label style="margin-left: 10px;">{{ Auth::user()->about }}</label>
			        		<img class="edit-element" src="/src/media/edit_icon.webp">
			        		<div class="configuration-title-panel configuration-panel">
			        			<h3>Modificar título</h3>
			        			<div class="new-title">
			        				<b>Nuevo título:</b>
			        				<input type="search" class="form-input" placeholder="Título" autocomplete="off" maxlength="40">
			        				<div class="character-counter">
			        					<label>0</label>
			        					<label>/40</label>
			        				</div>
			        			</div>
			        			<button class="configuration-update-title">Actualizar</button>
			        		</div>
		        		</div>
		        	</div>
	    	    </div>
	    	</div>
	    	@endif
	    	@if ($threads->isNotEmpty())
			    @foreach ($threads as $thread)
			        @include('layouts.desktop.templates.thread.content')
			    @endforeach
			@else
				<h3>Este usuario no ha creado ningún tema todavía</h3>
			@endif
		</div>
	    <div class="lateral-panel">
	    	<div class="lateral-cube">
	            <div class="lateral-title">Perfil</div>
	            <div class="profile-cube">
	            	<img src="{{ $data->avatar }}">
	            	<div>
	            		<b>{{ $data->name }}</b>
	            		<i>{{ $data->about }}</i>
	            	</div>
	            </div>
	        </div>
	        @if (Auth::check() && Auth::user()->id == $data->id)
	        <div class="lateral-cube user-actions">
	            <div class="lateral-title">Acciones</div>
	            <div class="profile-panel-buttons">
	            	<button class="profile-configuration-trigger">Configuración</button>
	            	<button>Suscripciones</button>
	            	<button class="profile-dark-theme">Tema Oscuro</button>
	        	</div>
	        </div>
	        @endif
	        <div class="lateral-cube">
	            <div class="lateral-title">Estadísticas</div>
            	<div class="profile-stats-cube">
            		<div title="Karma">
    		        	<img src="/src/media/wVgT7mQbXswj1sh0fK9zmMdMAz0JM8zQh2kgd8lS5tFi7WEqgg2HSDAI9IO7EUAv.png">
    		            <b>{{ $data->karma }}</b>
    		        </div>
    		        <div title="Mensajes">
			            <img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png">
			            <b>{{ $data->messages_count }}</b>
			        </div>
			        <div title="Temas">
			            <img src="/src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png">
			            <b>{{ $data->threads_count }}</b>
			        </div>
			        <div title="Votos Positivos">
			            <img src="/src/media/nAiEBnmyVoFYNBhtaIw8mIXoMmNaxQLOiayJ9FM0PhVQiGJ6adiTUFj4IqidT560.png">
			            <b>{{ $data->upvotes }}</b>
			        </div>
			        <div title="Votos Negativos">
			            <img src="/src/media/a7Vc4igYwqdHCM2UtoSinG5qTZCk9pD6mOT3sul7bl7OJq26ZN0qf7BPxD7KYklW.png">
			            <b>{{ $data->downvotes }}</b>
			        </div>
			        <div title="Posición en el Ranking">
			            <img src="/src/media/cjnMbZ9bq1KbMhr4JnxQOCI6rPsGI2rQ2P83jM3jVKlZdC7tHEChyBGnY6U3tL8b.png">
			            <b>{{ $data->placing }}</b>
			        </div>
            	</div>
	        </div>
	        @if ($rewards->isNotEmpty())
	        <div class="lateral-cube">
	            <div class="lateral-title">Logros</div>
            	<div class="profile-rewards-text">
            		<b>Aquí podrás ver los últimos logros del usuario</b>
            		<label>Desliza el cursor sobre el logro para obtener más información</label>
            	</div>
	            <div class="profile-cube profile-rewards-cube">
	            	@foreach ($rewards as $user_reward)
	            	<img src="/src/rewards/{{ $user_reward->reward->filename }}" data-title="{{ $user_reward->reward->name }}" data-description="{{ $user_reward->reward->text }}">
	            	@endforeach
	            </div>
	        </div>
	        @endif
	        @include('layouts.desktop.templates.lateral.lateral_help_center')
	    </div>
	</div>
	@if ($threads->hasPages())
	    <div style="text-align: center;">
	        <div class="pageSelector">
	            {!!$threads->links()!!}
	        </div>
	    </div>
	@endif
@endsection