<!-- Hero Section Start -->

<div class="hero-main white-sec" style="background: url('{{url('storage/clientes/portadas')}}/{{$clientesRedes->id_proyecto}}/{{$clientesRedes->id_cliente}}/{{$clientesRedes->imagenp}}')">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-12 col-md-5 hero-left cont-text-banner">
                <div class="sec-title">
                    <h1>{{$clientesRedes->nombre_cliente}}</h1>
                </div>
                <p>
                    {{$clientesRedes->descripcion_pry}}
                </p>
                <?php /*
                <div class="hero-btns">
                    <a href="redes-anticaidas-sistema-t/index.html" class="btn">Sistemas anticaidas</a>
                    <a href="https://www.youtube.com/watch?v=XZKO2CMstjw" class="btn btn2" target="_blank">Video</a>
                </div>
                */ ?>
            </div>
            <div class="col-sm-12 col-md-6 wow fadeIn" data-wow-delay="0.5s">
                
            </div>
        </div>
    </div>
</div>
<!-- Our Mission End -->

<div id="about" class="row">
    @include('web_redes.obras.info_cliente')
</div>