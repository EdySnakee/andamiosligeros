<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\ClientesRedes;
use App\Estados;

use App\Http\Requests;

class InglesController extends Controller
{
    public function indexEn()
    {
    	$objCliRedes = new ClientesRedes();
        $datos_clientes = $objCliRedes
            ->select("*")
            ->from("clientesredes AS cr")
            ->join("proyectos_redes AS pr", "pr.id_proyecto", "=", "cr.id_proyecto")
            ->join("estados AS es", "pr.id_estado", "=", "es.idestado")
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $tipo_menu = "principal";
        return view('web_redes/en/index/index', compact("tipo_menu", "datos_clientes"));
    }
}
