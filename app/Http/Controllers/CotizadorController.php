<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Clientes;
use App\Condiciones;
use App\Cotizaciones;
use App\Ventas;
use App\DetalleCotizaciones;
use App\Protegeme;
use App\Utilidades;
use App\Productos;
use App\TipoCobro;
use App\GiroEmpresas;
use App\User;
use App\actualizaTablas;
use App\Sucursales;
use \Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

session_start();

class CotizadorController extends Controller
{
    private $max_row;
    public $id_cotizacion;

    function __construct(){
        $this->max_row = 10;
        $this->middleware('auth');
    }
    public function buscarCliente(Request $request)
    {
        $term = $request->input('searchItem');
        $resultados = Clientes::select('idcl as id', 'nombrecl')->where('nombrecl', 'like', '%' . $term . '%')->orderBy('idcl', 'DESC')->paginate($request->page);
        return $resultados;
    }
    public function serverSideTable(Request $request)
    {
        //dd($request->all());
        $objCotizaciones = new Cotizaciones;
        $condicion_filtro = (!empty($request->get('fecha_inicio')) AND !empty($request->get('fecha_fin'))) ? 'fecha BETWEEN "'.$request->get('fecha_inicio').'" AND "'.$request->get('fecha_fin').'"' : 1;
        //$condicion_filtro .= (!empty($data_post->empresa)) ? ' AND cot.giro_empresa like \'%'.$data_post->empresa.'%\'' : ' AND 1';
        $info_cotizaciones = $objCotizaciones::select("*")
                ->from("cotizaciones AS cot")
                ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                ->Leftjoin("users AS us", "us.id", "=", "cot.id_usuario_genera")
                ->where("cot.giro_empresa", "al")
                ->whereRaw($condicion_filtro)
                ->get();

        return Datatables::of($info_cotizaciones)
            ->addColumn('action', function ($info_cotizaciones) {
                /*BOTONERA*/
                if($info_cotizaciones->giro_empresa == "ra"){
                    $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/redes-anticaidas/".$info_cotizaciones->ruta_encrypt).'"> Descargar PDF</a></li>';
                }
                if($info_cotizaciones->giro_empresa == "rp"){
                    $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/redes-perimetrales/".$info_cotizaciones->ruta_encrypt).'"> Descargar PDF</a></li>';
                }
                if($info_cotizaciones->giro_empresa == "sg"){
                    $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/score-gol/".$info_cotizaciones->ruta_encrypt).'"> Descargar PDF</a></li>';
                }
                if($info_cotizaciones->giro_empresa == "al"){
                    $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/andamios-ligeros/".$info_cotizaciones->ruta_encrypt).'"> Descargar PDF</a></li>';
                }

                if (Auth::user()->tipo_usuario  == "admin") {
                    $btn_editar = '<li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$info_cotizaciones->id_cotizacion).'" >Editar</a></li>';
                }else{
                    $btn_editar = "";
                }
                
                if($info_cotizaciones->status == 1){//ACTIVO
                    $btns_st = '
                        <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$info_cotizaciones->id_cotizacion).'" >Editar</a></li>
                        <li><a id="open_confirm_venta" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Realizar Venta</a></li>
                        '.$descarga_pdf.'
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                if($info_cotizaciones->status == 3){//ACEPTADA
                    $btns_st = '
                        <li><a class="btn col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/seguimineto/".$info_cotizaciones->id_cotizacion).'"> Realizar seguimiento</a></li>
                        '.$btn_editar.'
                    ';
                }
                if($info_cotizaciones->status == 2){//INACTIVO
                    $btns_st = '
                        <li><input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix"></li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_elimina_cliente" id="confirm_elimina_cliente" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" value="Eliminar" class="btn btn-danger col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                if($info_cotizaciones->status == 4){//PENDIENTE PAGO
                    $btns_st = '
                        <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$info_cotizaciones->id_cotizacion).'" >Editar</a></li>
                        <li><a id="open_confirm_venta" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Confirmar Venta</a></li>
                        '.$descarga_pdf.'
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                return '
                <div class="btn-group">
                    <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="prospecto-menu">
                        '.$btns_st.'
                    </ul>
                </div>
                ';
            })
            ->editColumn('nombrecl', function ($info_cotizaciones) {
                return $info_cotizaciones->nombrecl.' <a href="#" id="open_edit" id-cliente="'.$info_cotizaciones->idcl.'"><i class="fas fa-user-edit"></i></a>';
            })
            ->editColumn('lead', function ($info_cotizaciones) {
                return '<a target="_blank" href="https://angelgolcoral.kommo.com/chats/leads/detail/'.$info_cotizaciones->lead.'">'.$info_cotizaciones->lead.'</a>';
            })
            ->addColumn('ruta_link', function ($info_cotizaciones) {
                if ($info_cotizaciones->giro_empresa == "ra") {
                    return url("/cotizaciones/redes-anticaidas/".$info_cotizaciones->ruta_encrypt);
                }
                if ($info_cotizaciones->giro_empresa == "rp") {
                    return url("/cotizaciones/redes-perimetrales/".$info_cotizaciones->ruta_encrypt);
                }
                if ($info_cotizaciones->giro_empresa == "sg") {
                    return url("/cotizaciones/score-gol/".$info_cotizaciones->ruta_encrypt);
                }
                if ($info_cotizaciones->giro_empresa == "al") {
                    return url("/cotizaciones/andamios-ligeros/".$info_cotizaciones->ruta_encrypt);
                }
            })
            ->editColumn('cod_cotizacion', function ($info_cotizaciones) {
                if ($info_cotizaciones->giro_empresa == "ra") {
                    return '<a target="_blank" href="'.url("/cotizaciones/redes-anticaidas/".$info_cotizaciones->ruta_encrypt).'">'.$info_cotizaciones->cod_cotizacion.' <i class="fas fa-share-square"></i></a>';
                }
                if ($info_cotizaciones->giro_empresa == "rp") {
                    return '<a target="_blank" href="'.url("/cotizaciones/redes-perimetrales/".$info_cotizaciones->ruta_encrypt).'">'.$info_cotizaciones->cod_cotizacion.' <i class="fas fa-share-square"></i></a>';
                }
                if ($info_cotizaciones->giro_empresa == "sg") {
                    return '<a target="_blank" href="'.url("/cotizaciones/score-gol/".$info_cotizaciones->ruta_encrypt).'">'.$info_cotizaciones->cod_cotizacion.' <i class="fas fa-share-square"></i></a>';
                }
                if ($info_cotizaciones->giro_empresa == "al") {
                    return '<a target="_blank" href="'.url("/cotizaciones/andamios-ligeros/".$info_cotizaciones->ruta_encrypt).'">'.$info_cotizaciones->cod_cotizacion.' <i class="fas fa-share-square"></i></a>';
                }
            })
            ->editColumn('ruta_encrypt', function ($info_cotizaciones) {
                if ($info_cotizaciones->giro_empresa == "ra") {
                    return '<a target="_blank" href="'.url("/cotizaciones/redes-anticaidas/".$info_cotizaciones->ruta_encrypt).'">../'.$info_cotizaciones->cod_cotizacion.'</a>';
                }
                if ($info_cotizaciones->giro_empresa == "rp") {
                    return '<a target="_blank" href="'.url("/cotizaciones/redes-perimetrales/".$info_cotizaciones->ruta_encrypt).'">../'.$info_cotizaciones->cod_cotizacion.'</a>';
                }
                if ($info_cotizaciones->giro_empresa == "sg") {
                    return '<a target="_blank" href="'.url("/cotizaciones/score-gol/".$info_cotizaciones->ruta_encrypt).'">../'.$info_cotizaciones->cod_cotizacion.'</a>';
                }
                if ($info_cotizaciones->giro_empresa == "al") {
                    return '<a target="_blank" href="'.url("/cotizaciones/andamios-ligeros/".$info_cotizaciones->ruta_encrypt).'">../'.$info_cotizaciones->cod_cotizacion.'</a>';
                }
            })
            ->editColumn('status', function ($info_cotizaciones){
                /*ESTATUS COTIZACION*/
                if ($info_cotizaciones->status == 1) {
                    return '<span class="status bg-gradient-info text-white shadow">Activo</span>';
                }
                if ($info_cotizaciones->status == 2) {
                    return '<span class="status bg-secondary text-white shadow">Inactivo</span>';
                }
                if ($info_cotizaciones->status == 3){
                    return '<span class="status bg-gradient-success text-white shadow">Aceptada</span>';
                }
                if ($info_cotizaciones->status == 4){
                    return '<span class="status bg-gradient-warning text-white shadow">Pendiente</span>';
                }
            })
            ->addColumn('es_status', function ($info_cotizaciones) {
                if ($info_cotizaciones->status == 1) {
                    return 1;
                }
                if ($info_cotizaciones->status == 2) {
                    return 2;
                }
                if ($info_cotizaciones->status == 3){
                    return 3;
                }
                if ($info_cotizaciones->status == 4){
                    return 4;
                }
            })
            ->editColumn('total', function ($info_cotizaciones){
                return "$".number_format($info_cotizaciones->total, 2, '.', ',');
            })
            ->editColumn('celularcl', function ($info_cotizaciones){
                return $info_cotizaciones->telefonocl."<br>".$info_cotizaciones->celularcl;
            })
            ->editColumn('mp_status', function ($info_cotizaciones){
                /*ESTATUS COBRO CON MERCADO PAGO*/
                if ($info_cotizaciones->mp_status == "si") {
                    $ischecked = "checked";
                }else {
                    $ischecked = "";
                }
                if ($info_cotizaciones->status == 1) {
                    return '
                    <label class="checkbox-toggle">
                        <input type="checkbox" id="activa_mp" class="activado'.$info_cotizaciones->id_cotizacion.'" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" '.$ischecked.'>
                        <i></i>
                    </label>
                    ';
                }
                if ($info_cotizaciones->status == 2) {
                    return '
                    <label class="checkbox-toggle disabled">
                        <input type="checkbox" id="activa_mp" class="activado'.$info_cotizaciones->id_cotizacion.'" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                        <i></i>
                    </label>
                    ';
                }
                if ($info_cotizaciones->status == 3){
                    return '
                    <label class="checkbox-toggle aceptada">
                        <input type="checkbox" id="activa_mp" class="activado'.$info_cotizaciones->id_cotizacion.'" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                        <i></i>
                    </label>
                    ';
                }
                if ($info_cotizaciones->status == 4){
                    return '
                    <label class="checkbox-toggle pendiente">
                        <input type="checkbox" id="activa_mp" class="activado'.$info_cotizaciones->id_cotizacion.'" data-id-coti="'.$info_cotizaciones->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                        <i></i>
                    </label>
                    ';
                }
            })
            ->make(true);
    }

    public function verCotizaciones(Request $request){
        //$ip_cliente = $request->getClientIp();
        $objActTab = new actualizaTablas();
        $objGiroEmpresas = new GiroEmpresas();
        $objCotizaciones = new Cotizaciones();

        $actualizaCotis = $objActTab::where("tipo_act", "vigencia")->where("tabla", "cotizaciones")->where("fecha_act", date('Y-m-d'))->first();
        //dd($actualizaCotis);
        if (empty($actualizaCotis)) {
            $fechas_antiguas = date("Y-m-d",strtotime(date('Y-m-d')."- 30 days")); 
            $cotiAntiguas = $objCotizaciones::where("status", 5)->where("fecha", "<=", $fechas_antiguas)->get();
            
            foreach ($cotiAntiguas as $item_cotizaciones) {
                $edita_status_coti = $objCotizaciones->find($item_cotizaciones->id_cotizacion);
                $edita_status_coti->status = 5; //CAMBIA STATUS A VENCIDA
                $edita_status_coti->mp_status = "no"; //DESACTIVA MERCADO PAGO
                $edita_status_coti->save();
            }
            
            //dd(count($cotiAntiguas));
            
            $post_reg_tab = $objActTab;
            $post_reg_tab->accion = "actualiza_tabla";
            $post_reg_tab->tipo_act = "vigencia";
            $post_reg_tab->tabla = "cotizaciones";
            $post_reg_tab->num_reg = count($cotiAntiguas);
            $post_reg_tab->usuario = \Auth::User()->name;
            $post_reg_tab->fecha_act = date('Y-m-d');
            $post_reg_tab->hora_act = date("H:i:s");
            $post_reg_tab->save();
            
        } 
        
        //dd($actualizaCotis);

        $giroEmpresas = $objGiroEmpresas->selectGiroEmpresas();
        
      // Validamos el usuario ->
        $usuario_id = \Auth::User()->id;
        $tipo_usuario = \Auth::User()->tipo_usuario;

         if ($tipo_usuario == 'f1' || $tipo_usuario == 'v1') {
            // filtramos para FRANQUISIA ->
            $listado_cotizaciones = $objCotizaciones
                ->select("*")
                ->from("cotizaciones AS cot")
                ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                ->join("users AS us", "us.id", "=", "cot.id_usuario_genera")
                ->where("cot.giro_empresa", "al")
                ->where("cot.id_usuario_genera", $usuario_id)
                ->orderBy('cot.id_cotizacion', 'DESC')
                ->paginate($this->max_row);
        } else {
            $listado_cotizaciones = $objCotizaciones
                ->select("*")
                ->from("cotizaciones AS cot")
                ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                ->join("users AS us", "us.id", "=", "cot.id_usuario_genera")
                ->where("cot.giro_empresa", "al")
                ->orderBy('cot.id_cotizacion', 'DESC')
                ->paginate($this->max_row);
        }
                                
        return view('app_redes/modulos/cotizador/listado_cotizaciones', compact("giroEmpresas", "listado_cotizaciones"));
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

    public function generaCotizacion(){
    	$accion = "agregar";
        $objClientes = new Clientes();
        $objCondiciones = new Condiciones();
    	$datos_clientes = $objClientes->orderBy('idcl', 'DESC')->get();
    	
        // condiciones
        $condicion = $objCondiciones->where('id', 1)->first();
        $datos_condicion = $condicion ? $condicion->contenido : 'No se encontr�� condici��n';

        /*
        $objGiroEmpresas = new GiroEmpresas();
        $giroEmpresas = $objGiroEmpresas->selectGiroEmpresas();
        */
        $productos_giro = Productos::where("giro_producto", "al")->get();
        
        $sucursales = $this->getSucursales();
        
        return view('app_redes/modulos/cotizador/crea_cotizacion/crea_cotizacion', compact("datos_clientes","sucursales", "accion", "productos_giro", "datos_condicion"));
    }
    

    public function editaCotizacion($id_cotizacion){
       
        $accion="editar";
        $info_cotizacion = Cotizaciones::where("id_cotizacion", $id_cotizacion)->first();
        if (isset($info_cotizacion->id_cotizacion) and !empty($info_cotizacion->id_cotizacion)) {
            $objGiroEmpresas = GiroEmpresas::all();
            $datos_clientes = Clientes::where("idcl", $info_cotizacion->id_cliente)->first();
            $productos_giro = Productos::where("giro_producto", $info_cotizacion->giro_empresa)->get();
            $fecha = $info_cotizacion->fecha_formato;
            $condiciones_cotizacion = $info_cotizacion->configuracion;
            $sucursales = $this->getSucursales();
            return view('app_redes/modulos/cotizador/crea_cotizacion/crea_cotizacion', compact("accion", "fecha","sucursales", "datos_clientes", "objGiroEmpresas", "info_cotizacion", "productos_giro", "condiciones_cotizacion"));
        }else{
            return redirect(route('app_ver_cotizaciones'));
        }
        
    }

    public function ajax_cotizador(Request $request){
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if(!empty($request->datos)){
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'buscaClientes':
                        
                        $objClientes = new Clientes();
                        $condicion_filtro = (!empty($data_post->search_cliente)) ? ' nombrecl like \'%'.$data_post->search_cliente.'%\'' : 'AND 1';
                        $condicion_filtro .= (!empty($data_post->search_cliente)) ? ' OR telefonocl like \'%'.$data_post->search_cliente.'%\'' : ' OR 1';
                        $condicion_filtro .= (!empty($data_post->search_cliente)) ? ' OR celularcl like \'%'.$data_post->search_cliente.'%\'' : ' OR 1';

                        $result_clientes = $objClientes
                                ->select("*")
                                ->from("clientes")
                                ->whereRaw($condicion_filtro)
                                ->orderBy('idcl', 'DESC')
                                ->get();
                        
                        //dd($result_clientes);
                        //return view('app_redes/modulos/cotizador/crea_cotizacion/options_clientes', compact('result_clientes'));
                        return response()->json($result_clientes);

                    break;
                    case "obtieneTipoCotizacion":
                    	$fecha = Utilidades::fecha();
                    	$accion = $data_post->accion;
                        return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/formato_andamisligeros', compact("fecha", "accion"));
                    	/*
                        if ($data_post->tipo_cotizacion == "ra") {
                    		return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/formato_redes_anticaidas', compact("fecha", "accion"));
                    	}
                        if ($data_post->tipo_cotizacion == "rp") {
                            return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/formato_redes_perimetrales', compact("fecha", "accion"));
                        }
                        if ($data_post->tipo_cotizacion == "sg") {
                            return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/formato_scoregol', compact("fecha", "accion"));
                        }
                        if ($data_post->tipo_cotizacion == "al") {
                            return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/formato_andamisligeros', compact("fecha", "accion"));
                        }
                         */
                        
                    break;
                   	case 'seleccionaCliente':
                   		$datos_clientes = Clientes::find($data_post->cliente);
                   		return view('app_redes/modulos/cotizador/crea_cotizacion/formato_cotizacion/fieldset_info_cliente', compact("datos_clientes"));
                   	break;
                   	case 'muestraProductos':
                   		$info_productos = Productos::where("giro_producto", $data_post->tipo_cotizacion)->get();
                   		return view('app_redes/modulos/cotizador/crea_cotizacion/select_tipo_productos', compact("info_productos"));
                   		break;
                   	case 'detallarProducto':
                        $tipo_producto = $data_post->tipo_cotizacion;
                   		$detalle_producto = Productos::where("id_producto", $data_post->id_producto)->first();
                        if ($tipo_producto == "Venta") {
                   		    return view('app_redes/modulos/cotizador/crea_cotizacion/detallar_producto', compact("detalle_producto", "tipo_producto"));
                        }
                        if ($tipo_producto == "Renta") {
                            return view('app_redes/modulos/cotizador/crea_cotizacion/detallar_producto_renta', compact("detalle_producto", "tipo_producto"));
                        }
                   	break;
                   	case 'agregarConcepto':
                        //print_r($data_post->iva);
                        $conceptos = [];

                        if (!isset($_SESSION['conceptos'])) {
                            $_SESSION['conceptos'] = [];
                        }else{
                            $conceptos = $_SESSION['conceptos'];
                        }

                        $info_producto = Productos::where("id_producto", $data_post->id_producto)->first();

                        if ($info_producto->tipo_cobro == "m2") {
                            $largo = $data_post->largo;
                            $alto = $data_post->alto;
                            $dimensiones = $largo * $alto;
                        }
                        if($info_producto->tipo_cobro == "fijo"){
                            $largo = 1;
                            $alto = 1;
                            $dimensiones = $largo * $alto;
                        }

                        $cantidad = $data_post->cantidad;
                        //$descuento = $data_post->descuento;
                        if (\Auth::User()->tipo_usuario == "mayorista") {
                            $costo = $info_producto->precio_m;
                        }else{
                            $costo = $data_post->precio;
                        }

                        $concepto = [
                            'id' => rand(111111,999999),
                            'tipo_cobro' => $info_producto->tipo_cobro,
                            'cantidad' => $cantidad,
                            'nombre_producto' => $info_producto->nombre_p,
                            'categoria' => $info_producto->categoria,
                            'id_producto' => $info_producto->id_producto,
                            'sku' => $info_producto->SKU,
                            'largo' => $largo,
                            'alto' => $alto,
                            'costo' => $costo,
                            'dimensiones' => $dimensiones,
                            //'descuento' => $descuento,
                            'total' => $dimensiones * $costo * $cantidad
                        ];

                        //$iva = $data_post->iva;

                        $agrega_item_coti = Cotizaciones::agregaConcepto($concepto, $data_post);

                   	break;

                    case 'eliminarConcepto':
                        $elimina_item_coti = Cotizaciones::eliminaConcepto($data_post);
                    break;

                    case 'eliminaImpuesto':
                        //print_r($data_post);
                        $elimina_impuesto = Cotizaciones::eliminaImpuesto($data_post);
                    break;

                    case 'agregaImpuesto':
                        //dd($data_post);
                        $elimina_impuesto = Cotizaciones::agregaImpuesto($data_post);
                    break;

                    case 'addDescuento':
                        $agrega_descuento = Cotizaciones::agregaDescuento($data_post);
                    break;
                    case 'addEnvio':
                        $agrega_envio = Cotizaciones::agregaDescuento($data_post);
                    break;
                    case 'delEnvio':
                        
                        $elimina_envio = Cotizaciones::eliminaEnvio($data_post);
                    break;
                    case 'validaEnvio':
                        $elimina_envio = Cotizaciones::validaEnvio($data_post);
                    break;

                    case 'postCotizacion':
                        //dd($data_post);
                        if (isset($data_post->descuento_aplicado)) {
                            if ($data_post->t_descuento == "Porcentual") {
                                $porcentaje_descuento = $data_post->porcentaje_descuento;
                                $descuento_aplicado = $data_post->descuento_aplicado;
                            }
                            if ($data_post->t_descuento == "Fijo") {
                                $porcentaje_descuento = $data_post->descuento_aplicado;
                                $descuento_aplicado = $data_post->descuento_aplicado;
                            }
                        }else{
                            $porcentaje_descuento = 0;
                            $descuento_aplicado = 0;
                        }
                        $datosCotizacion = new Cotizaciones();
                        $datosCotizacion->giro_empresa = "al";
                        $datosCotizacion->id_cliente = $data_post->id_cliente;
                        $datosCotizacion->id_usuario_genera = Auth::user()->id;
                        $datosCotizacion->fecha = date('Y-m-d');
                        $datosCotizacion->fecha_formato = $data_post->fecha_formato;
                        $datosCotizacion->hora = date('H:i:s');
                        $datosCotizacion->t_descuento = !empty($data_post->t_descuento) ? $data_post->t_descuento : "NA";
                        $datosCotizacion->descuento = $porcentaje_descuento;
                        $datosCotizacion->tipo_cotizacion = $data_post->tipo_cotizacion;
                        $datosCotizacion->descuento_aplicado = $descuento_aplicado;
                        $datosCotizacion->subtotal = $data_post->subtotal;
                        if (isset($data_post->iva)) {
                            $datosCotizacion->iva = $data_post->iva;
                        }else{
                            $datosCotizacion->iva = 0;
                        }
                        $datosCotizacion->envio = !empty($data_post->envio) ? $data_post->envio : 0;
                        $datosCotizacion->total = $data_post->total;
                        $datosCotizacion->status = 1;
                        $datosCotizacion->mp_status = "si";
                        $datosCotizacion->configuracion = $data_post->configuracion;
                        $datosCotizacion->id_sucursal = $data_post->id_sucursal;
                        $datosCotizacion->save();

                        /*
                        if (!empty($data_post->giro_empresa) and $data_post->giro_empresa == "ra") {
                            $formato_cod_coti = sprintf('CRA%08d', $datosCotizacion->id_cotizacion);
                        }
                        if (!empty($data_post->giro_empresa) and $data_post->giro_empresa == "rp") {
                            $formato_cod_coti = sprintf('CRP%08d', $datosCotizacion->id_cotizacion);
                        }
                        if (!empty($data_post->giro_empresa) and $data_post->giro_empresa == "sg") {
                            $formato_cod_coti = sprintf('CSG%08d', $datosCotizacion->id_cotizacion);
                        }
                        if (!empty($data_post->giro_empresa) and $data_post->giro_empresa == "al") {
                            $formato_cod_coti = sprintf('CAL%08d', $datosCotizacion->id_cotizacion);
                        }
                        */

                        $formato_cod_coti = sprintf('CAL%08d', $datosCotizacion->id_cotizacion);
                        

                        $guarda_datos_adicionales = $datosCotizacion->find($datosCotizacion->id_cotizacion);
                        $guarda_datos_adicionales->cod_cotizacion = $formato_cod_coti;
                        $guarda_datos_adicionales->ruta_encrypt = md5($datosCotizacion->id_cotizacion);
                        $guarda_datos_adicionales->save();

                        $detCotizacion  = $data_post->detalle_coti;
                        
                        //print_r($detCotizacion);

                        foreach ($detCotizacion as $key_detalle_cotizacion => $info_detalle_cotizacion) {
                            $info_producto = Productos::where("id_producto", $info_detalle_cotizacion->id_producto)->first();
                            $objAsignaDetCotizacion = new DetalleCotizaciones();
                            $objAsignaDetCotizacion->id_cotizacion = $datosCotizacion->id_cotizacion;
                            $objAsignaDetCotizacion->id_producto = $info_detalle_cotizacion->id_producto;
                            $objAsignaDetCotizacion->cantidad = $info_detalle_cotizacion->cantidad;
                            $objAsignaDetCotizacion->nombre_producto = $info_detalle_cotizacion->nombre_producto;
                            $objAsignaDetCotizacion->alto = $info_detalle_cotizacion->alto;
                            $objAsignaDetCotizacion->largo = $info_detalle_cotizacion->largo;
                            $objAsignaDetCotizacion->precio_comercial = $info_producto->precio;
                            $objAsignaDetCotizacion->precio_unit = $info_detalle_cotizacion->precio_unit;
                            $objAsignaDetCotizacion->dimensiones = $info_detalle_cotizacion->dimensiones;
                            $objAsignaDetCotizacion->tipo_cobro = $info_detalle_cotizacion->tipo_cobro;
                            $objAsignaDetCotizacion->total_ind = $info_detalle_cotizacion->total_ind;
                            $objAsignaDetCotizacion->titulo_descripcion = $info_detalle_cotizacion->titulo_descripcion;
                            $objAsignaDetCotizacion->clave_prod_serv = $info_producto->clave_prod_serv;
                            $objAsignaDetCotizacion->clave_unidad = $info_producto->clave_unidad;
                            $objAsignaDetCotizacion->unidad = $info_producto->unidad;
                            $objAsignaDetCotizacion->estatus = 1;
                            $objAsignaDetCotizacion->save();
                        }

                        $qrimage = public_path().'/storage/qrs_cotizaciones/'.$datosCotizacion->id_cotizacion.'.png';
                        
                        /*
                        if ($data_post->giro_empresa == "ra") {
                            $ruta_cotizacion = "redes-anticaidas/".$guarda_datos_adicionales->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/redes-anticaidas/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($data_post->giro_empresa == "rp") {
                            $ruta_cotizacion = "redes-perimetrales/".$guarda_datos_adicionales->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/redes-perimetrales/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($data_post->giro_empresa == "sg") {
                            $ruta_cotizacion = "score-gol/".$guarda_datos_adicionales->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/score-gol/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($data_post->giro_empresa == "al") {
                            $ruta_cotizacion = "andamios-ligeros/".$guarda_datos_adicionales->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/andamios-ligeros/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        */

                        $ruta_cotizacion = "andamios-ligeros/".$guarda_datos_adicionales->ruta_encrypt;
                        \QRCode::url(url('cotizaciones/andamios-ligeros/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();


                        $guarda_qr_status = $datosCotizacion->find($datosCotizacion->id_cotizacion);
                        $guarda_qr_status->qr_status = 1;
                        $guarda_qr_status->save();

                        $info_cliente = Clientes::find($data_post->id_cliente);

                        $data = [
                            "ruta_coti" => $ruta_cotizacion,
                            "num_cliente" => $info_cliente->celularcl
                        ];

                        return $data;
                    break;

                    case 'generaQR':
                        //para generar custom
                        /*
                        $qrimage = public_path().'/storage/qrs_cotizaciones/qr-custom.png';
                        \QRCode::url(url('https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx'))->setSize(10)->setOutfile($qrimage)->png();
                        */
                            $infoCotizacion = Cotizaciones::find($data_post->id_coti);


                        $qrimage = public_path().'/storage/qrs_cotizaciones/'.$infoCotizacion->id_cotizacion.'.png';
                        
                        
                        if ($infoCotizacion->giro_empresa == "ra") {
                            $ruta_cotizacion = "redes-anticaidas/".$infoCotizacion->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/redes-anticaidas/')."/".$infoCotizacion->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($infoCotizacion->giro_empresa == "rp") {
                            $ruta_cotizacion = "redes-perimetrales/".$infoCotizacion->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/redes-perimetrales/')."/".$infoCotizacion->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($infoCotizacion->giro_empresa == "sg") {
                            $ruta_cotizacion = "score-gol/".$infoCotizacion->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/score-gol/')."/".$infoCotizacion->ruta_encrypt)->setOutfile($qrimage)->png();
                        }
                        if ($infoCotizacion->giro_empresa == "al") {
                            $ruta_cotizacion = "andamios-ligeros/".$infoCotizacion->ruta_encrypt;
                            \QRCode::url(url('cotizaciones/andamios-ligeros/')."/".$infoCotizacion->ruta_encrypt)->setOutfile($qrimage)->png();
                        }

                        $guarda_qr_status = $infoCotizacion->find($infoCotizacion->id_cotizacion);
                        $guarda_qr_status->qr_status = 1;
                        $guarda_qr_status->save();
                             
                        
                        
                    break;

                    case 'editCotizacion':
                        //dd($data_post);
                        if (isset($data_post->descuento_aplicado)) {
                            $porcentaje_descuento = $data_post->porcentaje_descuento;
                            $descuento_aplicado = $data_post->descuento_aplicado;
                        }else{
                            $porcentaje_descuento = 0;
                            $descuento_aplicado = 0;
                        }
                        if (isset($data_post->descuento_aplicado)) {
                            if ($data_post->t_descuento == "Porcentual") {
                                $porcentaje_descuento = $data_post->porcentaje_descuento;
                                $descuento_aplicado = $data_post->descuento_aplicado;
                            }
                            if ($data_post->t_descuento == "Fijo") {
                                $porcentaje_descuento = $data_post->descuento_aplicado;
                                $descuento_aplicado = $data_post->descuento_aplicado;
                            }
                        }else{
                            $porcentaje_descuento = 0;
                            $descuento_aplicado = 0;
                        }
                        $datosEditCotizacion = Cotizaciones::find($data_post->id_cotizacion);
                        $datosEditCotizacion->t_descuento = !empty($data_post->t_descuento) ? $data_post->t_descuento : "NA";
                        $datosEditCotizacion->tipo_cotizacion = !empty($data_post->tipo_cotizacion) ? $data_post->tipo_cotizacion : "NA";
                        $datosEditCotizacion->descuento = $porcentaje_descuento;
                        $datosEditCotizacion->descuento_aplicado = $descuento_aplicado;
                        $datosEditCotizacion->subtotal = $data_post->subtotal;
                        //dd($data_post->iva);
                        if (isset($data_post->iva)) {
                            $datosEditCotizacion->iva = $data_post->iva;
                        }else{
                            $datosEditCotizacion->iva = 0;
                        }
                        $datosEditCotizacion->envio = !empty($data_post->envio) ? $data_post->envio : 0;
                        $datosEditCotizacion->total = $data_post->total;
                        $datosEditCotizacion->configuracion = $data_post->configuracion;
                        $datosEditCotizacion->save();

                        $datosDetalleCotizacion = new DetalleCotizaciones();
                        $datos_to_delete = $datosDetalleCotizacion->where("id_cotizacion", $data_post->id_cotizacion);
                        $datos_to_delete->delete();
                        
                        $detCotizacion  = $data_post->detalle_coti;
                        foreach ($detCotizacion as $key_detalle_cotizacion => $info_detalle_cotizacion) {
                            $objAsignaDetCotizacion = new DetalleCotizaciones();
                            $objAsignaDetCotizacion->id_cotizacion = $datosEditCotizacion->id_cotizacion;
                            $objAsignaDetCotizacion->id_producto = $info_detalle_cotizacion->id_producto;
                            $objAsignaDetCotizacion->cantidad = $info_detalle_cotizacion->cantidad;
                            $objAsignaDetCotizacion->nombre_producto = $info_detalle_cotizacion->nombre_producto;
                            $objAsignaDetCotizacion->alto = $info_detalle_cotizacion->alto;
                            $objAsignaDetCotizacion->largo = $info_detalle_cotizacion->largo;
                            $objAsignaDetCotizacion->precio_unit = $info_detalle_cotizacion->precio_unit;
                            $objAsignaDetCotizacion->dimensiones = $info_detalle_cotizacion->dimensiones;
                            $objAsignaDetCotizacion->tipo_cobro = $info_detalle_cotizacion->tipo_cobro;
                            $objAsignaDetCotizacion->total_ind = $info_detalle_cotizacion->total_ind;
                            $objAsignaDetCotizacion->titulo_descripcion = $info_detalle_cotizacion->titulo_descripcion;
                            $objAsignaDetCotizacion->estatus = 1;
                            $objAsignaDetCotizacion->save();
                        }

                        $datosEditVtas = Ventas::where('id_cotizacion', $data_post->id_cotizacion)->first();
                        //dd($datosEditVtas);
                        if (!empty($datosEditVtas)) {
                            $datosEditVtas->porcentaje_descuento = $porcentaje_descuento;
                            $datosEditVtas->descuento_aplicado = $descuento_aplicado;
                            $datosEditVtas->subtotal = $data_post->subtotal;
                            
                            if (isset($data_post->iva)) {
                                $datosEditVtas->iva = $data_post->iva;
                            }else{
                                $datosEditVtas->iva = 0;
                            }
                            $datosEditVtas->total = $data_post->total;
                            $datosEditVtas->save();
                        }
                        

                        if ($datosEditCotizacion->giro_empresa == "ra") {
                            $ruta_cotizacion = "redes-anticaidas/".$datosEditCotizacion->ruta_encrypt;
                        }
                        if ($datosEditCotizacion->giro_empresa == "rp") {
                            $ruta_cotizacion = "redes-perimetrales/".$datosEditCotizacion->ruta_encrypt;
                        }
                        if ($datosEditCotizacion->giro_empresa == "sg") {
                            $ruta_cotizacion = "score-gol/".$datosEditCotizacion->ruta_encrypt;
                        }
                        if ($datosEditCotizacion->giro_empresa == "al") {
                            $ruta_cotizacion = "andamios-ligeros/".$datosEditCotizacion->ruta_encrypt;
                        }
                        return $ruta_cotizacion;
                    break;

                    case 'openConfirmInfo':
                        $catalogoCotizaciones = new Cotizaciones();
                        $datos_coti = $catalogoCotizaciones->find($data_post->id_coti);
                        return $datos_coti;
                    break;
                    case 'getMetodosPago':
                        $objMetodosPago = new TipoCobro();
                        $metodosPago = $objMetodosPago
                            ->select("*")
                            ->from("cat_tipoCobro")
                            ->get();
                        return response()->json($metodosPago);
                    break;

                    case 'confirmDesactiva':
                        //print_r($data_post->id_coti);
                        $datosCotizacion = new Cotizaciones();
                        $cambia_estatus = $datosCotizacion->find($data_post->id_coti);
                        $cambia_estatus->status = 2;
                        $cambia_estatus->save();
                    break;

                    case 'confirmActiva':
                        //print_r($data_post->id_coti);
                        $datosCotizacion = new Cotizaciones();
                        $cambia_estatus = $datosCotizacion->find($data_post->id_coti);
                        $cambia_estatus->status = 1;
                        $cambia_estatus->save();
                    break;

                    case 'confirmVende':
                        $datosCotizacion = new Cotizaciones();
                        $fecha = Utilidades::fecha();
                        $infoCotizacion = $datosCotizacion->find($data_post->id_coti);
                        $usuario = Auth::user()->id;
                        $status = 3; // STATUS 3 ES VENTA ->

                        //Actualizar el inventario ->
                        //code ->

                        // Asignamos los valores por defecto
                        $exportacion = '01';
                        $moneda = 'MXN';
                        $metodo_pago = 'PUE';

                        // asignamos el metodo de pago
                        $cot_metodo = $data_post->cod_met;

                        /*ACTUALIZA TABLA COTIZACIONES*/
                        $return_formato_cod_vta = Cotizaciones::confirmaVende($data_post, $infoCotizacion, $fecha, $status, $cot_metodo, $exportacion, $moneda, $metodo_pago);

                        /*GUARDA DATOS EN TABLA VENTAS*/
                        $return_st_vtas = Ventas::guardaVenta($data_post, $infoCotizacion, $fecha, $status,$return_formato_cod_vta, $usuario);

                    break;

                    case 'confirmElimina':
                        $datosCotizacion = new Cotizaciones();
                        $datos_to_delete = $datosCotizacion->find($data_post->id_coti);
                        $datos_to_delete->delete();
                    break;

                    case 'getTablaCotizaciones':
                        $objCotizaciones = new Cotizaciones();
                        $this->max_row = $data_post->max_row ?? $this->max_row;

                        $condicion_filtro = '';

                        if (!empty($data_post->filtrar_busqueda)) {
                            $term = trim($data_post->filtrar_busqueda);
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' (cli.nombrecl LIKE \'%' . $term . '%\' OR cot.cod_cotizacion LIKE \'%' . $term . '%\' OR cot.id_cotizacion LIKE \'%' . $term . '%\' OR cli.lead LIKE \'%' . $term . '%\' OR cli.telefonocl LIKE \'%' . $term . '%\' OR cli.celularcl LIKE \'%' . $term . '%\')';
                        }
                        if (!empty($data_post->filtro_usuario)) {
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . " us.name LIKE '%" . trim($data_post->filtro_usuario) . "%'";
                        }
                        if (!empty($data_post->filtro_status)) {
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . " cot.status = '" . (int)$data_post->filtro_status . "'";
                        }

                        if (!empty($data_post->fecha_inicio) && !empty($data_post->fecha_fin)) {
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha BETWEEN \'' . $data_post->fecha_inicio . '\' AND \'' . $data_post->fecha_fin . '\'';
                        } elseif (!empty($data_post->fecha_inicio)) {
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha >= \'' . $data_post->fecha_inicio . '\'';
                        } elseif (!empty($data_post->fecha_fin)) {
                            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha <= \'' . $data_post->fecha_fin . '\'';
                        }

                        if (!$condicion_filtro) {
                            $condicion_filtro = '1';
                        }

                             // -->filtro
                        // Validamos el usuario ->
                        $usuario_id = \Auth::User()->id;
                        $tipo_usuario = \Auth::User()->tipo_usuario;

                        if ($tipo_usuario == 'f1' || $tipo_usuario == 'v1') {
                            // filtramos para F1 y V1 ->
                            $listado_cotizaciones = $objCotizaciones
                                ->select("*")
                                ->from("cotizaciones AS cot")
                                ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                                ->join("users AS us", "us.id", "=", "cot.id_usuario_genera")
                                ->where("cot.giro_empresa", "al")
                                ->where("cot.id_usuario_genera", $usuario_id)
                                ->whereRaw($condicion_filtro)
                                ->orderBy('cot.id_cotizacion', 'DESC')
                                ->paginate($this->max_row);
                        } else {
                            $listado_cotizaciones = $objCotizaciones
                                ->select("*")
                                ->from("cotizaciones AS cot")
                                ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                                ->join("users AS us", "us.id", "=", "cot.id_usuario_genera")
                                ->where("cot.giro_empresa", "al")
                                ->whereRaw($condicion_filtro)
                                ->orderBy('cot.id_cotizacion', 'DESC')
                                ->paginate($this->max_row);
                        }


                        return view('app_redes/modulos/cotizador/tabla_listado_cotizaciones', compact('listado_cotizaciones'));
                    
                    break;

                    case 'muestraTablaCotizaciones':
                        
                        $objCotizaciones = new Cotizaciones();
                        
                        //$info_cotizaciones = Cotizaciones::orderBy('id_cotizacion', 'DESC')->get();
                        
                        //$condicion_filtro = (!empty($data_post->is_date_search) AND $data_post->is_date_search == "yes") ? 'cot.fecha BETWEEN \'%'.$data_post->start_date.'%\' AND \'%'.$data_post->end_date.'%\'' : 1;
                        
                        $condicion_filtro = (!empty($data_post->start_date) AND !empty($data_post->end_date)) ? 'fecha BETWEEN "'.$data_post->start_date.'" AND "'.$data_post->end_date.'"' : 1;
                        $condicion_filtro .= (!empty($data_post->empresa)) ? ' AND cot.giro_empresa like \'%'.$data_post->empresa.'%\'' : ' AND 1';

                        //print_r($condicion_filtro);
                        //$fecha_actual = date('Y-m-d');
                        //$semana = date("Y-m-d",strtotime($fecha_actual."- 7 days"));

                        if (Auth::user()->tipo_usuario == "admin") {
                            $info_cotizaciones = $objCotizaciones
                                            ->select("*")
                                            ->from("cotizaciones AS cot")
                                            ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                                            ->Leftjoin("users AS us", "us.id", "=", "cot.id_usuario_genera")
                                            ->where("cot.giro_empresa", "al")
                                            ->whereRaw($condicion_filtro)
                                            ->get();
                        }elseif (Auth::user()->tipo_usuario == "n2") {
                            $info_cotizaciones = $objCotizaciones
                                            ->select("*")
                                            ->from("cotizaciones AS cot")
                                            ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                                            ->Leftjoin("users AS us", "us.id", "=", "cot.id_usuario_genera")
                                            ->where("cot.giro_empresa", "al")
                                            ->whereRaw($condicion_filtro)
                                            ->get();
                        }else{
                            $info_cotizaciones = $objCotizaciones
                                            ->select("*")
                                            ->from("cotizaciones AS cot")
                                            ->join("clientes AS cli", "cli.idcl", "=", "cot.id_cliente")
                                            ->Leftjoin("users AS us", "us.id", "=", "cot.id_usuario_genera")
                                            ->where("cot.id_usuario_genera", Auth::user()->id)
                                            ->where("cot.giro_empresa", "al")
                                            //->where("cot.fecha", ">=", $semana)
                                            ->whereRaw($condicion_filtro)
                                            ->get();
                        }

                        $data = array();
                        foreach ($info_cotizaciones as $item_coti) {
                            if ($item_coti->giro_empresa == "ra") {
                                $ruta_coti = '<a target="_blank" href="'.url("/cotizaciones/redes-anticaidas/".$item_coti->ruta_encrypt).'">../'.$item_coti->cod_cotizacion.'</a>';
                                $ruta_link = url("/cotizaciones/redes-anticaidas/".$item_coti->ruta_encrypt);
                            }
                            if ($item_coti->giro_empresa == "rp") {
                                $ruta_coti = '<a target="_blank" href="'.url("/cotizaciones/redes-perimetrales/".$item_coti->ruta_encrypt).'">../'.$item_coti->cod_cotizacion.'</a>';
                                $ruta_link = url("/cotizaciones/redes-perimetrales/".$item_coti->ruta_encrypt);
                            }
                            if ($item_coti->giro_empresa == "sg") {
                                $ruta_coti = '<a target="_blank" href="'.url("/cotizaciones/score-gol/".$item_coti->ruta_encrypt).'">../'.$item_coti->cod_cotizacion.'</a>';
                                $ruta_link = url("/cotizaciones/score-gol/".$item_coti->ruta_encrypt);
                            }
                            if ($item_coti->giro_empresa == "al") {
                                $ruta_coti = '<a target="_blank" href="'.url("/cotizaciones/andamios-ligeros/".$item_coti->ruta_encrypt).'">../'.$item_coti->cod_cotizacion.'</a>';
                                $ruta_link = url("/cotizaciones/andamios-ligeros/".$item_coti->ruta_encrypt);
                            }
                            /*ESTATUS COTIZACION*/
                            if ($item_coti->status == 1) {
                                $estatus_coti = '<span class="status bg-gradient-info text-white shadow">Activo</span>';
                            }
                            if ($item_coti->status == 2) {
                                $estatus_coti = '<span class="status bg-secondary text-white shadow">Inactivo</span>';
                            }
                            if ($item_coti->status == 3){
                                $estatus_coti = '<span class="status bg-gradient-success text-white shadow">Aceptada</span>';
                            }
                            if ($item_coti->status == 4){
                                $estatus_coti = '<span class="status bg-gradient-warning text-white shadow">Pendiente</span>';
                            }
                            /*ESTATUS COBRO CON MERCADO PAGO*/
                            if ($item_coti->mp_status == "si") {
                                $ischecked = "checked";
                            }else {
                                $ischecked = "";
                            }
                            if ($item_coti->status == 1) {
                                $options_mp = '
                                <label class="checkbox-toggle">
                                    <input type="checkbox" id="activa_mp" class="activado'.$item_coti->id_cotizacion.'" data-id-coti="'.$item_coti->id_cotizacion.'" '.$ischecked.'>
                                    <i></i>
                                </label>
                                ';
                            }
                            if ($item_coti->status == 2) {
                                $options_mp = '
                                <label class="checkbox-toggle disabled">
                                    <input type="checkbox" id="activa_mp" class="activado'.$item_coti->id_cotizacion.'" data-id-coti="'.$item_coti->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                                    <i></i>
                                </label>
                                ';
                            }
                            if ($item_coti->status == 3){
                                $options_mp = '
                                <label class="checkbox-toggle aceptada">
                                    <input type="checkbox" id="activa_mp" class="activado'.$item_coti->id_cotizacion.'" data-id-coti="'.$item_coti->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                                    <i></i>
                                </label>
                                ';
                            }
                            if ($item_coti->status == 4){
                                $options_mp = '
                                <label class="checkbox-toggle pendiente">
                                    <input type="checkbox" id="activa_mp" class="activado'.$item_coti->id_cotizacion.'" data-id-coti="'.$item_coti->id_cotizacion.'" '.$ischecked.' disabled="disabled">
                                    <i></i>
                                </label>
                                ';
                            }
                            /*BOTONERA*/
                            if($item_coti->giro_empresa == "ra"){
                                $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/redes-anticaidas/".$item_coti->ruta_encrypt).'"> Descargar PDF</a></li>';
                            }
                            if($item_coti->giro_empresa == "rp"){
                                $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/redes-perimetrales/".$item_coti->ruta_encrypt).'"> Descargar PDF</a></li>';
                            }
                            if($item_coti->giro_empresa == "sg"){
                                $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/score-gol/".$item_coti->ruta_encrypt).'"> Descargar PDF</a></li>';
                            }
                            if($item_coti->giro_empresa == "al"){
                                $descarga_pdf = '<li><a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="'.url("pdf/andamios-ligeros/".$item_coti->ruta_encrypt).'"> Descargar PDF</a></li>';
                            }

                            if (Auth::user()->tipo_usuario  == "admin") {
                                $btn_editar = '<li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$item_coti->id_cotizacion).'" >Editar</a></li>';
                            }else{
                                $btn_editar = "";
                            }
                            
                            if($item_coti->status == 1){//ACTIVO
                                $btns_st = '
                                    <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$item_coti->id_cotizacion).'" >Editar</a></li>
                                    <li><a id="open_confirm_venta" data-id-coti="'.$item_coti->id_cotizacion.'" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Realizar Venta</a></li>
                                    '.$descarga_pdf.'
                                    <li class="divider"><hr></li>
                                    <li><input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente" data-id-coti="'.$item_coti->id_cotizacion.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                                ';
                            }
                            if($item_coti->status == 3){//ACEPTADA
                                $btns_st = '
                                    <li><a class="btn col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/seguimineto/".$item_coti->id_cotizacion).'"> Realizar seguimiento</a></li>
                                    '.$btn_editar.'
                                ';
                            }
                            if($item_coti->status == 2){//INACTIVO
                                $btns_st = '
                                    <li><input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente" data-id-coti="'.$item_coti->id_cotizacion.'" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix"></li>
                                    <li class="divider"><hr></li>
                                    <li><input type="submit" name="confirm_elimina_cliente" id="confirm_elimina_cliente" data-id-coti="'.$item_coti->id_cotizacion.'" value="Eliminar" class="btn btn-danger col-md-12 btn-dropdown-fix"></li>
                                ';
                            }
                            if($item_coti->status == 4){//PENDIENTE PAGO
                                $btns_st = '
                                    <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$item_coti->id_cotizacion).'" >Editar</a></li>
                                    <li><a id="open_confirm_venta" data-id-coti="'.$item_coti->id_cotizacion.'" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Confirmar Venta</a></li>
                                    '.$descarga_pdf.'
                                    <li class="divider"><hr></li>
                                    <li><input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente" data-id-coti="'.$item_coti->id_cotizacion.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                                ';
                            }
                            
                            $botonera = '
                            <div class="btn-group">
                                <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
                                <ul class="dropdown-menu" id="prospecto-menu">
                                    '.$btns_st.'
                                </ul>
                            </div>
                            ';

                            $sub_array = array();
                            $sub_array["giro_empresa"] = $item_coti->giro_empresa;
                            $sub_array["id_cotizacion"] = $item_coti->id_cotizacion;
                            $sub_array["cod_cotizacion"] = $item_coti->cod_cotizacion;
                            $sub_array["nombrecl"] = $item_coti->nombrecl;
                            $sub_array["telefonocl"] = $item_coti->telefonocl;
                            $sub_array["celularcl"] = $item_coti->celularcl;
                            $sub_array["fecha_formato"] = $item_coti->fecha_formato;
                            $sub_array["total"] = "$".number_format($item_coti->total, 2, '.', ',');
                            $sub_array["status"] = $estatus_coti;
                            $sub_array["mp_status"] = $options_mp;
                            $sub_array["name"] = $item_coti->name;
                            $sub_array["ruta_encrypt"] = $ruta_coti;
                            $sub_array["ruta_link"] = $ruta_link;
                            $sub_array["botonera"] = $botonera;
                            $data[] = $sub_array;
                        }
                        $arreglo = array("data"=>$data);
                        echo json_encode($arreglo);
                    break;

                    

                    case 'activaMercadoPago':
                        $activa_mp = Cotizaciones::find($data_post->id_cotizacion);
                        $activa_mp->mp_status = $data_post->st_mp;
                        $activa_mp->save();
                    break;
                    
                    case 'openAddCondicion':
                        $accion = $data_post->accion_condicion;

                        // Retorna modal
                        return view('app_redes/modulos/cotizador/condiciones/modal_add_condiciones', compact('accion'));
                        break;

                    default:
                    break;
                }

            }
        }
    }

    public function exportarCotizaciones(Request $request)
    {
        $objCotizaciones = new Cotizaciones();
        $usuario_id = \Auth::User()->id;
        $tipo_usuario = \Auth::User()->tipo_usuario;

        $condicion_filtro = '';

        if (!empty($request->filtrar_busqueda)) {
            $term = trim($request->filtrar_busqueda);
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' (cli.nombrecl LIKE \'%' . $term . '%\' OR cot.cod_cotizacion LIKE \'%' . $term . '%\' OR cot.id_cotizacion LIKE \'%' . $term . '%\' OR cli.lead LIKE \'%' . $term . '%\' OR cli.telefonocl LIKE \'%' . $term . '%\' OR cli.celularcl LIKE \'%' . $term . '%\')';
        }
        if (!empty($request->filtro_usuario)) {
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . " us.name LIKE '%" . trim($request->filtro_usuario) . "%'";
        }
        if (!empty($request->filtro_status)) {
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . " cot.status = '" . (int)$request->filtro_status . "'";
        }

        if (!empty($request->fecha_inicio) && !empty($request->fecha_fin)) {
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha BETWEEN \'' . $request->fecha_inicio . '\' AND \'' . $request->fecha_fin . '\'';
        } elseif (!empty($request->fecha_inicio)) {
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha >= \'' . $request->fecha_inicio . '\'';
        } elseif (!empty($request->fecha_fin)) {
            $condicion_filtro .= ($condicion_filtro ? ' AND ' : '') . ' cot.fecha <= \'' . $request->fecha_fin . '\'';
        }

        if (!$condicion_filtro) {
            $condicion_filtro = '1';
        }

        $query = $objCotizaciones
            ->select('cot.*', 'cli.nombrecl', 'cli.lead as cli_lead', 'cli.telefonocl', 'cli.celularcl', 'us.name as vendedor')
            ->from('cotizaciones AS cot')
            ->join('clientes AS cli', 'cli.idcl', '=', 'cot.id_cliente')
            ->join('users AS us', 'us.id', '=', 'cot.id_usuario_genera')
            ->where('cot.giro_empresa', 'al')
            ->whereRaw($condicion_filtro)
            ->orderBy('cot.id_cotizacion', 'DESC');

        if ($tipo_usuario == 'f1' || $tipo_usuario == 'v1') {
            $query->where('cot.id_usuario_genera', $usuario_id);
        }

        $cotizaciones = $query->get();

        $statusMap = [
            1 => 'Activo',
            2 => 'Inactivo',
            3 => 'Aceptada',
            4 => 'Pendiente',
            5 => 'Vencida',
            6 => 'Facturado'
        ];

        $sucursalesMap = [
            1 => 'MTY',
            2 => 'MID',
            3 => 'CDMX',
            5 => 'GDL'
        ];

        $headers = ['Código', 'Tipo', 'Cliente', 'Teléfono', 'Lead', 'Sucursal', 'Fecha', 'Subtotal', 'Descuento', 'Envío', 'IVA', 'Total', 'Estatus', 'Cotizó'];

        $filename = 'cotizaciones_' . date('Y-m-d_His') . '.csv';

        $callback = function() use ($cotizaciones, $headers, $statusMap, $sucursalesMap) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $headers);
            foreach ($cotizaciones as $c) {
                fputcsv($file, [
                    $c->cod_cotizacion,
                    $c->tipo_cotizacion ?: 'Venta',
                    $c->nombrecl,
                    $c->telefonocl ?: $c->celularcl,
                    $c->lead ?: $c->cli_lead,
                    $sucursalesMap[$c->id_sucursal] ?? 's/suc',
                    $c->fecha_formato ?: $c->fecha,
                    '$' . number_format($c->subtotal, 2, '.', ','),
                    $c->descuento_aplicado ? '-$' . number_format($c->descuento_aplicado, 2, '.', ',') : '0',
                    '$' . number_format($c->envio, 2, '.', ','),
                    '$' . number_format($c->iva, 2, '.', ','),
                    '$' . number_format($c->total, 2, '.', ','),
                    $statusMap[$c->status] ?? $c->status,
                    $c->vendedor ?: $c->name,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
