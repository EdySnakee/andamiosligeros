<header class="inicio-b">
    
    <div class="bienvenida">
        <div class="bienv-img pt-5">
            <img class="img-fluid" src="{{ url('web/buen_fin/assets/img/chingones.gif') }}" alt="Buen fin en Andamios Ligeros">
        </div>    
        <div class="cont-text-info">
            <div class="text-center">
                
            <img class="img-fluid" src="{{ url('web/buen_fin/assets/img/buen-fin-andamios.png') }}" alt="Buen fin en Andamios Ligeros">
                
                <a class="btn btn-chingon" href="#promos">Ver Promos</a>
            </div>
        </div>
        
    </div>
    <div class="cinta cinta1">
        <img src="{{ url('web/buen_fin/assets/img/1.png') }}" alt="">
    </div>
    <div class="cinta cinta2">
        <img src="{{ url('web/buen_fin/assets/img/2.png') }}" alt="">
    </div>
    
</header>
<div class="cont-info">
    <div class="anuncio-promo text-center">
        <div>
            <h1 class="family-promo f-rosa">¡Los Andamios más vendidos de México!</h1>
            <p class=" font-promo">Descubre nuestras promociones vigentes <br> del buen fin, <span class="f-rosa">¡Precios únicos e irrepetibles!</span></p>
        </div>
    </div>
    
    <div class="container-md cont-princ-product">
        <div class="row">
            {{-- 
            <div class="col-md-12">
                <h1>Nuestras promociones</h1>
            </div>
            --}}
            @if (!empty($items_promos))
                @foreach ($items_promos as $item)
                    <div class="col-md-6" style="margin-top: 2vw; margin-bottom: 2vw;">
                        <a class="" href="{{url('promociones')}}/{{$item->url_promo}}">
                            <div class="cont-item-product cont-promo {{ ($item->status == 2) ? 'item-vencido' : '' }}  card-product border rounded-5 shadow" style="cursor: pointer;">
                                <div class="img-item-promo border-bottom">
                                    @if ($item->status == 2)
                                        <div class="eti eti-vencida">
                                            PROMO VENCIDA 😞
                                        </div>
                                    @elseif($item->status == 1)
                                        <span class="eti eti-success">SUPER Promoción 🤑</span>
                                    @elseif($item->status == 3)
                                        <span class="eti eti-success">🤑 BUEN FIN 🤑</span>
                                    @endif
                                    
                                    <img class="img-fluid" loading="lazy" src="{{url('web/prom')}}/{{$item->img_social}}">
                                </div>
                                <div class="info-item-promo">
                                    <h2>🌟 <b>{{$item->nombre_product}}</b> 🌟</h2>
                                    <div class="desc-promo"><small><p>{{$item->descripcion}}</p></small></div>
                                    <p class="price mb-3">
                                        @if ($item->status == 1 or $item->status == 2)
                                            <span class="sale text-color-dark">$ {{number_format($item->costo_item, 2, '.', ',')}}</span>
                                        @else
                                        
                                        @endif
                                    </p>
                                    <div class="cont-btn-promo">
                                        @if ($item->status == 1 or $item->status == 2)
                                        <a  class="btn-slide btn-cotizar-s" style="position: relative; bottom: 1em; right: 0;" href="{{url('promociones')}}/{{$item->url_promo}}">La quiero</a>
                                       
                                    @else
                                        <a  class="btn-slide btn-cotizar-s" style="position: relative; bottom: 1em; right: 0;" href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20apartar%20{{$item->nombre_promo}}">¡Apartar ahora!</a>
                                    
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                @endforeach
            @endif
            
        </div>
    </div>
</div>


<div class="social-whats-footer">
    <a onclick="return gtag_report_conversion('https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20recibir%20información%20sobre%20Andamios%20Ligeros%20Del%20Buen%20Fin');" href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20recibir%20información%20sobre%20Andamios%20Ligeros%20Del%20Buen%20Fin" id="whatsapp_widget" class="whatsapp_widget_big" style="width:80px; height:80px; " target="_blank">
        <img src="{{url('web/img/icon_whatsApp.png')}}" alt="whatsapp icon" id="icon_whatsapp_widget">
    </a>
</div>