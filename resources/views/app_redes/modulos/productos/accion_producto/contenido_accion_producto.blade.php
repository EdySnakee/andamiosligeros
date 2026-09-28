<div class="container-fluid">

  <!-- Page Heading -->
  @if($accion == "agregar")
    <h1 class="h3 mb-2 text-gray-800" id="tipo_accion" data-accion="agregar">Agregar producto</h1>
    <p class="mb-4">Módulo para agregar productos</p>
  @elseif($accion == "editar")
    <h1 class="h3 mb-2 text-gray-800" id="tipo_accion" data-accion="editar">Editar producto</h1>
    <p class="mb-4">Módulo para editar productos</p>
  @endif

  <!-- DataTales Example -->
  @if($accion == "agregar")
    <form enctype="multipart/form-data" id="form_post_producto" class="row" method="post">
      <div class="col-xl-9 col-lg-9 offset-1 ">
        <h5 class="text-center">Elige una plantilla para ficha técnica</h5>
        <div class="row">
          <div class="col-xl-4 col-lg-4 offset-2" >
            <div class="select_plantilla card shadow mb-4" id="plantilla1" data-plantilla="1">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plantilla 1</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 border-text mb-1">
                      <small>The styling for this basic card example is created by using default Bootstrap utility classes. By using utility classes, the style of the card component.</small>
                    </div>
                    <div class="col-md-6 border-text mb-1">
                      <small>Bootstrap utility classes. By using utility classes, the style of the card component.</small>
                    </div>
                    <div class="col-md-6 border-text mb-1">
                      <div class="img-plan"><i class="far fa-image"></i></div>
                    </div>
                    <div class="col-md-12 border-text">
                      <small>Bootstrap utility classes. By using utility classes, the style of the card component.</small>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4" >
            <div class="select_plantilla card shadow mb-4" id="plantilla2" data-plantilla="2">
              <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Plantilla 2</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 border-text mb-1">
                      <small>Utility classes. By using utility classes, the style of the card component.</small>
                    </div>
                    <div class="col-md-12 border-text mb-1">
                      <small>Bootstrap utility classes. By using utility classes.</small>
                    </div>
                    <div class="col-md-12 border-text mb-1">
                      <div class="img-plan"><i class="far fa-image"></i></div>
                    </div>
                    <div class="col-md-12 border-text">
                      <small>Bootstrap utility classes. By using utility classes, the style of the card component.</small>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12" id="select_plantilla">
        
      </div>
    </form>
  @elseif($accion == "editar")
    <form enctype="multipart/form-data" id="form_edit_producto" class="row" method="post">
      <div class="col-xl-12 col-lg-12" id="select_plantilla">
        @if($detalle_producto->num_plantilla == 1)
          @include('app_redes.modulos.productos.accion_producto.plantillas_fichas_tecnicas.plantilla1')
        @elseif($detalle_producto->num_plantilla == 2)
          @include('app_redes.modulos.productos.accion_producto.plantillas_fichas_tecnicas.plantilla2')
        @endif
      </div>
    </form>
  @endif

  
</div>