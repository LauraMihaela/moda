<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SizeColorProduct extends Model
{
    // use HasFactory;
    public $table='sizes_colors_products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'product_id' => 'integer',
        'color_id' => 'integer',
        'size_id' => 'integer',
        'price' => 'float'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'product_id' => 'required',
        'price' => 'required'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function products(): HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function colors(): HasMany
    {
        return $this->hasMany(\App\Models\Color::class, 'color_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sizes(): HasMany
    {
        return $this->hasMany(\App\Models\Size::class, 'size_id');
    }
}
