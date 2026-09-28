<div class="modal fade" id="modalOrdenEmd" tabindex="-1" role="dialog" aria-labelledby="modalOrdenEmdLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalOrdenEmdLabel">Orden de Embarque</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formOrdenEmbarque">
                    <!-- Información de la orden -->
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="number" id="id" hidden>
                            <label for="responsable">Responsable</label>
                            <input type="text" class="form-control" id="responsable" name="responsable"
                                placeholder="Nombre del responsable" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fecha">Fecha de Embarque</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="form-group col-md-5">
                            <label for="suc_origen">Origen</label>
                            <select id="suc_origen" class="form-control" required>
                                <option value="" disabled selected>Selecciona una sucursal</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" data-nombre="{{ $sucursal->nombre }}">
                                        {{ $sucursal->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2 text-center d-flex justify-content-center align-items-center">
                            @include('app_redes.modulos.ordenes_embarque.assets.carrito')
                        </div>
                        <div class="form-group col-md-5">
                            <label for="suc_destino">Destino</label>
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

                    <div class="form-group col-md-6">
                        <label for="conducto">Conducto</label>
                        <input style="text-transform: uppercase" type="text" class="form-control" id="conducto"
                            name="conducto" placeholder="PAQUETERIA O CONDUCTOR" required>
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="button" class="btn btn-outline-primary mr-3 btn-sm" id="agregarAndamio"><i
                                class="fas fa-plus"> </i>
                            ANDAMIO</button>
                        <button id="agregarAccesorio" type="button" class="btn btn-outline-warning btn-sm"><i
                                class="fas fa-plus"> </i>
                            ACCESORIO</button>
                    </div>

                    <!-- Lista dinámica de productos agregados -->
                    <div id="listaProductos" class="mt-3">
                        <!-- Aquí se añadirán dinámicamente los productos seleccionados con modelo y cantidad -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-1"></i> Cerrar
                </button>
                <button id="editarOrden" type="button" class="btn btn-info rounded" style="display: none;"><i
                        class="fas fa-edit mr-1"></i> Editar</button>
                <button id="eliminarOrden" type="button" class="btn btn-danger rounded" data-dismiss="modal"
                    style="display: none;">
                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                </button>
                <button id="guardarOrden" type="button" class="btn btn-success rounded" style="display: none;"> <i
                        class="fas fa-save mr-1"></i> Guardar</button>
                <button id="actualizarOrden" type="button" class="btn btn-success rounded" style="display: none;">
                    <i class="fas fa-sync-alt mr-1"></i> Actualizar
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {


        // agregar andamios ->
        document.getElementById('agregarAndamio').addEventListener('click', () => {
            agregarProducto('andamio')
        })

        // agregar accesoriios ->
        document.getElementById('agregarAccesorio').addEventListener('click', () => {
            agregarProducto('accesorio')
        })

        // validar orden ->
        $(document).on("click", "#guardarOrden", validarOrdenEmbarque);
        // Activar editar orden ->
        $(document).on("click", "#editarOrden", editarOrdenEmbarque);
        // Actualizar orden ->
        $(document).on("click", "#actualizarOrden", validarOrdenEmbarque);
        // Eliminar orden ->
        $(document).on("click", "#eliminarOrden", eliminarOrdenEmbarque);


        // Lista para almacenar los productos seleccionados
        let productosSeleccionados = [];


        // Opciones de modelos para cada tipo de producto
        let modelosAndamio = <?php echo $modelos; ?>;
        let modelosAccesorio = <?php echo $accesorios; ?>;


        function getProductosOrden(idOrden) {
            var data = {
                id: idOrden
            }
            var data_json = {
                "accion": "getOrdenID",
                "datos": {
                    "id": idOrden
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_or_emb') }}',
                type: 'post',
                success: function(result) {
                    result.productos.forEach(producto => {
                        var productoFormato = {
                            cantidad: producto.cantidad,
                            modelo: {
                                id: producto.producto_id,
                                nombre: producto.producto
                            },
                            tipo: producto.tipo_producto
                        }
                        productosSeleccionados.push(productoFormato);
                    })
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

        //  agregar un producto nuevo (Andamio o Accesorio)
        function agregarProducto(tipo) {
            const producto = {
                tipo,
                modelo: {
                    id: "",
                    nombre: ""
                },
                cantidad: 1
            };
            productosSeleccionados.push(producto);
            actualizarListaProductos();
        }

        //  actualizar la lista de productos en el modal de forma dinámica
        function actualizarListaProductos() {
            const listaProductos = document.getElementById("listaProductos");
            listaProductos.innerHTML = "";

            productosSeleccionados.forEach((producto, index) => {
                const divProducto = document.createElement("div");
                divProducto.className = "producto-item border rounded p-1 mb-3";

                // Establecemos los modelos según el tipo de producto
                const modelos = producto.tipo === "andamio" ? modelosAndamio : modelosAccesorio;

                // Generamos el HTML para el producto
                divProducto.innerHTML = `
            <div class="form-row align-items-center">
                <div class="col-md-6">
                    <label class="font-weight-bold text-capitalize">${producto.tipo}</label>
                    <select id="modelo-${index}" class="actualizarModelo form-control" required>
                        <option value="" disabled>Seleccione un modelo</option>
                        ${modelos.map(modelo => `<option value="${modelo.id}">${modelo.descripcion}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="actualizarCantidad form-control" min="1" value="${producto.cantidad}">
                </div>
                <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button title="Eliminar" type="button" class="btn btn-danger rounded btn-sm form-control">Borrar</button>
                </div>
            </div>
        `;

                // Agregamos el producto al DOM
                listaProductos.appendChild(divProducto);

                // Establecemos el modelo seleccionado después de añadir el elemento
                const selectModelo = divProducto.querySelector(`#modelo-${index}`);
                selectModelo.value = producto.modelo.id;

                // Eventos para actualizar el modelo y cantidad en productosSeleccionados
                selectModelo.addEventListener("change", (event) => {
                    actualizarModelo(index, event.target);
                });

                const inputCantidad = divProducto.querySelector(".actualizarCantidad");
                inputCantidad.addEventListener("input", (event) => {
                    actualizarCantidad(index, event.target.value);
                });

                const btnEliminar = divProducto.querySelector("button");
                btnEliminar.addEventListener("click", () => {
                    eliminarProducto(index);
                });
            });
        }

        //  actualizar el modelo seleccionado en productosSeleccionados
        function actualizarModelo(index, selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            productosSeleccionados[index].modelo = {
                id: selectedOption.value,
                nombre: selectedOption.textContent
            };
        }

        // actualizar la cantidad del producto
        function actualizarCantidad(index, cantidad) {
            productosSeleccionados[index].cantidad = parseInt(cantidad) || 1;
        }

        // eliminar un producto de la lista
        function eliminarProducto(index) {
            productosSeleccionados.splice(index, 1);
            actualizarListaProductos();
        }

        // Validar datos
        function validarOrdenEmbarque() {

            const selectOrigen = document.getElementById("suc_origen");
            const selectDestino = document.getElementById("suc_destino");

            const totalPiezas = productosSeleccionados.reduce((sum, producto) => parseInt(sum) + parseInt(producto.cantidad), 0);

            const data = {
                id: document.getElementById("id").value,
                fecha: document.getElementById("fecha").value,
                id_origen: document.getElementById("suc_origen").value,
                origen: selectOrigen.options[selectOrigen.selectedIndex].getAttribute("data-nombre"),
                id_destino: document.getElementById("suc_destino").value,
                destino: selectDestino.options[selectDestino.selectedIndex].getAttribute("data-nombre"),
                responsable: document.getElementById("responsable").value,
                conducto: document.getElementById("conducto").value,
                estado: 'pendiente',
                total_piezas: totalPiezas,
                productos: productosSeleccionados
            };

            if (!data.fecha || !data.origen || !data.destino || !data.responsable || !data.conducto ||
                productosSeleccionados.length === 0) {
                swal({
                    title: "Complete todos los campos y añada al menos un producto.",
                    text: " ",
                    icon: "warning",
                    timer: 1000,
                    buttons: false
                });
                return;
            }

            if (data.id === '') {
                // Guardar Orden
                guardarOrdenEmbarque(data);
            } else {
                // Actualizar orden existente
                actualizarOrdenEmbarque(data)
            }
        }

        // Activar -> Editar cotización 
        function editarOrdenEmbarque() {

            let idOrden = document.getElementById('id').value;

            productosSeleccionados = [];

            getProductosOrden(idOrden);

            // Mostrar botones de actualización y edición
            document.getElementById("actualizarOrden").style.display = "inline-block";
            document.getElementById("guardarOrden").style.display = "none";
            document.getElementById("editarOrden").style.display = "none";
            document.getElementById("agregarAndamio").style.display = "inline-block";
            document.getElementById("agregarAccesorio").style.display = "inline-block";
            document.getElementById("eliminarOrden").style.display = "inline-block";


            // Activar los campos del formulario
            $('#responsable').prop('disabled', false);
            $('#fecha').prop('disabled', false);
            $('#suc_origen').prop('disabled', false);
            $('#suc_destino').prop('disabled', false);
            $('#conducto').prop('disabled', false);

            // Activar campos de productos
            $('#listaProductos input').prop('disabled', false);


        }

        // Enviar datos al inventario
        function guardarOrdenEmbarque(data) {
            var data_json = {
                "accion": "guardarOrdenEm",
                "datos": {
                    "ordenData": data
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_or_emb') }}',
                type: 'post',
                beforeSend: function() {

                },
                success: function(result) {
                    swal({
                        title: result.success,
                        text: " ",
                        icon: "success",
                        timer: 1000,
                        buttons: false
                    });

                    document.getElementById("formOrdenEmbarque").reset();
                    productosSeleccionados = [];
                    actualizarListaProductos();

                    $('#modalOrdenEmd').modal('hide');

                    // Actualizamos la pagina
                    location.reload();

                },
                error: function(result) {
                    if (result) {
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

        //Actualizar Orden embarque -> 
        function actualizarOrdenEmbarque(data) {
            // Datos
            if (data) {
                var data_json = {
                    "accion": "actualizarOrden",
                    "datos": {
                        "ordenData": data,
                    }
                };

                console.log('object :>> ', data_json);

                ajaxSetup();
                $.ajax({
                    data: data_json,
                    url: '{{ route('ajax_or_emb') }}',
                    type: 'post',
                    beforeSend: function() {

                    },
                    success: function(result) {

                        swal({
                            title: result.success,
                            text: " ",
                            icon: "success",
                            timer: 1000,
                            buttons: false
                        });

                        document.getElementById("formOrdenEmbarque").reset();
                        productosSeleccionados = [];
                        actualizarListaProductos();

                        $('#modalOrdenEmd').modal('hide');

                        // Actualizamos la pagina
                        location.reload();

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
        }

        //Eliminar Orden embarque -> 
        function eliminarOrdenEmbarque(data) {
            const idOrden = $('#id').val();

            swal({
                title: "¿Eliminar orden de embarque?",
                text: "Una vez eliminada no podras recuperar esta orden de embarque ",
                icon: "info",
                buttons: ["Cancelar", "Confirmar"],
                dangerMode: true,
            }).then((confirmDelete) => {
                if (confirmDelete) {
                    const data_json = {
                        "accion": "eliminarOrden",
                        "datos": {
                            id: idOrden
                        }
                    };

                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('ajax_or_emb') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {

                            if (result.status === 'success') {

                                // respuesta correcta del back
                                swal("Eliminado",
                                    "La orden ha sido eliminada exitosamente.",
                                    "success");

                                //cerrar modal
                                $('#modalOrdenEmd').modal('hide');

                                // Actualizamos la pagina
                                location.reload();

                            } else {
                                swal("Error", "No se pudo eliminar la orden.", "error");
                            }
                        },
                        error: function(error) {
                            swal("Error",
                                "Hubo un problema al eliminar la orden. Por favor, intenta nuevamente.",
                                "error");
                        }
                    });
                } else {
                    return
                    // swal("Actualizando...", "", "info", false);
                }


            });


        }

    });
</script>
