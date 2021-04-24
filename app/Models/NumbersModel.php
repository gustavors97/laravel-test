<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumbersModel extends Model {
    
    use HasFactory, SoftDeletes;

    protected $table = 'numbers';

    protected $fillable = [
        'customer_id', 'number', 'status'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function customer() {
        return $this->belongsTo(CustomersModel::class);
    }

    public function numbersPreferences() {
        return $this->hasMany(NumbersPreferencesModel::class);
    }
}
