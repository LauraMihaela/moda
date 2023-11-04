<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FashionDesigner extends Model
{
    // use HasFactory;
    public $table='fashion_designers';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'name',
        'country'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'name' => 'string',
        'country' => 'string'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'name' => 'required'
    ];

    // BelongsTo relationship: one to many (inverse)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function products(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'created_by_fashion_designer_id');
    }
}
