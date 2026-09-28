<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\ClientesRedes;
use App\Estados;
use App\FacebookApi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        return view('web_andamios/index/index', compact("tipo_menu", "datos_clientes"));
    }
}
