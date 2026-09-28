<?php

namespace App\Http\Controllers;


use App\ModeloAndamio;
use App\AccesoriosAL;
use App\PiezasAL;
use App\MovimientoInv;
use App\InventarioSuc;
use App\Sucursales;

use Illuminate\Http\Request;
use App\Cotizaciones;
use App\DetalleOrdenEmbarque;
use App\Protegeme;

use App\Http\Requests;
use App\OrdenEmbarque;

class OrdenEmbarqueController extends Controller
{

    private $sucursal_id = 4;

    function __construct()
    {
        $this->middleware('auth');
    }

    // Traer todas las sucursales
    public function getSucursales()
    {
        $sucursal = new Sucursales();

        $sucursales = $sucursal
            ->select("*")
            ->get();

        // Retornar el inventario
        return $sucursales;
    }
    // Traer Modelos de andamios
    public function getModelosAndamios()
    {
        $modelo = new ModeloAndamio();

        $modelos = $modelo
            ->select("*")
            ->get();

        // Retornar el inventario
        return $modelos;
    }

    // Traer los Accesorios
    public function getAccesorios()
    {
        $accesorio = new AccesoriosAL();

        $accesorios = $accesorio
            ->select("*")
            ->get();

        return $accesorios;
    }

    // Traer OrdenesEmbarque
    public function getOrdenesEmbarque()
    {
        $ordenEmbarque = new OrdenEmbarque();

        $ordenesEmbarque = $ordenEmbarque
            ->select("*")
            ->get();

        // Retornar el inventario
        return $ordenesEmbarque;
    }

    // INIt -> 
    public function ordenesEmbarque()
    {
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->estatus == 1) {

            //GET sucursales
            $sucursales  = $this->getSucursales();

            // GET modelos andamios
            $modelos = $this->getModelosAndamios();

            // GET accesorios andamios
            $accesorios = $this->getAccesorios();

            //GET ordenes de embarque
            $ordenes = $this->getOrdenesEmbarque();

            //   dd($modelos);

            // Retornar la vista con todas las variables
            return view('app_redes/modulos/ordenes_embarque/view/ordenes_embarque', compact(
                'ordenes',
                'sucursales',
                'accesorios',
                'modelos',
            ));
        } else {
            return \Redirect::to('logout');
        }
    }

    // GUARDAR Orden Embarque
    public function guardarOredenEm($datos)
    {
        // modelo de embarque
        $OrdenEmbarque = new OrdenEmbarque();

        // datos de la orden de embarque
        $datosOrEm = $datos->ordenData;

        $OrdenEmbarque->fecha = $datosOrEm->fecha;
        $OrdenEmbarque->id_destino = $datosOrEm->id_destino;
        $OrdenEmbarque->destino = $datosOrEm->destino;
        $OrdenEmbarque->id_origen = $datosOrEm->id_origen;
        $OrdenEmbarque->origen = $datosOrEm->origen;
        $OrdenEmbarque->total_piezas = $datosOrEm->total_piezas;
        $OrdenEmbarque->conducto = $datosOrEm->conducto;
        $OrdenEmbarque->responsable = $datosOrEm->responsable;
        $OrdenEmbarque->estado = $datosOrEm->estado;
        $OrdenEmbarque->save();

        // obtenemos el id guardado
        $ordenID = $OrdenEmbarque->id;


        // aqui vamos a actualizar en ivn -> 
        $result = $this->guardarDetalleOrden($datos, $ordenID);

        return $result;
    }

    // ACTUALIZAR Orden Embarque
    public function actualizarOredenEm($datos)
    {

        // datos de la orden de embarque
        $datosOrEm = $datos->ordenData;

        // Verificar si estamos actualizando una orden existente
        $OrdenEmbarque = OrdenEmbarque::find($datosOrEm->id);

        $OrdenEmbarque->fecha = $datosOrEm->fecha;
        $OrdenEmbarque->id_destino = $datosOrEm->id_destino;
        $OrdenEmbarque->destino = $datosOrEm->destino;
        $OrdenEmbarque->id_origen = $datosOrEm->id_origen;
        $OrdenEmbarque->origen = $datosOrEm->origen;
        $OrdenEmbarque->total_piezas = $datosOrEm->total_piezas;
        $OrdenEmbarque->conducto = $datosOrEm->conducto;
        $OrdenEmbarque->responsable = $datosOrEm->responsable;
        $OrdenEmbarque->estado = $datosOrEm->estado;
        $OrdenEmbarque->save();

        // obtenemos el id guardado
        $ordenID = $OrdenEmbarque->id;


        // aqui vamos a actualizar en ivn -> 
        $result = $this->guardarDetalleOrden($datos, $ordenID);

        return $result;
    }

    // GUARDAR detalles Orden Embarque
    public function guardarDetalleOrden($datos, $ordenID)
    {
        // Eliminar los detalles de la orden actual si existe
        DetalleOrdenEmbarque::where('orden_id', $ordenID)->delete();

        // datos de la orden de embarque
        $datos = $datos->ordenData;

        foreach ($datos->productos as $producto) {
            $detalleOrden = new DetalleOrdenEmbarque();
            $detalleOrden->orden_id = $ordenID;
            $detalleOrden->tipo_producto = $producto->tipo;
            $detalleOrden->producto_id = $producto->modelo->id;
            $detalleOrden->producto = $producto->modelo->nombre;
            $detalleOrden->cantidad = $producto->cantidad;
            $detalleOrden->save();
        }

        $this->completarSalida($datos, $ordenID);


        return response()->json(['success' => 'Orenden creada exitosamente']);
    }

    // AJAX de Ordenes de embarque
    public function ajax_ordenes_embarque(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'filtrarOrdenEm':

                        $datos = $data_post;

                        $ordenEmbarque = new OrdenEmbarque();

                        $query = $ordenEmbarque->query();

                        if (!empty($datos->fecha)) {
                            $query->whereDate('fecha', '=', $datos->fecha);
                        }

                        if (!empty($datos->sucursal_destino)) {
                            $query->where('id_destino', '=', $datos->sucursal_destino);
                        }

                        if (!empty($datos->sucursal_origen)) {
                            $query->where('id_origen', '=', $datos->sucursal_origen);
                        }

                        if (!empty($datos->estado)) {
                            $query->where('estado', '=', $datos->estado);
                        }

                        $ordenes = $query->get(); // Devuelve una colección de objetos Eloquent.

                        // Retornar la vista generada
                        return view('app_redes.modulos.ordenes_embarque.view.tarjetas', compact('ordenes'))->render();
                        break;
                    case 'guardarOrdenEm':

                        $datos = $data_post;

                        $result  = $this->guardarOredenEm($datos);

                        

                        return $result;
                        break;
                    case 'actualizarOrden':

                        $datos = $data_post;

                        $result  = $this->actualizarOredenEm($datos);

                        return $result;
                        break;
                    case 'autorizarOrden':
                        // Datos
                        $datos = $data_post;

                        // Buscar el Orden por ID
                        $ordenEm = OrdenEmbarque::find($datos->id);

                        if ($ordenEm) {

                            //agregamos el numero de guia
                            if (!empty($datos->numero_guia)) {
                                $ordenEm->guia = $datos->numero_guia;
                            }

                            // Actualizar el estado a 'autorizada'
                            $ordenEm->estado = $datos->status;
                            $ordenEm->save();

                            return response()->json([
                                'status' => 'success',
                                'message' => 'Orden de embarque actualizada',
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Registro no encontrado',
                            ], 404);
                        }
                        break;
                    case 'getOrdenID':
                        // Datos recibidos
                        $datos = $data_post;

                        // Buscar la orden de embarque por ID
                        $ordenEm = OrdenEmbarque::find($datos->id);

                        if ($ordenEm) {
                            // productos asociados DetalleOrdenEmbarque
                            $productos = DetalleOrdenEmbarque::where('orden_id', $ordenEm->id)->get(['tipo_producto', 'producto_id', 'cantidad', 'producto']);

                            // Formatear la respuesta
                            $response = [
                                'orden' => [
                                    'id' => $ordenEm->id,
                                    'fecha' => $ordenEm->fecha,
                                    'id_origen' => $ordenEm->id_origen,
                                    'origen' => $ordenEm->origen,
                                    'id_destino' => $ordenEm->id_destino,
                                    'destino' => $ordenEm->destino,
                                    'total_piezas' => $ordenEm->total_piezas,
                                    'conducto' => $ordenEm->conducto,
                                    'responsable' => $ordenEm->responsable,
                                    'estado' => $ordenEm->estado,
                                ],
                                'productos' => $productos
                            ];

                            return response()->json($response, 200);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Registro no encontrado',
                            ], 404);
                        }
                        break;
                    case 'eliminarOrden':
                        // Datos
                        $datos = $data_post;

                        // Buscar la orden a eliminar por ID
                        $ordenEm = OrdenEmbarque::find($datos->id);

                        if ($ordenEm) {
                            // Buscar y eliminar todos los detalles de la orden
                            $detallesOrden = DetalleOrdenEmbarque::where('orden_id', $datos->id);
                            $detallesOrden->delete();

                            // Eliminar el registro de la orden principal
                            $ordenEm->delete();

                            return response()->json([
                                'status' => 'success',
                                'message' => 'Orden y sus detalles eliminados',
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Registro no encontrado',
                            ], 404);
                        }
                        break;
                    case 'completarOrden':
                        // Datos
                        $datos = $data_post;

                        // Buscar el Orden por ID
                        $ordenEm = OrdenEmbarque::find($datos->id);

                        // Actualizamos inventario
                        $inventario = $this->actualizarInventario($ordenEm);

                        if ($ordenEm) {

                            // Actualizar el estado a 'autorizada'
                            $ordenEm->estado = $datos->status;
                            $ordenEm->nota = $datos->nota;
                            $ordenEm->save();

                            return response()->json([
                                'status' => 'success',
                                'message' => 'Orden Actualizada',
                                $inventario
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Registro no encontrado',
                                $inventario
                            ], 404);
                        }
                        break;
                }
            }
        }
    }


    //Para SAlidas ->
    public function completarSalida($datos, $ordenID)
    {
        $ordenEm = OrdenEmbarque::find($ordenID);
        $inventario = $this->actualizarInventario($ordenEm);

        if ($ordenEm) {
            $ordenEm->estado = 'completada';
            $ordenEm->nota = 'Salida completada';
            $ordenEm->save();

            return [
                'status' => 'success',
                'message' => 'Orden Actualizada',
                'inventario' => $inventario,
                'code' => 200
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Registro no encontrado',
                'inventario' => $inventario,
                'code' => 404
            ];
        }
    }

    //Actualizar inventario
    public function actualizarInventario($ordenEm)
    {
        $nventarioSuc = new InventarioSuc();

        // Obtener los detalles de la orden de embarque
        $detalleOrden = DetalleOrdenEmbarque::where('orden_id', $ordenEm->id)->get();

        foreach ($detalleOrden as $detalle) {
            // Variables del producto actual
            $productoId = $detalle->producto_id;
            $cantidad = $detalle->cantidad;
            $tipoProducto = $detalle->tipo_producto;
            $sucursalDestino = $ordenEm->id_destino;
            $sucursalOrigen = $ordenEm->id_origen;

            // Actualizar inventario en sucursal destino
            $inventarioDestino = $nventarioSuc
                ->where('sucursal_id', $sucursalDestino)
                ->where('producto_id', $productoId)
                ->where('tipo_producto', $tipoProducto)
                ->first();

            if ($inventarioDestino) {
                $inventarioDestino->cantidad += $cantidad;
                $inventarioDestino->save();
            } else {
                $nuevoInventarioDestino = new InventarioSuc();
                $nuevoInventarioDestino->sucursal_id = $sucursalDestino;
                $nuevoInventarioDestino->producto_id = $productoId;
                $nuevoInventarioDestino->tipo_producto = $tipoProducto;
                $nuevoInventarioDestino->cantidad = $cantidad;
                $nuevoInventarioDestino->save();
            }

            // Actualizar inventario en sucursal origen (restando la cantidad)
            $inventarioOrigen = $nventarioSuc
                ->where('sucursal_id', $sucursalOrigen)
                ->where('producto_id', $productoId)
                ->where('tipo_producto', $tipoProducto)
                ->first();

            if ($inventarioOrigen) {
                $inventarioOrigen->cantidad -= $cantidad;
                $inventarioOrigen->save();
            } else {
                // Este caso no debería ocurrir 
                throw new \Exception("Inventario insuficiente en la sucursal de origen para el producto ID $productoId.", 422);
            }
        }

        // Registrar movimientos de inventario
        $this->movimientosInventario($ordenEm);
    }

    //Actualizar Movimientos inventario
    public function movimientosInventario($ordenEm)
    {
        // Obtener los detalles de la orden
        $detalleOrden = DetalleOrdenEmbarque::where('orden_id', $ordenEm->id)->get();

        foreach ($detalleOrden as $detalle) {
            // Registrar salida en la sucursal de origen
            $movimientoSalida = new MovimientoInv();
            $movimientoSalida->sucursal_origen_id = $ordenEm->id_origen; // Origen de la orden
            $movimientoSalida->sucursal_destino_id = $ordenEm->id_destino; // Destino de la orden
            $movimientoSalida->producto_id = $detalle->producto_id;
            $movimientoSalida->tipo_producto = $detalle->tipo_producto;
            $movimientoSalida->tipo_movimiento = 'salida'; // Movimiento de salida
            $movimientoSalida->cantidad = $detalle->cantidad;
            $movimientoSalida->paqueteria = $ordenEm->conducto;
            $movimientoSalida->num_guia = $ordenEm->guia ?: $ordenEm->responsable ?: $ordenEm->conducto;
            $movimientoSalida->comentarios = $ordenEm->nota;
            $movimientoSalida->save();

            // Registrar entrada en la sucursal de destino
            $movimientoEntrada = new MovimientoInv();
            $movimientoEntrada->sucursal_origen_id = $ordenEm->id_origen; // Origen de la orden
            $movimientoEntrada->sucursal_destino_id = $ordenEm->id_destino; // Destino de la orden
            $movimientoEntrada->producto_id = $detalle->producto_id;
            $movimientoEntrada->tipo_producto = $detalle->tipo_producto;
            $movimientoEntrada->tipo_movimiento = 'entrada'; // Movimiento de entrada
            $movimientoEntrada->cantidad = $detalle->cantidad;
            $movimientoEntrada->paqueteria = $ordenEm->conducto;
            $movimientoSalida->num_guia = $ordenEm->guia ?: $ordenEm->responsable ?: $ordenEm->conducto;
            $movimientoEntrada->comentarios = $ordenEm->nota;
            $movimientoEntrada->save();
        }
    }
}
