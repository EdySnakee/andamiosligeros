<div class="container-fluid">
    @if ($accion == 'Agregar')
        <form enctype="multipart/form-data" id="form_post_promo" method="post">
        @elseif($accion == 'Editar')
            <form enctype="multipart/form-data" id="form_edit_promo" method="post">
    @endif

    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-header py-3">
                    <h3 class="m-0 font-weight-bold text-primary" id="tipo_accion" data-accion="{{ $accion }}"
                        style="display: inline;"><i class="fas fa-globe"></i> {{ $accion }} Promociones</h3>
                    <a href="{{ route('app_show_promos_web') }}" class="btn btn-danger pull-right btn-add"><i
                            class="fas fa-backspace"></i> Cancelar</a>
                </div>
                <div class="card-body">
                    <div class="row" style="margin: 0;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="cont-left item-content">
                                <div class="form-group">
                                    <h2 class="card-big-info-title"> <i class="fas fa-heading"></i> Nombre de Promoción
                                    </h2>

                                    @if ($accion == 'Agregar')
                                        <input type="text" class="form-control form-control-modern"
                                            name="titulo_producto" id="titulo_producto"
                                            value="{{ !empty($datos_generales->nombre_promo) ? $datos_generales->nombre_promo : '' }}"
                                            required />
                                        <small><b>URL:</b> <i><span>{{ url('/promociones') }}/</span></i><b><span
                                                    class="pinta_url_html">{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}</span></b>
                                        </small>
                                    @elseif($accion == 'Editar')
                                        <input type="text" class="form-control form-control-modern"
                                            name="titulo_producto" id="titulo_producto"
                                            value="{{ !empty($datos_generales->nombre_promo) ? $datos_generales->nombre_promo : '' }}"
                                            required />
                                        <small><b>URL:</b> <i><span>{{ url('/promociones') }}/</span></i><b><span
                                                    class="pinta_url_html">{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}
                                                    <a href="#" id="editar_url"
                                                        class="mb-1 mt-1 mr-1 btn btn-xs btn-info"><i
                                                            class="fas fa-edit"></i> URL</a></span></b> </small>
                                    @endif
                                    <input type="hidden" class="form-control form-control-modern pinta_url"
                                        name="url-producto"
                                        value="{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}"
                                        required />
                                    <input type="hidden" class="form-control form-control-modern pinta_url_original"
                                        name="url-producto-original"
                                        value="{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}"
                                        required />
                                </div>
                                <div class="form-grup mb-2em">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-stream"></i> Descripción
                                                corta</h2>
                                            <textarea class="form-control form-control-modern" name="descripcion_corta" rows="6"
                                                value="{{ !empty($datos_generales->descripcion) ? $datos_generales->descripcion : '' }}">{{ !empty($datos_generales->descripcion) ? $datos_generales->descripcion : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grup">
                                    <div class="row mt-10">
                                        <div class="col-md-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-image"></i> Banner
                                                principal</h2>
                                            <p class="card-big-info-desc">Se sugiere un banner llamativo de <b>1900 x
                                                    1900px</b> en formato <b>JPG</b> </p>
                                            @if ($accion == 'Agregar')
                                                @if (!empty($datos_generales->img_banner))
                                                    <input type="file" name="imagen_destacada" data-height="250"
                                                        id="imagen_destacada" class="dropify"
                                                        data-default-file="{{ url('web/prom') }}/{{ $datos_generales->img_banner }}" />
                                                @else
                                                    <input type="file" name="imagen_destacada" data-height="250"
                                                        id="imagen_destacada" class="dropify" />
                                                @endif
                                            @endif
                                            @if ($accion == 'Editar')
                                            <input type="file" name="imagen_destacada" data-height="250"
                                                   id="imagen_destacada" class="dropify"
                                                   data-default-file="{{ !empty($datos_generales->img_banner) ? url('web/prom/' . $datos_generales->img_banner) : '' }}" />
                                        @endif
                                            {{-- @if ($accion == 'Editar')
                                                <input type="file" name="imagen_destacada" data-height="250"
                                                    id="imagen_destacada" class="dropify"
                                                    data-default-file="{{ !empty($datos_generales->img_banner) ? $datos_generales->img_banner : '' }}" />
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <?php
                                /*
                                                                                                                                                                                                                                                                    <div class="accordion accordion-editores mb-2em" id="accordionExample">
                                                                                                                                                                                                                                                                        <div class="card">
                                                                                                                                                                                                                                                                          <div class="card-header enc-product" id="headingOne">
                                                                                                                                                                                                                                                                                <h2 class="tit-card card-big-info-title text-left" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="fas fa-pencil-alt"></i> Descripción Larga</h2>
                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                                                                                                                                                                                                                            <div class="card-body">
                                                                                                                                                                                                                                                                                <div class="form-group">
                                                                                                                                                                                                                                                                                    <div id="editor_descrip" style="height: 50vh;">
                                                                                                                                                                                                                                                                                        <?php print_r((!empty($datos_adicionales->descripcion_producto))?$datos_adicionales->descripcion_producto:'') ?>
                                ?>
                                ?>
                                ?>
                                ?>
                                ?>
                                ?>
                                ?>
                            </div>
                            <textarea class="form-control" rows="10" cols ="10" name="descripcion_producto" id="descripcion_producto"
                                type="textarea" style="display: none"
                                value="{{ !empty($datos_adicionales->descripcion_producto) ? $datos_adicionales->descripcion_producto : '' }}">{{ !empty($datos_adicionales->descripcion_producto) ? $datos_adicionales->descripcion_producto : '' }}</textarea>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card">
            <div class="card-header enc-product" id="headingTwo">
                <h2 class="tit-card card-big-info-title text-left" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseOne"> <i class="fas fa-pencil-alt"></i> Características
                </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="form-group">
                        <div id="editor_caract" style="height: 50vh;">
                            <?php print_r(!empty($datos_adicionales->caracteristicas_producto) ? $datos_adicionales->caracteristicas_producto : ''); ?>
                        </div>
                        <textarea class="form-control" rows="10" cols ="10" name="caracteristica_producto"
                            id="caracteristica_producto" type="textarea" style="display: none"
                            value="{{ !empty($datos_adicionales->caracteristicas_producto) ? $datos_adicionales->caracteristicas_producto : '' }}">{{ !empty($datos_adicionales->caracteristicas_producto) ? $datos_adicionales->caracteristicas_producto : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header enc-product" id="headingTres">
                <h2 class="tit-card card-big-info-title text-left" data-toggle="collapse" data-target="#collapseTres"
                    aria-expanded="true" aria-controls="collapseOne"> <i class="fas fa-pencil-alt"></i> Información
                    adicional</h2>
            </div>
            <div id="collapseTres" class="collapse" aria-labelledby="headingTres" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="form-group">
                        <div id="editor_adicional" style="height: 50vh;">
                            <?php print_r(!empty($datos_adicionales->extra_info_producto) ? $datos_adicionales->extra_info_producto : ''); ?>
                        </div>
                        <textarea class="form-control" rows="10" cols ="10" name="adicional_producto" id="adicional_producto"
                            type="textarea" style="display: none"
                            value="{{ !empty($datos_adicionales->extra_info_producto) ? $datos_adicionales->extra_info_producto : '' }}">{{ !empty($datos_adicionales->extra_info_producto) ? $datos_adicionales->extra_info_producto : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>*/
    ?>


    <section class="card mt-10 card-big-info">
        <div class="card-body card-precios">
            <div class="tabs-modern row no-margin" style="min-height: 490px;">
                <div class="col-lg-2-5 col-xl-1-5">
                    <div class="nav flex-column columna-blog-tab" id="tab" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active" id="price-tab" data-toggle="pill" href="#price" role="tab"
                            aria-controls="price" aria-selected="true">Precios</a>
                        <a class="nav-link" id="inventory-tab" data-toggle="pill" href="#inventory" role="tab"
                            aria-controls="inventory" aria-selected="false">Google Shoping</a>
                    </div>
                </div>
                <div class="col-lg-3-5 col-xl-4-5 card-info-product">
                    <div class="tab-content" id="tabContent">
                        <div class="tab-pane fade active show" id="price" role="tabpanel"
                            aria-labelledby="price-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-12 control-label mb-0">Cantidad</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control form-control-modern"
                                                id="cantidad" name="cantidad"
                                                value="{{ !empty($datos_generales->cantidad) ? $datos_generales->cantidad : 1 }}" />
                                        </div>
                                    </div>
                                </div>
                                {{-- SELECT DE TIPO PROMO --}}
                                    <div class="col-md-12">
                                    <div class="form-group row align-items-center">

                                        <label class="col-md-12 control-label mb-0">Tipo de promoción</label>
                                    <div class="col-md-12">

                                        <select name="tipo_promo" id="tipo_promo" class="form-control form-control-modern">
                                            @if ($accion == 'Agregar')
                                                @if (!$tipoPromo->isEmpty())
                                                    @foreach ($tipoPromo as $index => $item)
                                                        @if ($index == 0)
                                                            <option selected value="{{ $item->etiqueta }}">{{ $item->nombre }}</option>
                                                        @else
                                                            <option value="{{ $item->etiqueta }}">{{ $item->nombre }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option disabled selected>No hay tipos de promoción disponibles</option>
                                                @endif
                                            @elseif($accion == 'Editar')
                                                @if (!$tipoPromo->isEmpty())
                                                    @foreach ($tipoPromo as $item)
                                                        @if ($item->nombre == $datos_generales->nombre)
                                                            <option selected value="{{ $item->etiqueta }}">{{ $item->nombre }}</option>
                                                        @else
                                                            <option value="{{ $item->etiqueta }}">{{ $item->nombre }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-12 control-label mb-0">Precio promocional ($)</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control form-control-modern"
                                                id="costo_item" name="costo_item"
                                                value="{{ !empty($datos_generales->costo_item) ? $datos_generales->costo_item : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="checkbox-toggle">
                                            @if ($accion == 'Agregar')
                                                <input type="checkbox" name="activa_cant_min" id="activa_cant_min"
                                                    value="activa_cant_min">
                                                <i></i>
                                                Activar cantidad minima de compra.
                                            @elseif($accion == 'Editar')
                                                @if ($datos_generales->cant_min != 0)
                                                    <input type="checkbox" name="activa_cant_min" checked
                                                        id="activa_cant_min" value="activa_cant_min">
                                                    <i></i>
                                                    Activar cantidad minima de compra.
                                                @else
                                                    <input type="checkbox" name="activa_cant_min"
                                                        id="activa_cant_min" value="activa_cant_min">
                                                    <i></i>
                                                    Activar cantidad minima de compra.
                                                @endif
                                            @endif
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-12 control-label mb-0">Cantidad minima de compra
                                            (#) </label>
                                        <div class="col-md-4">
                                            <input {{ !empty($datos_generales->cant_min) ? '' : 'disabled' }}
                                                type="text" class="form-control form-control-modern"
                                                id="cant_min" name="cant_min"
                                                value="{{ !empty($datos_generales->cant_min) ? $datos_generales->cant_min : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-12 control-label mb-0">Precio despues de cantidad minima
                                            de compra ($)</label>
                                        <div class="col-md-12">
                                            <input {{ !empty($datos_generales->costo_desc) ? '' : 'disabled' }}
                                                type="text" class="form-control form-control-modern"
                                                id="costo_desc" name="costo_desc"
                                                value="{{ !empty($datos_generales->costo_desc) ? $datos_generales->costo_desc : '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-12 control-label mb-0">Precio de envío ($)</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control form-control-modern"
                                                id="envio" name="envio"
                                                value="{{ !empty($datos_generales->envio) ? $datos_generales->envio : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                            <div class="form-group row align-items-center">
                                <label class="col-md-12 control-label mb-0">og:title</label>
                                <div class="col-md-12">
                                    @if ($accion == 'Agregar')
                                        <input type="text" class="form-control form-control-modern" id="ogtitle"
                                            name="ogtitle"
                                            value="{{ !empty($datos_generales->meta_titulo) ? $datos_generales->meta_titulo : '' }}" />
                                    @elseif($accion == 'Editar')
                                        <input type="text" class="form-control form-control-modern" id="ogtitle"
                                            name="ogtitle"
                                            value="{{ !empty($datos_generales->meta_titulo) ? $datos_generales->meta_titulo : '' }}" />
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-md-12 control-label mb-0">og:description</label>
                                <div class="col-md-12">
                                    @if ($accion == 'Agregar')
                                        <input type="text" class="form-control form-control-modern"
                                            name="ogdescripcion" value="">
                                    @elseif($accion == 'Editar')
                                        <input type="text" class="form-control form-control-modern"
                                            name="ogdescripcion"
                                            value="{{ !empty($datos_generales->descripcion) ? $datos_generales->descripcion : '' }}">
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-md-12 control-label mb-0">og:url</label>
                                <div class="col-md-12">
                                    @if ($accion == 'Agregar')
                                        <input type="text" class="form-control form-control-modern pinta_url_seo"
                                            readonly="" id="ogurl" name="ogurl"
                                            value="{{ url('/promociones') }}/{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}">
                                    @else
                                        <input type="text" class="form-control form-control-modern pinta_url_seo"
                                            readonly="" id="ogurl" name="ogurl"
                                            value="{{ url('/promociones') }}/{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-md-12 control-label mb-0">canonical</label>
                                <div class="col-md-12">
                                    @if ($accion == 'Agregar')
                                        <input type="text" class="form-control form-control-modern pinta_url_seo"
                                            readonly="" id="canonical" name="canonical"
                                            value="{{ url('/promociones') }}/{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}">
                                    @else
                                        <input type="text" class="form-control form-control-modern pinta_url_seo"
                                            readonly="" id="canonical" name="canonical"
                                            value="{{ url('/promociones') }}/{{ !empty($datos_generales->url_promo) ? $datos_generales->url_promo : '' }}">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <div class="col-md-12">
                                    <h5>Imagen destacada para Google Shopping</h5>
                                    <label class="control-label mb-0">Se sugiere subir una imagen ligeramente vertical
                                        con fondo blanco</label>
                                    @if (!empty($datos_generales->img_social))
                                        <input type="file" name="imagen_destacada_social" data-height="335"
                                            id="imagen_destacada_social" class="dropify"
                                            data-default-file="{{ !empty($datos_generales->img_social) ? url('web/prom/' . $datos_generales->img_social) : '' }}" />
                                    @else
                                        <input type="file" name="imagen_destacada_social" data-height="200"
                                            id="imagen_destacada_social" class="dropify" />
                                    @endif
                                </div>
                            </div>

                        </div>
                        {{--
                                                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                                            AQUI VA VENTAS CRUZADAS
                                                        </div>
                                                        <div class="tab-pane fade" id="linked-products" role="tabpanel" aria-labelledby="linked-products-tab">
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label pt-2" for="textareaDefault">Body Script</label>
                                                            <div class="col-md-12">
                                                                <textarea rows="10" class="form-control" id="body_script" name="body_script" data-plugin-codemirror="" data-plugin-options="{ &quot;mode&quot;: &quot;text/javascript&quot; }" style="display: none;">    &lt;!--PEGA AQUÍ TU CÓDIGO SCRIPT--&gt;</textarea><div class="CodeMirror cm-s-monokai"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" style="position: absolute; bottom: -1em; padding: 0px; width: 1000px; height: 1em; outline: none;"></textarea></div><div class="CodeMirror-vscrollbar" tabindex="-1" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" tabindex="-1" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines" role="presentation"><div role="presentation" style="position: relative; outline: none;"><div class="CodeMirror-measure"></div><div class="CodeMirror-measure"><pre class="CodeMirror-line" role="presentation"><span role="presentation" style="padding-right: 0.1px;">    <span class="cm-comment">&lt;!--PEGA AQUÍ TU CÓDIGO SCRIPT--&gt;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code" role="presentation"></div></div></div></div></div><div style="position: absolute; height: 50px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>Copia y pega tu código script aqui va el código despues de la etiqueta <code> /body</code>.
                                                            </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label pt-2" for="textareaDefault">Footer Script</label>
                                                                <div class="col-md-12">
                                                                    <textarea class="form-control" rows="10" id="footer_script" name="footer_script" data-plugin-codemirror="" data-plugin-options="{ &quot;mode&quot;: &quot;text/javascript&quot; }" style="display: none;">    &lt;!--PEGA AQUÍ TU CÓDIGO SCRIPT--&gt;</textarea><div class="CodeMirror cm-s-monokai"><div style="overflow: hidden; position: relative; width: 3px; height: 0px;"><textarea autocorrect="off" autocapitalize="off" spellcheck="false" tabindex="0" style="position: absolute; bottom: -1em; padding: 0px; width: 1000px; height: 1em; outline: none;"></textarea></div><div class="CodeMirror-vscrollbar" tabindex="-1" cm-not-content="true"><div style="min-width: 1px;"></div></div><div class="CodeMirror-hscrollbar" tabindex="-1" cm-not-content="true"><div style="height: 100%; min-height: 1px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1"><div class="CodeMirror-sizer" style="margin-left: 0px; min-width: 3px;"><div style="position: relative;"><div class="CodeMirror-lines" role="presentation"><div role="presentation" style="position: relative; outline: none;"><div class="CodeMirror-measure"></div><div class="CodeMirror-measure"><pre class="CodeMirror-line" role="presentation"><span role="presentation" style="padding-right: 0.1px;">    <span class="cm-comment">&lt;!--PEGA AQUÍ TU CÓDIGO SCRIPT--&gt;</span></span></pre></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"></div><div class="CodeMirror-code" role="presentation"></div></div></div></div></div><div style="position: absolute; height: 50px; width: 1px;"></div><div class="CodeMirror-gutters"><div class="CodeMirror-gutter CodeMirror-linenumbers" style="width: 1px;"></div></div></div></div>Copia y pega tu código script aqui va el código despues de la etiqueta <code> /footer</code>.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="form-grup">
        {{-- 
                                        <div class="row mt-10">
                                            <div class="col-md-12">
                                                <h2 class="card-big-info-title"><i class="fas fa-images"></i> Galería de imagenes</h2>
                                                <p class="card-big-info-desc">Se sugiere una imágenes con fondo blanco</p>
                                                <input type="file" multiple class="multi with-preview" name="galeria[]" value="Subir Archivo"/>
                                                @if ($accion == 'Editar')
                                                    @if (!$datos_galeria->isEmpty())
                                                    <div class="cont-gal">
                                                        @foreach ($datos_galeria as $item_galeria)
                                                            <div class="img-cont-gal" data-id-gal="{{$item_galeria->id_file}}">
                                                                <img class="img-fluid rounded img-thumbnail" src="{{$item_galeria->file_url}}" alt="">
                                                                <a href="#" class="delete-item-gal"><i class="fas fa-times-circle"></i></a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                         --}}
        <div class="row mt-10">
            <div class="col-md-6">
                <a href="{{ route('app_show_promos_web') }}" class="cancel-button btn btn-danger pull-left">
                    <i class="fas fa-backspace"></i> Cancelar
                </a>
            </div>
            <div class="col-md-6">

                @if ($accion == 'Agregar')
                    <input type="hidden"
                        value="{{ !empty($datos_generales->id_producto) ? $datos_generales->id_producto : '' }}"
                        name="id_product_ref" id="id_product_ref">
                    <button type="submit" class="submit-button btn btn-info pull-right" data-status-prom="2"
                        style="margin-right: 9em;">
                        <i class="fas fa-save"></i> Guardar como Borrador
                    </button>
                    <button type="submit" class="submit-button btn btn-success pull-right" data-status-prom="1">
                        <i class="fas fa-globe"></i> Publicar
                    </button>
                @else
                    <input type="hidden"
                        value="{{ !empty($datos_generales->post_estatus) ? $datos_generales->post_estatus : '' }}"
                        name="post_status" id="post_status">
                    <input type="hidden"
                        value="{{ !empty($datos_generales->id_promo) ? $datos_generales->id_promo : '' }}"
                        name="id_promo" id="id_promo">
                    <button type="submit" class="submit-button btn btn-success pull-right">
                        <i class="fas fa-save"></i> Editar promoción
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>
</section>
</div>
</div>
</form>

</div>
