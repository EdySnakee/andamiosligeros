<div class="card shadow mb-4  no-padding">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Plantilla 1</h6>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-sm-12">
            <label for="nombre_producto">Nombre de producto *</label>
            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" placeholder="Nombre de producto" required value="{{(!empty($detalle_producto->nombre_p))?$detalle_producto->nombre_p:''}}">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-sm-12">
            <label for="giro_producto">Giro de producto *</label>
            @if($accion == "agregar")
            <select class="form-control js-example-basic-single" name="giro_producto" id="giro_producto">
              <option disabled selected>Selecciona un Giro</option>
              <option value="ra">Redes Anticaidas</option>
              <option value="rp">Redes perimetrales</option>
              <option value="sg">Scoregol</option>
              <option value="al">Andamios ligeros</option>
            </select>
            @elseif($accion == "editar")
            <select class="form-control js-example-basic-single" name="giro_producto" id="giro_producto">
              <option disabled>Selecciona un Giro</option>
              @if($detalle_producto->giro_producto == "ra")
              <option value="ra" selected>Redes Anticaidas</option>
              <option value="rp">Redes perimetrales</option>
              <option value="sg">Scoregol</option>
              <option value="al">Andamios ligeros</option>
              @elseif($detalle_producto->giro_producto == "rp")
              <option value="ra">Redes Anticaidas</option>
              <option value="rp" selected>Redes perimetrales</option>
              <option value="sg">Scoregol</option>
              <option value="al">Andamios ligeros</option>
              @elseif($detalle_producto->giro_producto == "sg")
              <option value="ra">Redes Anticaidas</option>
              <option value="rp">Redes perimetrales</option>
              <option value="sg" selected>Scoregol</option>
              <option value="al">Andamios ligeros</option>
              @elseif($detalle_producto->giro_producto == "al")
              <option value="ra">Redes Anticaidas</option>
              <option value="rp">Redes perimetrales</option>
              <option value="sg">Scoregol</option>
              <option value="al" selected>Andamios ligeros</option>
              @endif
            </select>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-sm-12">
            <label for="tipo_cobro">Tipo de cobro *</label>
            <select class="form-control js-example-basic-single" name="tipo_cobro" id="tipo_cobro">
              @if($accion == "agregar")
              <option disabled selected>Selecciona un tipo de cobro</option>
              <option value="fijo" selected>Fijo</option>
              <option value="m2">Por m<sup>2</sup></option>
              @elseif($accion == "editar")
              @if($detalle_producto->tipo_cobro == "fijo")
              <option value="fijo" selected>Fijo</option>
              <option value="m2">Por m<sup>2</sup></option>
              @elseif($detalle_producto->tipo_cobro == "m2")
              <option value="fijo">Fijo</option>
              <option value="m2" selected>Por m<sup>2</sup></option>
              @endif
              @endif
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-sm-12">
            <label for="precio_p">Precio *</label>
            @if(Auth::User()->tipo_usuario == "mayorista")
            <input type="number" step="any" class="form-control" name="precio_m" id="precio_m" placeholder="Precio de producto" required value="{{(!empty($detalle_producto->precio_m))?$detalle_producto->precio_m:''}}">
            @else
            <input type="number" step="any" class="form-control" name="precio_p" id="precio_p" placeholder="Precio de producto" required value="{{(!empty($detalle_producto->precio))?$detalle_producto->precio:''}}">
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group row">
          <div class="col-md-12 cont-text-editor">
            <label>Descripción del producto</label>
            <div id="contenedor_editable" style="height: 30vh;">
              <?php print_r((!empty($detalle_producto->descripcion_producto)) ? $detalle_producto->descripcion_producto : '') ?>
            </div>
            <textarea class="form-control" rows="5" cols="5" name="descripcion_producto" type="textarea" style="display: none" id="primer_contenido" value="{{(!empty($detalle_producto->descripcion_producto))?$detalle_producto->descripcion_producto:''}}">{{(!empty($detalle_producto->descripcion_producto))?$detalle_producto->descripcion_producto:''}}</textarea>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-md-12 cont-text-editor">
            <label>Caracteristicas del producto</label>
            <div id="contenedor_editable2" style="height: 30vh;">
              <?php print_r((!empty($detalle_producto->caracteristicas_producto)) ? $detalle_producto->caracteristicas_producto : '') ?>
            </div>
            <textarea class="form-control" rows="5" cols="5" name="caracteristicas_producto" type="textarea" style="display: none" id="segundo_contenido" value="{{(!empty($detalle_producto->caracteristicas_producto))?$detalle_producto->caracteristicas_producto:''}}">{{(!empty($detalle_producto->caracteristicas_producto))?$detalle_producto->caracteristicas_producto:''}}</textarea>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <label>Imagen del producto</label>
        @if($accion == "agregar")
        <input type="file" name="imagen_destacada" data-height="335" id="imagen_destacada" class="dropify" />
        @elseif($accion == "editar")
        <input type="file" name="imagen_destacada" data-height="335" id="imagen_destacada" class="dropify" data-default-file="{{url('storage/productos')}}/{{$detalle_producto->id_producto}}/{{$detalle_producto->imagen}}" />
        @endif
      </div>
      <div class="col-md-12">
        <label>Banner (Imagen ancha)</label>
        @if($accion == "agregar")
        <input type="file" name="banner" data-height="335" id="banner" class="dropify" />
        @elseif($accion == "editar")
        <input type="file" name="banner" data-height="335" id="banner" class="dropify"
          data-default-file="{{ (!empty($detalle_producto->banner)) ? url('storage/productos/banners').'/'.$detalle_producto->banner : '' }}" />
        @endif
      </div>
      <div class="col-md-12">
        <div class="form-group row">
          <div class="col-md-12 cont-text-editor">
            <label>Información adicional</label>
            <div id="contenedor_editable3" style="height: 30vh;">
              <?php print_r((!empty($detalle_producto->extra_info_producto)) ? $detalle_producto->extra_info_producto : '') ?>
            </div>
            <textarea class="form-control" rows="5" cols="5" name="extra_info_producto" type="textarea" style="display: none" id="tercer_contenido" value="{{(!empty($detalle_producto->extra_info_producto))?$detalle_producto->extra_info_producto:''}}">{{(!empty($detalle_producto->extra_info_producto))?$detalle_producto->extra_info_producto:''}}</textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12">
      @if($accion == "agregar")
      <input type="hidden" value="{{(!empty($numero_plantilla))?$numero_plantilla:''}}" name="num_plantilla" id="num_plantilla">
      <button type="submit" id="guarda_articulo" class="btn btn-primary float-right">Guardar producto</button>
      @elseif($accion == "editar")
      <input type="hidden" value="{{(!empty($detalle_producto->num_plantilla))?$detalle_producto->num_plantilla:''}}" name="num_plantilla" id="num_plantilla">
      <input type="hidden" value="{{(!empty($detalle_producto->id_producto))?$detalle_producto->id_producto:''}}" name="id_producto" id="id_producto">
      <button type="submit" id="edita_articulo" class="btn btn-primary float-right">Editar producto</button>
      @endif
    </div>
  </div>
</div>