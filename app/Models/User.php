<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable {

    use HasFactory, Notifiable, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'image'
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
        return $this->hasMany(CustomersModel::class, 'user_id', 'id');
    }

    public function userLevels() {
        return $this->hasMany(UserLevel::class, 'user_id', 'id');
    }
}
