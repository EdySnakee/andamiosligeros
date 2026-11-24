<div class="modal fade" id="modalFinHorasExtra" tabindex="-1" role="dialog" aria-labelledby="modalFinHorasExtraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalFinHorasExtraLabel">
                    <i class="fas fa-stop-circle mr-1"></i> Finalizar sesión de horas extra
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info small mb-3">
                    Al finalizar se registrará la hora del servidor, tu ubicación de cierre (si está permitida) y el respaldo de actividad en sistema, enviando la sesión para validación de un administrador.
                </div>

                <form id="formFinHorasExtra" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="txtResumenTrabajo" class="font-weight-bold">
                            Resumen del trabajo realizado <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="txtResumenTrabajo" name="resumen_trabajo" rows="4" minlength="20" maxlength="3000" required
                            placeholder="Describe qué actividades realizaste, folios atendidos y el resultado obtenido (mínimo 20 caracteres)..."></textarea>
                        <small class="form-text text-muted">Mínimo 20 caracteres. <span id="he-fin-chars">0</span>/3000</small>
                    </div>

                    <div class="form-group mb-2">
                        <label for="inpEvidenciasFin" class="font-weight-bold">
                            Evidencias (opcional)
                        </label>
                        <input type="file" class="form-control-file" id="inpEvidenciasFin" name="evidencias[]" multiple accept="image/*,application/pdf">
                        <small class="form-text text-muted">
                            Máximo {{ config('horas_extra.evidencias_max', 5) }} archivos (JPG, PNG o PDF, hasta {{ (int)(config('horas_extra.evidencia_max_kb', 5120) / 1024) }} MB c/u).
                        </small>
                    </div>
                </form>

                <div id="estadoGeoFin" class="small text-muted d-none mt-2">
                    <i class="fas fa-spinner fa-spin mr-1"></i> Capturando ubicación de cierre y subiendo resumen...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Seguir trabajando</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarFin">
                    <i class="fas fa-check-circle mr-1"></i> Finalizar y enviar a validación
                </button>
            </div>
        </div>
    </div>
</div>

