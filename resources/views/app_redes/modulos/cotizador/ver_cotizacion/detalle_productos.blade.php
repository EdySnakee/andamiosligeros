@php
use App\Productos;
@endphp

@foreach($idsproducts_unicos as $ids_productos)
<?php
$objProductos = new Productos();
$infoProducto = $objProductos
    ->select("*")
    ->from("productos AS pro")
    ->join("detalle_producto AS dp", "dp.id_producto", "=", "pro.id_producto")
    ->where("pro.id_producto", $ids_productos)
    ->first();
?>

<div id="{{$infoProducto->SKU}}" class="row mt-20" style="background: white; border: none; position: relative; max-width: 900px; margin-right: auto; margin-left: auto">
    <div class="col-md-12" style="padding: 20px;">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 style="color: #1a4189;"><b>ANEXO ({{$infoProducto->SKU}})</b> </h2>
                <h3 style="margin-top: 0;">{{$infoProducto->nombre_p}}</h3>
            </div>
            <div class="col-md-6 col-xs-12 text-center res-center">
                <img width="200px" src="{{$ruta_logo}}" alt="">
                <p class="text-img" style="font-weight: bold; color: #666;">50% mas ligero, misma resistencia.</p>
            </div>
        </div>
        <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="img-responsive" style="width: 100%;">


        <div class="row">
            <div class="col-md-12">
                <h5 style="border-bottom: 2px solid #f2bc1c; display: inline-block; padding-bottom: 5px; margin-top: 10px">DESCRIPCIÓN</h5>
                <div style="font-size: 14px; line-height: 1.6;">
                    <?php echo $infoProducto->descripcion_producto; ?>
                </div>
            </div>
        </div>

        @if($infoProducto->num_plantilla == 1)
        <div class="row cont-plantilla" style="margin-top: 20px;">
            <div class="col-md-6 col-xs-12">
                <h5 style="border-bottom: 2px solid #f2bc1c; display: inline-block;">CARACTERISTICAS</h5>
                <div style="font-size: 13px;">
                    <?php echo $infoProducto->caracteristicas_producto; ?>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 text-center" style="margin-top: 15px;">
                <img class="img-responsive" style="max-width: 100%; height: auto; display: inline-block;" src="{{url('storage/productos')}}/{{$infoProducto->id_producto}}/{{$infoProducto->imagen}}" alt="">
            </div>
        </div>
        @elseif($infoProducto->num_plantilla == 2)
        <div class="row cont-plantilla" style="margin-top: 20px;">
            <div class="col-md-12">
                <h5 style="border-bottom: 2px solid #f2bc1c; display: inline-block;">CARACTERISTICAS</h5>
                <div style="font-size: 13px;">
                    <?php echo $infoProducto->caracteristicas_producto; ?>
                </div>
            </div>
        </div>
        <div class="row cont-plantilla">
            <div class="col-md-12 text-center" style="margin-top: 15px;">
                <img class="img-responsive" style="max-width: 100%; height: auto; display: inline-block;" src="{{url('storage/productos')}}/{{$infoProducto->id_producto}}/{{$infoProducto->imagen}}" alt="">
            </div>
        </div>
        @endif

        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12">
                <?php echo $infoProducto->extra_info_producto; ?>
            </div>
        </div>

        <div class="row footer-content" style="">
            <div class="col-md-3 col-xs-4 text-right">
                <img src="{{url('cotizaciones/img/logo-bbva.png')}}" alt="BBVA" class="coti-bbva">
            </div>
            <div class="col-md-3 col-xs-8 text-left" style="padding-left: 10px">
                <p style="margin: 0; font-weight: bold;">LUIS ÁNGEL CORAL LÓPEZ</p>
                <p style="margin: 0;">CUENTA: 2943604209</p>
                <p style="margin: 0;">CLABE: 012910029436042092</p>
            </div>
            <div class="col-md-6 col-xs-12">
                <img src="{{ url('cotizaciones/img/mercadopago-logo.png') }}" alt="Mercado Pago" class="coti-mp" style="margin-right: 5px; margin-left: 0px">
            </div>
            <img class="footer-img" src="{{ url('cotizaciones/img/COTIZACION-Cinta-Seguridad-Hecho-En-Mexico.png') }}">
        </div>
    </div>

</div>
@endforeach