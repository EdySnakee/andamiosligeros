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
use App\Protegeme;

use App\Http\Requests;

class InventarioSucController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    // Traer inventario por ID
    public function getInventario($sucursal_id)
    {
        $inventario = new InventarioSuc();

        // Realizamos el join con la tabla 'modelos_andamios'
        $inventario_sucursal = $inventario
            ->select(
                'inventario_sucursal.*',
                'modelos_andamios.nombre as nombre_modelo',
                'modelos_andamios.descripcion as desc_modelo',
                'accesorios_andamios.nombre as nombre_accesorio',
                'accesorios_andamios.descripcion as desc_accesorio'
            )
            ->join('modelos_andamios', 'inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
            ->Leftjoin('accesorios_andamios', 'inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->get();

        // Retornamos el inventario con el nombre del modelo asociado
        return $inventario_sucursal;
    }

    //calcaulos para cantidades de invenrtario sucursal
    public function cantidadesInventarioSuc($sucursal_id)
    {
        $inventario = new InventarioSuc();

        // Sumar andamios
        $totalAndamios = $inventario
            ->where('inventario_sucursal.tipo_producto', 'andamio')
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->sum('inventario_sucursal.cantidad');

        // Sumar accesorios
        $totalAccesorios = $inventario
            ->where('inventario_sucursal.tipo_producto', 'accesorio')
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->sum('inventario_sucursal.cantidad');

        return [
            'total_andamios' => $totalAndamios,
            'total_accesorios' => $totalAccesorios,
        ];
    }

    //calcular los totales de invenrtario sucursal
    public function totalesInventarioSuc($sucursal_id)
    {
        $inventario = new InventarioSuc();

        // Sumar el costo total de los andamios (costo * cantidad)
        $costo_andamios = $inventario
            ->where('inventario_sucursal.tipo_producto', 'andamio')
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->join('modelos_andamios', 'inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
            ->selectRaw('SUM(inventario_sucursal.cantidad * modelos_andamios.costo) as total_costo_andamios')
            ->value('total_costo_andamios');

        // Sumar el costo total de los accesorios (si lo necesitas)
        $costo_accesorios = $inventario
            ->where('inventario_sucursal.tipo_producto', 'accesorio')
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->join('accesorios_andamios', 'inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
            ->selectRaw('SUM(inventario_sucursal.cantidad * accesorios_andamios.costo) as total_costo_accesorios')
            ->value('total_costo_accesorios');


        $suma_total_inventario = $costo_andamios + $costo_accesorios;

        // dd('Suma invent:', $suma_total_inventario);

        return  $suma_total_inventario;
    }

    // INIt -> validacion de usuario
    public function inventarioSuc()
    {
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->estatus == 1) {

            if (\Auth::User()->id == 26) {

                $sucursal_id = 5; //GDL

            } elseif (\Auth::User()->id == 25) {

                $sucursal_id = 1; //MTY

            } elseif (\Auth::User()->id == 16) {

                $sucursal_id = 3; //CDMX

            } elseif (\Auth::User()->id == 32) {

                $sucursal_id = 3; //CDMX

            }

            // Llamar a la sucursal ID 
            $inventario_sucursal = $this->getInventario($sucursal_id);

            // calcular andamios
            $calculo_sucursal = $this->cantidadesInventarioSuc($sucursal_id);

            //totales_sucursal
            $totales_sucursal = $this->totalesInventarioSuc($sucursal_id);


            // Extraer los valores
            $cantidad_andamios = $calculo_sucursal['total_andamios'];
            $cantidad_accesorios = $calculo_sucursal['total_accesorios'];

            //fecha actual
            $fecha_actual = \Carbon\Carbon::now()->format('d/m/Y');

            // dd('datos ->', $inventario_sucursal);

            return view('app_redes/modulos/inventarioSuc/view/inventarioSuc', compact(
                'inventario_sucursal',
                'cantidad_andamios',
                'cantidad_accesorios',
                'totales_sucursal',
                'fecha_actual'
            ));
        } else {
            return \Redirect::to('logout');
        }
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

    // Traer los piezas ( refacciones ) 
    public function getPiezas()
    {
        $pieza = new PiezasAL();

        $piezas = $pieza
            ->select("*")
            ->get();

        return $piezas;
    }

    // Guardar movimiento inventario
    public function guardarMovimiento($datos)
    {

        $datosInventario = new MovimientoInv();

        $inventario = $datos->transferenciaData;

        $datosInventario->sucursal_origen_id = $inventario->sucursal_origen;
        $datosInventario->sucursal_destino_id = $inventario->sucursal_destino;
        $datosInventario->producto_id = $inventario->id_producto;
        $datosInventario->tipo_producto = $inventario->categoria;
        $datosInventario->tipo_movimiento = $inventario->movimiento;
        $datosInventario->cantidad = $inventario->cantidad;
        $datosInventario->comentarios = $inventario->comentarios;
        $datosInventario->save();

        // actualizar las tablas de inventarios ->
        $result = $this->actualizarInventarios($datos);


        return $result;
    }

    // Actualizar intventario
    public function actualizarInventarios($datos)
    {
        $dtoInventario = new InventarioSuc();

        $inventario = $datos->transferenciaData;
        $_categoria = '';

        switch ($inventario->categoria) {
            case 1:
                $_categoria = 'andamio';
                break;
            case 2:
                $_categoria = 'accesorio';
                break;
            case 3:
                $_categoria = 'pieza';
                break;
        }

        // Inventario de origen
        $inventarioOrigen = $dtoInventario
            ->where('sucursal_id', $inventario->sucursal_origen)
            ->where('producto_id', $inventario->id_producto)
            ->where('tipo_producto', $_categoria)
            ->first();

        // dd('Inventario de origen', $inventarioOrigen);

        if ($inventarioOrigen) {
            // Restar la cantidad transferida al inventario de origen
            $inventarioOrigen->cantidad -= $inventario->cantidad;

            // Verificar que la cantidad no quede en valores negativos
            if ($inventarioOrigen->cantidad >= 0) {
                $inventarioOrigen->save();
            } else {
                return response()->json(['status' => 'error', 'message' => 'Cantidad insuficiente en inventario de origen.'], 400);
            }
        } else {
            // Si no existe el inventario en la sucursal de origen, manejamos el error
            return response()->json(['status' => 'error', 'message' => 'Inventario no encontrado en la sucursal de origen.'], 400);
        }


        // Obtener el inventario de la sucursal de destino
        $inventarioDestino = $dtoInventario
            ->where('sucursal_id', $inventario->sucursal_destino)
            ->where('producto_id', $inventario->id_producto)
            ->where('tipo_producto', $_categoria)
            ->first();

        //  dd('------>',$inventarioDestino);

        if ($inventarioDestino) {
            // Sumar la cantidad en la sucursal de destino
            $inventarioDestino->cantidad += $inventario->cantidad;
            $inventarioDestino->save();
        } else {
            // Si no existe en la sucursal destino, creamos el registro
            $nuevoInventarioDestino = new InventarioSuc();
            $nuevoInventarioDestino->sucursal_id = $inventario->sucursal_destino;
            $nuevoInventarioDestino->producto_id = $inventario->id_producto;
            $nuevoInventarioDestino->tipo_producto = $inventario->categoria;
            $nuevoInventarioDestino->cantidad = $inventario->cantidad;
            $nuevoInventarioDestino->save();
        }


        return response()->json(['success' => 'Transferencia completada exitosamente']);
    }

    // AJAX de inventario
    public function ajax_inventario(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'actualizarInv':

                        $id_sucursal = $request->input('datos.id_sucursal');
                        $inventario = new InventarioSuc();

                        // Realizamos el join con la tabla 'modelos_andamios'
                        $inventario_sucursal = $inventario
                            ->select(
                                'inventario_sucursal.*',
                                'modelos_andamios.nombre as nombre_modelo',
                                'modelos_andamios.descripcion as desc_modelo',
                                'accesorios_andamios.nombre as nombre_accesorio',
                                'accesorios_andamios.descripcion as desc_accesorio'
                            )
                            ->join('modelos_andamios', 'inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
                            ->Leftjoin('accesorios_andamios', 'inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
                            ->where('inventario_sucursal.sucursal_id', $id_sucursal)
                            ->get();

                        // Retornar solo la vista parcial de la tabla con los datos actualizados
                        return view('app_redes.modulos.inventarioSuc.view.tabla_inventarioSuc', compact('inventario_sucursal'))->render();
                        break;
                    case 'filtrarCategoria':
                        $datos = $data_post;
                        $categoria = $datos->categoria;

                        // 1. DETECCIÓN AUTOMÁTICA DE SUCURSAL (Para no depender del JS)
                        // Copiamos tu lógica de permisos para asegurar que vemos la sucursal correcta
                        $id_sucursal = 3; // Default CDMX
                        if (\Auth::User()->id == 26) {
                            $id_sucursal = 5;
                        }      // GDL
                        elseif (\Auth::User()->id == 25) {
                            $id_sucursal = 1;
                        }  // MTY
                        elseif (\Auth::User()->id == 16 || \Auth::User()->id == 32) {
                            $id_sucursal = 3;
                        } // CDMX

                        // Si el JS mandó un ID específico diferente, podrías usarlo, 
                        // pero por seguridad es mejor confiar en el Auth o usar el del JS si Auth falla.
                        // $id_sucursal = $datos->id_sucursal ?? $id_sucursal; 

                        $inventario = new InventarioSuc();
                        $inventario_sucursal = $inventario
                            ->select(
                                'inventario_sucursal.*',
                                'modelos_andamios.nombre as nombre_modelo',
                                'modelos_andamios.descripcion as desc_modelo',
                                'accesorios_andamios.nombre as nombre_accesorio',
                                'accesorios_andamios.descripcion as desc_accesorio'
                            )
                            // CORRECCIÓN AQUÍ: Cambiamos 'join' por 'leftJoin'
                            ->leftJoin('modelos_andamios', 'inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
                            ->leftJoin('accesorios_andamios', 'inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
                            ->where('inventario_sucursal.sucursal_id', $id_sucursal)
                            ->where('inventario_sucursal.tipo_producto', $categoria)
                            ->get();

                        return view('app_redes.modulos.inventarioSuc.view.tabla_inventarioSuc', compact('inventario_sucursal'))->render();
                        break;
                    case 'openModal':
                        // Recibimos el tipo de movimiento
                        $tipo_movimiento = $data_post->tipo_movimiento ?? 'salida';

                        // Llamamos a los datos necesarios
                        $sucursales = $this->getSucursales();
                        $modelos = $this->getModelosAndamios();
                        $accesorios = $this->getAccesorios();

                        // Pasamos $tipo_movimiento a la vista
                        return view(
                            'app_redes/modulos/inventarioSuc/modal/modal_inv_suc',
                            compact('sucursales', 'modelos', 'accesorios', 'tipo_movimiento')
                        );
                        break;

                    case 'guardarEntrada':

                        $datos = $data_post;
                        $sucursal_id = $datos->sucursal_id;
                        $productos = $datos->productos;
                        $referencia = $datos->referencia ?? 'Sin referencia'; // La factura o cotización
                        $comentarios = $datos->comentarios ?? '';

                        foreach ($productos as $prod) {
                            // 1. Determinar categoría texto para la BD
                            $tipo_prod_bd = ($prod->tipo == 'andamio') ? 'andamio' : 'accesorio';

                            // 2. ACTUALIZAR STOCK (Tu lógica actual)
                            $inventario = InventarioSuc::where('sucursal_id', $sucursal_id)
                                ->where('producto_id', $prod->modelo->id)
                                ->where('tipo_producto', $tipo_prod_bd)
                                ->first();

                            if ($inventario) {
                                $inventario->cantidad += $prod->cantidad;
                                $inventario->fecha_actualizacion = \Carbon\Carbon::now();
                                $inventario->save();
                            } else {
                                $nuevo = new InventarioSuc();
                                $nuevo->sucursal_id = $sucursal_id;
                                $nuevo->producto_id = $prod->modelo->id;
                                $nuevo->tipo_producto = $tipo_prod_bd;
                                $nuevo->cantidad = $prod->cantidad;
                                $nuevo->fecha_actualizacion = \Carbon\Carbon::now();
                                $nuevo->save();
                            }

                            // 3. --- NUEVO: GUARDAR EN HISTORIAL (MovimientoInv) ---
                            $movimiento = new MovimientoInv();

                            // En una entrada de compra, el origen suele ser nulo o 0, 
                            // y el destino es tu sucursal.
                            $movimiento->sucursal_origen_id = 0; // 0 representa "Externo" o "Proveedor"
                            $movimiento->sucursal_destino_id = $sucursal_id;

                            $movimiento->producto_id = $prod->modelo->id;
                            $movimiento->tipo_producto = $tipo_prod_bd;

                            $movimiento->tipo_movimiento = 'entrada'; // Importante para filtrar reportes
                            $movimiento->cantidad = $prod->cantidad;

                            // Usamos los campos de texto para guardar la referencia (Factura)
                            $movimiento->paqueteria = 'Proveedor / Ajuste';
                            $movimiento->num_guia = $referencia; // Aquí guardamos el núm de factura/cotización
                            $movimiento->comentarios = $comentarios;

                            $movimiento->save();
                        }

                        return response()->json(['success' => 'Entrada registrada e historial actualizado']);
                        break;
                    case 'guardarTransferenica':

                        $datos = $data_post;

                        $result  = $this->guardarMovimiento($datos);

                        return $result;
                        break;
                        break;
                }
            }
        }
    }
}
