@extends('layouts.desktop.main')

@isset ($character)
	@section('title', 'Afiliados ('.strtoupper($character).') · c/'.$community->tag.' - Forohub')
@else
	@section('title', 'Afiliados · c/'.$community->tag.' - Forohub')
@endif

@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/8AE3kMi5LgMMKoboN0dEZF8aHTmAeZ1xmReLDBB2cJd4ytvHNPlzfT0m3SI5lH40.css">
    <link rel="stylesheet" type="text/css" href="/css/PQgOkr0Wv7MpF16BvdG5aGgWNBlx5YF9y3ljjpHwKNESq23IJCczPi1rkXZDfcz1.css">
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