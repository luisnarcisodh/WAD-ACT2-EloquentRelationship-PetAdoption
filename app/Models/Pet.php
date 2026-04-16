<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'breed',
        'age',
        'gender',
        'status',
        'description',
        'image',
    ];

    public function vaccination()
    {
        return $this->hasOne(Vaccination::class);
    }

    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    public function vets()
    {
        return $this->belongsToMany(Vet::class, 'pet_vet');
    }
}
