@extends('layouts.app_redes')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">

@stop

@section('content')
    @include('app_redes.modulos.productos.accion_producto.contenido_accion_producto')
@stop

@section('js')
<script src="{{url('script/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

@if($accion == "editar")
<script>
    $( document ).ready(function() {
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
            ['link'],          // add's image support
            ['clean']
        ];

        quill = new Quill('#contenedor_editable', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions,
            },
            theme: 'snow'
        });

        quill.on('text-change', function (delta, oldDelta, source) {
            $('#primer_contenido').text($("#contenedor_editable > .ql-editor").html());
        });

        quill = new Quill('#contenedor_editable2', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions,
            },
            theme: 'snow'
        });

        quill.on('text-change', function (delta, oldDelta, source) {
            $('#segundo_contenido').text($("#contenedor_editable2 > .ql-editor").html());
        });

        quill = new Quill('#contenedor_editable3', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions,
            },
            theme: 'snow'
        });

        quill.on('text-change', function (delta, oldDelta, source) {
            $('#tercer_contenido').text($("#contenedor_editable3 > .ql-editor").html());
        });

        quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage()
        });

        $('.dropify').dropify({
            messages: {
                default: 'Arrastra y suelta una imagen o da click',
                replace: 'Arrastra y suelta una imagen o da click para reemplazar imagen',
                remove:  'Eliminar',
                error:   'El archivo no cuenta con el formato solicitado'
            }
        });
    });

</script>
@endif

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

function iniciaQuill() {
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
        ['link'],          // add's image support
        ['clean']
    ];

    quill = new Quill('#contenedor_editable', {
        modules: {
            syntax: true,
            toolbar: toolbarOptions,
        },
        theme: 'snow'
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        $('#primer_contenido').text($("#contenedor_editable > .ql-editor").html());
    });

    quill = new Quill('#contenedor_editable2', {
        modules: {
            syntax: true,
            toolbar: toolbarOptions,
        },
        theme: 'snow'
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        $('#segundo_contenido').text($("#contenedor_editable2 > .ql-editor").html());
    });

    quill = new Quill('#contenedor_editable3', {
        modules: {
            syntax: true,
            toolbar: toolbarOptions,
        },
        theme: 'snow'
    });

    quill.on('text-change', function (delta, oldDelta, source) {
        $('#tercer_contenido').text($("#contenedor_editable3 > .ql-editor").html());
    });

    quill.getModule('toolbar').addHandler('image', () => {
        selectLocalImage()
    });
}
</script>


<script>

function iniciaDropify() {
    $('.dropify').dropify({
        messages: {
            default: 'Arrastra y suelta una imagen o da click',
            replace: 'Arrastra y suelta una imagen o da click para reemplazar imagen',
            remove:  'Eliminar',
            error:   'El archivo no cuenta con el formato solicitado'
        }
    });
}

$(document).on("click", ".select_plantilla", seleccionaPlantilla);
function seleccionaPlantilla () {
    var num_plantilla = $(this).attr("data-plantilla");
    var tipo_accion = $("#tipo_accion").attr("data-accion");
    if (num_plantilla == 1) {
        $("#plantilla2").removeClass("pactive");
        $("#plantilla1").addClass("pactive");
    }
    if (num_plantilla == 2) {
        $("#plantilla1").removeClass("pactive");
        $("#plantilla2").addClass("pactive");
    }
    var data_json = {
        "accion":"seleccionaPlantilla",
        "datos":{
            'tipo_accion' : tipo_accion,
            'num_plantilla' : num_plantilla
        }
    }
    ajaxSetup();
    $.ajax({
        data:  data_json,
        url:   '{{ route("ajax_productos_path") }}',
        type:  'post',
        dataType:'html',
        beforeSend: function () {
        },
        success:  function (result) {
            $("#select_plantilla").html(result);
            iniciaDropify();
            iniciaQuill();
        },
        error: function(error){
            console.log(error);
        }
    });
}


$(function(){
    $("#form_post_producto").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this); 
        formData.append("accion", "addProducto");
        
        ajaxSetup();
        $.ajax({
            url: '{{ route("ajax_productos_path") }}',
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                swal({
                  title: "Guardando producto...",
                  text: "Espere mientras termina el proeceso",
                  buttons: false
                });
            },
            success:  function (result) {
                if (result == 1) {
                    swal({
                          title: "Felicidades",
                          text: "Se ha guardado el producto correctamente",
                          icon: "success",
                          buttons: true,
                          buttons: ["Ver artículos", "Agregar otro producto"],
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            location.reload();
                          } else {
                            window.location.href = "{{url('sb-admin/productos')}}";
                          }
                        });
                }else{
                    swal("Ups!", "Ocurrio un error!", "error");
                };
                
            },
            error: function(error){
                console.log(error);
            }
        })
    });
});

$(function(){
    $("#form_edit_producto").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this); 
        formData.append("accion", "editProducto");
        
        ajaxSetup();
        $.ajax({
            url: '{{ route("ajax_productos_path") }}',
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                swal({
                  title: "Editando producto...",
                  text: "Espere mientras termina el proeceso",
                  buttons: false
                });
            },
            success:  function (result) {
                if (result == 1) {
                    swal({
                          title: "Felicidades",
                          text: "Se ha guardado el producto correctamente",
                          icon: "success",
                          buttons: true,
                          buttons: ["Ver productos", "Seguir editando"],
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            location.reload();
                          } else {
                            window.location.href = "{{url('sb-admin/productos')}}";
                          }
                        });
                }else{
                    swal("Ups!", "Ocurrio un error!", "error");
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