@extends('layouts.desktop.main')

@section('title', $thread->title.' - Forohub')

@section('description', $meta_description)

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/LorEh6J3JDeDflokqvfpsYgK7yDIvyMl6qcULvqIgR8qGZ3zkagvsvtpw5pZ1rr8.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/dYLviCaMKKoganQbQUa7lwhnlGund6PVLESCtn4jSJ00xXWCahDLUxHsMjyDFpHu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/L02AaerYckTaqAgneODgPhYXNglw7NjScj7Wvu2SulxxotSZiCMHJpQ7fQKdIfU0.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/lMCdpjFSu5vMoCSIeycbdokrQqWyPZNLmvjARCwXWC4bkKQCg4BWhlpTQ1gqxMPI.css') }}">
@endpush
@push('scripts')
@if ($thread->user_is_admin || $thread->user_is_leader)
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