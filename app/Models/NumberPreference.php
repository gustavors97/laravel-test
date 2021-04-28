<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NumberPreference extends Model implements Auditable {
    
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'numbers_preferences';

    protected $fillable = [
        'number_id', 'name', 'value'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function number() {
        return $this->belongsTo(Number::class, 'number_id', 'id');
    }
}
