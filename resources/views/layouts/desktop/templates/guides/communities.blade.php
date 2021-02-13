@extends('layouts.desktop.main')

@section('title', 'Guía de comunidades - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/guides.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/guides.js"></script>
@endpush
@section('body')
	@include('layouts.desktop.templates.guides.guide_selection')
	@if($data->isEmpty())
		<h2 style="text-align: center;">No se han encontrado resultados</h2>
	@else
	<div class="communities">
		@foreach ($data as $community)
		<a href="/c/{{ $community->tag }}">
			<div class="community">
				<div class="community-logo">
					<img src="{{ $community->logo }}">
				</div>
				<div class="community-data">
					@if ($community->is_mod)
						<b>{{ $community->title }} <label title="Estás en la lista de moderadores de esta comunidad">⭐</label></b>
					@else
						<b>{{ $community->title }}</b>
					@endif
					<i>c/{{ $community->tag }}</i>
					<label>Fecha de creación: <label class="community-date">{{ $community->created_at }}</label></label>
				</div>
				<div class="community-stats">
			        <div title="Miembros">
			            <img src="/src/media/8tfjpJS2EukA0iPg27ikzxJizSu0UPOxYuLdQ9ipOqxgY2ccTNOVde5jjAroX1lh.png">
			            <b>{{ $community->sub_count }}</b>
			        </div>
			        <div title="Temas">
			            <img src="/src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png">
			            <b>{{ $community->threads_count }}</b>
			        </div>
			        <div title="Posición en el Ranking">
			            <img src="/src/media/xovLYVakqdxxo2OJVDPqbozbPp1W8InJqr4MbEPBHVzUmgM7Sf4uqFJMfGAUTalU.png">
			            <b>{{ $community->index }}</b>
			        </div>
				</div>
			</div>
		</a>
		@endforeach
	</div>
	@endif
@endsection