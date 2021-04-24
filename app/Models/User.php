<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable {

    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function customers() {
        return $this->hasMany(CustomersModel::class);
    }
}
