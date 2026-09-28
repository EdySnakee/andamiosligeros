<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\ClientesRedes;
use App\Estados;
use App\FacebookApi;

class HerramientasController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    public function verCodificar()
    {
        return view('app_redes/modulos/herramientas/codifica/codifica');
        
    }
}
