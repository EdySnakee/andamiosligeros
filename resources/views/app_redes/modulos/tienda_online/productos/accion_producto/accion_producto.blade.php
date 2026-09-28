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
    span.MultiFile-label {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    span.MultiFile-title {
        width: 70%;
    }
    img.MultiFile-preview {
        width: 30%;
    }
    a.MultiFile-remove {
        display: none;
    }
    .pull-right {
        margin-top: 0 !important;
    }
    .img-cont-gal {
        display: inline-block;
        position: relative;
        margin-bottom: 0.75em;
        margin-right: 0.25em;
        margin-left: 0.25em;
    }

    .img-cont-gal img {
        width: 100px;
        height: 100px;
        object-fit: contain;
    }
    .cont-gal {
        margin-top: 3em;
        text-align: center;
        margin-bottom: 2em;
    }
    a.delete-item-gal {
        position: absolute;
        top: 1px;
        right: 4px;
        font-size: 1.5em;
        display: none;
    }
    .img-cont-gal:hover a {
        display: block;
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
</script>
@stop