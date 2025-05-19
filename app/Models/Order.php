<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'status',
        'created_at',
        'updated_at',
    ];

    public function cats()
    {
        return $this->belongsToMany(Cat::class, 'order_cats', 'order_id', 'cat_id');
    }
}
