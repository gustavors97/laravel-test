<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumbersPreferencesModel extends Model {
    
    use HasFactory, SoftDeletes;

    protected $table = 'numbers_preferences';

    protected $fillable = [
        'number_id', 'name', 'value'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function number() {
        return $this->belongsTo(NumbersModel::class);
    }
}
