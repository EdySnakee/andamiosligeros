    <div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog" aria-labelledby="modalMovimientoLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMovimientoLabel">Agregar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí va el formulario para agregar un movimiento -->
                    <form>
                        <!-- ID como input oculto -->
                        <input type="hidden" id="id_movimiento" name="id_movimiento">

                        <!-- Tipo de Movimiento como input oculto -->
                        <input type="hidden" id="tipoMovimiento" name="tipoMovimiento">

                        <!-- Tipo de Movimiento como input oculto -->
                        <input type="hidden" id="id_usuario" name="id_usuario">

                        <div class="form-group col-6 p-0">
                            <label for="monto">Monto</label>
                            <input type="number" class="form-control" id="monto" placeholder="###" required>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Concepto</label>
                            <textarea class="form-control" id="descripcion" rows="3" placeholder="pago, compra, etc..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="comprobante">Comprobante</label>
                            <input type="file" name="comprobante" id="comprobante" class="form-control" accept="image/*">
                        </div>

                        <!-- Mostrar imagen actual si existe -->
                        <div id="comprobantePreview" style="margin-top: 10px;">
                            <img id="comprobanteImage" src="" style="max-width: 300px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button onclick="eliminarRegistro()" type="button" id="btnEliminar" class="btn btn-danger rounded d-none">Eliminar</button>
                    <button type="button" class="btn btn-warning rounded" data-dismiss="modal">Cancelar</button>
                    <button onclick="validarDatosModal()" type="button" id="btnGuardar" class="btn btn-success guardar-btn rounded">Guardar</button>
                    <button onclick="validarDatosModal()" type="button" id="btnActualizar" class="btn btn-primary  rounded d-none">Actualizar</button>
                </div>
            </div>
        </div>
    </div>