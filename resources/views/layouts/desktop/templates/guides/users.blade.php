@extends('layouts.desktop.main')

@section('title', 'Guía de usuarios - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/guides.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/guides.js"></script>
@endpush
@section('body')
	<script type="text/javascript">
		console.log({!!$data!!})
	</script>
	@include('layouts.desktop.templates.guides.guide_selection')
	@if($data->isEmpty())
		<h2 style="text-align: center;">No se han encontrado resultados</h2>
	@else
	<div class="communities">
		@foreach ($data as $user)
		<a href="/u/{{ strtolower($user->name) }}">
			<div class="community">
				<div class="community-logo">
					<img src="{{ $user->avatar }}">
				</div>
				<div class="community-data">
					<b>{{ $user->name }}</b>
					<i>u/{{ strtolower($user->name) }}</i>
					<label>Fecha de registro: <label class="community-date">{{ $user->created_at }}</label></label>
				</div>
				<div class="community-stats">
			        <div title="Karma">
			            <img src="/src/media/wVgT7mQbXswj1sh0fK9zmMdMAz0JM8zQh2kgd8lS5tFi7WEqgg2HSDAI9IO7EUAv.png">
			            <b>{{ $user->karma }}</b>
			        </div>
			        <div title="Mensajes">
			            <img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png">
			            <b>{{ $user->messages_count }}</b>
			        </div>
			        <div title="Temas">
			            <img src="/src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png">
			            <b>{{ $user->threads_count }}</b>
			        </div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
	@endif
@endsection