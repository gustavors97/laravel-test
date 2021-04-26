<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerModel extends Model implements Auditable {
    
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'customers';

    protected $fillable = [
        'user_id', 'name', 'document', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(UserModel::class);
    }

    public function numbers() {
        return $this->hasMany(NumberModel::class);
    }
}
