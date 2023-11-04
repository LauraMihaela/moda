<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    // use HasFactory;
    public $table='shipments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'client_id',
        'sizes_colors_products_id',
        'status_id'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'client_id' => 'integer',
        'sizes_colors_products_id' => 'integer',
        'status_id' => 'integer'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'client_id' => 'required',
        'sizes_colors_products_id' => 'required'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function clients(): HasMany
    {
        return $this->hasMany(\App\Models\Client::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function sizesColorsProducts(): HasMany
    {
        return $this->hasMany(\App\Models\SizeColorProduct::class, 'sizes_colors_products_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function status(): HasMany
    {
        return $this->hasMany(\App\Models\Status::class, 'status_id');
    }
}
