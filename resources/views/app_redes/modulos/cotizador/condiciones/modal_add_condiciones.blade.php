<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar Condiciones</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="descripcion_condicion">Condiciones:</label>
                        <div id="editor_condicion" style="height: 30vh">
                            <?php print_r(!empty($datos_condicion) ? $datos_condicion : ''); ?>
                        </div>
                        <textarea class="form-control" id="descripcion_condicion" name="descripcion_condicion"
                            placeholder="Describa la condición" autocomplete="nope" rows="7" type="textarea">
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save_condiciones"> Guardar </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
