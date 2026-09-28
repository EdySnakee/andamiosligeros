<div id="modal-info-fact" class="cont-form-ficha cerrado2">
    <div class="body-form">
        <div class="column">
            <h2>Datos Fiscales</h2>
            <div class="twelve columns mt-3">
                <div class="form-group">
                    <input autocomplete="off" class="form-c black" id="razon_social" type="text" placeholder="Razón Social *" required="required" data-validation-required-message="Necesitamos tu razon social.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                    <input autocomplete="off" class="form-c black" id="rfc" type="text" placeholder="RFC *" required="required" data-validation-required-message="Necesitamos tu RFC.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="form-group">
                    <input autocomplete="off" class="form-c black" id="direccion_fiscal" type="text" placeholder="Dirección Fiscal *"  required="required" data-validation-required-message="Necesitamos tu dirección fiscal.">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="twelve columns text-center">
                <div id="success_cli"></div>
                <input autocomplete="off" class="form-c" id="ficha_andamio" value="" type="hidden">
                <a class="btn btn-danger" href="#" id="cancelar"><i class="fa fa-close"></i> Cancelar</a>
                <button id="guarda_datos" class="btn btn-success" type="submit">Confirmar datos </button>
            </div>
        </div>
    </div>
</div>