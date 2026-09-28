<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosTiendaMeta extends Model
{
    protected $table = "productos_tienda_meta";
    public $timestamps = false;
    protected $primaryKey = "id_metas";
    protected $fillable = [
        'id_metas',
        'id_product',
        'meta_title',
        'meta_keywords',
        'meta_descripcion',
        'meta_url',
        'meta_canonical',
        'meta_alt_imagen',
        'meta_url_imagen'
    ];
}
