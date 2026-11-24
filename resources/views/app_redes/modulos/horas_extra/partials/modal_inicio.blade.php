<div class="modal fade" id="modalInicioHorasExtra" tabindex="-1" role="dialog" aria-labelledby="modalInicioHorasExtraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalInicioHorasExtraLabel">
                    <i class="fas fa-play-circle mr-1"></i> Iniciar sesión de horas extra
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border mb-3">
                    <div class="row small">
                        <div class="col-md-4"><strong>Solicitud:</strong> #<span id="he-ini-id"></span></div>
                        <div class="col-md-4"><strong>Tiempo estimado:</strong> <span id="he-ini-horas"></span></div>
                        <div class="col-md-4"><strong>Modalidad:</strong> <span id="he-ini-modalidad"></span></div>
                    </div>
                    <div class="small mt-1">
                        <strong>Motivo:</strong> <span id="he-ini-motivo"></span>
                    </div>
                </div>

                <div class="border rounded p-3 bg-light mb-3" style="max-height: 240px; overflow-y: auto;">
                    @include('app_redes.modulos.horas_extra.partials.aviso_privacidad')
                </div>

                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="chkAceptaAviso">
                    <label class="custom-control-label font-weight-bold text-dark" for="chkAceptaAviso">
                        He leído y acepto el aviso de privacidad (v{{ config('horas_extra.aviso_version', '2026-11') }}) y autorizo el registro de actividad dentro del sistema durante esta sesión.
                    </label>
                </div>

                <div id="estadoGeoInicio" class="small text-muted d-none mt-2">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Obteniendo ubicación aproximada (máx. 10 seg)...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="btnConfirmarInicio">
                    <i class="fas fa-play mr-1"></i> Iniciar sesión ahora
                </button>
            </div>
        </div>
    </div>
</div>

