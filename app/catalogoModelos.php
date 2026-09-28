<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class catalogoModelos extends Model
{
    protected $table = "cat_modelos";
    public $timestamps = false;
    protected $primaryKey = "id_modelo";
    protected $fillable = [
        'id_modelo',
        'nombre',
        'orden',
        'status'
    ];
}
