@if($users->isEmpty())
	<h2 class="empty-data">No se han encontrado resultados</h2>
@else
<div class="element-container">
	@foreach ($users as $user)
	<a href="/u/{{ strtolower($user->name) }}">
		<div class="element">
			<div class="element-logo round">
				<img src="{{ $user->avatar }}">
			</div>
			<div class="element-data">
				<b>{{ $user->name }}</b>
				<i>u/{{ strtolower($user->name) }}</i>
				<label>Fecha de registro: <label class="element-date-community">{{ $user->created_at }}</label></label>
			</div>
			<div class="element-stats">
		        <div title="Karma">
		            <img src="/src/media/wVgT7mQbXswj1sh0fK9zmMdMAz0JM8zQh2kgd8lS5tFi7WEqgg2HSDAI9IO7EUAv.png">
		            <b>{{ $user->karma }}</b>
		        </div>
		        <div title="Respuestas">
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