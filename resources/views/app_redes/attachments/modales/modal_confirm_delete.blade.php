
<div class="sweet-alert showSweetAlert visible" data-custom-class="" data-has-cancel-button="true" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="true" data-animation="pop" data-timer="null" style="display: block;">
    <div class="sa-icon sa-error" style="display: none;">
    <span class="sa-x-mark">
<span class="sa-line sa-left"></span>
    <span class="sa-line sa-right"></span>
    </span>
    </div>
    <div class="sa-icon sa-warning pulseWarning" style="display: block;">
        <span class="sa-body pulseWarningIns"></span>
        <span class="sa-dot pulseWarningIns"></span>
    </div>
    <div class="sa-icon sa-info" style="display: none;"></div>
    <div class="sa-icon sa-success" style="display: none;">
        <span class="sa-line sa-tip"></span>
        <span class="sa-line sa-long"></span>
        <div class="sa-placeholder"></div>
        <div class="sa-fix"></div>
    </div>
    <div class="sa-icon sa-custom" style="display: none; width: 80px; height: 80px; background-image: url('');"></div>
    <h2>Estas seguro que desea borrar el proyecto {{ $datos_proyecto->nombre_proyecto}}</h2>
    <p style="display: block;">Si confirma perdera los datos para siempre</p>
    <fieldset>
        <input type="text" tabindex="3" placeholder="">
        <div class="sa-input-error"></div>
    </fieldset>
    <div class="sa-error-container">
        <div class="icon">!</div>
        <p>Not valid!</p>
    </div>
    <div class="sa-button-container">
        <button class="cancel" data-dismiss="modal" tabindex="2" style="display: inline-block; box-shadow: none;">Cancelar</button>
        <button class="confirm" id="confirm_delete" data-id-proyecto="{{ $datos_proyecto->id_proyecto }}" tabindex="1" style="display: inline-block; box-shadow: rgba(221, 107, 85, 0.0980392) 0px 0px 2px, rgba(0, 0, 0, 0.0470588) 0px 0px 0px 1px inset; background-color: rgb(221, 107, 85);">Si, Borrar ahora</button>
    </div>
</div>