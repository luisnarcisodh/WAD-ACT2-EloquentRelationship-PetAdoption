<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'vaccine_name',
        'date',
        'next_due',
    ];

    protected $casts = [
        'date'     => 'date',
        'next_due' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
