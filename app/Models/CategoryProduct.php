<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryProduct extends Model
{
    // use HasFactory;
    public $table='categories_products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'product_id',
        'category_id'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'product_id' => 'integer',
        'category_id' => 'integer'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'product_id' => 'required',
        'category_id' => 'required'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function products(): HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'product_id');
    }

    // HasMany relationship: one to many
    // Returns hasMany
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function categories(): HasMany
    {
        return $this->hasMany(\App\Models\Category::class, 'category_id');
    }
}
