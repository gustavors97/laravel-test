<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NumberModel extends Model implements Auditable {
    
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'numbers';

    protected $fillable = [
        'customer_id', 'number', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function customer() {
        return $this->belongsTo(CustomerModel::class);
    }

    public function numbersPreferences() {
        return $this->hasMany(NumberPreferenceModel::class);
    }
}
