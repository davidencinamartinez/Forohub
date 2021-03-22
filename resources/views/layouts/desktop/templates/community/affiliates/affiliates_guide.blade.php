@if($affiliates->isEmpty())
	<h2 class="empty-data">No se han encontrado resultados</h2>
@else
	<div class="element-container">
		@foreach ($affiliates as $affiliate)
			<div class="element" data-id="{{ $affiliate->user->id }}" data-name="{{ $affiliate->user->name }}">
				<div class="element-logo round">
					<img src="{{ $affiliate->user->avatar }}">
				</div>
				<div class="element-data">
					<b>{{ $affiliate->user->name }}</b>
					@if ($affiliate->subscription_type == 2000)
						<label>Moderador <label class="element-extra">⭐</label></label>
					@else
						<label>Afiliado <label class="element-extra">👤</label></label>
					@endif
					</i>
					<label>Fecha de suscripción: <label class="element-date-affiliate" style="text-transform: capitalize;">{{ $affiliate->created_at }}</label></label>
				</div>
				@include('layouts.desktop.templates.community.affiliates.affiliates_permissions')
			</div>
		@endforeach
	</div>
@endif