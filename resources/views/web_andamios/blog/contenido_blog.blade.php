<div class="banner-titulo">
	<div class="grid12">
		<div class="col-item-b">
			<div class="text-info intro">
				<h1>
					<span class="tit2">BLOG</span>
					<span class="tit3">Andamios Ligeros</span>
				</h1>
			</div>
		</div>
	</div>
</div>

<section class="contenido">
	<div class="center-blog">
		@if(!$info_blog->isEmpty())
	        @foreach($info_blog as $item_blog)
	            <article class="item_blog">
	            	<a href="{{url('/blog')}}/{{$item_blog->post_url}}">
						<div class="cont-imagen-blog">
							<img src="{{url('storage/blog')}}/{{$item_blog->id_blog}}/{{$item_blog->img_portada}}" alt="">
						</div>
	            	</a>
                    <div class="blog-button">
                    	<div class="cont-url">
                    		<h1 class="blog-title">{{$item_blog->post_titulo}}</h1>
                        	<a href="{{url('/blog')}}/{{$item_blog->post_url}}">Ver Blog 📰</a>
                    	</div>
                    </div>
	            </article>
	        @endforeach
	    @else
	        <h3 class="text-center">Aun no existen entradas</h3>
	    @endif
	</div>
</section>