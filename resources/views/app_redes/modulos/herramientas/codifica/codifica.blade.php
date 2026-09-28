@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.herramientas.codifica.contenido_codifica')
@stop

@section('js')
<script>
    $(document).on("click","#codifica",codificaCadena);
    function codificaCadena() {
        var cadena = $("#cadena").val();
        var cadenaEncriptada = btoa(cadena);
        console.log(cadenaEncriptada);
        $("#result64").val(cadenaEncriptada)
    }
    
</script>
@stop
