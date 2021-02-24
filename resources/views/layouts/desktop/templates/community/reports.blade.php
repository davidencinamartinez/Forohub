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
        <h1 class="highlighted-title">Reportes</h1>
        @if ($thread_reports->isEmpty())
            <h2>No se han encontrado reportes de temas</h2>
        @else
            <h2>Reportes de temas</h2>
            <div class="thread-reports-container">
            @foreach ($thread_reports as $thread_report)
                <div class="thread-report">
                    <div class="report-type">
                        <label>📝</label>
                    </div>
                    <div class="report-data">
                        <label class="report-cause">{{ $thread_report->report_type }}</label>
                        <b>Enlace: <a href="/c/{{ $community->tag }}/t/{{ $thread_report->thread_id }}">{{ $thread_report->thread_id }}</a></b>
                        <label><b>Fecha: </b><label class="report-date">{{ $thread_report->created_at }}</label></label>
                        <label><b>Enviado por: </b><a href="/u/{{ strtolower($thread_report->author->name) }}">{{ $thread_report->author->name }}</a></label>
                        @if ($thread_report->description)
                        <label class="report-description"><b>Descripción: </b>{{ $thread_report->description }}</label>
                        @endif
                    </div>
                    <div class="report-actions">
                        <a href="/c/{{ $community->tag }}/t/{{ $thread_report->thread_id }}"><button>Visitar Tema ↩️</button></a>
                        <button>Cerrar Tema ❌</button>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
        @if ($reply_reports->isEmpty())
            <h3>No se han encontrado reportes de respuestas</h3>
        @else
            <h3>Reportes de respuestas</h3>
            <div class="thread-reports-container">
            @foreach ($reply_reports as $reply_report)
                <div style="border: solid 1px black; display: flex;">
                    <div style="width: 20%">
                        <label style="font-size: 20px;">💬</label>
                    </div>
                    <div style="width: 50%; display: grid;">
                        <b>{{ $reply_report }}</b>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    </div>
@endsection