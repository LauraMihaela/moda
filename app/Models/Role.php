<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends Model
{
    // use HasFactory;
    public $table='roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'role_name'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'role_name' => 'string'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'role_name' => 'required'
    ];

    // BelongsTo relationship: one to many (inverse)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function users(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'role_id');
    }
}
