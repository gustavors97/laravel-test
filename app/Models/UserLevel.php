<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class UserLevel extends Model implements Auditable {

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'users_levels';

    protected $fillable = [
        'user_id', 'level_id'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function level() {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
