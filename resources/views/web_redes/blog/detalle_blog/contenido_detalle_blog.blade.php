<?php
use App\User;
use App\Utilidades;

$usuario = User::find($ObjBlog->post_autor);  
$utilidades = new Utilidades();
$fecha_blog = $utilidades->fecha($ObjBlog->post_fecha);
?>

<div class="contenido mt-10vw">
        <article class="cont-text-blog">
            <h1 class="tit-blog">
                {{$ObjBlog->post_titulo}}
            </h1>
            <div class="dividetit">
                <ul class="more-info-blog">
                    <li>
                        <div class="postedby">
                            <div class="info">
                                <span class="name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    {{$usuario->name}} </span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{$fecha_blog}}</span>
                    </li>
                </ul>    
            </div>
            <div class="cont-img-blog">
                <img class="img-portada-blog" src="{{url('storage/blog')}}/{{$ObjBlog->id_blog}}/{{$ObjBlog->img_portada}}" alt="{{$ObjBlog->post_titulo}}">
            </div>
            <div class="cont-info-blog">
                <?php print_r($ObjBlog->post_contenido) ?>
            </div>
        </article>
    
    <div class="mas-info-det">
        <div class="cont-prod-int"></div>
        <aside class="blogs-relacionados">
            <div class="o-text-wrapper-mobile">
                <h5>Artículos recientes</h5>
                <ul>
                    @if(!$info_blog->isEmpty())
                        @foreach($info_blog as $item_blog)
                        <li><a href="{{url('/blog')}}/{{$item_blog->post_url}}">{{$item_blog->post_titulo}}</a></li>
                        @endforeach
                    @else
                        <li>Aun no existen proyectos</li>
                    @endif
                </ul>
            </div> 
        </aside>
    </div>
</div>