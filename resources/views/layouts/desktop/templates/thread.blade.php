@extends('layouts.desktop.main')

@section('title', $thread->title.' - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/misc_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
@endpush
@push('scripts')
@endpush
@section('body')
@if ($thread->communities->background)
    <style type="text/css">
        body {
            background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(/src/communities/background/{!! $thread->communities->background !!});
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
@endif
<div class="index-panel">
    <div class="threads-panel">
        <div class="thread">
            <div class="thread-data" data-id="{{$thread->id}}">
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
                        @if ($thread->user_joined_community == 'true')
                            <button class="required-auth thread-community-joined">Cancelar suscripción</button>
                        @else
                            <button class="required-auth thread-community-join">Suscribirse</button>
                        @endif
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
                    <h2 class="thread-title">
                        <a>{{ $thread->title }}</a>
                    </h2>
                    <div class="thread-body">
                        {!! $thread->body !!}
                    </div>
                    <div class="thread-info">
                        <a href="/c/{{ $thread->communities->tag }}/t/{{ $thread->id }}"><label style="text-shadow: none">💬</label> {{ $thread->replies_count }} Respuestas</a>
                        <span class="remarkable-text"><label>🔗</label> Compartir</span>
                        <span class="required-auth remarkable-text report-thread"><label>❗</label> Reportar</span>
                        <span class="required-auth remarkable-text activate-reply"><label>↩️</label> Responder</span>
                    </div>
                    <div class="thread-quick-reply">
                        <div>
                            <textarea class="thread-quick-reply-text" rows="4" maxlength="3000" placeholder="Deja un comentario..."></textarea>
                            <button class="thread-quick-reply-send" type="submit">Responder</button>
                            <button class="thread-quick-reply-cancel">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="thread-replies">
    @foreach ($thread_replies as $reply)
       <div id="{{ $loop->iteration }}" class="thread-reply">
            <div class="thread-reply-id">
                <b class="thread-reply-date">{{ $reply->created_at }}</b>
                <a href="#{{ $loop->iteration }}">#{{ $loop->iteration }}</a>
            </div>
            <div class="thread-reply-content">
                <div class="thread-reply-author">
                    <a href="/u/{{ strtolower($reply->user->name) }}" title="{{ $reply->user->name }}">{{ $reply->user->name }}</a>
                    <br>
                    <b>{{ $reply->user->about }}</b>
                    <br>
                    <img src="/src/avatars/{{ $reply->user->avatar }}">
                    <br>
                    <b class="thread-reply-user-register">{{ $reply->user->created_at }}</b> | <b>{{ $reply->user->user_reply_count }} Mens.</b>
                    <br>
                    <b>Karma: {{ $reply->user->user_karma }}</b>
                </div>
                <div class="thread-reply-text">{!! $reply->text !!}</div>
            </div>
            <div class="thread-reply-actions">
                <span class="required-auth remarkable-text report-reply"><label>❗</label> Reportar</span>
                <span class="required-auth remarkable-text quote"><label>📝</label>Citar</span>
            </div>
        </div>
    @endforeach
    </div>
    </div>
    <div class="lateral-panel">
    </div>
</div>
@endsection