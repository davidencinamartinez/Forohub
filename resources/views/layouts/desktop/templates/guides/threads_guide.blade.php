@if($threads->isEmpty())
	<h2 class="empty-data">No se han encontrado resultados</h2>
@else
	<div class="element-container">
	@foreach ($threads as $thread)
		<a href="/c/{{ $thread->community_tag }}/t/{{ $thread->id }}">
			<div class="element">
				<div class="element-logo">
					@if ($thread->type == "THREAD_POST")
					<img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/wtp0aa.webp" title="Post"> 
					@elseif ($thread->type == "THREAD_MEDIA")
					<img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/ogyfr6.webp" title="Multimedia"> 
					@elseif ($thread->type == "THREAD_YT")
					<img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/jbsvgx.webp" title="Youtube"> 
					@elseif ($thread->type == "THREAD_POLL")
					<img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1613559834/cylm0g.webp" title="Encuesta"> 
					@endif
				</div>
				<div class="element-data">
					<b title="{{ $thread->title }}">{{ $thread->title }}</b>
					<i>c/{{ $thread->community_tag }}
					@if ($thread->important)
					<label class="element-extra" title="Tema Serio">📑</label>
					@endif
					@if ($thread->nsfw)
					<label class="element-extra" title="NSFW">🔞</label>
					@endif
					@if ($thread->spoiler)
					<label class="element-extra" title="Spoiler">💥</label>
					@endif
					</i>
					<label class="element-date-threads">{{ $thread->created_at }}</label>
				</div>
				<div class="element-stats">
			        <div title="Respuestas">
			            <img src="/src/media/bGAP31dQIA6Y3fxrmZ9IMV4Mc4h2nokrgeZB2lqPvmJcKXXCENPWUpwMzDu4ZfB7.png">
			            <b>{{ $thread->replies_count }}</b>
			        </div>
			        <div title="Votos Positivos">
			            <img src="/src/media/nAiEBnmyVoFYNBhtaIw8mIXoMmNaxQLOiayJ9FM0PhVQiGJ6adiTUFj4IqidT560.png">
			            <b>{{ $thread->upvotes_count }}</b>
			        </div>
			        <div title="Votos Negativos">
			            <img src="/src/media/a7Vc4igYwqdHCM2UtoSinG5qTZCk9pD6mOT3sul7bl7OJq26ZN0qf7BPxD7KYklW.png">
			            <b>{{ $thread->downvotes_count }}</b>
			        </div>
				</div>
			</div>
		</a>
	@endforeach
</div>
@endif