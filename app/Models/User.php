<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function adoptionRequests()
    {
        return $this->hasMany(AdoptionRequest::class);
    }
}
