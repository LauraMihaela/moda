<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    // use HasFactory;
    public $table='products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'product_name',
        'picture',
        'description',
        'units',
        'price',
        'created_by_fashion_designer_id'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'product_name' => 'string',
        'picture' => 'string',
        'description' => 'string',
        'units' => 'integer',
        'price' => 'double',
        'created_by_fashion_designer_id' => 'integer'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'product_name' => 'required',
        'units' => 'required',
        'price' => 'required'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function fashionDesigners(): HasMany
    {
        return $this->hasMany(\App\Models\FashionDesigner::class, 'created_by_fashion_designer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function categoriesProducts(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CategoryProduct::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sizesColorsProducts(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SizeColorProduct::class, 'product_id');
    }
}
