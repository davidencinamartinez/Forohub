@extends('layouts.desktop.main')

@section('title', 'Reportes: '.$community->title.' - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/reports.css">
@endpush
@push('scripts')
    <script type="text/javascript" src="/js/community_reports.js"></script>
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
    <div class="reports-container">
        <div class="reports-community">
            <div class="reports-community-logo">
                <img class="lateral-community-logo" src="{{ $community->logo }}">
            </div>
            <div class="reports-community-data">
                <a href="/c/{{ $community->tag }}">{{ $community->title }}</a>
                <label>c/{{ $community->tag }}</label>
            </div>
        </div>
        <h1 class="highlighted-title">Reportes</h1>
        @include('layouts.desktop.templates.community.thread_reports')
        @include('layouts.desktop.templates.community.reply_reports')
    </div>
@endsection