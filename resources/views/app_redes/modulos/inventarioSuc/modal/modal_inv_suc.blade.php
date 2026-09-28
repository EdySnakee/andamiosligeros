<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header d-flex justify-content-between align-items-center"
            style=" padding-bottom: 0px; padding-top: 0px;">
            <div class="d-flex align-items-center">
                @include('app_redes.modulos.ordenes_embarque.assets.carrito')
                {{-- TÍTULO DINÁMICO --}}
                <h5 class="modal-title mb-0 ml-2" id="modalTitulo">
                    {{ isset($tipo_movimiento) && $tipo_movimiento == 'entrada' ? 'Orden de Entrada' : 'Orden de Salida' }}
                </h5>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formMovimientos">
                {{-- INPUT OCULTO PARA EL TIPO --}}
                <input type="hidden" id="tipo_movimiento" value="{{ $tipo_movimiento ?? 'salida' }}">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="number" id="id" hidden>
                        {{-- LABEL DINÁMICO --}}
                        <label for="cotizacion">
                            {{ isset($tipo_movimiento) && $tipo_movimiento == 'entrada' ? 'Referencia / Factura' : 'Cotización' }}:
                        </label>
                        <input type="text" class="form-control" id="cotizacion" name="cotizacion"
                            placeholder="{{ isset($tipo_movimiento) && $tipo_movimiento == 'entrada' ? 'Ref. proveedor' : 'Num cotizacion' }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-md-5">
                        <label for="suc_origen">Sucursal</label>
                        <select id="suc_origen" class="form-control" required>
                            <option value="" disabled selected>Selecciona una sucursal</option>
                            @foreach ($sucursales as $sucursal)
                                <option value="{{ $sucursal->id }}" data-nombre="{{ $sucursal->nombre }}"
                                    {{ $sucursal->id == 3 ? 'selected' : '' }}>
                                    {{ $sucursal->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- OCULTAR TIPO DE SALIDA SI ES ENTRADA --}}
                    @if(!isset($tipo_movimiento) || $tipo_movimiento != 'entrada')
                    <div class="form-group col-md-3">
                        <label for="tipo_salida">Tipo de salida</label>
                        <select id="tipo_salida" class="form-control" required>
                            <option value="" disabled selected>Tipo de salida</option>
                            <option value="ENTREGA">ENTREGA</option>
                            <option value="VENTA">VENTA</option>
                            <option value="PAQUETERIA">PAQUETERÍA</option>
                        </select>
                    </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="comentario">Comentarios</label>
                    <input style="text-transform: uppercase" type="text" class="form-control" id="comentario"
                        name="comentario" placeholder="Comentarios adicionales" required>
                </div>

                <div class="d-flex justify-content-start">
                    <button id="agregarAndamio" type="button" class="btn btn-outline-primary mr-3 btn-sm"><i
                            class="fas fa-plus"> </i>
                        ANDAMIO</button>
                    <button id="agregarAccesorio" type="button" class="btn btn-outline-warning btn-sm"><i
                            class="fas fa-plus"> </i>
                        ACCESORIO</button>
                </div>

                <div id="listaProductos" class="mt-3"></div>
            </form>
        </div>
        <div class="modal-footer">
            <button id="guardarOrden" type="button" class="btn btn-success rounded"> <i class="fas fa-save mr-1"></i>
                Guardar</button>
             {{-- Botones de editar ocultos por defecto, igual que antes --}}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Variables globales
        let productosSeleccionados = [];
        let modelosAndamio = <?php echo $modelos; ?>;
        let modelosAccesorio = <?php echo $accesorios; ?>;

        // Listeners básicos
        document.getElementById('agregarAndamio').addEventListener('click', () => { agregarProducto('andamio') });
        document.getElementById('agregarAccesorio').addEventListener('click', () => { agregarProducto('accesorio') });
        $(document).off("click", "#guardarOrden").on("click", "#guardarOrden", validarYGuardar);

        // Función Agregar Producto (Igual que antes)
        function agregarProducto(tipo) {
            const producto = { tipo, modelo: { id: "", nombre: "" }, cantidad: 1 };
            productosSeleccionados.push(producto);
            actualizarListaProductos();
        }

        // Función Actualizar Visualización (Igual que antes, resumida para brevedad)
        function actualizarListaProductos() {
            const listaProductos = document.getElementById("listaProductos");
            listaProductos.innerHTML = "";
            productosSeleccionados.forEach((producto, index) => {
                const divProducto = document.createElement("div");
                divProducto.className = "producto-item border rounded p-1 mb-3";
                const modelos = producto.tipo === "andamio" ? modelosAndamio : modelosAccesorio;
                
                divProducto.innerHTML = `
                   <div class="form-row align-items-center">
                       <div class="col-md-8">
                           <label class="font-weight-bold text-capitalize">${producto.tipo}</label>
                           <select id="modelo-${index}" class="actualizarModelo form-control" required>
                               <option value="" disabled selected>Seleccione un modelo</option>
                               ${modelos.map(m => `<option value="${m.id}">${m.descripcion}</option>`).join('')}
                           </select>
                       </div>
                       <div class="col-md-2">
                           <label>Cant.</label>
                           <input type="number" class="actualizarCantidad form-control" min="1" value="${producto.cantidad}">
                       </div>
                       <div class="col-md-2"><label>&nbsp;</label><button type="button" class="btn btn-danger btn-sm form-control btn-borrar">X</button></div>
                   </div>`;
                
                listaProductos.appendChild(divProducto);
                
                // Event Listeners dinámicos
                divProducto.querySelector(`#modelo-${index}`).value = producto.modelo.id; // Set value
                divProducto.querySelector(`#modelo-${index}`).addEventListener("change", (e) => {
                    productosSeleccionados[index].modelo = { id: e.target.value, nombre: e.target.options[e.target.selectedIndex].text };
                });
                divProducto.querySelector(".actualizarCantidad").addEventListener("input", (e) => {
                    productosSeleccionados[index].cantidad = parseInt(e.target.value) || 1;
                });
                divProducto.querySelector(".btn-borrar").addEventListener("click", () => {
                    productosSeleccionados.splice(index, 1);
                    actualizarListaProductos();
                });
            });
        }

        // --- LÓGICA DE VALIDACIÓN Y ENVÍO ---
        function validarYGuardar() {
            const tipoMovimiento = document.getElementById("tipo_movimiento").value;
            const selectOrigen = document.getElementById("suc_origen");
            
            // Validación básica
            if(productosSeleccionados.length === 0 || !document.getElementById("fecha").value){
                swal({ title: "Complete los campos y añada productos", icon: "warning", timer: 1200, buttons: false });
                return;
            }

            // Armado de datos
            const data = {
                tipo_movimiento: tipoMovimiento,
                fecha: document.getElementById("fecha").value,
                sucursal_id: selectOrigen.value, // En entrada es donde entra, en salida de donde sale
                referencia: document.getElementById("cotizacion").value, // Cotización o Factura
                comentarios: document.getElementById("comentario").value,
                productos: productosSeleccionados
            };

            // RUTA Y ACCIÓN DINÁMICA
            // Si es ENTRADA -> Usamos InventarioSucController
            // Si es SALIDA -> Usamos la lógica original (OrdenEmbarqueController / ajax_or_emb)
            
            if (tipoMovimiento === 'entrada') {
                enviarEntradaInventario(data);
            } else {
                // Mantenemos tu lógica original para salidas si lo deseas, 
                // o redirigimos todo al inventario. Aquí asumo mantener lógica original para salidas:
                 // Agregamos campos extra que pide Orden de Embarque
                 data.id_origen = data.sucursal_id;
                 data.origen = selectOrigen.options[selectOrigen.selectedIndex].getAttribute("data-nombre");
                 data.id_destino = 7; data.destino = 'SALIDAS'; 
                 data.responsable = data.referencia; data.conducto = data.comentarios;
                 data.estado = 'completada';
                 data.total_piezas = productosSeleccionados.reduce((a, b) => a + parseInt(b.cantidad), 0);
                 
                 guardarSalidaOriginal(data);
            }
        }

        // FUNCIÓN PARA GUARDAR ENTRADA (InventarioSucController)
        function enviarEntradaInventario(data) {
            var data_json = {
                "accion": "guardarEntrada", // Nueva acción en el controlador
                "datos": data
            };

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_inv_path') }}', // Ruta de Inventario
                type: 'post',
                success: function(result) {
                    swal({ title: "Entrada registrada", icon: "success", timer: 1000, buttons: false });
                    $('#modal_large_redes').modal('hide');
                    actualizarInventario(data.sucursal_id); // Refrescar tabla sin recargar toda la pág
                },
                error: function(xhr) {
                    swal({ icon: 'error', title: 'Error', text: 'No se pudo registrar la entrada' });
                }
            });
        }

        // TU FUNCIÓN ORIGINAL PARA SALIDAS (OrdenEmbarque)
        function guardarSalidaOriginal(data) {
             var data_json = {
                 "accion": "guardarOrdenEm",
                 "datos": { "ordenData": data }
             }
             ajaxSetup();
             $.ajax({
                 data: data_json,
                 url: '{{ route('ajax_or_emb') }}', // Ruta original de salidas
                 type: 'post',
                 success: function(result) {
                     swal({ title: result.success, icon: "success", timer: 1000, buttons: false });
                     $('#modal_large_redes').modal('hide');
                     location.reload();
                 },
                 error: function(res) { swal({ icon: 'error', title: 'Error' }); }
             });
        }
    });
</script>