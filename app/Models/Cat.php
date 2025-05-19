<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'birth_date',
        'color',
        'breed_id',
        'status',
        'photo'
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function mother()
    {
        return $this->belongsToMany(Cat::class, 'pedigrees', 'cat_id', 'parent_id')
            ->wherePivot('relation_type', 'mother');
    }

    public function father()
    {
        return $this->belongsToMany(Cat::class, 'pedigrees', 'cat_id', 'parent_id')
            ->wherePivot('relation_type', 'father');
    }

    public function children()
    {
        return $this->hasMany(Pedigree::class, 'parent_id');
    }

}
