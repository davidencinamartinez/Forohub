@extends('layouts.desktop.main')

@section('title', 'Forohub')

@section('description', $meta_description)

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/B7o87L2YkZdnuQkqz68BKA35j2mc0OLjT86jSOrps19DHKjTHCVjMrjaQCpz7m6k.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dYLviCaMKKoganQbQUa7lwhnlGund6PVLESCtn4jSJ00xXWCahDLUxHsMjyDFpHu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/L02AaerYckTaqAgneODgPhYXNglw7NjScj7Wvu2SulxxotSZiCMHJpQ7fQKdIfU0.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/lMCdpjFSu5vMoCSIeycbdokrQqWyPZNLmvjARCwXWC4bkKQCg4BWhlpTQ1gqxMPI.css') }}">
@endpush
@push('scripts')
@endpush
@section('body')
@if (session('status'))
    <script type="text/javascript">
        $(document).ready(function() {
           userVerifiedSuccess();
        });
    </script>
@endif
@if (session('warning'))
  <div class="alert alert-warning">
    {{ session('warning') }}
  </div>
@endif
<div class="index-panel">
    <div style="width: 10%"></div>
    <div class="threads-panel">
    @foreach ($threads as $thread)
        @include('layouts.desktop.templates.thread.content')
    @endforeach
</div>
    <div class="lateral-panel">
        <div class="lateral-cube top-communities">
            <div class="lateral-title">TOP Comunidades</div>
            @foreach ($top_communities as $top_community)
                <a class="top-community" href="c/{{ $top_community->tag }}">
                    <img class="top-community-logo" src="{{ $top_community->logo }}">
                    <b>c/{{ $top_community->tag }}</b>
                </a>
            @endforeach
        </div>
        <div class="lateral-cube user-actions">
            <div class="lateral-title">Acciones</div>
            <a class="required-auth" href="/crear/tema">Crear Tema</a>
            <a class="required-auth" href="/crear/comunidad">Crear Comunidad</a>
        </div>
        @include('layouts.desktop.templates.lateral.lateral_ad_1')
        <div class="lateral-cube last-replies">
            <div class="lateral-title">Últimos mensajes</div>
                @foreach ($latest_replies as $last_reply)
                    <div class="last-reply">
                        <a href="c/{{ $last_reply->tag }}/t/{{ $last_reply->id }}">{{ $last_reply->title }}</a>
                        <br>
                        <div>
                            <a href="/u/{{ strtolower($last_reply->name) }}">{{ $last_reply->name }}</a> · <label class="reply-date">{{ $last_reply->created_at }}</label>
                        </div>
                    </div>
                @endforeach
        </div>
        <div class="lateral-cube forum-stats">
            <div class="lateral-title">Estadísticas de Forohub</div>
            <ul style="list-style-type: circle;">
                <li><b>Comunidades:</b> {{ $fh_data['count_communities'] }}</li>
                <li><b>Miembros:</b> {{ $fh_data['count_users'] }}</li>
                <li><b>Temas:</b> {{ $fh_data['count_threads'] }}</li>
                <li><b>Mensajes:</b> {{ $fh_data['count_replies'] }}</li>
            </ul>
        </div>
        @include('layouts.desktop.templates.lateral.lateral_help_center')
    </div>
</div>
@if ($threads->hasPages())
  <div style="text-align: center;">
    <div class="pageSelector">
      {!!$threads->links()!!}
    </div>
  </div>
@endif
@endsection