@if($communities->isEmpty())
	<h2 class="empty-data">No se han encontrado resultados</h2>
@else
<div class="element-container">
	@foreach ($communities as $community)
	<a href="/c/{{ $community->tag }}">
		<div class="element">
			<div class="element-logo round">
				<img src="{{ $community->logo }}">
			</div>
			<div class="element-data">
				<b>{{ $community->title }}</b>
				<i>c/{{ $community->tag }}
				@if ($community->is_mod)
					<label class="element-extra" title="Estás en la lista de moderadores de esta comunidad">⭐</label>
				@endif
				</i>
				<label>Fecha de creación: <label class="element-date-community">{{ $community->created_at }}</label></label>
			</div>
			<div class="element-stats">
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