@if ($community->is_leader)
    <div class="configuration-panel">
        <div class="panel-title">Configuración</div>
        <div class="configuration-set">
            <div class="configuration-element">
                <b class="input-title">Título:</b>
                <label style="margin-left: 10px;">{{ $community->title }}</label>
                <img class="edit-element" src="/src/media/edit_icon.webp" title="Editar">
                <div class="configuration-datafield title">
                    <h3>Modificar título</h3>
                    <b>Título:</b>
                    <input type="text" class="form-input" placeholder="Título" autocomplete="off" maxlength="50" value="{{ $community->title }}">
                    <div class="character-counter">
                        <label>{{ strlen($community->title) }}</label>
                        <label>/50</label>
                    </div>
                    <button class="community-update fh-button title">Actualizar</button>
                </div>
            </div>
            <div class="configuration-element">
                <b class="input-title">Descripción de la comunidad</b>
                <img class="edit-element" src="/src/media/edit_icon.webp" title="Editar">
                <div class="configuration-datafield description">
                    <h3>Modificar descripción</h3>
                    <b>Descripción:</b>
                    <textarea rows="6" maxlength="500">{{ $community->description }}</textarea>
                    <div class="character-counter">
                        <label>{{ strlen($community->description) }}</label>
                        <label>/500</label>
                    </div>
                    <button class="community-update fh-button description">Actualizar</button>
                </div>
            </div>
            <div class="configuration-element">
                <b class="input-title">Normativa de la comunidad</b>
                <img class="edit-element" src="/src/media/edit_icon.webp" title="Editar">
                <div class="configuration-datafield rules">
                    @if ($community->community_rules->isNotEmpty())
                        <h3>Normativa actual</h3>
                        @foreach ($community->community_rules as $rule)
                            <div class="configuration-rule" data-id="{{ $rule->id }}">
                                <div>
                                    <b class="configuration-rule-title">{{ $rule->rule }}</b>
                                    <br>
                                    <label class="configuration-rule-description">{{ $rule->rule_description }}</label>
                                </div>
                                <div>
                                    <button class="edit-rule">
                                        <img src="/src/media/edit_icon.webp" title="Editar Regla">
                                    </button>
                                    <button class="delete-rule" title="Eliminar Regla">❌</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <br>
                    <button class="add-rule fh-button">Añadir regla</button>
                </div>
            </div>
            <div class="configuration-element">
                <b class="input-title">Logo de la comunidad</b>
                <img class="edit-element" src="/src/media/edit_icon.webp" title="Editar">
                <div class="configuration-datafield logo">
                    <div class="configuration-logo">
                        <img src="{{ $community->logo }}">
                        <div>
                            <ul>
                                <li>Sólo se permiten ficheros de tipo imagen</li>
                                <li>Extensiones válidas: .jpg, .png, .webp</li>
                                <li>Tamaño máximo del fichero: 2Mb</li>
                                <li>El fichero debe tener unas medidas:
                                    <ul>
                                        <li>Mínimo 64x64 (píxeles) (Anchura x Altura)</li>
                                        <li>Máximo 2048x2048 (píxeles) (Anchura x Altura)</li>
                                    </ul>
                                </li>
                                <li>Se recomienda que las imágenes tengan un formato cuadrado</li>
                                <li>La imagen debe cumplir con la <a href="">normativa de imágenes de Forohub</a></li>
                            </ul>
                        </div>
                    </div>
                    <input type="file" accept="image/*, .jpeg, .jpg, .webp, .png">
                    <br><br>
                    <button class="community-update fh-button logo">Actualizar</button>
                </div>
            </div>
            <div class="configuration-element">
                <b class="input-title">Fondo de la comunidad</b>
                <img class="edit-element" src="/src/media/edit_icon.webp" title="Editar">
                <div class="configuration-datafield background">
                    <div class="configuration-background">
                        @isset ($community->background)
                        <img src="{{ $community->background }}" style="border-radius: unset; width: 200px;">
                        @else
                        <img>
                        @endisset
                        <div>
                            <ul>
                                <li>Sólo se permiten ficheros de tipo imagen</li>
                                <li>Extensiones válidas: .jpg, .png, .webp</li>
                                <li>Tamaño máximo del fichero: 4Mb</li>
                                <li>El fichero debe tener unas medidas:
                                    <ul>
                                        <li>Mínimo 1366x768 (píxeles) (Anchura x Altura)</li>
                                        <li>Máximo 7680x4320 (píxeles) (Anchura x Altura)</li>
                                    </ul>
                                </li>
                                <li>Se recomienda que las imágenes tengan un formato rectangular</li>
                                <li>La imagen debe cumplir con la <a href="">normativa de imágenes de Forohub</a></li>
                            </ul>
                        </div>
                    </div>
                    <input type="file" accept="image/*, .jpeg, .jpg, .webp, .png">
                    <br><br>
                    <button class="community-update fh-button background">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
@endif