@extends('layouts.app_redes')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">
<style>
    .card{
        background-color: #f8f9fc;
    }
    .item-content {
        background: white;
        padding: 1rem;
        border-radius: 5px;
        border: 1px #ededed solid;
    }
    .card-header {
        background: white;
    }
    .enc-product {
        padding: 0;
    }
    .tit-card {
        padding: 0.75rem 1.25rem;
        margin: 0 !important;
        cursor: pointer;
    }
    .accordion-editores .form-group {
        background: white;
    }
    .mb-2em {
        margin-bottom: 2em;
    }
    .tabs-modern .nav .nav-link.active {
        background: #fff;
        border-radius: 0 4px 4px 0;
    }
    .tabs-modern .nav .nav-link {
        display: flex;
        align-items: center;
        color: #222529;
        font-weight: 700;
        font-size: 14.4px;
        font-size: .9rem;
        padding: 19.2px 22.4px;
        padding: 1.2rem 1.4rem;
        border-bottom: 1px solid #efefef;
    }
    
    .card.card-big-info .card-body>.row>div[class*=col-]:first-child {
        background: #f9f9f9;
    }
    .card-precios {
        padding: 0;
        background: white;
    }
    .dropify-wrapper p {
    font-size: 12px;
}
    .card-info-product {
        padding: 1rem 2rem;
    }
    div.MultiFile-wrap {
        margin-top: 5px;
    }
    div.MultiFile-label {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 6px;
        padding: 6px 12px;
        margin-top: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    div.MultiFile-label > span {
        display: flex;
        align-items: center;
        flex: 1;
        justify-content: space-between;
    }
    span.MultiFile-label {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
    }
    span.MultiFile-title {
        flex: 1;
        font-size: 13px;
        color: #4e73df;
        font-weight: 600;
        padding-right: 12px;
        word-break: break-all;
    }
    img.MultiFile-preview {
        max-width: 60px;
        max-height: 60px;
        border-radius: 4px;
        border: 1px solid #e3e6f0;
        object-fit: cover;
    }
    a.MultiFile-remove {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        background: #e74a3b;
        color: #ffffff !important;
        border-radius: 50%;
        text-decoration: none !important;
        font-size: 14px;
        font-weight: bold;
        line-height: 1;
        margin-right: 10px;
        flex-shrink: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    a.MultiFile-remove:hover {
        background: #be2617;
        color: #ffffff !important;
        transform: scale(1.1);
    }
    .pull-right {
        margin-top: 0 !important;
    }
    .img-cont-gal {
        display: inline-block;
        position: relative;
        margin-bottom: 0.75em;
        margin-right: 0.5em;
        margin-left: 0.5em;
        border-radius: 6px;
    }

    .img-cont-gal img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        background: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 6px;
        padding: 4px;
    }
    .cont-gal {
        margin-top: 2em;
        text-align: center;
        margin-bottom: 2em;
    }
    a.delete-item-gal {
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 1.3em;
        color: #e74a3b;
        background: #fff;
        border-radius: 50%;
        line-height: 1;
        display: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.25);
        z-index: 10;
        cursor: pointer;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    a.delete-item-gal:hover {
        color: #be2617;
        transform: scale(1.15);
    }
    .img-cont-gal:hover a.delete-item-gal {
        display: block;
    }
    @media (max-width: 768px) {
        a.delete-item-gal {
            display: block !important;
        }
    }
    
</style>
<script>
    var URL_BASE_ADMIN = "{{url('/sb-admin')}}";
    var URL_BASE_SECCION = "{{url('/tienda')}}";
</script>
@stop

@section('content')
    @include('app_redes.modulos.tienda_online.productos.accion_producto.contenido_accion_producto')
@stop

@section('js')
<script src="{{url('script/js/jquery.MultiFile.min.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('script/dist/bootstrap-tagsinput.min.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
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
            }
        });
    }

    function insertToEditor(url, editor) {
        const range = editor.getSelection();
        editor.insertEmbed(range.index, 'image', url);
    }
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        [{'header': [2, 3, 4, 5, 6, false]}],
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
        [{'direction': 'rtl'}],                         // text direction
        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
        [{'font': []}],
        [{'align': []}],
        ['link', 'image'],          // add's image support
        ['clean']
    ];
    $( document ).ready(function() {
        $('.dropify').dropify({
            messages: {
                default: 'Drag and Drop / click',
                replace: 'Drag and Drop / click para reemplazar imagen',
                remove:  'Eliminar',
                error:   'El archivo no cuenta con el formato solicitado'
            }
        });
        editorDescripcion()
        editorCaracteristica()
        editorAdicional()
    });
    function editorDescripcion() {
        quill = new Quill('#editor_descrip', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        quill.on('text-change', function (delta, oldDelta, source) {
            $('#descripcion_producto').text($("#editor_descrip > .ql-editor").html());
        });
        quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage()
        }); 
    }
    function editorCaracteristica() {
        quill = new Quill('#editor_caract', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        quill.on('text-change', function (delta, oldDelta, source) {
            $('#caracteristica_producto').text($("#editor_caract > .ql-editor").html());
        });
        quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage()
        }); 
    }
    function editorAdicional() {
        quill = new Quill('#editor_adicional', {
            modules: {
                syntax: true,
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
        quill.on('text-change', function (delta, oldDelta, source) {
            $('#adicional_producto').text($("#editor_adicional > .ql-editor").html());
        });
        quill.getModule('toolbar').addHandler('image', () => {
            selectLocalImage()
        }); 
    }
    $(document).on("keyup", "#titulo_producto", escribeURL);
    $(document).on("keyup", "#url_editada", modificaURL);
    $(document).on("click", "#editar_url", combierteAimput);
    $(document).on("click", "#cancela_url", cancelaURL);
    $(document).on("click", "#guarda_url", guardaURL);
    function escribeURL () {
        var titulo_seccion = $('#titulo_producto').val();
        var data_json = {
            "accion":"escribeURL",
            "datos":{
                'titulo_seccion' : titulo_seccion
            }
        }
        $('#ogtitle').val(titulo_seccion);
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_tienda_path") }}',
            type:  'post',
            dataType:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $(".pinta_url_html").html(result+' <a href="#" id="editar_url" class="mb-1 mt-1 mr-1 btn btn-xs btn-info"><i class="fas fa-edit"></i> URL</a>');
                $(".pinta_url").val(result);
                $(".pinta_url_original").val(result);
                $('#ogurl').val(URL_BASE_SECCION+"/"+result);
                $('#canonical').val(URL_BASE_SECCION+"/"+result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function combierteAimput (e) {
        e.preventDefault();
        var url_a_editar = $('.pinta_url').val();
        $(".pinta_url_html").html('<input style="width: 70%; display: inline-block;" id="url_editada" class="form-control form-control-sm mb-3" value="'+url_a_editar+'" type="text"> <button id="guarda_url" type="button" class="btn btn-xs btn-success"><i class="fas fa-thumbs-up"></i></button> <button id="cancela_url" type="button" class="btn btn-xs btn-danger"><i class="fas fa-ban"></i></button>');
    }

    function modificaURL () {
        var titulo_seccion = $('#url_editada').val();
        var data_json = {
            "accion":"escribeURL",
            "datos":{
                'titulo_seccion' : titulo_seccion
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_tienda_path") }}',
            type:  'post',
            dataType:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $(".pinta_url").val(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function cancelaURL(){
        var url_original = $('.pinta_url_original').val();
        $(".pinta_url").val(url_original);
        $(".pinta_url_html").html(url_original+' <a href="#" id="editar_url" class="mb-1 mt-1 mr-1 btn btn-xs btn-info"><i class="fas fa-edit"></i> URL</a>');
    }

    function guardaURL() {
        var url_cambiada = $(".pinta_url").val();
        $(".pinta_url_html").html(url_cambiada+' <a href="#" id="editar_url" class="mb-1 mt-1 mr-1 btn btn-xs btn-info"><i class="fas fa-edit"></i> URL</a>');
        $(".pinta_url_original").val(url_cambiada);
        $(".pinta_url_seo").val(URL_BASE_SECCION+"/"+url_cambiada);
    }

    $(function(){
        $("#form_post_producto").on("submit", function(e){
            e.preventDefault();
            var formData = new FormData(this); 
            formData.append("accion", "guardaProducto");
            
            ajaxSetup();
            $.ajax({
                url: '{{ route("ajax_tienda_path") }}',
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    swal({
                      title: "Publicando producto...",
                      text: "Espere mientras termina el proceso",
                      closeOnClickOutside: false,
                      buttons: false
                    });
                },
                success:  function (result) {
                    console.log(result);
                    if (result.type_swal == "error") {
                        swal(result.tit_swal, result.msj_swal, result.type_swal);
                    }
                    if (result.type_swal == "success") {
                        swal({
                              title: result.tit_swal,
                              text: result.msj_swal,
                              icon: result.type_swal,
                              buttons: true,
                              buttons: ["Listado de productos", "Agregar otro produto"],
                            })
                            .then((willPostOk) => {
                              if (willPostOk) {
                                location.reload();
                              } else {
                                //window.location.href = "";
                              }
                        });
                    }
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
            formData.append("accion", "editaProducto");
            
            ajaxSetup();
            $.ajax({
                url: '{{ route("ajax_tienda_path") }}',
                type: "post",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    swal({
                      title: "Editando producto...",
                      text: "Espere mientras termina el proceso",
                      closeOnClickOutside: false,
                      buttons: false
                    });
                },
                success:  function (result) {
                    console.log(result);
                    if (result.type_swal == "error") {
                        swal(result.tit_swal, result.msj_swal, result.type_swal);
                    }
                    if (result.type_swal == "success") {
                        swal({
                              title: result.tit_swal,
                              text: result.msj_swal,
                              icon: result.type_swal,
                              buttons: true,
                              closeOnClickOutside: false,
                              buttons: ["Listado de productos", "Seguir Editando"],
                            })
                            .then((willPostOk) => {
                              if (willPostOk) {
                                location.reload();
                              } else {
                                window.location.href = URL_BASE_ADMIN+"/productos-tienda";
                              }
                        });
                    }
                },
                error: function(error){
                    console.log(error);
                }
            })
        });
    });

    $(document).on("click", ".delete-item-gal", function(e) {
        e.preventDefault();
        var btn = $(this);
        var id_file = btn.attr("data-id-gal") || btn.closest(".img-cont-gal").attr("data-id-gal");
        var contImg = btn.closest(".img-cont-gal");

        swal({
            title: "¿Eliminar imagen?",
            text: "La imagen se eliminará permanentemente de la galería.",
            icon: "warning",
            buttons: ["Cancelar", "Sí, eliminar"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var data_json = {
                    "accion": "eliminaImagenGaleria",
                    "datos": {
                        "id_file": id_file
                    }
                };
                ajaxSetup();
                $.ajax({
                    data: data_json,
                    url: '{{ route("ajax_tienda_path") }}',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function () {
                        btn.html('<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function (result) {
                        if (result.type_swal === "success") {
                            contImg.fadeOut(300, function() {
                                $(this).remove();
                                if ($(".cont-gal .img-cont-gal").length === 0) {
                                    $(".cont-gal").remove();
                                }
                            });
                            swal(result.tit_swal, result.msj_swal, "success");
                        } else {
                            btn.html('<i class="fas fa-times-circle"></i>');
                            swal(result.tit_swal || "Error", result.msj_swal || "No se pudo eliminar la imagen.", "error");
                        }
                    },
                    error: function (error) {
                        btn.html('<i class="fas fa-times-circle"></i>');
                        console.log(error);
                        swal("Error", "Ocurrió un error al procesar la solicitud.", "error");
                    }
                });
            }
        });
    });
</script>
@stop