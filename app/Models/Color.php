<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{
    // use HasFactory;
    public $table='colors';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'color_name'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'color_name' => 'string'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'color_name' => 'required'
    ];

    // BelongsTo relationship: one to many (inverse)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sizesColorsProducts(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SizeColorProduct::class, 'color_id');
    }
}
