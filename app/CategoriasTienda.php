<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasTienda extends Model
{
    //
    protected $table = "categorias_tienda";
    public $timestamps = false;
    protected $primaryKey = "id_cate";
    protected $fillable = [
        'id_cate',
        'nomb_cate',
        'status'
    ];
}
