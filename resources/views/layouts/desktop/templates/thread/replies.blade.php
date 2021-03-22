<div id="{{ $reply->id }}" data-id="{{ $reply->id }}" class="thread-reply">
    <div class="thread-reply-id">
        <b class="thread-reply-date">{{ $reply->created_at }}</b>
        <a href="#{{ $reply->id }}">#{{ $reply->id }}</a>
    </div>
    <div class="thread-reply-content">
        <div class="thread-reply-author">
            <a href="/u/{{ strtolower($reply->user->name) }}" title="{{ $reply->user->name }}">{{ $reply->user->name }}</a>
            <br>
            <b>{{ $reply->user->about }}</b>
            <br>
            <img src="{{ $reply->user->avatar }}">
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
        @if ($thread->user_is_admin)
        <span class="required-auth remarkable-text delete-reply"><label>🗑️</label> Eliminar</span>
        @endif
    </div>
</div>