@extends('layouts.desktop.main')

@isset ($character)
	@section('title', 'Guía de comunidades ('.strtoupper($character).') - Forohub')
@else
	@section('title', 'Guía de comunidades - Forohub')
@endif

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/guides.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/guides.js"></script>
@endpush
@section('body')
	@include('layouts.desktop.templates.guides.guide_selection')
	@include('layouts.desktop.templates.guides.communities_guide')
@endsection