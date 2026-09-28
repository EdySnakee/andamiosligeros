@extends('layouts.app_redes')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">

@stop

@section('content')
    @include('app_redes.modulos.clientes.add_clientes.contenido_add_clientes')
@stop

@section('js')
<script src="{{url('script/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDtTrroMJ-mYXu8IupnvruJTlpFE5foi4g"></script>
<script src="{{url('script/js/maps.js')}}"></script>
<style>
	#map {
	  height: 250px;
	}
</style>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = null;

function selectLocalImage() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.click();

    // Listen upload local image and save to server
    input.onchange = () => {
        const file = input.files[0];

        // file type is only image.
        if (/^image\//.test(file.type)) {
            imageHandler(file);
        } else {
            console.warn('You could only upload images.');
        }
    };
}

function imageHandler(image) {
    var formData = new FormData();
    formData.append('image', image);
    formData.append('_token', $('meta[name=csrf-token]').attr("content"));

    $.ajax({
        type: "POST",
        url: '{{route("ajax_images_quill_path")}}',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
        	console.log(response);
            if (response.url) {
                insertToEditor(response.url, quill);
            }
            /*
            */
        }
    });
}

function insertToEditor(url, editor) {
    const range = editor.getSelection();
    editor.insertEmbed(range.index, 'image', url);
}

$(document).ready(function () {
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{'header': 1}, {'header': 2}],               // custom button values
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction
        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'header': [1, 2, 3, 4, 5, 6, false]}],
        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],
        [{'align': []}],
        ['link', 'image', 'video'],          // add's image support
        ['clean']
    ];

    quill = new Quill('#contentquill', {
        modules: {
            syntax: true,
            toolbar: toolbarOptions,
        },
        theme: 'snow'
    });

    quill.getModule('toolbar').addHandler('image', () => {
        selectLocalImage()
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        $('#content-textarea').text($(".ql-editor").html());
    });
});

</script>


<script>

$(document).on("keyup", "#nombre_cliente", escribeURL);

function escribeURL () {
    var nombre_proyecto = $('#nombre_cliente').val();
    var data_json = {
        "accion":"escribeURL",
        "datos":{
            'nombre_proyecto' : nombre_proyecto
        }
    }
    ajaxSetup();
    $.ajax({
        data:  data_json,
        url:   '{{ route("ajax_proyectos_path") }}',
        type:  'post',
        dataType:'html',
        beforeSend: function () {
        },
        success:  function (result) {
            $(".pinta_url").html(result);
            $(".pinta_url").val(result);
        },
        error: function(error){
            console.log(error);
        }
    });
}

$(function(){
    $("#formuploadajax").on("submit", function(e){
        
        e.preventDefault();
        
        var formData = new FormData(this); 
        formData.append("accion", "guardaClientes2");
        
        ajaxSetup();
        $.ajax({
            url: '{{ route("ajax_clientes_path") }}',
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                swal({
                  title: "Creando Proyecto...",
                  text: "Espere mientras termina el proeceso",
                  buttons: false
                });
            },
            success:  function (result) {
                if (result == 1) {
                    swal({
                          title: "Felicidades",
                          text: "Se ha guardado el proyecto correctamente",
                          icon: "success",
                          buttons: true,
                          buttons: ["Ver proyectos", "Agregar proyecto"],
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            location.reload();
                          } else {
                            window.location.href = "{{url('sb-admin/proyectos')}}";
                          }
                        });
                }else{
                    swal("Ups!", "Llena los campos requeridos!", "error");
                };
                
            },
            error: function(error){
                console.log(error);
            }
        })
    });
});

</script>
@stop