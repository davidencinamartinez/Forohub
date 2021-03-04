@extends('layouts.desktop.main')

@section('description', $meta_description)
@section('title', $thread->title.' - Forohub')

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/misc_panel.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/thread.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/lateral_panel.css">
@endpush
@push('scripts')
@if ($thread->user_is_admin)
    <script type="text/javascript" src="/js/thread_actions.js"></script>
@endif
@endpush
@section('body')
@if ($thread->communities->background)
    <script type="text/javascript">
        if (getCookie('DARK_THEME_CHECK') == 'TRUE') {
            $('html').css('backgroundImage', 'linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url({!! $thread->communities->background !!})');
        } else {
            $('html').css('backgroundImage', 'linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url({!! $thread->communities->background !!}');
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
@if ($thread_replies->hasPages())
    <div style="text-align: center;">
        <div class="pageSelector">
            {!!$thread_replies->links()!!}
        </div>
    </div>
@endif
@endsection