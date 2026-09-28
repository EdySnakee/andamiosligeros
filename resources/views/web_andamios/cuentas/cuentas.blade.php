@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros | Andamios Galvanizados | Andamios</title>
    <meta name="description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:title" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:site_name" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />


    <link rel="canonical" href="{{ url('/cuentas-oficiales') }}">
    <meta property="og:url" content="{{ url('/cuentas-oficiales') }}" />
@stop

@section('content')
    <main class="page-normal">
        <section class="seccion-normal bienvenida">
            <div class="contenido">
                <div class="grid-flex wrapper">
                    <div class="col-12">
                        <div class="o-text-wrapper">
                            <style>
                                ul.list-cuentas li {
                                    list-style: disc;
                                    margin: 0;
                                }

                                .list-cuentas {
                                    margin-top: 0;
                                }
                            </style>
                            <h3 class="text-center">REDES ANTICAIDAS SA DE CV</h3>
                            <ul class="list-cuentas">
                                <li>
                                    <p>RFC: RAN1410105J2</p>
                                </li>
                                <li>
                                    <p>DIRECCIÓN: Calle 58 núm 263 x 55 y 59a fracc. Las Vigas, Merida, Yuc. CP 97227.</p>
                                </li>
                                <li>
                                    <p>OFICINA: 9999459290 </p>
                                </li>
                                <li>
                                    <p>LADA SIN COSTO: 800 083 6848</p>
                                </li>
                                <li>
                                    <p>WHATSAP: 9996361314 y 5569328135</p>
                                </li>
                            </ul>
                            <p style="margin: 0;">LA SIGUIENTE CUENTA ES LA ÚNICA AUTORIZADA POR LA EMPRESA PARA EL PAGO DE
                                NUESTROS PRODUCTOS Y SERVICIOS.</p>
                            <ul class="list-cuentas">
                                <img style="width: 200px;" src="{{ url('script/BBVA-logo.jpg') }}" alt="">
                                <h3>Cuenta Maestra PYME BBVA</h3>
                                <li>
                                    <p>Cuenta: 2943604209</p>
                                </li>
                                <li>
                                    <p>Clabe: 012910029436042092</p>
                                </li>
                                <li>
                                    <p>Sucursal: 5129</p>
                                </li>
								<li>
                                    <p>Dirección: Calle 54 599 Col. Fracc. Gran Santa Fe, Mérida, Yucatán. MEX</p>
                                </li>
								<li>
                                    <p>Teléfono: 9996213434</p>
                                </li>

								<br>
								<p>Puede pagar sus compras a través de <span><img style="width: 60px;" src="{{url('script/oxxo-logo.jpeg')}}"></span> o cualquier practicaja Bancomer.</p>
								<p>Tarjeta: 4815 1630 2105 0672</p>
                            </ul>
                            <hr>
                            <ul class="list-cuentas">
                                <img style="width: 200px; margin:20px 0" src="{{ url('script/mercado-pago-logo.png') }}">
                                <li>
                                    <p>Tarjeta: 5428 7801 8418 7359</p>
                                </li>
                                <li>
                                    <p>Cuenta CLABE: 722969010201851441</p>
                                </li>
                            </ul>
                            <hr>
							<ul class="list-cuentas">
                                <img style="width: 200px;" src="https://redesanticaidas.mx/script/Santander-Logo.png"
                                    alt="">
                                <li>
                                    <p>Cuenta: 65-50656173-4</p>
                                </li>
                                <li>
                                    <p>Clabe: 014910655065617341</p>
                                </li>
                            </ul>
							<p style="text-align:center;margin-top:100px"><b>Andamios Ligeros®</b> es una empresa filial del grupo <b>Redes Anticaídas SA de CV</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop
