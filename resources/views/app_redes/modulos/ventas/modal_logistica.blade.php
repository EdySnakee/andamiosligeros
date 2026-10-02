<!-- Modal Unificado de Logística y Envío -->
<div class="modal fade" id="modalLogisticaEnvio" tabindex="-1" role="dialog" aria-labelledby="modalLogisticaEnvioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow border-0" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #0948AF;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="modalLogisticaEnvioLabel">
                        <i class="fas fa-truck-moving mr-2"></i> Logística y Envío
                    </h5>
                    <small class="text-white-50">
                        Venta: <span id="modal_log_cod_venta" class="text-white font-weight-bold"></span> &nbsp;|&nbsp;
                        Cliente: <span id="modal_log_cliente" class="text-white font-weight-bold"></span>
                    </small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formLogisticaEnvio">
                <input type="hidden" id="modal_log_id_venta" name="id_vta">

                <div class="modal-body p-4" style="background-color: #f8fafc;">
                    
                    {{-- SECCIÓN 1: PRIMER ENVÍO (PRINCIPAL) --}}
                    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-body p-3">
                            <h6 class="font-weight-bold text-dark mb-3" style="font-size: 0.92rem;">
                                <i class="fas fa-box text-primary mr-1"></i> Primer Envío (Principal)
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="small font-weight-bold text-muted mb-1">Envío Cobrado al Cliente ($)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" class="form-control" id="modal_log_envio" placeholder="0.00">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">Monto cotizado o cobrado al cliente</small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small font-weight-bold text-muted mb-1">Origen</label>
                                    <input type="text" class="form-control form-control-sm" id="modal_log_origen" placeholder="Ej. Querétaro">
                                    <small class="text-muted" style="font-size: 0.72rem;">Ciudad o sucursal de salida</small>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="small font-weight-bold text-muted mb-1">Destino (Dirección de entrega)</label>
                                    <textarea class="form-control form-control-sm" id="modal_log_destino" rows="2" placeholder="Dirección completa de entrega / destino..." style="resize: vertical;"></textarea>
                                </div>
                                <div class="col-md-4 mb-2 mb-md-0">
                                    <label class="small font-weight-bold text-muted mb-1">Paquetería</label>
                                    <select class="form-control form-control-sm" id="modal_log_paqueteria_select">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Paquetexpress">Paquetexpress</option>
                                        <option value="Pitic">Pitic</option>
                                        <option value="Tresguerras">Tresguerras</option>
                                        <option value="Castores">Castores</option>
                                        <option value="DHL">DHL</option>
                                        <option value="FedEx">FedEx</option>
                                        <option value="Estafeta">Estafeta</option>
                                        <option value="Flecha Amarilla">Flecha Amarilla</option>
                                        <option value="Transporte Propio / Local">Transporte Propio / Local</option>
                                        <option value="Otros">Otra paquetería (especificar)...</option>
                                    </select>
                                    <input type="text" class="form-control form-control-sm mt-1" id="modal_log_paqueteria_otra" placeholder="Nombre de paquetería" style="display: none;">
                                </div>
                                <div class="col-md-4 mb-2 mb-md-0">
                                    <label class="small font-weight-bold text-muted mb-1">Costo Paquetería Real ($)</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light font-weight-bold">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" class="form-control" id="modal_log_envio_paqueteria" placeholder="0.00">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">Costo pagado a paquetería</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="small font-weight-bold text-muted mb-1">Fecha Envío</label>
                                    <input type="date" class="form-control form-control-sm" id="modal_log_fecha_envio">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: SEGUNDO ENVÍO (OPCIONAL) --}}
                    <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="check_segundo_envio">
                                <label class="custom-control-label font-weight-bold text-dark" for="check_segundo_envio" style="cursor: pointer;">
                                    <i class="fas fa-boxes text-info mr-1"></i> ¿Registrar un segundo envío para esta venta?
                                </label>
                            </div>

                            <div id="seccion_segundo_envio" class="mt-3 pt-3 border-top" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">Envío 2 Cobrado al Cliente ($)</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light font-weight-bold">$</span>
                                            </div>
                                            <input type="number" step="0.01" min="0" class="form-control" id="modal_log_envio_2" placeholder="0.00">
                                        </div>
                                        <small class="text-muted" style="font-size: 0.72rem;">Monto adicional cobrado al cliente por 2º envío</small>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1">Origen 2</label>
                                        <input type="text" class="form-control form-control-sm" id="modal_log_origen_2" placeholder="Ej. Querétaro">
                                        <small class="text-muted" style="font-size: 0.72rem;">Ciudad o sucursal de salida</small>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="small font-weight-bold text-muted mb-0">Destino 2</label>
                                            <button type="button" class="btn btn-outline-secondary btn-xs py-0 px-2" id="btn_copiar_destino" title="Copiar dirección del primer envío" style="font-size: 0.75rem; border-radius: 4px;">
                                                <i class="fas fa-copy mr-1"></i> Copiar destino del 1º
                                            </button>
                                        </div>
                                        <textarea class="form-control form-control-sm" id="modal_log_destino_2" rows="2" placeholder="Dirección completa de entrega para el 2º envío..." style="resize: vertical;"></textarea>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="small font-weight-bold text-muted mb-1">2ª Paquetería</label>
                                        <select class="form-control form-control-sm" id="modal_log_paqueteria_select_2">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="Paquetexpress">Paquetexpress</option>
                                            <option value="Pitic">Pitic</option>
                                            <option value="Tresguerras">Tresguerras</option>
                                            <option value="Castores">Castores</option>
                                            <option value="DHL">DHL</option>
                                            <option value="FedEx">FedEx</option>
                                            <option value="Estafeta">Estafeta</option>
                                            <option value="Flecha Amarilla">Flecha Amarilla</option>
                                            <option value="Transporte Propio / Local">Transporte Propio / Local</option>
                                            <option value="Otros">Otra paquetería (especificar)...</option>
                                        </select>
                                        <input type="text" class="form-control form-control-sm mt-1" id="modal_log_paqueteria_otra_2" placeholder="Nombre de 2ª paquetería" style="display: none;">
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="small font-weight-bold text-muted mb-1">Costo 2º Envío Real ($)</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light font-weight-bold">$</span>
                                            </div>
                                            <input type="number" step="0.01" min="0" class="form-control" id="modal_log_envio_paqueteria_2" placeholder="0.00">
                                        </div>
                                        <small class="text-muted" style="font-size: 0.72rem;">Costo pagado al 2º transporte</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold text-muted mb-1">Fecha 2º Envío</label>
                                        <input type="date" class="form-control form-control-sm" id="modal_log_fecha_envio_2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer bg-light border-0 py-2 px-4 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-3" id="btn_guardar_logistica" style="background-color: #0948AF; border-color: #0948AF;">
                        <i class="fas fa-save mr-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
