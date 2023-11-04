<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Client extends Model
{
    // use HasFactory;
    public $table = 'clients';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Campos que se pueden rellenar
    public $fillable = [
        'address',
        'user_id'
    ];

    // Tipo de datos de los atributos
    protected $casts = [
        'address' => 'string',
        'user_id' => 'integer'
    ];

    // Definimos las reglas de lo atributos (si son obligatorios o no)
    public static $rules = [
        'address' => 'required',
        'user_id' => 'required'
    ];

    // One to one relationship
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     **/
    public function users(): MorphOne
    {
        return $this->morphOne(\App\Models\User::class, 'user_id');
    }
}
