<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Status extends Model
{
    // use HasFactory;
    public $table='status';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'status_name'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'status_name' => 'string'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'status_name' => 'required'
    ];

    // BelongsTo relationship: one to many (inverse)
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function shipments(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Shipment::class, 'status_id');
    }
}
