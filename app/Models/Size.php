<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    // use HasFactory;
    public $table='sizes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'size_name'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'size_name' => 'string'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'size_name' => 'required'
    ];

    // BelongsTo relationship: one to many (inverse)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sizesColorsProducts(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SizeColorProduct::class, 'size_id');
    }
}
