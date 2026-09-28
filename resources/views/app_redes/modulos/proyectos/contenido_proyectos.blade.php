<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Estados</h1>
    <?php /*<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Gemerar Reporte</a>*/ ?>
    <a href="{{url('sb-admin/agregar-estados')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle"></i> Alta de estados</a>
  </div>

  
  <div class="row" id="items-proyectos">
      @include('app_redes.modulos.proyectos.items_proyectos')
  </div>
</div>