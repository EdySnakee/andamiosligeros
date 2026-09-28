<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bienvenido {{\Auth::User()->name}}</h1>
    <a href="{{url('sb-admin/cotizaciones')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-calculator"></i> Ver cotizaciones</a>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Redes anticaidas</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$cant_re_anti}} Cotizaciones</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Scoregol</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$cant_sgol}} Cotizaciones</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Andamios Ligeros</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$cant_anda_lig}} Cotizaciones</div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Redes perimetrales</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{$cant_re_peri}} Cotizaciones</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->
  <div class="row">

    <div class="col-lg-6 mb-4">
      <!-- Illustrations -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">App Redes Anticaidas</h6>
        </div>
        <div class="card-body">
          <div class="text-center">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{url('script/img/undraw_posting_photo.svg')}}" alt="">
          </div>
          <p>Sistema en la nube para la realización de cotizaciones a clientes y como el inicio de manejador de contenido para el sitio mallasanticaidas.com</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <!-- Approach -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Actualizaciones Sistema Redes Anticaidas</h6>
        </div>
        <div class="card-body">
          <p><b>Junio 2021.</b></p>
          <p class="mb-0">13 Junio 2021 - Actualziación en las cotizaciones se añade opcion con/sin IVA.</p>
          <p>15 Junio 2021 - Actualziación en las cotizaciones se agrega otros giros de negocio.</p>
          <p><b>Julio 2021.</b></p>
          <p class="mb-0">13 Julio 2021- Se agrega vistas de cotizaciones de giros de negocios</p>
          <p class="mb-0">14 Julio 2021- Se agrega permisos nivel usuarios</p>
          <p class="mb-0">23 Julio 2021- Módolo para editar cotizaciones activas.</p>
        </div>
      </div> 
    </div>
  </div>

</div>