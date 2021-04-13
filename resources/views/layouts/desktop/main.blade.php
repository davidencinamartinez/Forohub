<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset='utf-8'>
	<meta name="description" content="@yield('description')">
	@if ($unread_notifications)
		<title>({{ $unread_notifications }}) @yield('title')</title>
	@else
		<title>@yield('title')</title>
	@endif
	<link rel='shortcut icon' type='image/png' href='/src/media/favicon.png'>
		<link rel='stylesheet' type='text/css' href='{{ asset("/css/desktop/min.css") }}'>
		<link rel='stylesheet' type='text/css' href='{{ asset("/css/desktop/header.css") }}'>
		<link rel='stylesheet' type='text/css' href='{{ asset("/css/desktop/footer.css") }}'>
		<link rel='stylesheet' type='text/css' href='{{ asset("/css/desktop/modal.css") }}'>
		<link rel='stylesheet' type='text/css' href='{{ asset("/css/desktop/classes.css") }}'>
	@stack('styles')
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" src="/js/moment_js/moment.js"></script>
		<script type="text/javascript" src="/js/moment_js/es.js"></script>
		<!--
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>
		-->
		@if (Auth::check())
		<script src='{{ asset("/js/authenticated.js") }}'></script>
		@else
		<script src='{{ asset("/js/non_authenticated.js") }}'></script>
		@endif
		<script src='{{ asset("/js/scriptsheet.js") }}'></script>
		<meta content="{{ csrf_token() }}" name="csrf-token" />
	@stack('scripts')
</head>
<body>
	<div class='header'>
		<a href="/">
			<img class='forohub-logo' src='/src/media/logo_white.webp' alt='forohub_logo' title='Forohub' clickeable>
		</a>
		<div class='user-login'>
			@if (Auth::check())
				<div class='user-header-panel'>
					<img class='user-avatar' src='{{ Auth::user()->avatar }}'>
					@if ($unread_notifications)
						@if ($unread_notifications > 9)
							<div class="user-unread-notifications">9+</div>
						@else
							<div class="user-unread-notifications">{{ $unread_notifications }}</div>
						@endif
					@endif
					<span class='user-welcome'>
						<b>{{ Auth::user()->name }}</b>
						<br>
						<label>{{ Auth::user()->about }}</b>
					</span>
					<br>
					<br>
					<div class='user-buttons' style='text-align: center; display: inline-block;'>
						<a class="user-profile" href="/u/{{ strtolower(Auth::user()->name) }}">
					  		<button>Mi Perfil</button>
					  	</a>
					  	<button id="user-rewards">Logros</button>
					  	<button id="user-notifications">Notificaciones</button>
						<form id="logout-form" action="<?php echo e(route('logout')); ?>" style="float: right;" method="POST">
							{{ csrf_field() }}
					 		<button type="submit" style="margin-left: 4px;">Salir</button>
						</form>
					</div>
				</div>
			@else
				<form action="{{ route('login') }}" method='POST'>
					@csrf
					<input type='text' name='name' maxlength='20' title='Usuario' placeholder='Usuario'>
					<input type='password' name='password' title='Contraseña' placeholder='Contraseña'>
					<button type='submit' title='Entrar'>Entrar</button>
				</form>
				<span class="register-label">
					<b>Has olvidado tu contraseña?
						<a style="color: #FFB600; cursor: pointer;" onclick="registerModal()">Click aquí</a>
					</b>
				</span>
				<br>
				<span class="register-label">
					<b>No tienes cuenta?
						<a style="color: #FFB600; cursor: pointer;" onclick="registerModal()">Regístrate</a>
					</b>
				</span>
				@if(session()->has('err'))
					<br>
					<p class="error" style="display: contents">{{session('err')}}</p>
				@endif
				<br>
			@endif
		</div>
		<div class='navigation-bar'>
			<div style="float: left;">
				<a href='/' title='Inicio'>Inicio</a>
				<a href='/destacados' id='forumEntry' title='Destacados'>Destacados</a>
				<a href='/tops/semana' title='Tops'>Tops</a>
				<a href='/comunidades/' title='Comunidades'>Comunidades</a>
			</div>
			<div style="float: right;">
				<div class="search-bar">
					<input class='search-input' type='search' name='search' placeholder='Buscar...' autocomplete='off'>
					<button class="search-button">
						<img src="/src/media/search.png">
					</button>
					
				</div>
			</div>
		</div>
	</div>
	@section('body')
    @show
    <div class="notification-bar"></div>
    <div class='footer'>
        <div class='social-network'>
            <a href='https://twitter.com/forohub' target='_blank' title='Twitter'><img src='/src/media/tw_logo.webp' alt='twitter_logo'></a>
            <a href='https://www.facebook.com/forohub/' target='_blank' title='Facebook'><img src='/src/media/fb_logo.webp' alt='facebook_logo'></a>
            <a href='https://www.instagram.com/_u/viboxx/' target='_blank' title='Instagram'><img src='/src/media/ig_logo.webp' alt='instagram_logo'></a>
        </div>
        <div class='info'>
        	|
        	<a href='/stats'>Estadísticas</a>
        	|
        	<a href='/stats'>Actualizaciones</a>
        	|
        	<a href='/thread/3'>FAQ</a>
        	|
        	<a href='/contact'>Contacto</a>
        	|
        </div>
    </div>  
</body>
</html>