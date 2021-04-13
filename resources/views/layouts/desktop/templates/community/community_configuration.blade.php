@if ($community->is_leader)
    <div class="configuration-panel">
        <div class="panel-title">Configuración</div>
        <div class="configuration-set">
            <div class="configuration-element">
                <b class="input-title">Título:</b>
                <label style="margin-left: 10px;">{{ $community->title }}</label>
                <img class="edit-element" src="/src/media/edit_icon.webp">
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
                <b class="input-title">Logo de la comunidad</b>
                <img class="edit-element" src="/src/media/edit_icon.webp">
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
        </div>
    </div>
@endif