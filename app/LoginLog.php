<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    /**
     * No auto-timestamp para updated_at
     * Solo usamos created_at
     */
    public $timestamps = false;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relación con User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
