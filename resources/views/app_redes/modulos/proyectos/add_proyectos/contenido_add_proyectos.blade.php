<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Agregar nuevo estado</h1>
  <p class="mb-4">Módulo para agregar nuevos estados, todos los estados se guardarán en la siguiente url base: 
  <br> https://mallasanticaidas.mx/proyectos/<span id="pinta_url">{titulo-de-estado}</span>.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Nuevo estado</h6>
    </div>
    <div class="card-body">
        <div class="form-group row">
          <label for="nombre_proyecto" class="col-sm-2 col-form-label">Titulo de estado *</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nombre_proyecto" placeholder="Titulo de estado">
          </div>
        </div>
        <div class="form-group row">
          <label for="estado" class="col-sm-2 col-form-label">Estado *</label>
          <div class="col-sm-10">
            <select class="form-control" id="estado" placeholder="Estado">
              <option value="SE" >Selecciona un Estado</option>
              @foreach($catalogo_estados as $catestado)
                  <option value="{{$catestado->idestado}}" data-estado="{{$catestado->estado}}">{{$catestado->estado}}</option>
              @endforeach
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
            <input type="text" class="form-control inputtags" value="Redes anticaidas" id="palabras_clave" data-role="tagsinput" placeholder="Separadas por Enter" />
          </div>
        </div>

        <div class="form-group row">
          <label for="descripcion_proyectos" class="col-sm-2 col-form-label">Descripción de estado</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="descripcion_proyectos" placeholder="Descripción de estado" rows="3"></textarea>
          </div>
        </div>

        <div class="form-group row">
          <label for="subida_imagen" class="col-sm-2 col-form-label">Elige una imágen de portada
            <small>Medida de imágen recomendada <br> 1900 x 450px</small>
          </label>

          <div class="col-sm-10">
            <input type="file" name="subida_imagen" id="subida_imagen" class="dropify" />
          </div>
        </div>

        

        <div class="form-group row">
          <div class="col-sm-10">
            <button type="submit" id="guarda_proyecto" class="btn btn-primary">Guardar estado</button>
          </div>
        </div>
    </div>
  </div>

</div>