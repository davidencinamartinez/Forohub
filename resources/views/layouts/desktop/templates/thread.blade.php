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
    <div style="width: 10%;"></div>
    <div class="threads-panel">
        @include('layouts.desktop.templates.thread.content')
        <div class="thread-replies">
            @foreach ($thread_replies as $reply)
                @include('layouts.desktop.templates.thread.replies')
            @endforeach
        </div>
    </div>
    <div class="lateral-panel">
        @include('layouts.desktop.templates.lateral.lateral_community')
    </div>
</div>
@endsection