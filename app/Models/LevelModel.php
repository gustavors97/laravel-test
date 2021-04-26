<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class LevelModel extends Model implements Auditable {

    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'levels';

    protected $fillable = [
        'type'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];
}