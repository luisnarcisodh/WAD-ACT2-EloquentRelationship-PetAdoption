<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'image_path' // Updated from 'image'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : asset('images/default-pet.jpg');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // REQUIRED RELATIONSHIPS
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
