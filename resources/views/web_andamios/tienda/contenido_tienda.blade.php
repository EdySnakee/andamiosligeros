<div class="container-md cont-princ-product shadow">
    <div class="row">
        <div class="col-md-12">
            {{--
            <div class="banner-promo">
                <button id="close_banner" type="button" class="close" >&times;</button>
                <img class="img-responsive" src="{{ url('web/img/banner-descuento.png') }}" alt="">
            </div>
            --}}
            <div class="datos-filtro">
                <div class="categoria pdr1">
                    <p><b>CATEGORIAS</b></p>
                    <select name="filter_categoria" id="filter_categoria" class="form-control form-control-modern form-cate">
                        <option value="" selected="">Todos</option>
                        <option value="andamio">Andamios</option>
                        <option value="accesorio">Accesorios</option>
                    </select>
                </div>
                <div class="marca pdr1">
                    <p><b>MODELOS</b></p>
                    <select name="filter_model" id="filter_model" class="form-control form-control-modern form-cate">
                        <option value="" selected="">Todos</option>
                        @if (!$catModelos->isEmpty())
                            @foreach ($catModelos as $item_modulos)
                                <option value="{{$item_modulos->nombre}}">{{$item_modulos->nombre}}</option>
                            @endforeach
                        @endif
                    </select>
                    
                </div>
                
            </div>
        </div>
        <div class="col-md-12">
            <div class="row" id="list-products">
                
            </div>
        </div>
    </div>
</div>
