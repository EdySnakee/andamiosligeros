<script>
	$(document).on("click","#open_add_cliente", openAddCliente);
	$(document).on("change","#activa_empresa", agregaEmpresa);
    $(document).on("click","#add_cliente", AddCliente);
	$(document).on("click","#edit_cliente", editCliente);
    $(document).on("change", "#estado", getMunicipios);
    

	function agregaEmpresa () {
        if($(this).is(":checked")){
            var data_json = {
                "accion":"agregaEmpresa"
            }
        }
        else {
            $("#info_empresa").html("");
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#info_empresa").html(result);
            },
            error: function(error){
            }
        });
    }

    function openAddCliente (e) {
        e.preventDefault();
        var accion_cliente = $(this).attr("data-accion-cliente");
        var data_json = {
            "accion":"openAddCliente",
            "datos":{
                accion_cliente : accion_cliente
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#modal_large_redes").html(result);
                $('#modal_large_redes').modal({backdrop: 'static',keyboard:false});
                //asignaTarea();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function openEdit (id_cliente) {
        var id_cliente = id_cliente;
        var data_json = {
            "accion":"openEdit",
            "datos":{
                id_cliente : id_cliente
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#modal_large_redes").html(result);
                $('#modal_large_redes').modal({backdrop: 'static',keyboard:false});
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function AddCliente () {
        $("#add_cliente").attr("disabled", "disabled")
        var nombres_cliente = $("#nombres_cliente").val();
        var numero_lead = $("#numero_lead").val();
        //var a_paterno = $("#a_paterno").val();
        //var a_materno = $("#a_materno").val();
        var telefono = $("#telefono").val();
        var celular = $("#celular").val();
        var email = $("#email").val();
        var rfc = $("#rfc").val();
        var cp = $("#cp").val();
        var direccion = $("#direccion").val();
        var estado = $('#estado option:selected').attr('data-estado');
        var ciudad_p = $('#ciudad_p option:selected').attr('data-municipio');
        var comentarios = $("#comentarios").val();
        var es_empresa = $("#activa_empresa").is(":checked");
        
        var nombre_empresa = $("#nombre_empresa").val();
        var r_social = $("#r_social").val();
        var rfc_empresa = $("#rfc_empresa").val();

        //console.log(nombres_cliente);
        if (nombres_cliente == "" || nombres_cliente == undefined ) {
            swal({
              title: "Campos vacios!",
              text: "Necesitamos al menos un nombre!",
              icon: "warning",
              dangerMode: true,
            });
            $( "#nombres_cliente" ).focus();
            $("#add_cliente").removeAttr("disabled")
            return;
        };
        if (numero_lead == "" || numero_lead == undefined ) {
            swal({
              title: "Campo vacios!",
              text: "Registra el número de leed de kommo no seas flojo!",
              icon: "warning",
              dangerMode: true,
            });
            $( "#numero_lead" ).focus();
            $("#add_cliente").removeAttr("disabled")
            return;
        };


        var data_json = {
            "accion":"AddCliente",
            "datos":{
                'nombres_cliente' : nombres_cliente,
                'numero_lead' : numero_lead,
                //'a_paterno' : a_paterno,
                //'a_materno' : a_materno,
                'telefono' : telefono,
                'celular' : celular,
                'email' : email,
                'rfc' : rfc,
                'cp' : cp,
                'direccion' : direccion,
                'estado' : estado,
                'ciudad_p' : ciudad_p,
                'comentarios' : comentarios,
                'es_empresa' : es_empresa,
                'nombre_empresa' : nombre_empresa,
				'r_social' : r_social,
				'rfc_empresa' : rfc_empresa
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result.idcl);
                $("#modal_large_redes").modal('hide');
                swal("El cliente", "Se ha creado satisfactoriamiente", "success");
                $('#search_cliente').val(result.nombrecl);
                $('#search_cliente').attr("idcl", result.idcl);
                $('#search_cliente').removeClass("is-invalid");
                $('#search_cliente').addClass("is-valid");
                seleccionaCliente(result.idcl)
                //$("#cliente").html(result);
                //getTablaClientes();
            },
            error: function(error){
                console.log(error);
            }
        });
        
    }

    function editCliente () {
        $("#edit_cliente").attr("disabled", "disabled")
        var id_cliente = $("#id_cliente").val();
        var nombres_cliente = $("#nombres_cliente").val();
        var numero_lead = $("#numero_lead").val();
        //var a_paterno = $("#a_paterno").val();
        //var a_materno = $("#a_materno").val();
        var telefono = $("#telefono").val();
        var celular = $("#celular").val();
        var email = $("#email").val();
        var rfc = $("#rfc").val();
        var cp = $("#cp").val();
        var direccion = $("#direccion").val();
        var estado = $('#estado option:selected').attr('data-estado');
        var ciudad_p = $('#ciudad_p option:selected').attr('data-municipio');
        var lugarcl = $('#lugarcl').val();
        var comentarios = $("#comentarios").val();
        var es_empresa = $("#activa_empresa").is(":checked");
        
        var nombre_empresa = $("#nombre_empresa").val();
        var r_social = $("#r_social").val();
        var rfc_empresa = $("#rfc_empresa").val();

        //console.log(nombres_cliente);
        if (nombres_cliente == "" || nombres_cliente == undefined ) {
            swal({
              title: "Campos vacios!",
              text: "Necesitamos al menos un nombre!",
              icon: "warning",
              dangerMode: true,
            });
            $( "#nombres_cliente" ).focus();
            $("#edit_cliente").removeAttr("disabled")
            return;
        };
        if (numero_lead == "" || numero_lead == undefined ) {
            swal({
              title: "Campo vacios!",
              text: "Registra el número de leed de kommo no seas flojo!",
              icon: "warning",
              dangerMode: true,
            });
            $( "#numero_lead" ).focus();
            $("#edit_cliente").removeAttr("disabled")
            return;
        };

        var data_json = {
            "accion":"editCliente",
            "datos":{
                'id_cliente' : id_cliente,
                'nombres_cliente' : nombres_cliente,
                'numero_lead' : numero_lead,
                //'a_paterno' : a_paterno,
                //'a_materno' : a_materno,
                'telefono' : telefono,
                'celular' : celular,
                'email' : email,
                'rfc' : rfc,
                'cp' : cp,
                'direccion' : direccion,
                'estado' : estado,
                'ciudad_p' : ciudad_p,
                'lugarcl' : lugarcl,
                'comentarios' : comentarios,
                'es_empresa' : es_empresa,
                'nombre_empresa' : nombre_empresa,
                'r_social' : r_social,
                'rfc_empresa' : rfc_empresa
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
                $('#dt_cliente').dataTable().fnClearTable();
                $('#dt_cliente').dataTable().fnDestroy();
            },
            success:  function (result) {
                $("#modal_large_redes").modal('hide');
                swal("El cliente", "Se ha editado satisfactoriamiente", "success");
                $("#cliente").html(result);
                $('#tabla_cotizaciones').DataTable().ajax.reload();
                muestraTabla();
                
            },
            error: function(error){
                console.log(error);
            }
        });
        
    }

    function getMunicipios(){
        var id_estado = $(this).val();

        var data_json = {
            "accion":"getMunicipiosClientes",
            "datos":{
                'id_estado':id_estado,
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_utilidades_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#ciudad_p").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }


</script>