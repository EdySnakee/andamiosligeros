<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Clientes;
use App\User;
class Cotizaciones extends Model
{
    protected $table = "cotizaciones";
    public $timestamps = false;
    protected $primaryKey = "id_cotizacion";
    protected $fillable = [
        'id_cotizacion',
        'giro_empresa',
        'id_cliente',
        'id_usuario_genera',
        'cod_cotizacion',
        'cod_venta',
        'fecha',
        'fecha_formato',
        'hora',
        'fecha_venta',
        'fecha_venta_formato',
        'hora_venta',
        'porcentaje_descuento',
        'descuento_aplicado',
        'subtotal',
        'iva',
        'total',
        'status',
        'mp_status',
        'ruta_encrypt',
        'forma_pago',
        'exportacion',
        'moneda',
        'metodo_pago',
        'configuracion',
        'id_sucursal'
    ];

    public static function agregaConcepto($concepto, $data_post)
    {
        //dd($data_post);
        $_SESSION['conceptos'][] = $concepto; 
        $funsionTabla = new Cotizaciones();
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function eliminaConcepto($data_post)
    {
        if (!isset($data_post->id)) {
            echo "Sin acceso, concepto no valido";
        }
        $id = $data_post->id;
        //print_r($id);
        //si no hay conceptos
        if (!isset($_SESSION['conceptos']) || empty($_SESSION['conceptos'])) {
            echo "No hay conceptos en lista";
        }
        //si si hay conceptos
        foreach ($_SESSION['conceptos'] as $i => $v) {
            if ($v['id'] == $id) {
                unset ($_SESSION['conceptos'][$i]);
            }
        }

        $funsionTabla = new Cotizaciones();
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function eliminaImpuesto($data_post)
    {
        $funsionTabla = new Cotizaciones();
        //$iva = "no";
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function agregaImpuesto($data_post)
    {
        $funsionTabla = new Cotizaciones();
        //$iva = "si";
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function agregaDescuento($data_post)
    {
        //$descuento = $data_post->descuento;
        $funsionTabla = new Cotizaciones();
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function eliminaEnvio($data_post)
    {
        //$descuento = $data_post->descuento;
        $funsionTabla = new Cotizaciones();
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }
    
    public static function validaEnvio($data_post)
    {
        //$descuento = $data_post->descuento;
        $funsionTabla = new Cotizaciones();
        echo $tabla_actualizada = $funsionTabla->actualizaTabla($_SESSION['conceptos'], $data_post, "");
    }

    public static function actualizaTabla($info_array, $data_post, $accion)
    {   
        $subtotal = 0;
        $impuestos = 0;
        $total = 0;
        $subtotal_sin_descuento = 0;
        $num_proc = 0;
        $descuento_global = 0;
        $nuevo_descuento = 0;

        if (!empty($info_array)) {
            foreach ($info_array as $i => $v) {
                ?>
                <tr class="fila-det-servicio">
                    <td class="text-center" style="vertical-align: middle;"><?php echo $v['cantidad'] ?></td>
                    <td class="text-left font-weight-bold" nomb-det-serv="<?php echo htmlspecialchars($v['nombre_producto'], ENT_QUOTES) ?>" data-id-producto="<?php echo $v['id_producto'] ?>" style="vertical-align: middle;"><?php echo $v['nombre_producto'] ?></td>
                    <td class="text-center" style="vertical-align: middle;"><span style="color: #007bff; font-weight: 600;">ANEXO <?php echo $v['sku'] ?></span></td>
                    <td class="text-center" data-punit="<?php echo $v['costo'] ?>" data-alto="<?php echo $v['alto'] ?>" data-largo="<?php echo $v['largo'] ?>" style="vertical-align: middle;"><?php echo "$".number_format($v['costo'], 2, '.', ',') ?></td>
                    <td class="text-center font-weight-bold" data-total-ind="<?php echo $v['total'] ?>" style="vertical-align: middle;"><?php echo "$".number_format($v['total'], 2, '.', ',') ?></td>
                    <td class="text-center boton-eliminar col-accion-td no-captura" data-tipo-cobro="<?= $v['tipo_cobro'] ?>" dimensiones="<?php if ($v['tipo_cobro'] == "m2"){echo $v['dimensiones'];}else{echo "N/A";} ?>" style="vertical-align: middle;">
                        <button type="button" class="eliminar_servicio btn btn-sm btn-outline-danger" style="border-radius: 50%; width: 26px; height: 26px; padding: 0; line-height: 24px;" data-id="<?php echo $v['id'] ?>" title="Eliminar"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
                <?php
                $subtotal_sin_descuento += $v['total'];
                if ($v['categoria'] == "andamio") {
                    $num_proc += $v['cantidad'];
                }
            }
        } else {
            ?>
            <tr id="sin_conceptos_row">
                <td colspan="6" class="text-center text-muted py-4" style="background: #fafafa;">
                    <span style="font-size: 13px; color: #888;">No hay productos agregados a la cotización</span>
                </td>
            </tr>
            <?php
        }
        
        if (!empty($data_post->descuento_aplicado)) {
            if ($data_post->t_descuento == "Porcentual") {
                if(!empty($accion) and $accion == "editar"){
                    $descuento = ((float)$subtotal_sin_descuento * $data_post->descuento); 
                }else{
                    $descuento = ((float)$subtotal_sin_descuento * $data_post->descuento_aplicado); 
                }
                $nuevo_descuento = $descuento/100; 
            }
            if ($data_post->t_descuento == "Fijo") {
                if (!empty($accion) and $accion == "editar") {
                    $nuevo_descuento = $data_post->descuento; 
                }else{
                    $nuevo_descuento = $data_post->descuento_aplicado; 
                }
            }
        } else {
            $nuevo_descuento = 0;
        }

        $envio_val = (!empty($data_post->envio) ? (float)$data_post->envio : 0);
        $base_productos = max(0, (float)$subtotal_sin_descuento - (float)$nuevo_descuento);
        $subtotal_global = round($base_productos + $envio_val, 2);
        
        $activa_iva_bool = (isset($data_post->activa_iva) && ($data_post->activa_iva === true || $data_post->activa_iva === "true" || $data_post->activa_iva === 1 || $data_post->activa_iva === "1"))
            || (isset($data_post->iva) && (float)$data_post->iva > 0);

        if ($activa_iva_bool) {
            $impuestos = round($subtotal_global * 0.16, 2);
        } else {
            $impuestos = 0;
        }

        $total = round($subtotal_global + $impuestos, 2);
        ?>
        <tr id="fila_totales_hidden" style="display: none !important;">
            <td colspan="6">
                <input type="hidden" id="subtotal_sin_descuento" value="<?php echo $subtotal_sin_descuento ?>">
                <span id="subtotal_global" data-subtotal-global="<?php echo $subtotal_global ?>"></span>
                <span id="nuevo_descuento" data-nuevo-descuento="<?php echo $nuevo_descuento ?>"></span>
                <span id="envio" data-costo-envio="<?php echo $envio_val ?>"></span>
                <input type="hidden" id="iva" value="<?php echo $impuestos ?>">
                <input type="hidden" id="v_iva" value="<?php echo (!empty($impuestos) ? $impuestos : "0.0") ?>">
                <span id="total" data-total="<?php echo $total ?>"></span>
            </td>
        </tr>
        <script>
        if (typeof actualizarCajaTotales === 'function') {
            actualizarCajaTotales({
                envio: <?php echo json_encode($envio_val); ?>,
                subtotal: <?php echo json_encode($subtotal_global); ?>,
                subtotal_productos: <?php echo json_encode($base_productos); ?>,
                subtotal_sin_descuento: <?php echo json_encode($subtotal_sin_descuento); ?>,
                descuento: <?php echo json_encode($nuevo_descuento); ?>,
                iva: <?php echo json_encode($impuestos); ?>,
                total: <?php echo json_encode($total); ?>
            });
        }
        </script>
        <?php
    }

    public static function confirmaVende($data_post, $infoCotizacion, $fecha, $status, $cot_metodo, $exportacion, $moneda, $metodo_pago)
    {
        // dd($infoCotizacion);
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "ra") {
            $formato_cod_vta = sprintf('VRA%08d', $data_post->id_coti);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "rp") {
            $formato_cod_vta = sprintf('VRP%08d', $data_post->id_coti);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "sg") {
            $formato_cod_vta = sprintf('VSG%08d', $data_post->id_coti);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "al") {
            $formato_cod_vta = sprintf('VAL%08d', $data_post->id_coti);
        }
        //print_r($formato_cod_vta);
        $genera_venta = Cotizaciones::find($data_post->id_coti);
        $genera_venta->cod_venta = $formato_cod_vta;
        $genera_venta->fecha_venta = date('Y-m-d');
        $genera_venta->fecha_venta_formato = $fecha;
        $genera_venta->hora_venta = date('H:i:s');
        $genera_venta->status = $status;
        $genera_venta->forma_pago = $cot_metodo;
        $genera_venta->exportacion = $exportacion;
        $genera_venta->moneda = $moneda;
        $genera_venta->metodo_pago = $metodo_pago;
        $genera_venta->save();
        return $formato_cod_vta;
    }

    // FUNC DE PRODUCION
    // public static function confirmaVende($data_post, $infoCotizacion, $fecha, $status)
    // {
    //     //dd($infoCotizacion);
    //     if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "ra") {
    //         $formato_cod_vta = sprintf('VRA%08d', $data_post->id_coti);
    //     }
    //     if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "rp") {
    //         $formato_cod_vta = sprintf('VRP%08d', $data_post->id_coti);
    //     }
    //     if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "sg") {
    //         $formato_cod_vta = sprintf('VSG%08d', $data_post->id_coti);
    //     }
    //     if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "al") {
    //         $formato_cod_vta = sprintf('VAL%08d', $data_post->id_coti);
    //     }
    //     //print_r($formato_cod_vta);
    //     $genera_venta = Cotizaciones::find($data_post->id_coti);
    //     $genera_venta->cod_venta = $formato_cod_vta;
    //     $genera_venta->fecha_venta = date('Y-m-d');
    //     $genera_venta->fecha_venta_formato = $fecha;
    //     $genera_venta->hora_venta = date('H:i:s');
    //     $genera_venta->status = $status;
    //     $genera_venta->save();
    //     return $formato_cod_vta;
    // }
    
    public static function cambiaStatus($data_post, $status)
    {
        $cambia_status = Cotizaciones::find($data_post->id_coti);
        $cambia_status->status = $status;
        $cambia_status->save();
    }
    
}