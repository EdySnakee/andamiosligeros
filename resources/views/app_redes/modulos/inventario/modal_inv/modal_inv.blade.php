<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titulo_modal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row align-items-center">
                <!-- Sucursal de origen -->
                <div class="col-5">
                    <div class="form-group">
                        <label for="suc_origen">ORIGEN</label>
                        <select id="suc_origen" class="form-control" required>
                            <option value="" disabled selected>Selecciona una sucursal</option>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id }}" data-nombre="{{ $sucursal->nombre }}">
                                    {{ $sucursal->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Icono de flecha en el medio -->
                <div class="col-2 text-center">
                    <i class="fas fa-arrow-right fa-2x text-primary"></i>
                </div>

                <!-- Sucursal de destino -->
                <div class="col-5">
                    <div class="form-group">
                        <label for="suc_destino">DESTINO</label>
                        <select id="suc_destino" class="form-control" required>
                            <option value="" disabled selected>Selecciona una sucursal</option>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id }}" data-nombre="{{ $sucursal->nombre }}">
                                    {{ $sucursal->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- PAQUETERIA -->
                <div class="col-6">
                    <div class="form-group">
                        <label for="paqueteria">Paqueteria</label>
                        <input style="text-transform: uppercase;" type="text" id="paqueteria"
                            placeholder="paqueteria de traslado" class="form-control" min="1" required>
                    </div>
                </div>
                <!-- GUIA -->
                <div class="col-4">
                    <div class="form-group">
                        <label for="num-guia">GUIA</label>
                        <input style="text-transform: uppercase;" type="text" id="num-guia" class="form-control"
                            placeholder="número de guia" min="1" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- CATEGORIA -->
                <div class="col-4">
                    <div class="form-group">
                        <label for="categoria">Categorías</label>
                        <select id="categoria" class="form-control" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            <option value="1">ANDAMIO</option>
                            <option value="2">ACCESORIO</option>
                        </select>
                    </div>
                </div>
                <!-- Modelo de Andamio -->
                <div class="col-10" id="modelo_andamio_section" style="display: none;">
                    <div class="form-group">
                        <label for="modelo_andamio">Modelo de Andamio</label>
                        <select id="modelo_andamio" class="form-control">
                            <option value="" disabled selected>Selecciona un modelo</option>
                            @foreach ($modelos as $modelo)
                                <option value="{{ $modelo->id }}" data-nombre="{{ $modelo->nombre }}">
                                    {{ $modelo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Accesorios -->
                <div class="col-10" id="accesorios_section" style="display: none;">
                    <div class="form-group">
                        <label for="accesorios">Accesorios</label>
                        <select id="accesorios" class="form-control" required>
                            <option value="" disabled selected>Selecciona un accesorio</option>
                            @foreach ($accesorios as $accesorio)
                                <option value="{{ $accesorio->id }}">
                                    {{ $accesorio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Piezas ref -->
                <div class="col-10" id="piezas_section" style="display: none;">
                    <div class="form-group">
                        <label for="piezas">Pieza o refacción</label>
                        <select id="piezas" class="form-control" required>
                            <option value="" disabled selected>Selecciona pieza o refacción</option>
                            <option value="1">Niple</option>
                            <option value="2">diagonal</option>
                            <option value="3">Cruceta</option>
                        </select>
                    </div>
                </div>

                <!-- TIPO DE MOVIMIENTO -->
                {{-- <div class="col-12">
                    <div class="form-group">
                        <label for="movimiento">Tipo de movimiento</label>
                        <select id="movimiento" class="form-control" required>
                            <option value="" disabled selected>Tipo de movimiento</option>
                            <option value="1">ENTRADA</option>
                            <option value="2">SALIDA</option>
                        </select>
                    </div>
                </div> --}}

                <!-- Cantidad -->
                <div class="col-4">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" placeholder="Ingresa la cantidad"
                            min="1">
                    </div>
                </div>

                <!-- Comentarios -->
                {{-- <div class="col-12">
                    <div class="form-group">
                        <label for="comentarios">Comentarios</label>
                        <textarea class="form-control" id="comentarios" rows="3" placeholder="Detalles adicionales..."></textarea>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary rounded" id="transferir"><i class="fas fa-dolly"></i>
                Transferir </button>
            <button type="button" class="btn btn-danger rounded" data-dismiss="modal"><i class="fas fa-times"></i>
                Cancelar </button>
        </div>
    </div>
</div>

<script>
    // Al activarser el modal ->
    let _movimiento = '';

    $(document).off('shown.bs.modal', '#modal_large_redes').on('shown.bs.modal', '#modal_large_redes', function() {
        // Validación de modal para ajustar el título y el movimiento
        if ($(this).hasClass('modal-entrada')) {
            _movimiento = 'entrada';
            $('#titulo_modal').text('ENTRADA');
        } else if ($(this).hasClass('modal-salida')) {
            _movimiento = 'salida';
            $('#titulo_modal').text('SALIDA');
        }
    });

    // Selector de categoria ->
    $('#categoria').on('change', function() {
        var selectedCategory = $(this).val();

        // Ocultar todas las secciones
        $('#modelo_andamio_section').hide();
        $('#accesorios_section').hide();
        $('#piezas_section').hide();

        // Mostrar la sección correspondiente
        if (selectedCategory == '1') {
            $('#modelo_andamio_section').show();
        } else if (selectedCategory == '2') {
            $('#accesorios_section').show();
        } else if (selectedCategory == '3') {
            $('#piezas_section').show();
        }
    });

    // Verificar datos capturados 
    $('#transferir').on('click', function() {

        // Capturamos los valores de cada campo
        var movimiento = _movimiento;
        var sucursalOrigen = $('#suc_origen').val();
        var sucursalDestino = $('#suc_destino').val();
        var categoria = $('#categoria').val();
        var cantidad = $('#cantidad').val();
        var paqueteria = $('#paqueteria').val();
        var numGuia = $('#num-guia').val();



        // Condicional para capturar los modelos o accesorios según la categoría seleccionada
        var id_producto = "";

        if (categoria == '1') {

            id_producto = $('#modelo_andamio').val();

        } else if (categoria == '2') {

            id_producto = $('#accesorios').val();
        }

        // Crear un objeto con todos los datos
        var transferenciaData = {
            sucursal_origen: sucursalOrigen,
            sucursal_destino: sucursalDestino,
            categoria: categoria,
            cantidad: cantidad,
            movimiento: movimiento,
            id_producto: id_producto,
            paqueteria: paqueteria,
            numGuia: numGuia,
        };


        // Llamar a la función para enviar los datos al inventario
        // console.log('datos de transferencia :>> ', transferenciaData);
        enviarTrans(transferenciaData);

    });

    // Enviar datos al inventario
    function enviarTrans(data) {
        var data_json = {
            "accion": "guardarTransferenica",
            "datos": {
                "transferenciaData": data
            }
        }
        // console.log('object :>> ', data_json);
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_inv_ajax') }}',
            type: 'post',
            beforeSend: function() {},
            success: function(result) {
                $('#modal_large_redes').modal('hide');
                // Mostrar el loader y el mensaje de actualización
                swal({
                    title: "Actualizando inventario...",
                    text: " ",
                    icon: "info",
                    buttons: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    timer: 1550,
                }).then(() => {
                    // Actualizamos 
                    location.reload();
                });


            },
            error: function(xhr) {
                if (xhr.responseJSON.status === 'error') {
                    swal({
                        icon: 'error',
                        text: '',
                        title: xhr.responseJSON.message,
                        timer: 1200,
                        buttons: false
                    });
                } else {
                    swal({
                        icon: 'error',
                        title: 'Error inesperado',
                        text: 'Ocurrió un error inesperado. Por favor, intenta nuevamente.'
                    });
                }
            }
        });
    }
</script>
