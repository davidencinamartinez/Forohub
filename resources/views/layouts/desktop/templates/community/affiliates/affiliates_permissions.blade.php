<div class="element-stats">
    <div>
        <label class="element-extra">👤</label>
        @if ($affiliate->subscription_type == 0)
            <button class="checkbox-button checked" disabled></button>
        @else
            <button class="checkbox-button affiliate"></button>
        @endif
    </div>
    <div>
        <label class="element-extra">⭐</label>
        @if ($affiliate->subscription_type == 2000)
            <button class="checkbox-button checked" disabled></button>
        @else
            <button class="checkbox-button moderator"></button>
        @endif
    </div>
    <div>
        <label class="element-extra">👑</label>
        <button class="checkbox-button leader"></button>
    </div>
    <div>
        <button class="ban-user-button">Expulsar</button>
    </div>
</div>