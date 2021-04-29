<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audict extends Model {

    use HasFactory;

    protected $table = 'audits';

    protected $primaryKey = 'id';
}
