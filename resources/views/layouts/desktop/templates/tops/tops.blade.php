@extends('layouts.desktop.main')

@section('title', 'Tops - Forohub')

@section('description', 'Lo mejor de lo mejor. Aquí encontrarás las mejores comunidades, los mejores temas y los usuarios más populares de la semana')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/8AE3kMi5LgMMKoboN0dEZF8aHTmAeZ1xmReLDBB2cJd4ytvHNPlzfT0m3SI5lH40.css">
    <link rel="stylesheet" type="text/css" href="/css/Qaa3sfPYzde0Y65kX1TjRAqH2UvKzsvwoBavOYn43jhy4nbUHon8hW3I23crFrEc.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/guides.js"></script>
@endpush
@section('body')
<script type="text/javascript">
	console.log({!! $threads !!});
</script>
<div style="width: 100%; text-align: center;">
	<div class="top-element-container">
		<div class="top-element-container-title">
			<b>Top Comunidades</b>
		</div>
		@foreach ($communities as $community)
		<div class="top-element">
			<div style="display: grid; width: 100%;">
				<div style="display: flex; align-items: center; width: 100%; margin: 10px 0px;">
					<div style="width: 30%;">
						<img class="top-element-image" src="{{ $community->logo }}">
					</div>
					<div class="top-element-data">
						<b>{{ $community->title }}</b>
						<i>c/{{ $community->tag }}</i>
					</div>
					<div class="top-position">
					@if ($loop->index == 0)
					<b class="top-position-first" style=>🥇</b>
					@elseif ($loop->index == 1)
					<b class="top-position-second">🥈</b>
					@elseif ($loop->index == 2)
					<b class="top-position-third">🥉</b>
					@endif
					</div>
				</div>
				<div>
					<b style="margin-left: 20px;">Estadísticas:</b>
				</div>
				<div class="top-element-stats">
					<div style="width: 25%; text-align: center;" title="Usuarios">
						<img src="/src/media/8tfjpJS2EukA0iPg27ikzxJizSu0UPOxYuLdQ9ipOqxgY2ccTNOVde5jjAroX1lh.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $community->users_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Temas">
						<img src="/src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $community->threads_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Votos Positivos">
						<img src="/src/media/nAiEBnmyVoFYNBhtaIw8mIXoMmNaxQLOiayJ9FM0PhVQiGJ6adiTUFj4IqidT560.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $community->upvotes_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Mensajes">
						<img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $community->replies_count }}</label>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<div class="top-element-container" style="min-width: 350px; max-width: 400px; width: 33.3%">
		<div class="top-element-container-title">
			<b>Top Usuarios</b>
		</div>
		@foreach ($users as $user)
		<div class="top-element">
			<div style="display: grid; width: 100%;">
				<div style="display: flex; align-items: center; width: 100%; margin: 10px 0px;">
					<div style="width: 30%;">
						<img class="top-element-image" src="{{ $user->avatar }}">
					</div>
					<div class="top-element-data">
						<b style="font-size: 20px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $user->name }}</b>
						<i style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">{{ $user->about }}</i>
					</div>
					<div style="width: 30%; font-size: 30px; text-align: center;">
					@if ($loop->index == 0)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #BF953F 10%, #ffef50 45%, #BF953F); border: solid 2px black;">🥇</b>
					@elseif ($loop->index == 1)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #848484 10%, #cccccc 45%, #848484); border: solid 2px black;">🥈</b>
					@elseif ($loop->index == 2)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #946700 10%, #da9800 45%, #946700); border: solid 2px black;">🥉</b>
					@endif
					</div>
				</div>
				<div>
					<b style="margin-left: 20px;">Estadísticas:</b>
				</div>
				<div style="display: flex; margin: 10px 0px; font-weight: bold; width: 85%; margin: 20px auto;">
					<div style="width: 25%; text-align: center;" title="Karma">
						<img src="/src/media/wVgT7mQbXswj1sh0fK9zmMdMAz0JM8zQh2kgd8lS5tFi7WEqgg2HSDAI9IO7EUAv.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">{{ $user->score }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Temas">
						<img src="src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $user->threads_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Votos Positivos">
						<img src="/src/media/nAiEBnmyVoFYNBhtaIw8mIXoMmNaxQLOiayJ9FM0PhVQiGJ6adiTUFj4IqidT560.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $user->upvotes_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Mensajes">
						<img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $user->replies_count }}</label>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<div class="top-element-container" style="min-width: 350px; max-width: 400px; width: 33.3%">
		<div class="top-element-container-title">
			<b>Top Temas</b>
		</div>
		@foreach ($threads as $thread)
		<div class="top-element">
			<div style="display: grid; width: 100%;">
				<div style="display: flex; align-items: center; width: 100%; margin: 10px 0px;">
					<div style="width: 30%;">
						@if ($thread->type == "THREAD_POST")
						<img class="top-element-image" src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/wtp0aa.webp" title="Post" style="border-radius: unset; border: unset; background-color: unset;"> 
						@elseif ($thread->type == "THREAD_MEDIA")
						<img class="top-element-image" src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/ogyfr6.webp" title="Multimedia" style="border-radius: unset; border: unset; background-color: unset;"> 
						@elseif ($thread->type == "THREAD_YT")
						<img class="top-element-image" src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/jbsvgx.webp" title="Youtube" style="border-radius: unset; border: unset; background-color: unset;"> 
						@elseif ($thread->type == "THREAD_POLL")
						<img class="top-element-image" src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/cylm0g.webp" title="Encuesta" style="border-radius: unset; border: unset; background-color: unset;"> 
						@endif
					</div>
					<div class="top-element-data">
						<b style="font-size: 20px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" title="{{ $thread->title }}">{{ $thread->title }}</b>
					</div>
					<div style="width: 30%; font-size: 30px; text-align: center;">
					@if ($loop->index == 0)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #BF953F 10%, #ffef50 45%, #BF953F); border: solid 2px black;">🥇</b>
					@elseif ($loop->index == 1)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #848484 10%, #cccccc 45%, #848484); border: solid 2px black;">🥈</b>
					@elseif ($loop->index == 2)
					<b style="border-radius: 50%; padding: 10px; background-image: linear-gradient(to top, #946700 10%, #da9800 45%, #946700); border: solid 2px black;">🥉</b>
					@endif
					</div>
				</div>
				<div>
					<b style="margin-left: 20px;">Estadísticas:</b>
				</div>
				<div style="display: flex; margin: 10px 0px; font-weight: bold; width: 85%; margin: 20px auto;">
					<div style="width: 25%; text-align: center;" title="Votos Positivos">
						<img src="/src/media/nAiEBnmyVoFYNBhtaIw8mIXoMmNaxQLOiayJ9FM0PhVQiGJ6adiTUFj4IqidT560.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $thread->upvotes_count }}</label>
					</div>
					<div style="width: 25%; text-align: center;" title="Mensajes">
						<img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png" style="width: 32px; height: 32px; vertical-align: bottom;">
						<label style="margin-left: 2px;">+{{ $thread->replies_count }}</label>
					</div>
					@if ($thread->nsfw == 1)
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: flex-end; align-self: center;">📑</div>
					@else
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: flex-end; filter: grayscale(1); align-self: center;">📑</div>
					@endif
					@if ($thread->nsfw == 1)
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: center; align-self: center;">🔞</div> 
					@else
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: center; filter: grayscale(1); align-self: center;">🔞</div>
					@endif
					@if ($thread->nsfw == 1)
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: left; align-self: center;">💥</div>
					@else
					<div style="width: 20%; text-align: center; display: flex; font-size: 20px; justify-content: left; filter: grayscale(1); align-self: center;">💥</div>
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection