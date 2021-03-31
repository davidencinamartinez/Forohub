@extends('layouts.desktop.main')

@isset ($character)
	@section('title', 'Afiliados ('.strtoupper($character).') · c/'.$community->tag.' - Forohub')
@else
	@section('title', 'Afiliados · c/'.$community->tag.' - Forohub')
@endif

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/desktop/classes.css">
    <link rel="stylesheet" type="text/css" href="/css/desktop/guides.css">
@endpush
@push('scripts')
	<script type="text/javascript" src="/js/affiliates.js"></script>
@endpush
@section('body')
<form>
	@csrf
</form>
	@include('layouts.desktop.templates.community.character_selection')
	@include('layouts.desktop.templates.community.affiliates.affiliates_guide')
	@if ($affiliates->hasPages())
	  <div style="text-align: center;">
	    <div class="pageSelector">
	      {!!$affiliates->links()!!}
	    </div>
	  </div>
	@endif
@endsection