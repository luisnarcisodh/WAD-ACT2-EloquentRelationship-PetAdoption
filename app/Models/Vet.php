<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'clinic',
        'email',
        'phone',
        'specialization',
    ];

    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'pet_vet');
    }
}
