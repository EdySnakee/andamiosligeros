<?php

namespace App\Http\Controllers;


use App\ModeloAndamio;
use App\AccesoriosAL;
use App\PiezasAL;
use App\MovimientoInv;
use App\InventarioSuc;
use App\Sucursales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InventarioController extends Controller
{

    private $max_row = 10;
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

    // Traer los piezas ( refacciones ) 
    public function getPiezas()
    {
        $pieza = new PiezasAL();

        $piezas = $pieza
            ->select("*")
            ->get();

        return $piezas;
    }

    // Traer inventarios
    public function getInventario($sucursal_id)
    {
        $inventario = new InventarioSuc();


        $inventario_sucursal = $inventario
            ->select(
                'inventario_sucursal.*',
                // Campos para modelos de andamios
                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_modelo"),
                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_modelo"),
                DB::raw("CASE 
                     WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.costo 
                     ELSE NULL 
                  END AS costo_modelo"),
                DB::raw("CASE 
                  WHEN inventario_sucursal.tipo_producto = 'andamio' THEN (modelos_andamios.costo * inventario_sucursal.cantidad) 
                  ELSE NULL 
               END AS suma_modelo"),
                // Campos para accesorios
                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_accesorio"),
                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_accesorio"),
                DB::raw("CASE 
                     WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.costo 
                     ELSE NULL 
                  END AS costo_accesorio"),
                DB::raw("CASE 
                  WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN (accesorios_andamios.costo * inventario_sucursal.cantidad) 
                  ELSE NULL 
               END AS suma_accesorio"),
            )
            ->leftJoin('modelos_andamios', function ($join) {
                $join->on('inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
                    ->where('inventario_sucursal.tipo_producto', '=', 'andamio');
            })
            ->leftJoin('accesorios_andamios', function ($join) {
                $join->on('inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
                    ->where('inventario_sucursal.tipo_producto', '=', 'accesorio');
            })
            ->where('inventario_sucursal.sucursal_id', $sucursal_id)
            ->get();

        return $inventario_sucursal;
    }

    // Traer ENTRADAS inventario
    public function getEntradas($sucursal_id)
    {
        $entradas = new MovimientoInv();
        $movimientos_entradas = $entradas
            ->select(
                'movimientos_inventario.*',
                DB::raw("CASE 
                        WHEN movimientos_inventario.tipo_producto = 'andamio' THEN modelos_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_modelo"),
                DB::raw("CASE 
                        WHEN movimientos_inventario.tipo_producto = 'andamio' THEN modelos_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_modelo"),
                DB::raw("CASE 
                        WHEN movimientos_inventario.tipo_producto = 'accesorio' THEN accesorios_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_accesorio"),
                DB::raw("CASE 
                        WHEN movimientos_inventario.tipo_producto = 'accesorio' THEN accesorios_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_accesorio")
            )
            ->leftJoin('modelos_andamios', function ($join) {
                $join->on('movimientos_inventario.producto_id', '=', 'modelos_andamios.id')
                    ->where('movimientos_inventario.tipo_producto', '=', 'andamio');
            })
            ->leftJoin('accesorios_andamios', function ($join) {
                $join->on('movimientos_inventario.producto_id', '=', 'accesorios_andamios.id')
                    ->where('movimientos_inventario.tipo_producto', '=', 'accesorio');
            })
            ->where('movimientos_inventario.tipo_movimiento', 'entrada')
            ->where('movimientos_inventario.sucursal_destino_id', $sucursal_id)
            ->orderBy('movimientos_inventario.fecha_movimiento', 'DESC')
            ->get();

        return $movimientos_entradas;
    }

    // Traer SALIDAS inventario
    public function getSalidas($sucursal_id)
    {
        $salidas = new MovimientoInv();
        $movimientos_salidas = $salidas
            ->select(
                'movimientos_inventario.*',
                DB::raw("CASE 
                      WHEN movimientos_inventario.tipo_producto = 'andamio' THEN modelos_andamios.nombre 
                      ELSE NULL 
                   END AS nombre_modelo"),
                DB::raw("CASE 
                      WHEN movimientos_inventario.tipo_producto = 'andamio' THEN modelos_andamios.descripcion 
                      ELSE NULL 
                   END AS desc_modelo"),
                DB::raw("CASE 
                      WHEN movimientos_inventario.tipo_producto = 'accesorio' THEN accesorios_andamios.nombre 
                      ELSE NULL 
                   END AS nombre_accesorio"),
                DB::raw("CASE 
                      WHEN movimientos_inventario.tipo_producto = 'accesorio' THEN accesorios_andamios.descripcion 
                      ELSE NULL 
                   END AS desc_accesorio")
            )
            ->leftJoin('modelos_andamios', function ($join) {
                $join->on('movimientos_inventario.producto_id', '=', 'modelos_andamios.id')
                    ->where('movimientos_inventario.tipo_producto', '=', 'andamio');
            })
            ->leftJoin('accesorios_andamios', function ($join) {
                $join->on('movimientos_inventario.producto_id', '=', 'accesorios_andamios.id')
                    ->where('movimientos_inventario.tipo_producto', '=', 'accesorio');
            })
            ->where('movimientos_inventario.tipo_movimiento', 'salida')
            ->where('movimientos_inventario.sucursal_origen_id', $sucursal_id)
            ->orderBy('movimientos_inventario.fecha_movimiento', 'DESC')
            ->get();

        return $movimientos_salidas;
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
    public function vistaAdmin()
    {
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->estatus == 1) {

            // Validamos si es gerente
            if (\Auth::User()->tipo_usuario == 'g1') {
                $sucursal_id = \Auth::User()->sucursal_id;
            } else {
                $sucursal_id = 4; //MATRIZ
            }

            $nombre_sucursal = Sucursales::where('id', $sucursal_id)->value('nombre');

            // Llamar a la sucursal ID
            $inventario_sucursal = $this->getInventario($sucursal_id);

            // llamar a las sucursales
            $sucursales  = $this->getSucursales();

            //Traer las entradas y salidas
            $entradas  = $this->getEntradas($sucursal_id);
            $salidas  = $this->getSalidas($sucursal_id);

            //Calcular total de sucursal
            $totales_sucursal = $this->totalesInventarioSuc($sucursal_id);

            // Retornar la vista con todas las variables
            return view('app_redes/modulos/inventario/admin_dash/admin', compact(
                'inventario_sucursal',
                'sucursales',
                'entradas',
                'salidas',
                'totales_sucursal',
                'nombre_sucursal',
            ));
        } else {
            return \Redirect::to('logout');
        }
    }

    // guardar movimientos
    public function guardarMovimiento($datos)
    {
        // Crear el movimiento original (entrada o salida)
        $datosInventario = new MovimientoInv();
        $inventario = $datos->transferenciaData;

        $datosInventario->sucursal_origen_id = $inventario->sucursal_origen;
        $datosInventario->sucursal_destino_id = $inventario->sucursal_destino;
        $datosInventario->producto_id = $inventario->id_producto;
        $datosInventario->tipo_producto = $inventario->categoria;
        $datosInventario->tipo_movimiento = $inventario->movimiento; // entrada o salida
        $datosInventario->cantidad = $inventario->cantidad;
        $datosInventario->paqueteria = $inventario->paqueteria;
        $datosInventario->num_guia = $inventario->numGuia;
        $datosInventario->save();

        // Crear el movimiento inverso
        $movimientoInverso = new MovimientoInv();
        $movimientoInverso->sucursal_origen_id = $inventario->sucursal_origen;
        $movimientoInverso->sucursal_destino_id = $inventario->sucursal_destino;
        $movimientoInverso->producto_id = $inventario->id_producto;
        $movimientoInverso->tipo_producto = $inventario->categoria;

        // Si el movimiento original es 'entrada', el inverso será 'salida' y viceversa
        if ($inventario->movimiento === 'entrada') {
            $movimientoInverso->tipo_movimiento = 'salida';
        } else {
            $movimientoInverso->tipo_movimiento = 'entrada';
        }

        $movimientoInverso->cantidad = $inventario->cantidad;
        $movimientoInverso->paqueteria = $inventario->paqueteria;
        $movimientoInverso->num_guia = $inventario->numGuia;
        $movimientoInverso->save();

        // Actualizar inventarios
        $result = $this->actualizarInventarios($datos);

        return $result;
    }

    //Actualizar inventario
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
    public function ajax_inventario_admin(Request $request)
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


                        $inventario_sucursal = $inventario
                            ->select(
                                'inventario_sucursal.*',
                                // Campos para modelos de andamios
                                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_modelo"),
                                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_modelo"),
                                DB::raw("CASE 
                     WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.costo 
                     ELSE NULL 
                  END AS costo_modelo"),
                                DB::raw("CASE 
                  WHEN inventario_sucursal.tipo_producto = 'andamio' THEN (modelos_andamios.costo * inventario_sucursal.cantidad) 
                  ELSE NULL 
               END AS suma_modelo"),
                                // Campos para accesorios
                                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.nombre 
                        ELSE NULL 
                     END AS nombre_accesorio"),
                                DB::raw("CASE 
                        WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.descripcion 
                        ELSE NULL 
                     END AS desc_accesorio"),
                                DB::raw("CASE 
                     WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.costo 
                     ELSE NULL 
                  END AS costo_accesorio"),
                                DB::raw("CASE 
                  WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN (accesorios_andamios.costo * inventario_sucursal.cantidad) 
                  ELSE NULL 
               END AS suma_accesorio"),
                            )
                            ->leftJoin('modelos_andamios', function ($join) {
                                $join->on('inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
                                    ->where('inventario_sucursal.tipo_producto', '=', 'andamio');
                            })
                            ->leftJoin('accesorios_andamios', function ($join) {
                                $join->on('inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
                                    ->where('inventario_sucursal.tipo_producto', '=', 'accesorio');
                            })
                            ->where('inventario_sucursal.sucursal_id', $id_sucursal)
                            ->get();

                        return view('app_redes.modulos.inventario.admin_dash.tabla_admin', compact('inventario_sucursal'));
                        break;
                    case 'actualizarMov':
                        $sucursal_id = $request->input('datos.id_sucursal');

                        //Traer las entradas y salidas
                        $entradas  = $this->getEntradas($sucursal_id);
                        $salidas  = $this->getSalidas($sucursal_id);

                        //  dd('controller->', $entradas, $salidas);

                        return view('app_redes.modulos.inventario.admin_dash.movimientos', compact('entradas', 'salidas'));
                        break;
                    case 'actualizarTotales':
                        $sucursal_id = $request->input('datos.id_sucursal');

                        //Calcular total de sucursal
                        $totales_sucursal = $this->totalesInventarioSuc($sucursal_id);
                        //  dd('controller->', $entradas, $salidas);

                        return view('app_redes.modulos.inventario.admin_dash.totales_inven', compact('totales_sucursal'));
                        break;
                    case 'filtrarCategoria':
                        $inventario = new InventarioSuc();
                        $id_sucursal = $request->input('datos.id_sucursal');
                        $categoria = $request->input('datos.categoria');

                        // Realizamos la consulta adaptada según el tipo de producto
                        $inventario_sucursal = $inventario
                            ->select(
                                'inventario_sucursal.*',
                                // Campos para modelos de andamios
                                DB::raw("CASE 
                                    WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.nombre 
                                    ELSE NULL 
                                 END AS nombre_modelo"),
                                DB::raw("CASE 
                                    WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.descripcion 
                                    ELSE NULL 
                                 END AS desc_modelo"),
                                DB::raw("CASE 
                                 WHEN inventario_sucursal.tipo_producto = 'andamio' THEN modelos_andamios.costo 
                                 ELSE NULL 
                              END AS costo_modelo"),
                                DB::raw("CASE 
                              WHEN inventario_sucursal.tipo_producto = 'andamio' THEN (modelos_andamios.costo * inventario_sucursal.cantidad) 
                              ELSE NULL 
                           END AS suma_modelo"),
                                // Campos para accesorios
                                DB::raw("CASE 
                                    WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.nombre 
                                    ELSE NULL 
                                 END AS nombre_accesorio"),
                                DB::raw("CASE 
                                    WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.descripcion 
                                    ELSE NULL 
                                 END AS desc_accesorio"),
                                DB::raw("CASE 
                                 WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN accesorios_andamios.costo 
                                 ELSE NULL 
                              END AS costo_accesorio"),
                                DB::raw("CASE 
                              WHEN inventario_sucursal.tipo_producto = 'accesorio' THEN (accesorios_andamios.costo * inventario_sucursal.cantidad) 
                              ELSE NULL 
                           END AS suma_accesorio"),
                            )
                            ->leftJoin('modelos_andamios', function ($join) {
                                $join->on('inventario_sucursal.producto_id', '=', 'modelos_andamios.id')
                                    ->where('inventario_sucursal.tipo_producto', '=', 'andamio');
                            })
                            ->leftJoin('accesorios_andamios', function ($join) {
                                $join->on('inventario_sucursal.producto_id', '=', 'accesorios_andamios.id')
                                    ->where('inventario_sucursal.tipo_producto', '=', 'accesorio');
                            })
                            ->where('inventario_sucursal.sucursal_id', $id_sucursal)
                            ->where('inventario_sucursal.tipo_producto', $categoria) // Filtro por categoría
                            ->get();

                        // Retornar solo la vista parcial de la tabla con los datos actualizados
                        return view('app_redes.modulos.inventario.admin_dash.tabla_admin', compact('inventario_sucursal'));

                        break;
                    case 'openModalTransferencia':

                        $accion = $request->accion;

                        // llamar a las sucursales
                        $sucursales  = $this->getSucursales();

                        // llamar a los modelos andamios
                        $modelos  = $this->getModelosAndamios();

                        // llamar a los accesorios andamios
                        $accesorios  = $this->getAccesorios();


                        return view('app_redes/modulos/inventario/modal_inv/modal_inv', compact('accion', 'sucursales', 'modelos', 'accesorios'));
                        break;
                    case 'guardarTransferenica':

                        $datos = $data_post;

                        $result  = $this->guardarMovimiento($datos);

                        return $result;
                        break;
                }
            }
        }
    }
}
