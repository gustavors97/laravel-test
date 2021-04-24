<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomersModel extends Model {
    
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'user_id', 'name', 'document', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function numbers() {
        return $this->hasMany(NumbersModel::class);
    }
}
