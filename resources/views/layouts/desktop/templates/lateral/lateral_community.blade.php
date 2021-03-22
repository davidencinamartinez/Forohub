<div class="lateral-cube lateral-community-data">
    <div class="lateral-title">Comunidad</div>
    <img class="lateral-community-logo" src="{{ $community->logo }}">
    <a class="lateral-community-title" href="/c/{{ $community->tag }}">{{ $community->title }}</a>
    <label class="lateral-community-tag">c/{{ $community->tag }}</label>
    <p class="lateral-community-description">{{ $community->description }}</p>
    <div style="display: inline-flex;">
        <div class="lateral-community-info" title="Miembros">
            <img class="lateral-community-users" src="/src/media/8tfjpJS2EukA0iPg27ikzxJizSu0UPOxYuLdQ9ipOqxgY2ccTNOVde5jjAroX1lh.png">
            <b>{{ $community->sub_count }}</b>
        </div>
        <div class="lateral-community-info" title="Temas">
            <img class="lateral-community-users" src="/src/media/DVZoxBZv3qFwJqcTkAa2jrvJ49TcIPsMIzA2dJn0ytRWRwJt6daINZLImpsOAsAP.png">
            <b>{{ $community->threads_count }}</b>
        </div>
        <div class="lateral-community-info" title="Posición en el Ranking">
            <img class="lateral-community-users" src="/src/media/xovLYVakqdxxo2OJVDPqbozbPp1W8InJqr4MbEPBHVzUmgM7Sf4uqFJMfGAUTalU.png">
            <b>{{ $community->index }}</b>
        </div>
    </div>
</div>
@isset ($thread)
@if ($thread->user_is_admin)
    <div class="lateral-cube">
        <div class="lateral-title">Acciones</div>
        <div class="lateral-thread-options">
            @if ($thread->closed == 0)
            <button class="thread-options thread-close">Cerrar Tema 🔒</button>
            @endif
            <button class="thread-options thread-delete">Eliminar Tema ⛔</button>
        </div>
    </div> 
@endif
@endisset
@if ($community->community_rules->isNotEmpty())
    <div class="lateral-cube lateral-community-data">
        <div class="lateral-title">Reglamento</div>
        @foreach ($community->community_rules as $rule)
            <div class="lateral-community-rule">{{ $rule->rule }}<label>▼</label>
                <div class="rule-description">{{ $rule->rule_description }}</div>
            </div>
        @endforeach
    </div>
@endif
<div class="lateral-cube lateral-community-data">
    <div class="lateral-title">Moderadores</div>
    @foreach ($community->community_moderators as $moderator)
        <div class="lateral-community-moderators">
            <a href="/u/{{ strtolower($moderator->user->name) }}">{{ $moderator->user->name }}</a>
            @if ($moderator->subscription_type == 5000)
                <label>👑</label>
            @elseif ($moderator->subscription_type == 2000)
                <label>⭐</label>
            @endif
        </div>
    @endforeach
</div>
<div class="lateral-cube">
    <div class="lateral-title">Tags</div>
    <div class="lateral-community-tags">
        @foreach ($tags as $tag) 
            <b class="lateral-community-keyword">{{ $tag->tagname }}</b>
        @endforeach
    </div>
</div>
@include('layouts.desktop.templates.lateral.lateral_help_center')