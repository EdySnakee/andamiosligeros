<div class="container-fluid">

  <!-- Page Heading -->
  @if($accion == "agregar")
    <h1 class="h3 mb-2 text-gray-800">Agregar artículo</h1>
    <p class="mb-4">Módulo para agregar artículos (Blog).</p>
  @elseif($accion == "editar")
    <h1 class="h3 mb-2 text-gray-800">Editar artículo</h1>
    <p class="mb-4">Módulo para editar artículos (Blog).</p>
  @endif

  <!-- DataTales Example -->
  @if($accion == "agregar")
    <form enctype="multipart/form-data" id="form_post_articulo" class="row" method="post">
  @elseif($accion == "editar")
    <form enctype="multipart/form-data" id="form_edit_articulo" class="row" method="post">
  @endif
      <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4  no-padding">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Documento</h6>
          </div>
          <div class="card-body">
              <div class="form-group row">
                <label for="titulo_articulo" class="col-sm-2 col-form-label">Título de artículo *</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="titulo_articulo" id="nombre_cliente" placeholder="Título de artículo" required value="{{(!empty($info_blog->post_titulo))?$info_blog->post_titulo:''}}">
                </div>
              </div>
               <hr>
               <div class="form-group row ">
                <label for="img_portada" class="col-sm-2 col-form-label">Reemplazar Imagen de Portada * <br>
                <small>Medida de imágen recomendada <br> 1900x800px</small>
                 </label>
                <div class="col-sm-10">
                  <input class="btn label-info subida_imagen" type="file" name="img_portada" id="img_portada">
                  @if($accion == "editar")
                  <div class="contimagen">
                    @if($info_blog->img_portada != "")
                      <img src="{{url('storage/blog')}}/{{$info_blog->id_blog}}/{{$info_blog->img_portada}}" alt="">
                    @else
                      <img src="{{url('script/img/unnamed.png')}}" alt="">
                    @endif
                  </div>
                  @endif
                </div>
              </div>
              <hr>
              <div class="form-group row mb-70">
                <label class="col-sm-2 col-form-label">Contenido HTML</label>
                <div class="col-sm-10">
                  <div id="contentquill" style="height: 90vh;">
                    <?php print_r((!empty($info_blog->post_contenido))?$info_blog->post_contenido:'') ?>
                  </div>
                  <textarea class="form-control" rows="10" cols ="10" name="contenido_html" type="textarea" style="display: none" id="content-textarea" value="{{(!empty($info_blog->post_contenido))?$info_blog->post_contenido:''}}">{{(!empty($info_blog->post_contenido))?$info_blog->post_contenido:''}}</textarea>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4 no-padding">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">SEO</h6>
          </div>
          <div class="card-body">
              <div class="form-group row">
                <label for="titulo_articulo" class="col-sm-12 col-form-label">URL de blog </label>
                <div class="col-sm-12">
                  <p>https://mallasanticaidas.com/blog/<span class="pinta_url">{{{(!empty($info_blog->post_url))?$info_blog->post_url:''}}}</span>.</p>
                  <input type="hidden" value="{{(!empty($info_blog->post_url))?$info_blog->post_url:''}}" name="url_articulo" id="url_articulo" class="pinta_url">
                </div>
              </div>
              <hr>
              <div class="form-group row">
                <label for="palabras_clave" class="col-sm-12 col-form-label">Palabras Clave
                </label>
                <div class="col-sm-12" id="p_claves">
                  <input type="text" class="form-control inputtags" value="{{(!empty($info_blog->palabras_clave))?$info_blog->palabras_clave:'Redes anticaidas'}}" name="palabras_clave" id="palabras_clave" data-role="tagsinput" placeholder="Separadas por coma" />
                </div>
              </div>
              <div class="form-group row">
                <label for="descripcion_proyectos" class="col-sm-12 col-form-label">Descripción de proyecto <br>
                <small>Se usará como Meta descripición</small>
              </label>

                <div class="col-sm-12">
                  <textarea class="form-control" id="descripcion_proyectos" name="meta_descripcion" placeholder="Descripción de proyecto" rows="3">{{(!empty($info_blog->meta_descripcion))?$info_blog->meta_descripcion:''}}</textarea>
                </div>
              </div>
              <hr>
              <div class="form-group row">
                <div class="col-sm-12">
                  @if($accion == "agregar")
                    <button type="submit" id="guarda_articulo" class="btn btn-primary float-right">Publicar artículo</button>
                  @elseif($accion == "editar")
                    <input type="hidden" value="{{(!empty($info_blog->id_blog))?$info_blog->id_blog:''}}" name="id_blog" id="id_blog">
                    <button type="submit" id="edita_articulo" class="btn btn-primary float-right">Editar artículo</button>
                  @endif
                </div>
              </div>
          </div>
        </div> 
      </div>
    </form>
</div>