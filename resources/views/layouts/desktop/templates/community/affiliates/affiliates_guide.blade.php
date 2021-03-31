@if($affiliates->isEmpty())
	<h2 class="empty-data">No se han encontrado resultados</h2>
@else
	<div class="element-container">
		<div style="display: flex;">
			<div class="guide-community">
	            <div class="guide-community-logo">
	                <img class="lateral-community-logo" src="/src/communities/logo/s2HGcJxofEphgzMYmZvPnRlQi1Admxl.webp">
	            </div>
	            <div class="guide-community-data">
	                <a href="/c/forohub">Forohub - Oficial</a>
	                <label>c/forohub</label>
	            </div>
	        </div>
	        <div style="margin: auto; display: grid;">
	        	<label style="font-size: 14px; font-weight: bold;">* Haz click sobre el círculo para administrar el rango del usuario *</label>
	        	<label style="font-size: 14px; font-weight: bold;">👤 Afiliado / ⭐ Moderador / 👑 Líder</label>
	        </div>
		</div>
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