<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Agregar nuevo proyecto</h1>
  <p class="mb-4">Módulo para agregar nuevos proyectos, todos los proyectos se guardarán en la siguiente url base: 
  <br> https://mallasanticaidas.com/proyectos/<span class="pinta_url">{titulo-de-proyecto}</span>.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Nuevo proyecto</h6>
    </div>
    <div class="card-body">
      <form enctype="multipart/form-data" id="formuploadajax" method="post">
        <div class="form-group row">
          <label for="nombre_cliente" class="col-sm-2 col-form-label">Nombre de proyecto *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre de proyecto" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="proyecto" class="col-sm-2 col-form-label">Estado *</label>
          <div class="col-sm-10">
            <select class="form-control" name="proyecto" id="proyecto" placeholder="Estado" required>
              <option disabled selected>Selecciona un Estado</option>
              @foreach($catalogo_proyectos as $catproyectos)
                  <option value="{{$catproyectos->id_proyecto}}">{{$catproyectos->nombre_proyecto}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <hr>
        <div class="form-group row">
          <label for="palabras_clave" class="col-sm-2 col-form-label">Palabras Clave <br>
          <small>Preciona enter para separar palabras clave</small>
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control inputtags" value="Redes anticaidas" name="palabras_clave" id="palabras_clave" data-role="tagsinput" placeholder="Separadas por Enter" />
          </div>
        </div>

        <div class="form-group row">
          <label for="descripcion_proyectos" class="col-sm-2 col-form-label">Descripción de proyecto
          <small>Se usará en la Meta descripición y en la desripción principal</small>
        </label>

          <div class="col-sm-10">
            <textarea class="form-control" id="descripcion_proyectos" name="descripcion_pry" placeholder="Descripción de proyecto" rows="3"></textarea>
          </div>
        </div>

         <hr>
         <div class="form-group row ">
          <label for="img_portada" class="col-sm-2 col-form-label">Imagen Principal * <br>
          <small>Medida de imágen recomendada <br> 1900x800px</small>
           </label>

          <div class="col-sm-10">
            <input class="btn label-info subida_imagen" type="file" name="img_portada" id="img_portada" required>
          </div>
        </div>
        <hr>

        <div class="form-group row">
          <label for="latitud" class="col-sm-2 col-form-label">Latitud</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="latitud" id="latitud" placeholder="Latitud">
          </div>
        </div>
        <div class="form-group row">
          <label for="longitud" class="col-sm-2 col-form-label">Longitud</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="longitud" id="longitud" placeholder="Longitud">
          </div>
        </div>
        <hr>        

        <div class="form-group row">
          <label for="longitud" class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10">
            <input class="form-control" type="hidden"  id="ubicacion" name="ubicacion" data-lat="20.9802115" data-long="-89.7029583" value="">
            <div id="map_canvas" style="width:100%;height:300px;"></div>, 
          </div>
        </div>

        <hr>

        <div class="form-group row mb-70">
          <label class="col-sm-2 col-form-label">Contenido HTML</label>
          <div class="col-sm-10">
            <div id="contentquill" style="height: 90vh;">
            </div>
            <textarea class="form-control" rows="10" cols ="10" name="contenido_html" type="textarea" style="display: none" id="content-textarea">
                          
            </textarea>
          </div>
        </div>


        <hr>
        <div class="form-group row ">
          <label for="imgs_galeria" class="col-sm-2 col-form-label">Galeria</label>
          <div class="col-sm-10">
            <input class="btn label-info subida_imagen" type="file" name="imgs_galeria[]" id="imgs_galeria" multiple>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-10">
            <input type="hidden" value="" name="url_cliente" id="url_cliente" class="pinta_url">
            <button type="submit" id="guarda_cliente" class="btn btn-primary">Guardar proyecto</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>