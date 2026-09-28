<!-- Section Titre -->
<div class="o-container-fluid">
    <div class="row">
        <div class="twelve columns">
            <div class="portada-blog">
                <div class="cont-text-proyectos text-center">
                    <h1 class="font-ant-titulos tit-color-purple">BLOG</h1>
                    <h2 class="font-ant-titulos tit-color-white">MALLAS ANTICAIDAS</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog -->
<div class="o-container-fluid mt-90">
    <div class="row">
        <div class="ten columns offset-by-one">
            <div class="row">
                @if(!$info_blog->isEmpty())
                    @foreach($info_blog as $item_blog)
                        <div class="four columns realisation">
                            <div class="parallax img-reveal">
                                <div class="c-bg-img" style="background-image: url({{url('storage/blog')}}/{{$item_blog->id_blog}}/{{$item_blog->img_portada}})"></div>
                                <div class="c-bg-color u-bg-color-primary opacity"></div>
                                <div class="c-bg-color u-bg-color-primary img-reveal-2"></div>
                                <div class="c-bg-color u-bg-color-white img-reveal-1"></div>
                                <div class="cinetic-divider-75vh"></div>
                                <h1 class="realisation-title u-h2 u-color-white font-ant-titulos">{{$item_blog->post_titulo}}</h1>
                                
                                <div class="realisation-type-line"></div>
                                <div class="realisation-button">
                                    <div class="realisation-button-wrapper">
                                        <img src="{{url('/web/img/icon-arrow-right-white.svg')}}" />
                                        <a href="{{url('/blog')}}/{{$item_blog->post_url}}"></a>
                                    </div>
                                </div>
                                <div class="see-project">
                                    <div class="see-project-wrapper">
                                        <div class="see-project-text">
                                            Ver Blog
                                        </div>
                                    </div>
                                </div>
                                <a href="{{url('/blog')}}/{{$item_blog->post_url}}"></a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-center">Aun no existen entradas</h3>
                @endif

            </div>
        </div>
    </div>
</div>