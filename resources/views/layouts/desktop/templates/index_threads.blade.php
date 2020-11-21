<div class="threads-panel">
    @foreach ($threads as $thread)
    <div class="thread">
        <div class="thread-data">
            <div class="thread-votes">
                <b class="thread-votes-data">
                    @if (Auth::check())
                        @if ($thread->user_vote_type == '1')
                            <span class="thread-vote upvote upvote-active" data-thread-id={{ $thread->id }}>▲</span>
                        @else
                            <span class="thread-vote upvote" data-thread-id={{ $thread->id }}>▲</span>
                        @endif
                            <span class="thread-vote-count">{{$thread->upvotes_count - $thread->downvotes_count}}</span>
                        @if ($thread->user_vote_type == '0')
                            <span class="thread-vote downvote downvote-active" data-thread-id={{ $thread->id }}>▼</span>
                        @else
                            <span class="thread-vote downvote" data-thread-id={{ $thread->id }}>▼</span>
                        @endif
                    @else
                        <span class="required-auth thread-vote upvote" data-thread-id={{ $thread->id }}>▲</span>
                        <span class="thread-vote-count">{{$thread->upvotes_count - $thread->downvotes_count}}</span>
                        <span class="required-auth thread-vote downvote" data-thread-id={{ $thread->id }}>▼</span>
                    @endif
                </b>
            </div>
            <div class="thread-content">
                <span>
                    <div class="thread-community">
                        <img class="thread-community-logo" src="/src/communities/logo/{{ $thread->communities->logo }}" alt="{{ $thread->communities->name }}">
                        <b><a class="thread-community-name" href="/c/{{ $thread->communities->tag }}">{{ $thread->communities->tag }}</a></b>
                    </div>
                    <button class="required-auth thread-community-join">Suscribirse</button>
                </span>
                <div class="thread-author">
                    <span>Creado por <a href="/u/{{ strtolower($thread->author->name) }}">{{ $thread->author->name }}</a> · </span>
                    <span>
                        <label class="thread-date">{{ $thread->created_at }}</label>
                    </span>
                </div>
                @if ($thread->important == true)
                <label title="Tema serio">📑</label>
                @endif
                @if ($thread->nsfw == true)
                <label title="NSFW">🔞</label>
                @endif
                @if ($thread->spoiler == true)
                <label title="Spoiler">💥</label>
                @endif
                <h2 class="thread-title"><a href="c/{{ $thread->communities->tag }}/t/{{ $thread->id }}" title="{{ strip_tags($thread->body) }}">{{ $thread->title }}</a></h2>
                <div class="thread-body">
                    {!! $thread->body !!}
                </div>
                <div class="thread-info">
                    <a href="c/{{ $thread->communities->tag }}/t/{{ $thread->id }}">💬 {{ $thread->replies_count }} Respuestas</a>
                    <span class="remarkable-text">🔗 Compartir</span>
                    <span class="required-auth remarkable-text">🏴 Reportar</span>
                    <span class="required-auth remarkable-text activate-reply">↩️ Responder</span>
                </div>
                <div class="thread-quick-reply">
                    <div>
                        <form method="POST" action="/submitReply?thread={{ $thread->id }}">
                            <textarea class="thread-quick-reply-text" rows="4" placeholder="Deja un comentario..."></textarea>
                            <button class="thread-quick-reply-send" type="submit">Responder</button>
                        </form>
                        <button class="thread-quick-reply-cancel">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>