
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
                                @else  
                                    <span class="eti eti-success">SUPER Promoción 🤑</span>
                                @endif
                                
                                <img class="img-fluid" loading="lazy" src="{{url('web/prom')}}/{{$item->img_banner}}">
                            </div>
                            <div class="info-item-promo">
                                <h2>🌟 <b>{{$item->nombre_product}}</b> 🌟</h2>
                                <div class="desc-promo"><small><p>{{$item->descripcion}}</p></small></div>
                                <p class="price mb-3">
                                    <span class="sale text-color-dark">$ {{number_format($item->costo_item, 2, '.', ',')}}</span>
                                </p>
                                <a  class="btn-slide btn-cotizar-s" style="position: absolute; bottom: 1em; right: 0;" href="{{url('promociones')}}/{{$item->url_promo}}">Ver promo</a>
                            </div>
                        </div>
                    </a>
                </div>
                
            @endforeach
        @endif
        
    </div>
</div>