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
        //dd($data_post);
        //$cenvio = 100;
        $subtotal = 0;
        $impuestos = 0;
        //$descuento = 0;
        $total = 0;
        $subtotal_sin_descuento = 0;
        $num_proc = 0;
        $descuento_global = 0;
        $nuevo_descuento = 0;
        $s = 'A';
        foreach ($info_array as $i => $v) {
        ?>
        
        <tr class="fila-det-servicio">
            <td class="text-center"><?php echo $v['cantidad'] ?></td>
            <td class="text-left" nomb-det-serv="<?php echo $v['nombre_producto'] ?>" data-id-producto="<?php echo $v['id_producto'] ?>"><?php echo $v['nombre_producto'] ?></td>
            <td class="text-center"><?php echo "ANEXO ".$v['sku'] ?></td>
            <td class="text-center" data-punit="<?php echo $v['costo'] ?>" data-alto="<?php echo $v['alto'] ?>" data-largo="<?php echo $v['largo'] ?>"><?php echo "$".number_format($v['costo'], 2, '.', ',') ?></td>
            <td class="text-center" data-total-ind="<?php echo $v['total'] ?>"><?php echo "$".number_format($v['total'], 2, '.', ',') ?></td>
            <td class="text-center boton-eliminar" data-tipo-cobro="<?= $v['tipo_cobro'] ?>" dimensiones="<?php if ($v['tipo_cobro'] == "m2"){echo $v['dimensiones'];}else{echo "N/A";} ?>">
                <button type="button" class="eliminar_servicio btn btn-sm btn-danger" data-id="<?php echo $v['id'] ?>"><i class="fa fa-times"></i></button>
            </td>
        </tr>
        <?php
            $subtotal_sin_descuento += $v['total'];
            if ($v['categoria'] == "andamio") {
                $num_proc += $v['cantidad'];
            }
        }
        //dd($data_post);
        /*
        if ($data_post->activa_envio == "true" or isset($data_post->envio) and $data_post->envio != 0) {
            $envio = $cenvio * $num_proc;
        }else{
            $envio = 0;
        }
        */
        
        if (!empty($data_post->descuento_aplicado)) {
            if ($data_post->t_descuento == "Porcentual") {
                echo $accion;
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
        }else{
            $nuevo_descuento = 0;
        }

        $subtotal_global = $subtotal_sin_descuento + (!empty($data_post->envio) ? $data_post->envio : 0) - $nuevo_descuento;
        //$subtotal_global = $subtotal_sin_descuento + $envio - $nuevo_descuento;
        
        if ($data_post->activa_iva == "true" or isset($data_post->iva) and $data_post->iva != 0.0) {
            $impuestos = (float) $subtotal_global*0.16;
            $total = $impuestos + $subtotal_global;
        }else{
            $total = $subtotal_global;
        }
        //dd($impuestos);
        ?>
        <?php 
        if ($nuevo_descuento != 0) {
            ?>
            <tr>
                <td colspan="4" class="text-right">Descuento</td>
                <td class="text-center" id="nuevo_descuento" data-nuevo-descuento="<?php echo $nuevo_descuento ?>"><?php echo "-$".number_format($nuevo_descuento, 2, '.', ',') ?></td>
                <td>
                <button type="button" class="del_descuento btn btn-sm btn-danger" ><i class="fa fa-times"></i></button>
                </td>
            </tr>
            <?php 
        }
        //dd($data_post->activa_envio);
        if (!empty($data_post->envio) and $data_post->envio != 0) {
            
            ?>
            <tr>
                <td colspan="4" class="text-right">Envío</td>
                <td class="text-center" id="envio" data-costo-envio="<?php echo $data_post->envio ?>"><?php echo "$".number_format($data_post->envio, 2, '.', ',') ?></td>
                <td>
                <a href="#" class="del_envio btn btn-sm btn-danger" ><i class="fa fa-times"></i></a>
                </td>
            </tr>
            <?php 
        }
         ?>
        <tr>
            <td colspan="4" class="text-right">
                Subtotal
                <input type="hidden" id="subtotal_sin_descuento" value="<?php echo $subtotal_sin_descuento ?>">
            </td>
            <td class="text-center" id="subtotal_global" data-subtotal-global="<?php echo $subtotal_global ?>"><?php echo "$".number_format($subtotal_global, 2, '.', ',') ?></td>
            <td></td>
        </tr>
        <?php
            //dd($impuestos);
            if (isset($impuestos) and $impuestos != 0) {
                //$total = $subtotal + $impuestos;
                ?>
                    <tr>
                        <td colspan="4" class="text-right">IVA</td>
                        <td class="text-center">
                            $ <?php echo number_format($impuestos, 2, '.', ',') ?>
                            <input id="iva" type="hidden" value="<?php echo $impuestos ?>">
                        </td>
                        <td></td>
                    </tr>
                <?php
            }
        ?>
        <tr>
            <input type="hidden" id="v_iva" value="<?php !empty($impuestos) ? print_r($impuestos) : print_r("0.0"); ?>">
            <td colspan="4" class="text-right">TOTAL</td>
            <td class="text-center"><h4 id="total" data-total="<?php echo $total ?>"><?php echo "$".number_format($total, 2, '.', ',') ?></h4></td>
            <td></td>
        </tr>
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