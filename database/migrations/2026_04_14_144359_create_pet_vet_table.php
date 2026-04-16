<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_vet', function (Blueprint $table) {
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->foreignId('vet_id')->constrained()->onDelete('cascade');

            // important: composite primary key
            $table->primary(['pet_id', 'vet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_vet');
    }
};