<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'name',
        'lastname',
        'email',
        'remember_token',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'username' => 'string',
        'password' => 'hashed',
        'name' => 'string',
        'lastname' => 'string',
        'email' => 'string',
        'remember_token' => 'string',
        'role_id' => 'string',
    ];

    public static $rules = [
        'username' => 'required|unique:users,username',
        'password' => 'required',
        'name' => 'required',
        'lastname' => 'required',
        'email' => 'required|unique:users,email|email:rfc,dns',
        // Se valida que el email sea tipo email mediante protocolos rfc y dns
        'role_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function roles(): HasMany
    {
        return $this->hasMany(\App\Models\Role::class, 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function clients(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'user_id');
    }
}
