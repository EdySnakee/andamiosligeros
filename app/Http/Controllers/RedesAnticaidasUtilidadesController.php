<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Estados;

class RedesAnticaidasUtilidadesController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    
    public function ajax_utilidades(Request $request)
    {
        $data_post = new \stdClass();

        if(!empty($request->datos))
        { $data_post = json_decode(json_encode($request->datos));}

        if(!empty($request->accion)){
            switch($request->accion)
            {
                case "getMunicipios":

                    $catalogoProyectos = ProyectosRedes::where("id_estado", $data_post->id_estado)->first();

                    if(!empty($catalogoProyectos)){
                        $existe = "si";
                        return view("app_redes/attachments/existe_proyecto/existe_proyecto", array(
                            "existe" => $existe,
                            "catalogoProyectos" => $catalogoProyectos
                            ));
                    }else{
                        $existe = "no";
                        $estado = $data_post->id_estado;
                        return view("app_redes/attachments/existe_proyecto/existe_proyecto", array(
                            "existe" => $existe,
                            "estado" => $estado
                            ));
                    }

                    //$estados = Estados::find($data_post->id_estado)->municipios;
                    //return view("app_redes/attachments/municipios/municipios", ["estados"=>$estados]);
                break;

                case "getMunicipiosClientes":
                    $estados = Estados::find($data_post->id_estado)->municipios;
                    return view("app_redes/modulos/extras/municipios", ["estados"=>$estados]);
                break;

            }
        }

    }
}
