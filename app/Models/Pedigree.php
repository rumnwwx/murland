<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'cat_id',
        'relation_type'
    ];
}
