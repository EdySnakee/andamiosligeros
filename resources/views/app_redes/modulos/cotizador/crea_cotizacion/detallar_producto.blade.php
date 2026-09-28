
@if($detalle_producto->tipo_cobro == "m2")
  <div class="col-md-4">
    <label for="cantidad">Cantidad</label>
    <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="#" value="">
  </div>
  <div class="col-md-4">
    <label for="largo">Largo</label>
    <input type="number" class="form-control" name="largo" id="largo" placeholder="#" value="">
  </div>
  <div class="col-md-4">
    <label for="alto">Alto</label>
    <input type="number" class="form-control" name="alto" id="alto" placeholder="#" value="">
  </div>
  <div class="col-md-12">
    <label for="precio" class="col-form-label">Precio</label>
    <input type="number" class="form-control" name="precio" id="precio" placeholder="#" value="{{$detalle_producto->precio}}">
  </div>
@elseif($detalle_producto->tipo_cobro == "fijo")
  <div class="col-md-4">
    <label for="cantidad" class="col-form-label">Cantidad</label>
    <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="#" value="" autocomplete="off">
  </div>
  <div class="col-md-8">
    <label for="precio" class="col-form-label">Precio</label>
    <div class="input-group mb-2">
      <div class="input-group-prepend">
        <div class="input-group-text">$</div>
      </div>
      <input type="number" class="form-control" name="precio" id="precio" placeholder="#" value="{{$detalle_producto->precio}}" autocomplete="off">
    </div>
  </div>
@endif

