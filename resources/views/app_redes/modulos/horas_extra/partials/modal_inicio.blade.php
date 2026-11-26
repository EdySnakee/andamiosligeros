<div class="modal fade" id="modalInicioHorasExtra" tabindex="-1" role="dialog" aria-labelledby="modalInicioHorasExtraLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                <div class="alert alert-light border mb-2">
                    <div class="row small">
                        <div class="col-md-4"><strong>Solicitud:</strong> #<span id="he-ini-id"></span></div>
                        <div class="col-md-4"><strong>Tiempo estimado:</strong> <span id="he-ini-horas"></span></div>
                        <div class="col-md-4"><strong>Modalidad:</strong> <span id="he-ini-modalidad"></span></div>
                    </div>
                    <div class="small mt-1">
                        <strong>Motivo:</strong> <span id="he-ini-motivo"></span>
                    </div>
                </div>

                <p class="small text-muted mb-0">
                    Al confirmar comenzará el conteo de tu sesión. Al terminar tus actividades recuerda presionar <strong>Finalizar</strong> para enviar tu resumen y evidencias.
                </p>

                <div id="estadoGeoInicio" class="small text-muted d-none mt-2">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Iniciando sesión...
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
