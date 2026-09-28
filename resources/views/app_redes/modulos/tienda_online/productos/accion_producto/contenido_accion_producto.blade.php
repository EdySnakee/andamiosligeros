<div class="container-fluid">
    @if($accion == "Agregar")
    <form enctype="multipart/form-data" id="form_post_producto" method="post">
    @elseif($accion == "Editar")
    <form enctype="multipart/form-data" id="form_edit_producto" method="post">
    @endif
        <div class="row">
            <div class="col">
                <section class="card card-modern card-big-info">
                    <div class="card-header py-3">
                        <h3 class="m-0 font-weight-bold text-primary" id="tipo_accion" data-accion="{{$accion}}" style="display: inline;"><i class="fas fa-globe"></i> {{$accion}} Producto Online</h3>
                        <a href="{{route('app_show_productos_web')}}" class="btn btn-danger pull-right btn-add"><i class="fas fa-backspace"></i>  Cancelar</a>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin: 0;">
                            <div class="col-md-8">
                                <div class="cont-left item-content">
                                    <div class="form-group">
                                        <h2 class="card-big-info-title"> <i class="fas fa-heading"></i> Nombre producto</h2>
                                        
                                        @if($accion == "Agregar")
                                        <input type="text" class="form-control form-control-modern" name="titulo_producto" id="titulo_producto" value="{{(!empty($datos_generales->nombre_p))?$datos_generales->nombre_p:''}}" required />
                                        <small><b>URL:</b> <i><span>{{url('/tienda')}}/</span></i><b><span class="pinta_url_html">{{(!empty($url_proyecto))?$url_proyecto:''}}</span></b> </small>
                                        @elseif($accion == "Editar")
                                        <input type="text" class="form-control form-control-modern" name="titulo_producto" id="titulo_producto" value="{{(!empty($datos_generales->post_titulo))?$datos_generales->post_titulo:''}}" required />
                                        <small><b>URL:</b> <i><span>{{url('/tienda')}}/</span></i><b><span class="pinta_url_html">{{(!empty($url_proyecto))?$url_proyecto:''}} <a href="#" id="editar_url" class="mb-1 mt-1 mr-1 btn btn-xs btn-info"><i class="fas fa-edit"></i> URL</a></span></b> </small>
                                        @endif
                                        <input type="hidden" class="form-control form-control-modern pinta_url" name="url-producto" value="{{(!empty($url_proyecto))?$url_proyecto:''}}" required />
                                        <input type="hidden" class="form-control form-control-modern pinta_url_original" name="url-producto-original" value="{{(!empty($url_proyecto))?$url_proyecto:''}}" required />
                                    </div>
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
                                                    </div>
                                                    <textarea class="form-control" rows="10" cols ="10" name="descripcion_producto" id="descripcion_producto" type="textarea" style="display: none"  value="{{(!empty($datos_adicionales->descripcion_producto))?$datos_adicionales->descripcion_producto:''}}">{{(!empty($datos_adicionales->descripcion_producto))?$datos_adicionales->descripcion_producto:''}}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header enc-product" id="headingTwo">
                                                <h2 class="tit-card card-big-info-title text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne"> <i class="fas fa-pencil-alt"></i> Características</h2>
                                          </div>
                                          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div id="editor_caract" style="height: 50vh;">
                                                        <?php print_r((!empty($datos_adicionales->caracteristicas_producto))?$datos_adicionales->caracteristicas_producto:'') ?>
                                                    </div>
                                                    <textarea class="form-control" rows="10" cols ="10" name="caracteristica_producto" id="caracteristica_producto" type="textarea" style="display: none"  value="{{(!empty($datos_adicionales->caracteristicas_producto))?$datos_adicionales->caracteristicas_producto:''}}">{{(!empty($datos_adicionales->caracteristicas_producto))?$datos_adicionales->caracteristicas_producto:''}}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header enc-product" id="headingTres">
                                                  <h2 class="tit-card card-big-info-title text-left" data-toggle="collapse" data-target="#collapseTres" aria-expanded="true" aria-controls="collapseOne"> <i class="fas fa-pencil-alt"></i> Información adicional</h2>
                                            </div>
                                            <div id="collapseTres" class="collapse" aria-labelledby="headingTres" data-parent="#accordionExample">
                                              <div class="card-body">
                                                  <div class="form-group">
                                                      <div id="editor_adicional" style="height: 50vh;">
                                                          <?php print_r((!empty($datos_adicionales->extra_info_producto))?$datos_adicionales->extra_info_producto:'') ?>
                                                      </div>
                                                      <textarea class="form-control" rows="10" cols ="10" name="adicional_producto" id="adicional_producto" type="textarea" style="display: none"  value="{{(!empty($datos_adicionales->extra_info_producto))?$datos_adicionales->extra_info_producto:''}}">{{(!empty($datos_adicionales->extra_info_producto))?$datos_adicionales->extra_info_producto:''}}</textarea>
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                    </div>

                                    <section class="card  card-big-info">
                                        <div class="card-body card-precios">
                                            <div class="tabs-modern row no-margin" style="min-height: 490px;">
                                                <div class="col-lg-2-5 col-xl-1-5">
                                                    <div class="nav flex-column columna-blog-tab" id="tab" role="tablist" aria-orientation="vertical">
                                                        <a class="nav-link active" id="price-tab" data-toggle="pill" href="#price" role="tab" aria-controls="price" aria-selected="true">Precios</a>
                                                        <a class="nav-link" id="linked-products-tab" data-toggle="pill" href="#linked-products" role="tab" aria-controls="linked-products" aria-selected="false">Medidas</a>
                                                        <a class="nav-link" id="shipping-tab" data-toggle="pill" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Modelos</a>
                                                        <a class="nav-link" id="inventory-tab" data-toggle="pill" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">SEO</a>
                                                        
                                                        {{--
                                                        
                                                        
                                                        <a class="nav-link" id="attributes-tab" data-toggle="pill" href="#attributes" role="tab" aria-controls="attributes" aria-selected="false">Footer Script</a>
                                                        --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-3-5 col-xl-4-5 card-info-product">
                                                    <div class="tab-content" id="tabContent">
                                                        <div class="tab-pane fade active show" id="price" role="tabpanel" aria-labelledby="price-tab">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Precio normal ($)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control form-control-modern" id="precio1" name="precio1" value="{{(!empty($datos_generales->precio))?$datos_generales->precio:''}}" />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Precio rebajado ($)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control form-control-modern" id="precio2" name="precio2" value="{{(!empty($datos_generales->precio2))?$datos_generales->precio2:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Tipo de cobro</label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control js-example-basic-single" name="tipo_cobro" id="tipo_cobro">
                                                                                @if($accion == "Agregar")
                                                                                    <option disabled selected>Selecciona un tipo de cobro</option>
                                                                                    <@if(!empty($datos_generales->tipo_cobro) AND $datos_generales->tipo_cobro == "fijo")
                                                                                        <option value="fijo" selected>Fijo</option>
                                                                                        <option value="m2">Por m<sup>2</sup></option>
                                                                                    @elseif(!empty($datos_generales->tipo_cobro) AND $datos_generales->tipo_cobro == "m2")
                                                                                        <option value="fijo">Fijo</option>
                                                                                        <option value="m2" selected>Por m<sup>2</sup></option>
                                                                                    @else
                                                                                    <option value="fijo">Fijo</option>
                                                                                    <option value="m2">Por m<sup>2</sup></option>
                                                                                    @endif
                                                                                @elseif($accion == "Editar")
                                                                                  @if($datos_generales->tipo_cobro == "fijo")
                                                                                    <option value="fijo" selected>Fijo</option>
                                                                                    <option value="m2">Por m<sup>2</sup></option>
                                                                                  @elseif($datos_generales->tipo_cobro == "m2")
                                                                                    <option value="fijo">Fijo</option>
                                                                                    <option value="m2" selected>Por m<sup>2</sup></option>
                                                                                  @endif
                                                                                @endif
                                                                            </select>
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
                                                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Selecciona un modelo</label>
                                                                        <div class="col-md-12">
                                                                            <select class="form-control js-example-basic-single" name="modelo" id="modelo">
                                                                                @if($accion == "Agregar")
                                                                                    <option disabled selected>Selecciona un modelo</option>
                                                                                    @if (!$catModelos->isEmpty())
                                                                                        @foreach ($catModelos as $item_modelo)
                                                                                            <option value="{{$item_modelo->nombre}}">{{$item_modelo->nombre}}</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                @elseif($accion == "Editar")
                                                                                    @if (!$catModelos->isEmpty())
                                                                                        @foreach ($catModelos as $item_modelo)
                                                                                            @if($item_modelo->nombre == $datos_generales->modelo)
                                                                                            <option selected value="{{$item_modelo->nombre}}">{{$item_modelo->nombre}}</option>
                                                                                            @else
                                                                                            <option value="{{$item_modelo->nombre}}">{{$item_modelo->nombre}}</option>
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
                                                                        <label class="col-md-12 control-label mb-0">REF-Modelo</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control form-control-modern" id="modelo_ref" name="modelo_ref" value="{{(!empty($datos_generales->modelo_ref))?$datos_generales->modelo_ref:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="linked-products" role="tabpanel" aria-labelledby="linked-products-tab">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Alto del andamio (m)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" step="0.01" class="form-control form-control-modern" id="alto" name="alto" value="{{(!empty($datos_adicionales->alto))?$datos_adicionales->alto:''}}" />
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Ancho del andamio (m)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" step="0.01" class="form-control form-control-modern" id="ancho" name="ancho" value="{{(!empty($datos_adicionales->ancho))?$datos_adicionales->ancho:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Profundidad del andamio (m)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" step="0.01" class="form-control form-control-modern" id="profundidad" name="profundidad" value="{{(!empty($datos_adicionales->profundidad))?$datos_adicionales->profundidad:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Diámetro del caño (mm)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" step="0.01" class="form-control form-control-modern" id="diametro" name="diametro" value="{{(!empty($datos_adicionales->diametro))?$datos_adicionales->diametro:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Peso máximo soportado (kg)</label>
                                                                        <div class="col-md-12">
                                                                            <input type="number" step="0.01" class="form-control form-control-modern" id="peso_soportado" name="peso_soportado" value="{{(!empty($datos_adicionales->peso_soportado))?$datos_adicionales->peso_soportado:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group row align-items-center">
                                                                        <label class="col-md-12 control-label mb-0">Multiuso</label>
                                                                        <div class="col-md-12">
                                                                            <input type="text" class="form-control form-control-modern" id="multiuso" name="multiuso" value="{{(!empty($datos_adicionales->multiuso))?$datos_adicionales->multiuso:''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">og:title</label>
                                                                <div class="col-md-12">
                                                                    @if($accion == "Agregar")
                                                                    <input type="text" class="form-control form-control-modern" id="ogtitle" name="ogtitle" value="{{(!empty($datos_generales->nombre_p))?$datos_generales->nombre_p:''}}" />
                                                                    @elseif($accion == "Editar")
                                                                    <input type="text" class="form-control form-control-modern" id="ogtitle" name="ogtitle" value="{{(!empty($datos_meta->meta_title))?$datos_meta->meta_title:''}}" />
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">og:description</label>
                                                                <div class="col-md-12">
                                                                    @if($accion == "Agregar")
                                                                    <input type="text" class="form-control form-control-modern" name="ogdescripcion" value="">
                                                                    @elseif($accion == "Editar")
                                                                    <input type="text" class="form-control form-control-modern" name="ogdescripcion" value="{{(!empty($datos_meta->meta_descripcion))?$datos_meta->meta_descripcion:''}}">
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">og:url</label>
                                                                <div class="col-md-12">
                                                                    @if($accion == "Agregar")
                                                                    <input type="text" class="form-control form-control-modern pinta_url_seo" readonly="" id="ogurl" name="ogurl" value="{{url('/tienda')}}/{{(!empty($url_proyecto))?$url_proyecto:''}}">
                                                                    @else
                                                                    <input type="text" class="form-control form-control-modern pinta_url_seo" readonly="" id="ogurl" name="ogurl" value="{{url('/tienda')}}/{{(!empty($url_proyecto))?$url_proyecto:''}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">canonical</label>
                                                                <div class="col-md-12">
                                                                    @if($accion == "Agregar")
                                                                    <input type="text" class="form-control form-control-modern pinta_url_seo" readonly="" id="canonical" name="canonical" value="{{url('/tienda')}}/{{(!empty($url_proyecto))?$url_proyecto:''}}">
                                                                    @else
                                                                    <input type="text" class="form-control form-control-modern pinta_url_seo" readonly="" id="canonical" name="canonical" value="{{url('/tienda')}}/{{(!empty($url_proyecto))?$url_proyecto:''}}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">Keywords</label>
                                                                <div class="col-md-12">
                                                                    <input name="keywords" id="tags-input" data-role="tagsinput" data-tag-class="badge badge-primary" class="form-control" value="{{(!empty($datos_meta->meta_keywords))?$datos_meta->meta_keywords:'Andamios,ligeros,galvanizados'}}" />
                                                                    <p>
                                                                        Se agregarán al metatag <code>name="keywords"</code> utiliza palabras adecuadas para los buscadores.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">Imágen destacada</label>
                                                                <div class="col-md-12">
                                                                    @if(!empty($datos_meta->meta_url_imagen))
                                                                        <input type="file" name="imagen_destacada_social" data-height="335" id="imagen_destacada_social" class="dropify" data-default-file="{{(!empty($datos_meta->meta_url_imagen))?$datos_meta->meta_url_imagen: ''}}"/>
                                                                    @else
                                                                        <input type="file" name="imagen_destacada_social" data-height="200" id="imagen_destacada_social" class="dropify"/>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row align-items-center">
                                                                <label class="col-md-12 control-label mb-0">og:image:alt</label>
                                                                
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control form-control-modern" name="imagealt" value="{{(!empty($datos_meta->meta_alt_imagen))?$datos_meta->meta_alt_imagen: ''}}">
                                                                    <small>Nombre de la imágen</small>
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
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cont-right item-content">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-stream"></i> Descripción corta</h2>
                                            <textarea class="form-control form-control-modern" name="descripcion_corta" rows="6" value="{{(!empty($datos_generales->descripcion_corta))?$datos_generales->descripcion_corta:''}}">{{(!empty($datos_generales->descripcion_corta))?$datos_generales->descripcion_corta:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-lg-12 col-xl-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-list-alt"></i> Categoria de producto</h2>
                                            <select name="cate_product" id="cate_product" class="form-control form-control-modern">
                                                @if($accion == "Agregar")
                                                    <option disabled selected>Selecciona una categoría</option>
                                                    @if (!$categoriasTienda->isEmpty())
                                                        @foreach ($categoriasTienda as $item_categoria)
                                                            <option value="{{$item_categoria->nomb_cate}}">{{$item_categoria->nomb_cate}}</option>
                                                        @endforeach
                                                    @endif
                                                @elseif($accion == "Editar")
                                                    @if (!$categoriasTienda->isEmpty())
                                                        @foreach ($categoriasTienda as $item_categoria)
                                                            @if($item_categoria->nomb_cate == $datos_generales->categoria)
                                                            <option selected value="{{$item_categoria->nomb_cate}}">{{$item_categoria->nomb_cate}}</option>
                                                            @else
                                                            <option value="{{$item_categoria->nomb_cate}}">{{$item_categoria->nomb_cate}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                                
            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-md-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-image"></i> Imágen principal</h2>
                                            <p class="card-big-info-desc">Se sugiere una imágen con fondo blanco</p>
                                            @if ($accion == "Agregar")
                                                @if(!empty($datos_adicionales->imagen))
                                                    <input type="file" name="imagen_destacada" data-height="150" id="imagen_destacada" class="dropify" data-default-file="{{url('storage/productos')}}/{{$datos_adicionales->id_producto}}/{{$datos_adicionales->imagen}}"/>
                                                @else
                                                    <input type="file" name="imagen_destacada" data-height="150" id="imagen_destacada" class="dropify"/>
                                                @endif
                                            @endif
                                            @if ($accion == "Editar")
                                                <input type="file" name="imagen_destacada" data-height="150" id="imagen_destacada" class="dropify" data-default-file="{{(!empty($datos_adicionales->imagen_portada))?$datos_adicionales->imagen_portada:''}}"/>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-10">
                                        <div class="col-md-12">
                                            <h2 class="card-big-info-title"><i class="fas fa-images"></i> Galería de imagenes</h2>
                                            <p class="card-big-info-desc">Se sugiere una imágenes con fondo blanco</p>
                                            <input type="file" multiple class="multi with-preview" name="galeria[]" value="Subir Archivo"/>
                                            @if ($accion == "Editar")
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
                                    <div class="row mt-10">
                                        <div class="col-md-6">
                                            <a href="{{route('app_show_productos_web')}}" class="cancel-button btn btn-danger pull-left">
                                                <i class="fas fa-backspace"></i> Cancelar
                                            </a>
                                        </div>
                                        <div class="col-md-6">

                                            @if($accion == "Agregar")
                                                <input type="hidden" value="{{(!empty($datos_generales->id_producto))?$datos_generales->id_producto:''}}" name="id_product_ref" id="id_product_ref">
                                                <button type="submit" class="submit-button btn btn-success pull-right">
                                                    <i class="fas fa-save"></i> Guardar
                                                </button>
                                            @else
                                                <input type="hidden" value="{{(!empty($datos_generales->post_estatus))?$datos_generales->post_estatus:''}}" name="post_status" id="post_status">
                                                <input type="hidden" value="{{(!empty($datos_generales->id_product))?$datos_generales->id_product:''}}" name="id_product" id="id_product">
                                                <button type="submit" class="submit-button btn btn-success pull-right">
                                                    <i class="fas fa-save"></i> Editar
                                                </button>
                                            @endif
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