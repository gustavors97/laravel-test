<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable {
    
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'customers';

    protected $fillable = [
        'user_id', 'name', 'document', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function numbers() {
        return $this->hasMany(Number::class, 'customer_id', 'id');
    }
}
