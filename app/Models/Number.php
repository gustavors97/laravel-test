<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Number extends Model implements Auditable {
    
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'numbers';

    protected $fillable = [
        'customer_id', 'number', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function numberPreferences() {
        return $this->hasMany(NumberPreference::class, 'number_id', 'id');
    }
}
