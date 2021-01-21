<div class="lateral-cube lateral-community-data">
    <div class="lateral-title">Comunidad</div>
    <img class="lateral-community-logo" src="{{ $community->logo }}">
    <b class="lateral-community-title">{{ $community->title }}</b>
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
@if ($community->community_rules->isNotEmpty())
    <div class="lateral-cube lateral-community-data">
        <div class="lateral-title">Reglamento</div>
        @foreach ($community->community_rules as $rule)
            <div class="lateral-community-rule">
                <b>{{ $rule->rule }}</b>
                <br>
                <label class="accordian">{{ $rule->rule_description }}</label>
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
                <img src="/src/media/mQgfVUkYMgWC6zVz3z06aejvIJqGW7ORdQOmLrvdlmlJ0ovzPImfCFxVtLie5Haj.png" title="Creador">
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