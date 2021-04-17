@extends('layouts.desktop.main')

@section('title', $community->title.' - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/misc_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/configuration.css">
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
    @if ($threads->isNotEmpty())
        @foreach ($threads as $thread)
            @include('layouts.desktop.templates.thread.content')
        @endforeach
    @else
        <h3 class="required-auth">
            <a href="/crear/tema">Todavía no hay temas en esta comunidad.<br>Sé el primero en crear uno</a>
        </h3>
    @endif
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
@if ($threads->hasPages())
    <div style="text-align: center;">
        <div class="pageSelector">
          {!!$threads->links()!!}
        </div>
    </div>
@endif
@endsection