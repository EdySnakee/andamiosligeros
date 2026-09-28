<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Editar Proyecto: <span class="tit-proyecto-edit">{{$datos_proyecto->nombre_proyecto}}</span></h1>
    <a href="{{url('sb-admin/proyectos')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-undo"></i> Regresar a proyectos</a>
  </div>

  <p class="mb-4">Módulo para editar proyectos, este proyecto se visualiza en la siguiente url: 
  <br> https://mallasanticaidas.mx/proyectos/<span id="pinta_url">{{$datos_proyecto->url_proyecto}}</span>.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Editar proyecto</h6>
    </div>
    <div class="card-body">
        <div class="form-group row">
          <label for="nombre_proyecto" class="col-sm-2 col-form-label">Nombre de proyecto *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nombre_proyecto" placeholder="Nombre de proyecto" value="{{$datos_proyecto->nombre_proyecto}}">
          </div>
        </div>
        <div class="form-group row">
          <label for="estado" class="col-sm-2 col-form-label">Estado *</label>
          <div class="col-sm-10">
            <select class="form-control" id="estado" placeholder="Estado" disabled>
              <option value="{{$datos_proyecto->id_estado}}" selected>{{$datos_proyecto->estado}}</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label for="ciudad" class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10" id="resultado_proyecto">
          </div>
        </div>

         <hr>

        <div class="form-group row">
          <label for="palabras_clave" class="col-sm-2 col-form-label">Palabras Clave <br>
          <small>Preciona enter para separar palabras clave</small>
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control inputtags" value="{{$datos_proyecto->palabras_clave}}" id="palabras_clave" data-role="tagsinput" placeholder="Separadas por Enter" />
          </div>
        </div>
        <div class="form-group row">
          <label for="descripcion_proyectos" class="col-sm-2 col-form-label">Descripción de proyectos</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="descripcion_proyectos" placeholder="Descripción de proyectos" rows="3">{{$datos_proyecto->descripcion}}</textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="subida_imagen" class="col-sm-2 col-form-label">Reemplazar imágen de portada</label>
          <div class="col-sm-10">
            <input class="btn label-info" type="file" name="subida_imagen" id="subida_imagen">
            <br>
            <div class="contimagen">
              @if($datos_proyecto->img_portada != "")
                <img src="{{url('storage/proyectos/')}}/{{$datos_proyecto->id_proyecto}}/{{$datos_proyecto->img_portada}}" alt="">
              @else
                <img src="{{url('script/img/unnamed.png')}}" alt="">
              @endif

            </div>
          </div>
        </div>

        

        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" id="editar_proyecto" data-id-proyecto="{{$datos_proyecto->id_proyecto}}" class="btn btn-primary">Editar proyecto</button>
          </div>
        </div>
    </div>
  </div>

</div>