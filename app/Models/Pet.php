<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
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
        return $this->belongsToMany(Vet::class);
    }
}
