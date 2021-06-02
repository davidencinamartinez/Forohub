@extends('layouts.desktop.main')

@section('title', $community->title.' - Forohub')

@section('description', $meta_description)

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/B7o87L2YkZdnuQkqz68BKA35j2mc0OLjT86jSOrps19DHKjTHCVjMrjaQCpz7m6k.css">
    <link rel="stylesheet" type="text/css" href="/css/dYLviCaMKKoganQbQUa7lwhnlGund6PVLESCtn4jSJ00xXWCahDLUxHsMjyDFpHu.css">
    <link rel="stylesheet" type="text/css" href="/css/L02AaerYckTaqAgneODgPhYXNglw7NjScj7Wvu2SulxxotSZiCMHJpQ7fQKdIfU0.css">
    <link rel="stylesheet" type="text/css" href="/css/lMCdpjFSu5vMoCSIeycbdokrQqWyPZNLmvjARCwXWC4bkKQCg4BWhlpTQ1gqxMPI.css">
    <link rel="stylesheet" type="text/css" href="/css/MZZkS6zSSswEuYty9HW5AeUDm2Cwi2fd7lO7cZMmjcPf5QsZDNCJLaDf3E0o4QiY.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="/js/community.js"></script>
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
@if ($community->background)
    <script type="text/javascript">
        if (getCookie('DARK_THEME_CHECK') == 'TRUE') {
            $('html').css('backgroundImage', 'linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url({!! $community->background !!})');
        } else {
            $('html').css('backgroundImage', 'linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url({!! $community->background !!}');
        }
    </script>
    <style type="text/css">
        html {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
@endif
<div class="index-panel">
    <div style="width: 10%"></div>
    <div class="threads-panel">
    @include('layouts.desktop.templates.community.community_configuration')
    @isset($threads)
        @foreach ($threads as $thread)
            @include('layouts.desktop.templates.thread.content')
        @endforeach
    @endisset
    @empty($threads)
        <h3 class="required-auth">
            <a href="/crear/tema">Todavía no hay temas en esta comunidad.<br>Sé el primero en crear uno</a>
        </h3>
    @endempty
</div>
    <div class="lateral-panel">
        @if ($community->is_mod) 
        <div class="lateral-cube">
            <div class="lateral-title">Panel de moderación</div>
            <div class="lateral-community-procedures">
                <a href="/c/{{ $community->tag }}/reportes">
                    <button>Reportes 🚨</button>
                </a>
            </div>
        </div>
        @elseif ($community->is_leader)
        <div class="lateral-cube">
            <div class="lateral-title">Panel de moderación</div>
            <div class="lateral-community-procedures">
                <a href="/c/{{ $community->tag }}/reportes">
                    <button>Reportes 🚨</button>
                </a>
                <a href="/c/{{ $community->tag }}/afiliados/">
                    <button>Afiliados 👥</button>
                </a>
                <button class="community-configuration-trigger">Configuración ⚙️</button>
            </div>
        </div>
        @endif
        @include('layouts.desktop.templates.lateral.lateral_community')
    </div>
</div>
@isset($threads)
    @if ($threads->hasPages())
        <div style="text-align: center;">
            <div class="pageSelector">
              {!!$threads->links()!!}
            </div>
        </div>
    @endif
@endisset
@endsection