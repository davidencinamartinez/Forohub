@extends('layouts.desktop.main')

@section('description', 'Índice de temas. Aquí encontrarás un listado con todos los temas existentes en Forohub')

@isset ($character)
	@section('title', 'Guía de temas ('.strtoupper($character).') - Forohub')
@else
	@section('title', 'Guía de temas - Forohub')
@endif

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/8AE3kMi5LgMMKoboN0dEZF8aHTmAeZ1xmReLDBB2cJd4ytvHNPlzfT0m3SI5lH40.css">
    <link rel="stylesheet" type="text/css" href="/css/PQgOkr0Wv7MpF16BvdG5aGgWNBlx5YF9y3ljjpHwKNESq23IJCczPi1rkXZDfcz1.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/guides.js"></script>
@endpush
@section('body')
	@include('layouts.desktop.templates.guides.guide_selection')
	@include('layouts.desktop.templates.guides.threads_guide')
@endsection