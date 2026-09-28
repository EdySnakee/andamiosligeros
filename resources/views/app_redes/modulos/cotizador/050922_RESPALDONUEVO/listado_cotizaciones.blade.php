@extends('layouts.app_redes')
@section('css')
    <link rel="stylesheet" href="{{url('script/js/datepicker/datepicker3.css')}}">
    <style>
    .btn-md{
        border-radius: 0.2rem;
    }
    </style>
@stop
@section('content')
    @include('app_redes.modulos.cotizador.contenido_listado_cotizaciones')
@stop
@section('js')
<script src="{{url('script/js/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    $( document ).ready(function() {
        muestraTablaCotizaciones();
        $('.input-daterange').datepicker({
            "locale": {
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
    function muestraTablaCotizaciones (start_date = '', end_date = '', empresa = '') {
        var data_json = {
            "accion":"muestraTablaCotizaciones",
            "datos":{
                "start_date": start_date,
                "end_date": end_date,
                "empresa": empresa
            }
        }
        ajaxSetup();
        var table = $('#tabla_cotizaciones').DataTable({
            "ajax":{
                "method":"POST",
                "data":  data_json,
                "url":"{{ route('path_ajax_cotizador') }}"
            },
            "order": [[ 0, "desc" ]],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página.",
                "sEmptyTable": "Lo sentimos. No se encontraron registros.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros aún.",
                "infoFiltered": "(filtrados de un total de _MAX_ registros)",
                "search": "Búsqueda",
                "sLoadingRecords": "Cargando ...",
                "Processing": "Procesando...",
                "SearchPlaceholder": "Comience a teclear...",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente",
                }
            },
            rowCallback:function(row,data)
            {
                //console.log(row);
                //console.log(data["giro_empresa"]);
                if(data["giro_empresa"] == "ra"){
                    $(row).css("background-color","#d4b2d387");
                    $(row).css("color","#000");
                }
                if(data["giro_empresa"] == "sg"){
                    $(row).css("background-color","#7ec25c80");
                    $(row).css("color","#000");
                }
                if(data["giro_empresa"] == "al"){
                    $(row).css("background-color","#7ea7ff6e");
                    $(row).css("color","#000");
                }
                if(data["giro_empresa"] == "rp"){
                    $(row).css("background-color","#ddddddad");
                    $(row).css("color","#000");
                }
            },
            "columns":[
                {"data":"id_cotizacion"},
                {"data":"cod_cotizacion"},
                {"data":"nombrecl"},
                {"data":"telefonocl"},
                {"data":"fecha_formato"},
                {"data":"total"},
                {"data":"status"},
                {"data":"name"},
                {"data":"ruta_encrypt"},
                {"data":"botonera"}
            ]
        });

        obtener_data_editar("#tabla_cotizaciones tbody", table);
    }
    function obtener_data_editar (tbody, table) {
        $(tbody).on("click", "button#open_edit", function(){
            var data = table.row( $(this).parents("tr") ).data();
            var id_coti = data.id_cotizacion;
            alert(id_coti);
        });
    }
    $('#search').click(function() {
        var start_date = $('#fecha_inicio').val();
        var end_date = $('#fecha_fin').val();
        var giro_empresa = $('#giro_empresa').val();
        if (start_date != '' && end_date != '') {
            $('#tabla_cotizaciones').DataTable().destroy();
            muestraTablaCotizaciones(start_date, end_date, giro_empresa);
        } else {
            alert("Por favor seleccione un rango de fechas");
        }
    });
    $(document).on("change","#giro_empresa",function(e){
        $('#tabla_cotizaciones').DataTable().destroy();
        var giro_empresa = $('#giro_empresa').val();
        var start_date = $('#fecha_inicio').val();
        var end_date = $('#fecha_fin').val();
        muestraTablaCotizaciones(start_date, end_date, giro_empresa);
    });
</script>
@stop